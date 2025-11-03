<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            $table->foreignId('team_manager_id')
                ->nullable() 
                ->constrained('users')
                ->cascadeOnDelete();

            // Division and home court
            $table->foreignId('division_id')->constrained()->cascadeOnDelete();
            $table->foreignId('home_court_id')->constrained('courts');

            // Optional fields
            $table->string('coach_name')->nullable();
            $table->text('bio')->nullable();
            $table->string('logo_path')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
