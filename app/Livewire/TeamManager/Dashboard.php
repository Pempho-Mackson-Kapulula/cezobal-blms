<?php

namespace App\Livewire\TeamManager;

use App\Models\User;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Collection;

#[Layout('components.layouts.app')]
class Dashboard extends Component
{
    public $team;
    public $players;
    public $nextMatch; // Property for real-time match data

    public function mount()
    {
        $this->loadTeamData();
    }

    #[On('team-created')]
    public function refreshTeam()
    {
        $this->loadTeamData();
    }

    private function loadTeamData()
    {
        /** @var User $user */
        $user = Auth::user();
        
        // Eager load the team, division, and players
        $this->team = $user->team()->with(['division', 'players'])->first();
        
        if ($this->team) {
            $this->players = $this->team->players;

            // Query the Game model for the single next upcoming match
            $this->nextMatch = Game::where(function($query) {
                    $query->where('home_team_id', $this->team->id)
                          ->orWhere('away_team_id', $this->team->id);
                })
                ->where('date', '>=', now()) // 2026 data priority
                ->where('status', '!=', 'completed')
                ->orderBy('date', 'asc')
                ->with(['homeTeam', 'awayTeam', 'court', 'timeSlot'])
                ->first();
        } else {
            $this->players = collect();
            $this->nextMatch = null;
        }
    }

    public function render()
    {
        return view('livewire.team-manager.dashboard', [
            'team' => $this->team,
            'players' => $this->players,
            'nextMatch' => $this->nextMatch
        ]);
    }
}
