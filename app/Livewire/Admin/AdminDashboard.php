<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Team;
use App\Models\User;
use App\Models\Game;
use App\Models\Payment;


class AdminDashboard extends Component
{
    public $pendingUsers = 0;
    public $totalUsers = 0;
    public $upcomingGames = [];
    public $payments = [];
    public $standings = [];

    public function mount()
    {
        // Count teams pending approval
        $this->pendingUsers = User::where('status', 'pending')->count();

        // Count active users (approved)
        $this->totalUsers = User::where('status', 'active')->count();

        // Get next 5 upcoming games
        $this->upcomingGames = Game::where('status', 'scheduled')->count();


        // Get recent payments (latest 10)
        $this->payments = Payment::with('team') // make sure Payment has a `team()` relationship
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        
    }

    public function render()
    {
        return view('livewire.admin.admin-dashboard');
    }
}
