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
        // Load all divisions
        $this->divisions = Division::all();

        // Default to first division if available
        $this->selectedDivision = $this->divisions->first()?->id;

        $this->loadStandings();
    }

    // Called automatically when the dropdown changes
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

            $wins = $homeGames->where('score_home', '>', 'score_away')->count()
                  + $awayGames->where('score_away', '>', 'score_home')->count();

            $losses = $homeGames->where('score_home', '<', 'score_away')->count()
                   + $awayGames->where('score_away', '<', 'score_home')->count();

            $pointsFor = $homeGames->sum('score_home') + $awayGames->sum('score_away');
            $pointsAgainst = $homeGames->sum('score_away') + $awayGames->sum('score_home');

            return [
                'team' => $team->name,
                'played' => $homeGames->count() + $awayGames->count(),
                'wins' => $wins,
                'losses' => $losses,
                'points_for' => $pointsFor,
                'points_against' => $pointsAgainst,
                'point_diff' => $pointsFor - $pointsAgainst,
                'league_points' => $wins * 2,
            ];
        })
        ->sortByDesc('league_points')
        ->values()
        ->all();
    }

    public function render()
    {
        return view('livewire.admin.standings');
    }
}
