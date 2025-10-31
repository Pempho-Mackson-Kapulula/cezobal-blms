<?php

namespace App\Livewire\Statistician;

use Livewire\Component;
use App\Models\Game;
use App\Models\Player;
use App\Models\ScoreEvent;

class StatInput extends Component
{
    public Game $game;
    public bool $isLocked = false;

    public array $homePlayerStats = [];
    public array $awayPlayerStats = [];
    public array $teamTotals = [];

    public function mount(Game $game)
    {
        $this->loadGame($game->id);
    }

    protected function loadGame($gameId)
    {
        $this->game = Game::with('homeTeam.players', 'awayTeam.players')->findOrFail($gameId);
        $this->isLocked = $this->game->status === 'completed';

        $this->computeStats();
    }

    protected function computeStats()
    {
        $this->homePlayerStats = [];
        $this->awayPlayerStats = [];

        foreach ($this->game->homeTeam->players as $player) {
            $this->homePlayerStats[$player->id] = $this->aggregateStats($player->id);
        }

        foreach ($this->game->awayTeam->players as $player) {
            $this->awayPlayerStats[$player->id] = $this->aggregateStats($player->id);
        }

        $this->computeTeamTotals();
    }

    
    public function addShot($playerId, $type, $made)
    {
        if ($this->isLocked)
            return;

        $player = Player::findOrFail($playerId);

        if ($made) {
            $eventType = match ($type) {
                'fg' => '2pt',
                '3pt' => '3pt',
                'ft' => 'ft',
            };
        } else {
            $eventType = match ($type) {
                'fg' => '2pt_attempt',
                '3pt' => '3pt_attempt',
                'ft' => 'ft_attempt',
            };
        }

        ScoreEvent::create([
            'player_id' => $playerId,
            'team_id' => $player->team_id,
            'game_id' => $this->game->id,
            'event_type' => $eventType,
        ]);

        $this->computeStats();
    }

    public function addStat($playerId, $stat)
    {
        if ($this->isLocked)
            return;

        $player = Player::findOrFail($playerId);

        ScoreEvent::create([
            'player_id' => $player->id,
            'team_id' => $player->team_id,
            'game_id' => $this->game->id,
            'event_type' => $stat,
        ]);

        $this->computeStats();
    }

    protected function computeTeamTotals()
    {
        $this->teamTotals = [];

        foreach (['homeTeam', 'awayTeam'] as $teamSide) {
            $team = $this->game->$teamSide;
            $totals = [
                'min' => 0,
                '2fg_made' => 0,
                '2fg_attempt' => 0,
                '3pt_made' => 0,
                '3pt_attempt' => 0,
                'fg_made' => 0,       // overall FG
                'fg_attempt' => 0,    // overall FG
                'ft_made' => 0,
                'ft_attempt' => 0,
                'reb' => 0,
                'ast' => 0,
                'stl' => 0,
                'blk' => 0,
                'to' => 0,
                'pf' => 0,
                'pts' => 0,
            ];

            foreach ($team->players as $player) {
                $s = $teamSide === 'homeTeam' ? $this->homePlayerStats[$player->id] : $this->awayPlayerStats[$player->id];

                $totals['min'] += $s['min'] ?? 0;
                $totals['2fg_made'] += $s['2fg_made'] ?? 0;
                $totals['2fg_attempt'] += $s['2fg_attempt'] ?? 0;
                $totals['3pt_made'] += $s['3pt_made'] ?? 0;
                $totals['3pt_attempt'] += $s['3pt_attempt'] ?? 0;
                $totals['ft_made'] += $s['ft_made'] ?? 0;
                $totals['ft_attempt'] += $s['ft_attempt'] ?? 0;
                $totals['reb'] += $s['reb'] ?? 0;
                $totals['ast'] += $s['ast'] ?? 0;
                $totals['stl'] += $s['stl'] ?? 0;
                $totals['blk'] += $s['blk'] ?? 0;
                $totals['to'] += $s['to'] ?? 0;
                $totals['pf'] += $s['pf'] ?? 0;
            }

            // Calculate overall FG
            $totals['fg_made'] = $totals['2fg_made'] + $totals['3pt_made'];
            $totals['fg_attempt'] = $totals['2fg_attempt'] + $totals['3pt_attempt'];

            $totals['pts'] = $totals['2fg_made'] * 2 + $totals['3pt_made'] * 3 + $totals['ft_made'];

            $this->teamTotals[$teamSide] = $totals;
        }
    }

    protected function aggregateStats($playerId)
    {
        $events = ScoreEvent::where('player_id', $playerId)
            ->where('game_id', $this->game->id)
            ->get();

        $stats = [
            'min' => 0,
            '2fg_made' => 0,
            '2fg_attempt' => 0,
            '3pt_made' => 0,
            '3pt_attempt' => 0,
            'fg_made' => 0,   // overall FG
            'fg_attempt' => 0, // overall FG
            'ft_made' => 0,
            'ft_attempt' => 0,
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
                    $stats['2fg_made']++;
                    $stats['2fg_attempt']++;
                    $stats['pts'] += 2;
                    break;
                case '2pt_attempt':
                    $stats['2fg_attempt']++;
                    break;
                case '3pt':
                    $stats['3pt_made']++;
                    $stats['3pt_attempt']++;
                    $stats['pts'] += 3;
                    break;
                case '3pt_attempt':
                    $stats['3pt_attempt']++;
                    break;
                case 'ft':
                    $stats['ft_made']++;
                    $stats['ft_attempt']++;
                    $stats['pts'] += 1;
                    break;
                case 'ft_attempt':
                    $stats['ft_attempt']++;
                    break;
                case 'reb':
                    $stats['reb']++;
                    break;
                case 'ast':
                    $stats['ast']++;
                    break;
                case 'stl':
                    $stats['stl']++;
                    break;
                case 'blk':
                    $stats['blk']++;
                    break;
                case 'to':
                    $stats['to']++;
                    break;
                case 'pf':
                    $stats['pf']++;
                    break;
            }
        }

        // Overall FG per player
        $stats['fg_made'] = $stats['2fg_made'] + $stats['3pt_made'];
        $stats['fg_attempt'] = $stats['2fg_attempt'] + $stats['3pt_attempt'];

        return $stats;
    }


    public function render()
    {
        return view('livewire.statistician.stat-input', [
            'isLocked' => $this->isLocked,
        ]);
    }
}
