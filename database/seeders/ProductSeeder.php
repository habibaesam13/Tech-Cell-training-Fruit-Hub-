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
                'name' => 'Cheese Burger',
                'price' => 5.99,
                'description' => 'Grilled beef patty with cheese and toppings.',
                'image' => 'ProductsImages/cheeseburger.jpg',
                'quantity' => 50,
                'category_id' => 1,
                'ingredients' => json_encode(['Beef Patty', 'Cheese', 'Tomato', 'Lettuce']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Spicy Chicken Wrap',
                'price' => 4.49,
                'description' => 'Crispy chicken with spicy sauce and fresh lettuce.',
                'image' => 'ProductsImages/spicywrap.jpg',
                'quantity' => 40,
                'category_id' => 2,
                'ingredients' => json_encode(['Chicken Breast', 'Spicy Sauce', 'Lettuce', 'Tortilla']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pepperoni Pizza',
                'price' => 8.99,
                'description' => 'Classic pizza with mozzarella cheese and pepperoni slices.',
                'image' => 'ProductsImages/pepperonipizza.jpg',
                'quantity' => 30,
                'category_id' => 3,
                'ingredients' => json_encode(['Pizza Dough', 'Mozzarella', 'Pepperoni', 'Tomato Sauce']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Combo Meal Box',
                'price' => 11.99,
                'description' => 'Meal box including burger, fries, and a drink.',
                'image' => 'ProductsImages/combobox.jpg',
                'quantity' => 60,
                'category_id' => 4,
                'ingredients' => json_encode(['Beef Patty', 'Cheese', 'Fries', 'Ketchup', 'Soft Drink']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Loaded Fries',
                'price' => 3.99,
                'description' => 'French fries topped with cheese, jalapeños, and sauces.',
                'image' => 'ProductsImages/loadedfries.jpg',
                'quantity' => 70,
                'category_id' => 1,
                'ingredients' => json_encode(['Fries', 'Cheese', 'Jalapeños', 'Spicy Sauce']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Veggie Salad',
                'price' => 4.99,
                'description' => 'Fresh mix of vegetables with a tangy dressing.',
                'image' => 'ProductsImages/veggiesalad.jpg',
                'quantity' => 80,
                'category_id' => 3,
                'ingredients' => json_encode(['Lettuce', 'Tomato', 'Cucumber', 'Olives', 'Feta Cheese']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Grilled Chicken Sandwich',
                'price' => 6.49,
                'description' => 'Tender grilled chicken with lettuce and mayo on a bun.',
                'image' => 'ProductsImages/grilledchickensandwich.jpg',
                'quantity' => 55,
                'category_id' => 2,
                'ingredients' => json_encode(['Chicken Breast', 'Lettuce', 'Mayonnaise', 'Bread Bun']),
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
