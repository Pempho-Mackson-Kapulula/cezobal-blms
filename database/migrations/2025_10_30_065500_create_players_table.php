<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // Added bio field for player profiles
            $table->text('bio')->nullable(); 
            
            $table->integer('jersey_number')->nullable();
            
            $table->string('position')->nullable(); 
            
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            
            $table->integer('fouls')->default(0); 
            
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
