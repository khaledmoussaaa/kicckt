<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(LaratrustSeeder::class);
        $this->call(UserSeeder::class);
        // User::factory()->count(10)->create();
        // Join::factory()->count(10)->create();
    }
}
