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
        Schema::create('match_games', function (Blueprint $table) {
            $table->id();

            $table->string('match_name');
            $table->date('date');
            $table->time('time_from');
            $table->time('time_to');
            $table->integer('red_goals')->default(0);
            $table->integer('purple_goals')->default(0);
            $table->integer('joining_numbers')->default(0);
            $table->foreignId('man_of_the_match')->nullable()->constrained('users')->onDelete('cascade');
            $table->enum('status',['pending', 'playing', 'finished'])->default('pending');
            $table->foreignId('staduim_id')->constrained('staduims')->onDelete('cascade');

            $table->timestamps();

            // Add a unique constraint for the combination of date, time_from, time_to, and staduim_id
            $table->unique(['staduim_id', 'date', 'time_from', 'time_to']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_games');
    }
};
