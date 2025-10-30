<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Silber\Bouncer\BouncerFacade as Bouncer;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $role = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:team_manager,statistician,scorekeeper'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        // Create the user
        $user = User::create($validated);

        // Assign role via Bouncer
        Bouncer::assign($this->role)->to($user);

        // Mark account as pending admin approval
        $user->status = 'pending';
        $user->save();

        event(new Registered($user));

        Session::flash('status', 'Registration successful! Please wait for admin approval.');

        // Redirect back to login instead of auto-login
        $this->redirect(route('login'), navigate: true);
    }
}; 
?>

<div class="flex flex-col gap-6">
    {{-- Header --}}
    <div class="flex w-full flex-col text-center">
      
        <p class="text-sm sm:text-lg text-red-600 font-semibold">
            {{ __('Create your account') }}
        </p>
    </div>

    <x-auth-session-status class="text-center" :status="session('status')" />

    <form method="POST" wire:submit="register" class="flex flex-col gap-6">
        <!-- Name -->
        <flux:input
            wire:model="name"
            :label="__('Full Name')"
            type="text"
            required
            autofocus
            autocomplete="name"
            placeholder="e.g., Pempho Kapulula"
        />

        <!-- Email -->
        <flux:input
            wire:model="email"
            :label="__('Email Address')"
            type="email"
            required
            autocomplete="email"
            placeholder="you@example.com"
        />

        <!-- Role -->
        <flux:select wire:model="role" :label="__('Select Role')" required>
            <option value="">{{ __('Select Role') }}</option>
            <option value="team_manager">{{ __('Team Manager') }}</option>
            <option value="statistician">{{ __('Statistician') }}</option>
            <option value="scorekeeper">{{ __('Scorekeeper') }}</option>
        </flux:select>

        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('Password')"
            type="password"
            required
            autocomplete="new-password"
            placeholder="••••••••"
            viewable
        />

        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('Confirm Password')"
            type="password"
            required
            autocomplete="new-password"
            placeholder="••••••••"
            viewable
        />

        <!-- Submit -->
         <div class="flex items-center justify-end">
            <flux:button color="red" type="submit" class="w-full hover:!bg-red-500">
                {{ __('Create your account') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        <span>{{ __('Already have an account?') }}</span>
        <flux:link class="text-red-600 hover:text-red-500" :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
</div>
