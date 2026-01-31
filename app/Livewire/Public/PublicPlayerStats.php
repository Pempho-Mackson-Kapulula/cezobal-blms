<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\ScoreEvent;
use App\Models\Division;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 

class PublicPlayerStats extends Component
{
    // ... (rest of the class properties and mount/update methods are the same) ...
    public $selectedDivision;
    public $search = '';

    public function mount()
    {
        $this->selectedDivision = Division::first()?->id;
    }
    
    public function updatedSelectedDivision() {}
    public function updatedSearch() {}

    public function render()
    {
        $divisions = Division::all();
        $currentYear = Carbon::now()->year;

        $playerStats = ScoreEvent::query()
            ->whereHas('game', function($query) use ($currentYear) {
                $query->whereYear('date', $currentYear)
                      ->where('status', 'completed');
            })
            ->whereHas('player.team', function($query) { 
                $query->where('division_id', $this->selectedDivision);
            })
            ->whereHas('player', function($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->select('player_id',
                // Raw Sums for Totals
                DB::raw('SUM(CASE WHEN event_type = "2pt" THEN 2 WHEN event_type = "3pt" THEN 3 WHEN event_type = "ft" THEN 1 ELSE 0 END) as total_points'),
                DB::raw('SUM(CASE WHEN event_type = "reb" THEN 1 ELSE 0 END) as total_rebounds'),
                DB::raw('SUM(CASE WHEN event_type = "ast" THEN 1 ELSE 0 END) as total_assists'),
                DB::raw('SUM(CASE WHEN event_type = "tov" THEN 1 ELSE 0 END) as total_turnovers'),
                DB::raw('SUM(CASE WHEN event_type = "pf" THEN 1 ELSE 0 END) as total_fouls'),
                DB::raw('SUM(CASE WHEN event_type = "stl" THEN 1 ELSE 0 END) as total_steals'), // Added steals
                DB::raw('COUNT(DISTINCT game_id) as games_played')
            )
            ->groupBy('player_id')
            ->with(['player.team'])
            ->get()
            // Convert to Averages
            ->map(function ($item) {
                $gp = max($item->games_played, 1);
                $item->ppg = number_format($item->total_points / $gp, 1);
                $item->rpg = number_format($item->total_rebounds / $gp, 1);
                $item->apg = number_format($item->total_assists / $gp, 1);
                $item->topg = number_format($item->total_turnovers / $gp, 1);
                $item->pfpg = number_format($item->total_fouls / $gp, 1);
                $item->spg = number_format($item->total_steals / $gp, 1); // Added steals per game
                return $item;
            })
            ->sortByDesc('ppg'); // Order by Points Per Game

        return view('livewire.public.public-player-stats', [
            'divisions' => $divisions,
            'players' => $playerStats
        ])->layout('components.layouts.public');
    }
}
