<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Official extends Model {
    use HasFactory;

    protected $fillable = ['name','role'];

    public function scorekeeperGames() {
        return $this->hasMany(Game::class,'scorekeeper_id');
    }

    public function statisticianGames() {
        return $this->hasMany(Game::class,'statistician_id');
    }
}