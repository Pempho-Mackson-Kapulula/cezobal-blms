<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Team;
use App\Models\Division;

class Standings extends Component
{
    public $divisions = [];
    public $selectedDivision = null;
    public $standings = [];

    public function mount()
    {
        $this->divisions = Division::all();
        $this->selectedDivision = $this->divisions->first()?->id;
        $this->loadStandings();
    }

    public function updatedSelectedDivision($value)
    {
        $this->loadStandings();
    }

    public function loadStandings()
    {
        if (!$this->selectedDivision) {
            $this->standings = [];
            return;
        }
        $teams = Team::where('division_id', $this->selectedDivision)->get();
        $this->standings = $teams->map(function ($team) {
            $homeGames = $team->homeGames()->where('status', 'completed')->get();
            $awayGames = $team->awayGames()->where('status', 'completed')->get();

            // --- Calculate wins and losses correctly ---
            $wins = $homeGames->filter(callback: fn($g) => (int) $g->score_home > (int) $g->score_away)->count()
                + $awayGames->filter(fn($g) => (int) $g->score_away > (int) $g->score_home)->count();

            $losses = $homeGames->filter(fn($g) => (int) $g->score_home < (int) $g->score_away)->count()
                + $awayGames->filter(fn($g) => (int) $g->score_away < (int) $g->score_home)->count();

            // --- Points For / Against ---
            $pointsFor = $homeGames->sum('score_home') + $awayGames->sum('score_away');
            $pointsAgainst = $homeGames->sum('score_away') + $awayGames->sum('score_home');

            // --- League Points Formula (2 for win, 1 for loss) ---
            $leaguePoints = ($wins * 2) + ($losses * 1);

            return [
                'team' => $team->name,
                'played' => $homeGames->count() + $awayGames->count(),
                'wins' => $wins,
                'losses' => $losses,
                'points_for' => $pointsFor,
                'points_against' => $pointsAgainst,
                'point_diff' => $pointsFor - $pointsAgainst,
                'league_points' => $leaguePoints,
            ];
        })
            ->sort(function ($a, $b) {
                // Sort by league points first, then by point diff
                if ($b['league_points'] === $a['league_points']) {
                    return $b['point_diff'] <=> $a['point_diff'];
                }
                return $b['league_points'] <=> $a['league_points'];
            })
            ->values()
            ->all();
    }

    public function render()
    {
        return view('livewire.admin.standings');
    }
}
