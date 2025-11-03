<?php

namespace App\Livewire\Statistician;

use Livewire\Component;
use App\Models\Game;
use App\Models\Player;
use App\Models\ScoreEvent;
use Illuminate\Support\Collection;

class StatInput extends Component
{
    public Game $game;
    public $isLocked = false;

    public Collection $homePlayers;
    public Collection $awayPlayers;

    public int $period = 1;
    public int $homeScore = 0;
    public int $awayScore = 0;

    public $homePlayerStats = [];
    public $awayPlayerStats = [];
    public $teamTotals = [];

    protected $listeners = [
        'refreshScoreboard' => 'refreshScores',
    ];

    public function mount(Game $game)
    {
        $this->loadGame($game->id);
    }

    protected function loadGame($gameId)
    {
        $this->game = Game::with(['homeTeam.players', 'awayTeam.players'])->findOrFail($gameId);
        $this->isLocked = $this->game->status === 'completed';
        $this->homePlayers = $this->game->homeTeam?->players ?? collect();
        $this->awayPlayers = $this->game->awayTeam?->players ?? collect();
        $this->homeScore = $this->game->score_home ?? 0;
        $this->awayScore = $this->game->score_away ?? 0;
        $this->computeStats();
    }

    public function addShot($playerId, $type, $made)
    {
        if ($this->isLocked) return;

        $player = Player::findOrFail($playerId);

        $eventType = match($type) {
            '2fg' => $made ? '2pt' : '2pt_attempt',
            '3pt' => $made ? '3pt' : '3pt_attempt',
            'ft'  => $made ? 'ft' : 'ft_attempt',
            default => null,
        };

        if (!$eventType) return;

        ScoreEvent::create([
            'player_id' => $player->id,
            'team_id' => $player->team_id,
            'game_id' => $this->game->id,
            'event_type' => $eventType,
            'period' => $this->period,
        ]);

        // Update scoreboard
        $points = match($eventType) {
            '2pt' => 2,
            '3pt' => 3,
            'ft'  => 1,
            default => 0
        };

        if ($points > 0) {
            if ($player->team_id === $this->game->home_team_id) {
                $this->homeScore += $points;
                $this->game->increment('score_home', $points);
            } else {
                $this->awayScore += $points;
                $this->game->increment('score_away', $points);
            }
        }

        $this->computeStats();
        $this->dispatch('refreshScoreboard', ['gameId' => $this->game->id]);
    }

    public function addStat($playerId, $stat)
    {
        if ($this->isLocked) return;

        $player = Player::findOrFail($playerId);

        ScoreEvent::create([
            'player_id' => $player->id,
            'team_id' => $player->team_id,
            'game_id' => $this->game->id,
            'event_type' => $stat,
            'period' => $this->period,
        ]);

        $this->computeStats();
        $this->dispatch('refreshScoreboard', ['gameId' => $this->game->id]);
    }

    protected function computeStats()
    {
        $this->homePlayerStats = [];
        $this->awayPlayerStats = [];

        foreach ($this->homePlayers as $player) {
            $this->homePlayerStats[$player->id] = $this->aggregateStats($player->id);
        }

        foreach ($this->awayPlayers as $player) {
            $this->awayPlayerStats[$player->id] = $this->aggregateStats($player->id);
        }

        $this->computeTeamTotals();
    }

    protected function computeTeamTotals()
    {
        $this->teamTotals = [];

        foreach (['homeTeam', 'awayTeam'] as $side) {
            $team = $this->game->$side;
            $totals = [
                '2fg_made'=>0,'2fg_attempt'=>0,'3pt_made'=>0,'3pt_attempt'=>0,
                'fg_made'=>0,'fg_attempt'=>0,'ft_made'=>0,'ft_attempt'=>0,
                'reb'=>0,'ast'=>0,'stl'=>0,'blk'=>0,'to'=>0,'pf'=>0,'pts'=>0
            ];

            foreach ($team->players as $player) {
                $stats = $side === 'homeTeam' ? $this->homePlayerStats[$player->id] : $this->awayPlayerStats[$player->id];

                foreach ($totals as $key => $_) {
                    $totals[$key] += $stats[$key] ?? 0;
                }
            }

            $totals['fg_made'] = $totals['2fg_made'] + $totals['3pt_made'];
            $totals['fg_attempt'] = $totals['2fg_attempt'] + $totals['3pt_attempt'];
            $totals['pts'] = $totals['2fg_made']*2 + $totals['3pt_made']*3 + $totals['ft_made'];

            $this->teamTotals[$side] = $totals;
        }
    }

    protected function aggregateStats($playerId)
    {
        $events = ScoreEvent::where('player_id', $playerId)
            ->where('game_id', $this->game->id)
            ->get();

        $stats = [
            '2fg_made'=>0,'2fg_attempt'=>0,'3pt_made'=>0,'3pt_attempt'=>0,
            'fg_made'=>0,'fg_attempt'=>0,'ft_made'=>0,'ft_attempt'=>0,
            'reb'=>0,'ast'=>0,'stl'=>0,'blk'=>0,'to'=>0,'pf'=>0,'pts'=>0
        ];

        foreach ($events as $event) {
            switch($event->event_type){
                case '2pt': $stats['2fg_made']++; $stats['2fg_attempt']++; $stats['pts']+=2; break;
                case '2pt_attempt': $stats['2fg_attempt']++; break;
                case '3pt': $stats['3pt_made']++; $stats['3pt_attempt']++; $stats['pts']+=3; break;
                case '3pt_attempt': $stats['3pt_attempt']++; break;
                case 'ft': $stats['ft_made']++; $stats['ft_attempt']++; $stats['pts']+=1; break;
                case 'ft_attempt': $stats['ft_attempt']++; break;
                case 'reb': $stats['reb']++; break;
                case 'ast': $stats['ast']++; break;
                case 'stl': $stats['stl']++; break;
                case 'blk': $stats['blk']++; break;
                case 'to': $stats['to']++; break;
                case 'pf': $stats['pf']++; break;
            }
        }

        $stats['fg_made'] = $stats['2fg_made'] + $stats['3pt_made'];
        $stats['fg_attempt'] = $stats['2fg_attempt'] + $stats['3pt_attempt'];

        return $stats;
    }

    public function refreshScores($payload)
    {
        if ($payload['gameId'] != $this->game->id) return;

        $this->game->refresh();
        $this->homeScore = $this->game->score_home ?? 0;
        $this->awayScore = $this->game->score_away ?? 0;
    }

    public function render()
    {
        return view('livewire.statistician.stat-input', [
            'isLocked' => $this->isLocked,
            'homeScore' => $this->homeScore,
            'awayScore' => $this->awayScore,
            'homeTeamName' => $this->game->homeTeam?->name ?? 'Unknown',
            'awayTeamName' => $this->game->awayTeam?->name ?? 'Unknown',
        ]);
    }
}
