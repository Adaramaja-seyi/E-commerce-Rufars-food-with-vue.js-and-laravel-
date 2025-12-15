<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'oluwaseyiadaramaja@gmail.com',
            'password' => Hash::make('Admin23'), // Change this in production!
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        // Create a regular test user
        User::create([
            'name' => 'John Doe',
            'email' => 'user@rufarsfoods.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);
    }
}
