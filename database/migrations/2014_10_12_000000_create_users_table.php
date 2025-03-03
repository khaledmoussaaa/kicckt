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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('social_id');
            $table->string('phone')->nullable();
            $table->integer('joining_numbers')->default(0);
            $table->integer('missing_numbers')->default(0);
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('blocked')->default(false);
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['id', 'email', 'social_id', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
