<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
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
use App\Livewire\TeamManager\CreateForm;

// Statistician Livewire Components
use App\Livewire\Statistician\StatisticianDashboard;
use App\Livewire\Statistician\StatInput;

//public Livewire Components
use App\Livewire\Public\HomePage;
use App\Livewire\Public\TeamsPage;
use App\Livewire\Public\TeamShow;
use App\Livewire\Public\PublicStandings;
use App\Livewire\Public\PublicSchedules;
use App\Livewire\Public\MatchCenter;
use App\Livewire\Public\PublicPlayerStats;
use App\Livewire\Public\PublicTeamStats;
use App\Livewire\Public\PlayerShow;


/* public site pages */
Route::get('/', HomePage::class)->name('home');

// Use a more distinct path for individual teams
Route::get('/teams-list', TeamsPage::class)->name('public-teams-page');
Route::get('/team-profile/{team}', TeamShow::class)->name('public-team-show');

// Individual player profile
Route::get('/player/{player}', \App\Livewire\Public\PlayerShow::class)->name('public-player-show');

// Public standings
Route::get('/standings', PublicStandings::class)->name('public-standings');

// Public schedules
Route::get('/schedules', PublicSchedules::class)->name('public-schedules');

// Match center
Route::get('/match/{game}', MatchCenter::class)->name('match-center');

// Public Stats (New for 2026)
Route::group(['prefix' => 'stats'], function () {
    Route::get('/players', \App\Livewire\Public\PublicPlayerStats::class)->name('public-stats-players');
    Route::get('/teams', \App\Livewire\Public\PublicTeamStats::class)->name('public-stats-teams');
});



/* Default Dashboard (fallback users) */
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'approved', 'verified'])
    ->name('dashboard');



/* Pending / Rejected Pages */
Route::middleware('auth')->group(function () {
    // Pending approval page
    Route::view('/approval-pending', 'livewire.admin.approval-pending')
        ->name('approval.pending');

    // Rejected approval page
    Route::view('/approval-rejected', 'livewire.admin.approval-rejected')
        ->name('approval.rejected');
});



/* Settings */
Route::middleware(['auth', 'approved'])->group(function () {
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

/* Admin routes – no 'approved' middleware, admins can approve users */
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
        Route::get('/payments', AdminPayments::class)->name('payments');
    });

/* Team Manager routes */
Route::middleware(['auth', 'approved', 'can:access-team-manager-dashboard'])
    ->prefix('team-manager')
    ->name('team-manager.')
    ->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('/create-player/{teamId}', CreatePlayerForm::class)->name('create-player');
        Route::get('/payments', TeamPayments::class)->name('payments');
    });

/* Statistician routes */
Route::middleware(['auth', 'approved', 'can:access-statistician-dashboard'])
    ->prefix('statistician')
    ->name('statistician.')
    ->group(function () {
        Route::get('/statistician-dashboard', StatisticianDashboard::class)->name('dashboard');
        Route::get('/game/{game}/stat-input', StatInput::class)->name('stat-input');
    });


/* Checkout and payment routes – approved users only */
Route::middleware(['auth', 'approved'])->group(function () {
    // Ensure the ->name('checkout') is attached here
    Route::get('/checkout/{payment}', function ($paymentId) {
        $payment = \App\Models\Payment::with('team')->findOrFail($paymentId);
        return view('payments.checkout', compact('payment'));
    })->name('checkout');
});
Route::middleware(['auth', 'approved'])->group(function () {

    // Success view route
    Route::get('/payment/complete', function () {
        return view('payments.complete');
    })->name('payment.complete');

    // Failure view route
    Route::get('/payment/failed', function () {
        return view('payments.failed');
    })->name('payment.failed');

    // Callback handler route
    Route::get('/payment/callback', function (\Illuminate\Http\Request $request) {
        $tx_ref = $request->query('tx_ref');

        // If no reference exists, redirect to the red failed page
        if (!$tx_ref) {
            return redirect()->route('payment.failed');
        }

        // Find and update the payment record
        $updated = \App\Models\Payment::where('tx_ref', $tx_ref)
            ->update(['status' => 'completed']);

        // If the record exists and was updated, go to complete, else go to failed
        if ($updated) {
            return redirect()->route('payment.complete');
        }

        return redirect()->route('payment.failed');
    })->name('payment.callback');
});


require __DIR__ . '/auth.php';
