<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@simbadoors.co.tz',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        // Create additional users if needed
        if (app()->environment('local', 'development')) {
            User::create([
                'name' => 'Editor',
                'email' => 'editor@simbadoors.co.tz',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
        }
    }
}
