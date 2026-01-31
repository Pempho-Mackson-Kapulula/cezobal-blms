<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'team_id', 
        'position', 
        'fouls',
        'bio', // Added
        'jersey_number' // Added
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function games()
    {
        // Assuming you have a pivot table 'game_player'
        return $this->belongsToMany(Game::class, 'game_player');
    }
}
