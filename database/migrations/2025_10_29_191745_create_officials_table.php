<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('officials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('role', ['scorekeeper','statistician']);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('officials');
    }
};