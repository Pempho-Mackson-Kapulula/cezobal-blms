<?php


use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use Silber\Bouncer\BouncerFacade as Bouncer;

// Admin Livewire Components
use App\Livewire\Admin\UserApproval;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\ScheduleGenerator;
use App\Livewire\Admin\ViewFixtures;
use App\Livewire\Admin\EditFixture;
use App\Livewire\Admin\Standings;
use App\Livewire\Admin\AdminPayments;

// Team Manager Livewire Components
use App\Livewire\TeamManager\Dashboard;
use App\Livewire\TeamManager\CreatePlayerForm;
use App\Livewire\TeamManager\TeamPayments;

// Statistician Livewire Components
use App\Livewire\Statistician\StatisticianDashboard;
use App\Livewire\Statistician\StatInput;

Route::get('/', function () {
    return view('welcome');
})->name('home');

/* Default Dashboard (for fallback users) */
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

// Admin routes
Route::middleware(['auth', 'can:access-admin-dashboard'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/admin-dashboard', AdminDashboard::class)->name('dashboard');
        Route::get('/user-approvals', UserApproval::class)->name('user-approvals');
        Route::get('/schedule-generator', ScheduleGenerator::class)->name('schedule-generator');
        Route::get('/fixtures', ViewFixtures::class)->name('view-fixtures');
        Route::get('/fixture/{gameId}/edit', EditFixture::class)->name('edit-fixture');
        Route::get('/standings', Standings::class)->name('standings');
        Route::get('/payments', AdminPayments::class)->name('payments'); // ✅ admin payments
    });

// Team Manager routes
Route::middleware(['auth', 'can:access-team-manager-dashboard'])
    ->prefix('team-manager')
    ->name('team-manager.')
    ->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('/create-player/{teamId}', CreatePlayerForm::class)->name('create-player');
        Route::get('/payments', TeamPayments::class)->name('payments'); // ✅ team payments
    });

// Statistician routes
Route::middleware(['auth', 'can:access-statistician-dashboard'])
    ->prefix('statistician')
    ->name('statistician.')
    ->group(function () {
        Route::get('/statistician-dashboard', StatisticianDashboard::class)->name('dashboard');
        Route::get('/game/{game}/stat-input', StatInput::class)->name('stat-input');
    });

// Checkout and payment routes
Route::middleware('auth')->group(function () {
    // Team manager can initiate checkout with optional amount
    Route::get('/checkout/{payment}', function ($paymentId) {
        $payment = \App\Models\Payment::with('team')->findOrFail($paymentId);
        return view('payments.checkout', compact('payment'));
    })->name('checkout');



    Route::get('/payment/complete', function () {
        return view('payments.complete');
    })->name('payment.complete');

    // PayChangu callback endpoint
    Route::post('/payment/callback', function () {
        // log or verify data from PayChangu here
        return response()->json(['status' => 'callback received']);
    })->name('payment.callback');
});

require __DIR__ . '/auth.php';
