<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('joins', function (Blueprint $table) {
            $table->id();
            $table->enum('team_color', ['red', 'purple']);
            $table->integer('goals')->default(0);
            $table->integer('assists')->default(0);
            $table->integer('goal_keeper')->default(0);
            $table->integer('position')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('match_id')->constrained('match_games')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('joins');
    }
};
