<?php

namespace App\Livewire\Scorekeeper;

use Livewire\Component;
use App\Models\Game;
use App\Models\Player;
use App\Models\ScoreEvent;
use Illuminate\Support\Collection;

class ScoreInput extends Component
{
    public Game $game;
    public int $period = 1;

    public Collection $homePlayers;
    public Collection $awayPlayers;

    public int $homeScore = 0;
    public int $awayScore = 0;

    public string $homeTeamName = 'Unknown';
    public string $awayTeamName = 'Unknown';

    public function mount(Game $game)
    {
        // Load the game with teams and players
        $this->game = Game::with(['homeTeam.players', 'awayTeam.players'])->findOrFail($game->id);

        // Assign players to component properties
        $this->homePlayers = $this->game->homeTeam?->players ?? collect();
        $this->awayPlayers = $this->game->awayTeam?->players ?? collect();

        // Set team names
        $this->homeTeamName = $this->game->homeTeam?->name ?? 'Unknown';
        $this->awayTeamName = $this->game->awayTeam?->name ?? 'Unknown';

        // Initialize scores from the database
        $this->homeScore = $this->game->score_home ?? 0;
        $this->awayScore = $this->game->score_away ?? 0;
    }

    /**
     * Add an event for a player
     */
    public function addEvent($playerId, $eventType)
    {
        $player = Player::find($playerId);
        if (!$player) return;

        // Record event in the database
        ScoreEvent::create([
            'game_id' => $this->game->id,
            'player_id' => $player->id,
            'team_id' => $player->team_id,
            'event_type' => $eventType,
            'period' => $this->period,
        ]);

        // Calculate points
        $points = match($eventType) {
            '2pt' => 2,
            '3pt' => 3,
            'ft'  => 1,
            default => 0
        };

        // Update scores locally and in DB
        if ($points > 0) {
            if ($player->team_id === $this->game->home_team_id) {
                $this->homeScore += $points;
                $this->game->increment('score_home', $points);
            } else {
                $this->awayScore += $points;
                $this->game->increment('score_away', $points);
            }
        }

        // Optional: handle fouls, turnovers, steals here
    }

    public function render()
    {
        return view('livewire.scorekeeper.score-input');
    }
}
