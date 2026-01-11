<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@feedstore.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'status' => 'active',
            'username' => 'admin',
        ]);

        // Regular User
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'status' => 'active',
            'username' => 'testuser',
        ]);

        // Supplier
        User::factory()->create([
            'name' => 'Supplier User',
            'email' => 'supplier@feedstore.com',
            'password' => bcrypt('password'),
            'role' => 'supplier',
            'status' => 'active',
            'username' => 'supplier',
        ]);

        // Customer
        User::factory()->create([
            'name' => 'Customer User',
            'email' => 'customer@feedstore.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
            'status' => 'active',
            'username' => 'customer',
        ]);
    }
}
