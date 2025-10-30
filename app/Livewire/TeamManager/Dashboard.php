<?php

namespace App\Livewire\TeamManager;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Collection;

#[Layout('components.layouts.app')]
class Dashboard extends Component
{
    public $team;
    public Collection $players;

    public function mount()
    {
        $this->loadTeamData();
    }

    #[On('team-created')]
    #[On('livewire:navigated')] // Add this listener
    public function refreshTeam() // Remove the parameter from the method
    {
        $this->loadTeamData();
    }

    private function loadTeamData()
    {
        $user = User::with('team.players', 'team.division')->find(Auth::id());
        $this->team = $user->team;
        
        $this->players = $this->team ? $this->team->players : new Collection();
    }

    public function render()
    {
        return view('livewire.team-manager.dashboard');
    }
}
