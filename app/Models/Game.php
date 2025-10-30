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
    ];

    protected $casts = [
        'date' => 'date',
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

    // Use User instead of Official for scorekeeper/statistician
    public function scorekeeper()
    {
        return $this->belongsTo(User::class, 'scorekeeper_id');
    }

    public function statistician()
    {
        return $this->belongsTo(User::class, 'statistician_id');
    }
}
