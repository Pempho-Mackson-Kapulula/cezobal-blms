<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'division_id',
        'home_court_id',
        'team_manager_id', // ✅ add manager
        'coach_name',
        'bio',
        'logo_path',
    ];


    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function homeGames()
    {
        return $this->hasMany(Game::class, 'home_team_id');
    }

    public function awayGames()
    {
        return $this->hasMany(Game::class, 'away_team_id');
    }
    public function manager()
    {
        return $this->belongsTo(User::class, 'team_manager_id');
    }
    public function players()
    {
        return $this->hasMany(Player::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get total successful payments
     */
    public function totalPaid()
    {
        return $this->payments()->where('status', 'successful')->sum('amount');
    }

    /**
     * Get total pending payments
     */
    public function totalPending()
    {
        return $this->payments()->where('status', 'pending')->sum('amount');
    }

    /**
     * Get total payments by type
     */
    public function totalPaidByType($type)
    {
        return $this->payments()
            ->where('status', 'successful')
            ->where('payment_type', $type)
            ->sum('amount');
    }

}