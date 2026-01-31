<?php

namespace App\Livewire\Public;

use App\Models\{Game, ScoreEvent};
use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;

class MatchCenter extends Component
{
    public Game $game;

    // Add this property to track modal state
    public bool $showBoxscore = false;

    public function mount(Game $game)
    {
        $this->game = $game->load(['homeTeam.players', 'awayTeam.players', 'division', 'court']);
    }

    // Add this method to handle the button clicks
    public function toggleBoxscore()
    {
        $this->showBoxscore = !$this->showBoxscore;
    }
    #[Computed]
    public function playerStats()
    {
        return ScoreEvent::where('game_id', $this->game->id)
            ->select('player_id', 'event_type', DB::raw('count(*) as count'))
            ->groupBy('player_id', 'event_type')
            ->get()
            ->groupBy('player_id');
    }

    /**
     * This was the missing property causing your error!
     */
    #[Computed]
    public function periodScores()
    {
        return ScoreEvent::where('game_id', $this->game->id)
            ->select('team_id', 'period', DB::raw("SUM(CASE 
                WHEN event_type = '2pt' THEN 2 
                WHEN event_type = '3pt' THEN 3 
                WHEN event_type = 'ft' THEN 1 
                ELSE 0 END) as total"))
            ->groupBy('team_id', 'period')
            ->get()
            ->groupBy('team_id');
    }

    #[Computed]
    public function homePlayers()
    {
        return $this->game->homeTeam->players;
    }

    #[Computed]
    public function awayPlayers()
    {
        return $this->game->awayTeam->players;
    }

    #[Computed]
    public function recentEvents()
    {
        return ScoreEvent::where('game_id', $this->game->id)
            ->with('player') // Eager load for the name
            ->latest()
            ->take(10)
            ->get();
    }

    public function render()
    {
        return view('livewire.public.match-center')->layout('components.layouts.public');

    }
}