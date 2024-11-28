<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Product::factory(10)->create();

        // Admin user
        // User::create([
        //     'name' => 'Admin User',
        //     'email' => 'admin@example.com',
        //     'password' => bcrypt('admin'),
        //     'role' => 'admin',
            
        // ]);

        // // Regular user
        // User::create([
        //     'name' => 'John Doe',
        //     'email' => 'user@example.com',
        //     'password' => bcrypt('user'),
        //     'role' => 'user',
            
        // ]);
    }
}
