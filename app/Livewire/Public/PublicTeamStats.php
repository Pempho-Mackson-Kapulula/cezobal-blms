<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\ScoreEvent;
use App\Models\Division;
use App\Models\Game; // Need this for opponent data
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class PublicTeamStats extends Component
{
    public $selectedDivision;

    public function mount()
    {
        $this->selectedDivision = Division::first()?->id;
    }
    
    public function render()
    {
        $divisions = Division::all();

        // Get all completed games for 2026 season to calculate league-wide data
        $completedGames = Game::whereYear('date', 2026)->where('status', 'completed')->get();
        $teamStats = collect();

        foreach ($divisions as $division) {
            if ($division->id != $this->selectedDivision) continue;

            foreach ($division->teams as $team) {
                $homeGames = $completedGames->where('home_team_id', $team->id);
                $awayGames = $completedGames->where('away_team_id', $team->id);
                $gamesPlayed = $homeGames->count() + $awayGames->count();

                if ($gamesPlayed === 0) continue;

                // Points For (PF) and Points Against (PA)
                $pointsFor = $homeGames->sum('score_home') + $awayGames->sum('score_away');
                $pointsAgainst = $homeGames->sum('score_away') + $awayGames->sum('score_home');

                // Shooting stats from ScoreEvents
                $events = ScoreEvent::where('team_id', $team->id)
                    ->whereIn('game_id', $completedGames->pluck('id'))
                    ->get();
                
                $fgm = $events->whereIn('event_type', ['2pt', '3pt'])->count();
                $fga = $events->whereIn('event_type', ['2pt', '2pt_attempt', '3pt', '3pt_attempt'])->count();
                $ftm = $events->where('event_type', 'ft')->count();
                $fta = $events->where('event_type', 'ft_attempt')->count() + $ftm; // Total attempts is made + missed
                
                // Rebounds (requires tracking offensive/defensive rebounds separately, assuming 'reb' is total for now)
                $rebounds = $events->where('event_type', 'reb')->count();
                $assists = $events->where('event_type', 'ast')->count();
                $steals = $events->where('event_type', 'stl')->count();
                $blocks = $events->where('event_type', 'blk')->count();
                $turnovers = $events->where('event_type', 'tov')->count();

                $teamStats->push([
                    'team_id' => $team->id,
                    'team_name' => $team->name,
                    'games_played' => $gamesPlayed,
                    'ppg' => number_format($pointsFor / $gamesPlayed, 1),
                    'pa' => number_format($pointsAgainst / $gamesPlayed, 1),
                    'fg_percent' => $fga > 0 ? round(($fgm / $fga) * 100, 1) : 0.0,
                    'rebounds' => number_format($rebounds / $gamesPlayed, 1),
                    'assists' => number_format($assists / $gamesPlayed, 1),
                    'steals' => number_format($steals / $gamesPlayed, 1),
                    'blocks' => number_format($blocks / $gamesPlayed, 1),
                    'turnovers' => number_format($turnovers / $gamesPlayed, 1),
                ]);
            }
        }

        // Sort by PPG for default leaderboard view
        $teamStats = $teamStats->sortByDesc('ppg')->values();


        return view('livewire.public.public-team-stats', [
            'divisions' => $divisions,
            'stats' => $teamStats
        ])->layout('components.layouts.public');
    }
}
