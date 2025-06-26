<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Category::insert([
            ['name' => 'Popular'],
            ['name' => 'Top'],
            ['name' => 'New'],
            ['name' => 'Combo'],
            ['name' => 'Hottest'],
        ]);
    }
}
