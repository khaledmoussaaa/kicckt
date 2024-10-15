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
        Schema::create('staduims', function (Blueprint $table) {
            $table->id();

            $table->string('staduim_name');
            $table->string('area')->nullable();
            $table->string('location')->nullable();
            $table->enum('players_number', ['12', '14', '18', '24'])->default(12);
            $table->integer('sales')->default(0);
            $table->double('price');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staduims');
    }
};
