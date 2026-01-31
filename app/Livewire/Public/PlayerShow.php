<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\{Player, ScoreEvent};
use Livewire\Attributes\{Computed, Layout};
use Illuminate\Support\Facades\DB;

class PlayerShow extends Component
{
    public Player $player;

    public function mount(Player $player)
    {
        $this->player = $player->load('team.division');
    }

    #[Computed]
    public function averages()
    {
        return ScoreEvent::where('player_id', $this->player->id)
            ->whereHas('game', fn($q) => $q->where('status', 'completed'))
            ->selectRaw('
                COUNT(DISTINCT game_id) as gp,
                SUM(CASE WHEN event_type = "2pt" THEN 2 WHEN event_type = "3pt" THEN 3 WHEN event_type = "ft" THEN 1 ELSE 0 END) / COUNT(DISTINCT game_id) as ppg,
                SUM(CASE WHEN event_type = "reb" THEN 1 ELSE 0 END) / COUNT(DISTINCT game_id) as rpg,
                SUM(CASE WHEN event_type = "ast" THEN 1 ELSE 0 END) / COUNT(DISTINCT game_id) as apg,
                SUM(CASE WHEN event_type = "stl" THEN 1 ELSE 0 END) / COUNT(DISTINCT game_id) as spg,
                SUM(CASE WHEN event_type = "blk" THEN 1 ELSE 0 END) / COUNT(DISTINCT game_id) as bpg
            ')
            ->first();
    }

    #[Computed]
    public function recentGames()
    {
        return ScoreEvent::where('player_id', $this->player->id)
            ->with('game')
            ->latest()
            ->take(5)
            ->get();
    }

    #[Layout('components.layouts.public')]
    public function render()
    {
        return view('livewire.public.player-show');
    }
}
