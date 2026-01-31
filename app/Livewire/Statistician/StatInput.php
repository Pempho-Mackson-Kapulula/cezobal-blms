<?php



namespace App\Livewire\Statistician;



use Livewire\Component;

use App\Models\{Game, Player, ScoreEvent};

use Livewire\Attributes\Computed;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Collection;



class StatInput extends Component
{

    public Game $game;

    public bool $isLocked = false;

    public $lastActionId = null;

    public int $period = 1;

    public bool $showBoxscore = false;



    // NEW: Tracks which on-court player is being replaced

    public $swappingPlayerId = null;



    public array $onCourtIds = [];



    const MAX_PLAYER_FOULS = 5;

    const REGULAR_PERIODS = 4;



    public function mount(Game $game)
    {

        $this->game = $game;

        $this->isLocked = $game->status === 'completed';

        $this->period = $game->current_period ?? 1;



        // Auto-initialize with first 5 players from each team if not set

        $this->onCourtIds = array_merge(

            $this->game->homeTeam->players->take(5)->pluck('id')->toArray(),

            $this->game->awayTeam->players->take(5)->pluck('id')->toArray()

        );

    }

    public function initiateSwap($outPlayerId)
    {

        $this->swappingPlayerId = $outPlayerId;

    }



    public function confirmSwap($inPlayerId)
    {
        if (!$this->swappingPlayerId)
            return;

        $outPlayer = Player::find($this->swappingPlayerId);
        $inPlayer = Player::find($inPlayerId);

        // Guard: Ensure both players exist and belong to the same team
        if (!$outPlayer || !$inPlayer || $outPlayer->team_id !== $inPlayer->team_id) {
            session()->flash('error', 'Substitution must be between players of the same team.');
            $this->swappingPlayerId = null;
            return;
        }

        // Remove old player, add new player
        $this->onCourtIds = array_diff($this->onCourtIds, [$this->swappingPlayerId]);
        $this->onCourtIds[] = $inPlayerId;

        $this->swappingPlayerId = null;
        session()->flash('message', 'Substitution complete.');
    }



    public function cancelSwap()
    {

        $this->swappingPlayerId = null;

    }



    // --- COMPUTED PROPERTIES ---

    #[Computed]

    public function periodLabel(): string
    {

        if ($this->period <= self::REGULAR_PERIODS) {

            return "P{$this->period}";

        }



        $otCount = $this->period - self::REGULAR_PERIODS;

        return $otCount === 1 ? 'OT' : "{$otCount}OT";

    }



    #[Computed]

    public function homePlayers()
    {

        return Player::where('team_id', $this->game->home_team_id)->get();

    }



    #[Computed]

    public function awayPlayers()
    {

        return Player::where('team_id', $this->game->away_team_id)->get();

    }



    #[Computed]

    public function stats(): Collection
    {

        return ScoreEvent::where('game_id', $this->game->id)

            ->select('player_id', 'event_type', DB::raw('count(*) as count'))

            ->groupBy('player_id', 'event_type')

            ->get()

            ->groupBy('player_id');

    }



    #[Computed]

    public function teamFouls(): Collection
    {

        return ScoreEvent::where('game_id', $this->game->id)

            ->where('event_type', 'pf')

            ->where('period', $this->period)

            ->select('team_id', DB::raw('count(*) as count'))

            ->groupBy('team_id')

            ->pluck('count', 'team_id');

    }



    #[Computed]

    public function teamStats(): array
    {

        $allEvents = ScoreEvent::where('game_id', $this->game->id)->get();

        $calc = function ($teamId) use ($allEvents) {

            $t = $allEvents->where('team_id', $teamId);

            $m2 = $t->where('event_type', '2pt')->count();

            $a2 = $t->where('event_type', '2pt_attempt')->count() + $m2;

            $m3 = $t->where('event_type', '3pt')->count();

            $a3 = $t->where('event_type', '3pt_attempt')->count() + $m3;

            return [

                'reb' => $t->where('event_type', 'reb')->count(),

                'ast' => $t->where('event_type', 'ast')->count(),

                'fg_percent' => ($a2 + $a3) > 0 ? round((($m2 + $m3) / ($a2 + $a3)) * 100) : 0,

            ];

        };

        return ['home' => $calc($this->game->home_team_id), 'away' => $calc($this->game->away_team_id)];

    }



    // --- ACTIONS ---



    public function addShot(int $playerId, string $type, bool $made)
    {

        if ($this->isLocked)

            return;

        $event = match ($type) {

            '2fg' => $made ? '2pt' : '2pt_attempt',

            '3pt' => $made ? '3pt' : '3pt_attempt',

            'ft' => $made ? 'ft' : 'ft_attempt',

            default => null,

        };
        if ($event)
            $this->recordEvent($playerId, $event);

    }
    public function addStat(int $playerId, string $stat)
    {
        if ($this->isLocked || ($this->isDisqualified($playerId) && $stat !== 'pf')) {
            session()->flash('error', 'Player is disqualified.');
            return;
        }

        if ($this->isLocked)

            return;

        if ($stat === 'pf' && (($this->stats[$playerId] ?? collect())->where('event_type', 'pf')->first()->count ?? 0) >= self::MAX_PLAYER_FOULS) {

            session()->flash('error', 'Player fouled out.');

            return;
        }
        $this->recordEvent($playerId, $stat);
    }
    // Helper to check if a player is disqualified
    public function isDisqualified($playerId): bool
    {
        $fouls = $this->stats->get($playerId)?->where('event_type', 'pf')->first()?->count ?? 0;
        return $fouls >= self::MAX_PLAYER_FOULS;
    }



    protected function recordEvent(int $playerId, string $type)
    {

        $player = Player::findOrFail($playerId);

        $event = ScoreEvent::create([

            'player_id' => $player->id,

            'team_id' => $player->team_id,

            'game_id' => $this->game->id,

            'event_type' => $type,

            'period' => $this->period,

        ]);

        $this->lastActionId = $event->id;

        $this->updateGameScore();

    }



    public function undoLastAction()
    {

        if (!$this->lastActionId || $this->isLocked)

            return;

        ScoreEvent::find($this->lastActionId)?->delete();

        $this->updateGameScore();

        $this->lastActionId = null;

    }



    protected function updateGameScore()
    {

        $scores = ScoreEvent::where('game_id', $this->game->id)

            ->select('team_id', DB::raw('SUM(CASE WHEN event_type="2pt" THEN 2 WHEN event_type="3pt" THEN 3 WHEN event_type="ft" THEN 1 ELSE 0 END) as total'))

            ->groupBy('team_id')->pluck('total', 'team_id');

        $this->game->update(['score_home' => $scores[$this->game->home_team_id] ?? 0, 'score_away' => $scores[$this->game->away_team_id] ?? 0]);

        $this->game->refresh();

    }



    public function changePeriod()
    {

        if ($this->isLocked)

            return;

        $this->period++;

        $this->game->update(['current_period' => $this->period]);

    }



    public function finalizeGame()
    {

        if ($this->isLocked)

            return;

        $this->game->update(['status' => 'completed', 'completed_at' => now()]);

        $this->isLocked = true;

    }



    public function render()
    {

        return view('livewire.statistician.stat-input');

    }

}