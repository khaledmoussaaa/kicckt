<?php

namespace Database\Seeders;

use App\Models\Join;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        // \App\Models\User::create([
        //     'name' => 'Khaled Moussa',
        //     'email' => 'Khaledmoussa202@gmail.com',
        //     'phone' => '01015571129',
        //     'social_id' => '123456789'
        // ]);

        User::factory()->count(10)->create();
        Join::factory()->count(10)->create();
    }

}
