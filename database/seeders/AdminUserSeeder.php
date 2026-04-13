<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Prevent duplicate owner during multiple seed runs
        User::updateOrCreate(
            ['email' => 'admin@gosheep.test'],
            [
                'name' => 'Admin Owner',
                'password' => Hash::make('password'),
                'role' => 'owner',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
    }
}
