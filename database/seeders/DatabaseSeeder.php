<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Product::factory(20)->create();

        // // Admin user
        // User::create([
        //     'name' => 'Admin',
        //     'email' => 'admin@test.com',
        //     'contact_number' => '1234567899',
        //     'password' => bcrypt('admin'),
        //     'role' => 'admin',
            
        // ]);

        // // Regular user
        // User::create([
        //     'name' => 'User',
        //     'email' => 'user@test.com',
        //     'contact_number' => '1234567890',
        //     'password' => bcrypt('user'),
        //     'role' => 'user',
            
        // ]);

        // Cart
        Cart::create([
            'user_id' => 2,
            'product_id' => 1,
            'quantity_requested' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
