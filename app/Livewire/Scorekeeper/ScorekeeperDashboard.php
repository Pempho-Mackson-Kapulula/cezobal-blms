<?php

namespace App\Livewire\Scorekeeper;

use Livewire\Component;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;

class ScorekeeperDashboard extends Component
{
    public $assignedGames = [];

    public function mount()
    {
        // Load games where the logged-in user is the assigned scorekeeper
        $this->assignedGames = Game::where('scorekeeper_id', Auth::id())
            ->orderBy('date')
            ->get();
    }

    public function render()
    {
        return view('livewire.scorekeeper.scorekeeper-dashboard');
    }
}
