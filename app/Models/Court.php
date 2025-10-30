<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Court extends Model {
    use HasFactory;

    protected $fillable = ['name','location'];

    public function teams() {
        return $this->hasMany(Team::class,'home_court_id');
    }

    public function games() {
        return $this->hasMany(Game::class);
    }
}
