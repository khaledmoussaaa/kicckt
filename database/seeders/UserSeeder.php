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
            'name' => 'Khalil',
            'email' => 'khalilmohabulail@gmail.com',
            'phone' => '+962791759617',
            'social_id' => '109166918267821418640'
        ]);
        $user->syncRoles(['superadmin']);
    }
}
