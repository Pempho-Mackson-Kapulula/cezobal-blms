<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model {
    use HasFactory;

    protected $fillable = ['start_time','end_time'];

    public function games() {
        return $this->hasMany(Game::class);
    }
}