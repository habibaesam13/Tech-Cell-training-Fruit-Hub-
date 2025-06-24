<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::insert([
            [
                'name' => 'Apple',
                'price' => 25.00,
                'quantity' => 100,
                'description' => 'Fresh red apples',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Banana',
                'price' => 15.00,
                'quantity' => 80,
                'description' => 'Sweet yellow bananas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ]);
    }
}
