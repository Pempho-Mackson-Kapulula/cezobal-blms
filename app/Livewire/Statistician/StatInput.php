<?php

namespace App\Livewire\Statistician;

use Livewire\Component;
use App\Models\Game;
use App\Models\Player;
use App\Models\ScoreEvent;


class StatInput extends Component
{
    public Game $game;

    public function mount(Game $game)
    {
        $this->game = Game::with('homeTeam.players', 'awayTeam.players')->findOrFail($game->id);

        // Prepare player stats aggregation
        foreach ($this->game->homeTeam->players as $player) {
            $player->stats = $this->aggregateStats($player->id);
        }

        foreach ($this->game->awayTeam->players as $player) {
            $player->stats = $this->aggregateStats($player->id);
        }
    }

    public function addStat($playerId, $eventType)
    {
        ScoreEvent::create([
            'game_id' => $this->game->id,
            'player_id' => $playerId,
            'team_id' => Player::find($playerId)->team_id,
            'event_type' => $eventType,
        ]);

        // Recalculate stats for this player
        $player = $this->game->homeTeam->players->firstWhere('id', $playerId)
            ?? $this->game->awayTeam->players->firstWhere('id', $playerId);

        if ($player) {
            $player->stats = $this->aggregateStats($playerId);
        }
    }


    protected function aggregateStats($playerId)
    {
        $events = ScoreEvent::where('player_id', $playerId)
            ->where('game_id', $this->game->id)
            ->get();

        $stats = [
            'min' => 0,
            'fg' => '0-0',
            '3pt' => '0-0',
            'ft' => '0-0',
            'oreb' => 0,
            'dreb' => 0,
            'reb' => 0,
            'ast' => 0,
            'stl' => 0,
            'blk' => 0,
            'to' => 0,
            'pf' => 0,
            'pts' => 0,
        ];

        foreach ($events as $event) {
            switch ($event->event_type) {
                case '2pt':
                    $stats['pts'] += 2;
                    break;
                case '3pt':
                    $stats['pts'] += 3;
                    break;
                case 'ft':
                    $stats['pts'] += 1;
                    break;
                case 'oreb':
                    $stats['oreb'] += 1;
                    break;
                case 'dreb':
                    $stats['dreb'] += 1;
                    break;
                case 'ast':
                    $stats['ast'] += 1;
                    break;
                case 'stl':
                    $stats['stl'] += 1;
                    break;
                case 'blk':
                    $stats['blk'] += 1;
                    break;
                case 'to':
                    $stats['to'] += 1;
                    break;
                case 'pf':
                    $stats['pf'] += 1;
                    break;
            }
        }

        $stats['reb'] = $stats['oreb'] + $stats['dreb'];
        return $stats;
    }

    public function render()
    {
        return view('livewire.statistician.stat-input');
    }
}
