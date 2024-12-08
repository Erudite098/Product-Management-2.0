<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

const randomCategory = ['Fashion & Apparel',
                        'Electronics & Gadgets',
                        'Health & Beauty',
                        'Home & Living',
                        'Toys & Baby Products',
                        'Sports & Outdoor Equipment',
                        'Books & Media',
                        'Groceries & Food Products',
                        'Pet Supplies',
                        'Automotive Parts & Accessories'];


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //Malabanannn
            'barcode' => fake()->numberBetween(1000000000, 9999999999),
            'product_name' => fake()->words(2, true), 
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 10, 1000),
            'quantity' => fake()->numberBetween(1, 100),
            'category' => fake()->randomElement(randomCategory)


        ];
    }
}
