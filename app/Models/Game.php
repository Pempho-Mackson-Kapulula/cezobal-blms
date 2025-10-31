<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'division_id',
        'home_team_id',
        'away_team_id',
        'date',
        'time_slot_id',
        'court_id',
        'scorekeeper_id',
        'statistician_id',
        'status',
        'score_home',
        'score_away',
        'current_period',
        'completed_at',
    ];

    protected $casts = [
        'date' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // 🔗 Relationships
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function court()
    {
        return $this->belongsTo(Court::class);
    }

    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }

    public function scorekeeper()
    {
        return $this->belongsTo(User::class, 'scorekeeper_id');
    }

    public function statistician()
    {
        return $this->belongsTo(User::class, 'statistician_id');
    }

    public function players()
    {
        return $this->belongsToMany(Player::class, 'game_player');
    }

    // ✅ Helper: Mark game as completed/finalized
    public function finalizeGame(): void
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }

    // ✅ Quick helper to check completion
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }
}
