<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Livewire\Admin\UserApproval;
use Silber\Bouncer\BouncerFacade as Bouncer;
use App\Livewire\TeamManager\Dashboard;
use App\Livewire\TeamManager\CreatePlayerForm;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\ScheduleGenerator;
use App\Livewire\Admin\ViewFixtures;
use App\Livewire\Admin\EditFixture;
use App\Livewire\Admin\Standings;
use App\Livewire\Scorekeeper\ScorekeeperDashboard;
use App\Livewire\Scorekeeper\ScoreInput;
use App\Livewire\Statistician\StatisticianDashboard;
use App\Livewire\Statistician\StatInput;

Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Default Dashboard (for fallback users)
|--------------------------------------------------------------------------
*/
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



Route::middleware(['auth', 'can:access-admin-dashboard'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/admin-dashboard', AdminDashboard::class)->name('dashboard');
        Route::get('/user-approvals', UserApproval::class)->name('user-approvals');
        Route::get('/schedule-generator', ScheduleGenerator::class)->name('schedule-generator');
        Route::get('/fixtures', ViewFixtures::class)->name('view-fixtures');
        Route::get('/fixture/{gameId}/edit', EditFixture::class)->name('edit-fixture');
        Route::get('/standings', Standings::class)->name('standings'); // ✅ fixed
    });


// Routes for team managers
Route::middleware(['auth', 'can:access-team-manager-dashboard'])->prefix('team-manager')->name('team-manager.')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/create-player/{teamId}', CreatePlayerForm::class)->name('create-player');
});
// Routes for statisticians
Route::middleware(['auth', 'can:access-statistician-dashboard'])->prefix('statistician')->name('statistician.')->group(function () {
    Route::get('/statistician-dashboard', StatisticianDashboard::class)->name('dashboard');
    Route::get('/game/{game}/stat-input', StatInput::class)->name('stat-input');

});

// Routes for scorekeepers
Route::middleware(['auth', 'can:access-scorekeeper-dashboard'])->prefix('scorekeeper')->name('scorekeeper.')->group(function () {
    Route::get('/scorekeeper-dashboard', ScorekeeperDashboard::class)->name('dashboard');
    //Route::get('/game/{gameId}/input', ScoreInput::class)->name('score-input');
    Route::get('/game/{game}/input', ScoreInput::class)->name('score-input');


});


require __DIR__ . '/auth.php';
