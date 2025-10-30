<?php

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Features;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use Silber\Bouncer\BouncerFacade as Bouncer;
use App\Services\DashboardService;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        $user = $this->validateCredentials();

        // 🔒 Block login for users who are not yet approved
        if ($user->status !== 'active') {
            throw ValidationException::withMessages([
                'email' => __('Your account is pending admin approval.'),
            ]);
        }

        // ✅ Log in the user
        Auth::login($user, $this->remember);
        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        // 🧭 Redirect based on user role
        if (Bouncer::is($user)->an('admin')) {
            $this->redirect(route('admin.dashboard'), navigate: true);
        } elseif (Bouncer::is($user)->an('team_manager')) {
            $this->redirect(route('team-manager.dashboard'), navigate: true);
        } elseif (Bouncer::is($user)->an('statistician')) {
            $this->redirect(route('statistician.dashboard'), navigate: true);
        } elseif (Bouncer::is($user)->an('scorekeeper')) {
            $this->redirect(route('scorekeeper.dashboard'), navigate: true);
        } else {
            $this->redirect(route('dashboard'), navigate: true);
        }
    }

    /**
     * Validate the user's credentials.
     */
    protected function validateCredentials(): User
    {
        $user = Auth::getProvider()->retrieveByCredentials([
            'email' => $this->email,
            'password' => $this->password,
        ]);

        if (!$user || !Auth::getProvider()->validateCredentials($user, ['password' => $this->password])) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        return $user;
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }
};
?>

<div class="flex flex-col gap-6">
    <div class="flex w-full flex-col text-center">
      
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
            {{ __('Log in to your account') }}
        </h1>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
            {{ __('Enter your email and password below to log in') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form method="POST" wire:submit="login" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input wire:model="email" :label="__('Email address')" type="email" required autofocus autocomplete="email"
            placeholder="email@example.com" />

        <!-- Password -->
        <div class="relative">
            <flux:input wire:model="password" :label="__('Password')" type="password" required
                autocomplete="current-password" :placeholder="__('Password')" viewable />

            @if (Route::has('password.request'))
                <flux:link class="absolute top-0 text-sm end-0 text-red-600 hover:text-red-500"
                    :href="route('password.request')" wire:navigate>
                    {{ __('Forgot your password?') }}
                </flux:link>
            @endif
        </div>

        <!-- Remember Me -->
        <flux:checkbox wire:model="remember" :label="__('Remember me')" />

        <div class="flex items-center justify-end">
            <flux:button color="red" type="submit" class="w-full hover:!bg-red-500" data-test="login-button">
                {{ __('Log in') }}
            </flux:button>
        </div>
    </form>

    @if (Route::has('register'))
        <div class="space-x-1 text-sm text-center rtl:space-x-reverse text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Don\'t have an account?') }}</span>
            <flux:link class="text-red-600 hover:text-red-500" :href="route('register')" wire:navigate>
                {{ __('Sign up') }}</flux:link>
        </div>
    @endif
</div>
