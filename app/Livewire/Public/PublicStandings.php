<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Division;
use App\Models\Team;

class PublicStandings extends Component
{
    public $selectedDivision;
    public $isSidebar = false;

    public function mount($isSidebar = false)
    {
        $this->isSidebar = $isSidebar;
        // Default to first division if not already set
        $this->selectedDivision = $this->selectedDivision ?? Division::first()?->id;
    }

    public function render()
    {
        $divisions = Division::all();
        $currentDivision = $divisions->firstWhere('id', $this->selectedDivision);

        // Fetch teams for the selected division
        $teams = Team::where('division_id', $this->selectedDivision)->get();

        // Use the same logic as your Admin component for consistency
        $standings = $teams->map(function ($team) {
            $homeGames = $team->homeGames()->where('status', 'completed')->get();
            $awayGames = $team->awayGames()->where('status', 'completed')->get();

            $wins = $homeGames->filter(fn($g) => (int) $g->score_home > (int) $g->score_away)->count()
                + $awayGames->filter(fn($g) => (int) $g->score_away > (int) $g->score_home)->count();

            $losses = $homeGames->filter(fn($g) => (int) $g->score_home < (int) $g->score_away)->count()
                + $awayGames->filter(fn($g) => (int) $g->score_away < (int) $g->score_home)->count();

            $pointsFor = $homeGames->sum('score_home') + $awayGames->sum('score_away');
            $pointsAgainst = $homeGames->sum('score_away') + $awayGames->sum('score_home');

            return [
                'team' => $team->name,
                'team_id' => $team->id,
                'played' => $homeGames->count() + $awayGames->count(),
                'wins' => $wins,
                'losses' => $losses,
                'point_diff' => $pointsFor - $pointsAgainst,
                'league_points' => ($wins * 2) + ($losses * 1), // Standard CEZOBAL scoring
            ];
        })
            ->sortByDesc('point_diff') // Tie-breaker
            ->sortByDesc('league_points')
            ->values();

        if ($this->isSidebar) {
            $standings = $standings->take(5);
        }

        $view = view('livewire.public.public-standings', [
            'divisions' => $divisions,
            'currentDivisionName' => $currentDivision?->name ?? 'League',
            'standings' => $standings,
        ]);

        // Do not return a layout if this is a nested component (Sidebar)
        return $this->isSidebar ? $view : $view->layout('components.layouts.public');
    }
}
