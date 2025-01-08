<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(LaratrustSeeder::class);
        // $this->call(UserSeeder::class);
        // $users = User::factory()->count(10)->create();
        // // Assign the 'user' role to each user
        // foreach ($users as $user) {
        //     $user->syncRoles(['user']);
        // }
    }
}
