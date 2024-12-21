<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super Admin
        $user = User::create([
            'name' => 'Khalil Mohamed',
            'email' => 'khalilmohamed@gmail.com',
            'phone' => '01015571129',
            'social_id' => '123456789'
        ]);
        $user->syncRoles(['superadmin']);
    }
}
