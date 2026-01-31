<?php

namespace App\Livewire\Public;

use App\Models\Team;
use App\Models\Game;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.public')]
class TeamShow extends Component
{
    public Team $team;

    public function mount(Team $team)
    {
        $this->team = $team->load(['players', 'division']);
    }

    public function render()
    {
        $teamId = $this->team->id;

        return view('livewire.public.team-show', [
            'recentResults' => Game::with(['homeTeam', 'awayTeam', 'division'])
                ->where('status', 'completed')
                ->where(function ($query) use ($teamId) {
                    $query->where('home_team_id', $teamId)
                        ->orWhere('away_team_id', $teamId);
                })
                ->latest('completed_at')
                ->take(5)
                ->get(),

            'upcomingSchedule' => Game::with(['homeTeam', 'awayTeam', 'court'])
                ->whereIn('status', ['scheduled', 'in_progress']) // Matches your Enum values
                ->where('date', '>=', now()->startOfDay())
                ->where(column: function ($query) use ($teamId) {
                    $query->where('home_team_id', $teamId)
                        ->orWhere('away_team_id', $teamId);
                })
                ->orderBy('date', 'asc')
                ->take(5)
                ->get(),


        ]);
    }

}
