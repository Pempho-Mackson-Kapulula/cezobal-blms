<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('score_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade');
            $table->foreignId('player_id')->nullable()->constrained('players')->onDelete('set null'); // ✅ fixed
            $table->integer('period')->default(1);
            $table->string('event_type'); // 2pt, 3pt, ft, foul, turnover, steal
            $table->integer('points')->default(0); // ✅ optional but practical
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('score_events');
    }
};
