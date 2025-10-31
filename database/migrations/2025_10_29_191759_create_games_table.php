<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('division_id')->constrained()->cascadeOnDelete();
            $table->foreignId('home_team_id')->constrained('teams');
            $table->foreignId('away_team_id')->constrained('teams');
            $table->dateTime('date');
            $table->foreignId('time_slot_id')->nullable()->constrained('time_slots');
            $table->foreignId('court_id')->nullable()->constrained('courts');
            $table->foreignId('scorekeeper_id')->nullable()->constrained('users');
            $table->foreignId('statistician_id')->nullable()->constrained('users');
            
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'canceled'])
                  ->default('scheduled');

            $table->integer('score_home')->default(0);
            $table->integer('score_away')->default(0);
            $table->integer('current_period')->default(1);
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
