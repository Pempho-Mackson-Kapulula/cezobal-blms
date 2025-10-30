<?php

namespace App\Services;

use App\Models\Game;
use App\Models\ScoreEvent;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ScorekeepingService
{
    protected $foulLimit = 5; // Default foul limit per player

    /**
     * Record a game event
     *
     * @param array $data [
     *      'game_id' => int,
     *      'team_id' => int,
     *      'player_id' => int|null,
     *      'period'  => int,
     *      'event_type' => string (2pt, 3pt, ft, foul, turnover, steal, etc)
     * ]
     */
    public function recordEvent(array $data)
    {
        DB::transaction(function () use ($data) {

            // 1️⃣ Create the event
            $event = ScoreEvent::create([
                'game_id'    => $data['game_id'],
                'team_id'    => $data['team_id'],
                'player_id'  => $data['player_id'],
                'period'     => $data['period'],
                'event_type' => $data['event_type'],
                'created_at' => now(),
            ]);

            // 2️⃣ Update score if necessary
            $this->updateGameScore($data['game_id'], $data);

            // 3️⃣ Track fouls and disqualify player if over limit
            if ($data['event_type'] === 'foul' && $data['player_id']) {
                $this->checkPlayerFouls($data['game_id'], $data['player_id']);
            }

            Log::info("ScorekeepingService: Event recorded", [
                'event_id' => $event->id,
                'game_id'  => $data['game_id'],
                'type'     => $data['event_type']
            ]);
        });

        return true;
    }

    /**
     * Update per-team score totals
     */
    protected function updateGameScore($gameId, $data)
    {
        $game = Game::findOrFail($gameId);

        $points = 0;
        switch ($data['event_type']) {
            case '2pt':
                $points = 2;
                break;
            case '3pt':
                $points = 3;
                break;
            case 'ft':
                $points = 1;
                break;
            default:
                $points = 0; // turnovers, steals, fouls don't add points
        }

        if ($points > 0) {
            if ($game->home_team_id == $data['team_id']) {
                $game->home_score = ($game->home_score ?? 0) + $points;
            } elseif ($game->away_team_id == $data['team_id']) {
                $game->away_score = ($game->away_score ?? 0) + $points;
            }
            $game->save();
        }
    }

    /**
     * Return current scores for a game
     */
    public function getGameScore(Game $game)
    {
        return [
            $game->home_team_id => $game->home_score ?? 0,
            $game->away_team_id => $game->away_score ?? 0,
        ];
    }

    /**
     * Check if a player has reached foul limit and disqualify
     */
    protected function checkPlayerFouls($gameId, $playerId)
    {
        $fouls = ScoreEvent::where('game_id', $gameId)
            ->where('player_id', $playerId)
            ->where('event_type', 'foul')
            ->count();

        if ($fouls >= $this->foulLimit) {
            $player = User::find($playerId);
            // You can mark player as disqualified in DB or alert
            Log::warning("ScorekeepingService: Player {$player->name} disqualified after {$fouls} fouls.");
        }
    }
}
