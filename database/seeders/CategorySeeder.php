<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::insert([
            ['category_name' => 'Account', 'game_name' => 'Valorant'],
            ['category_name' => 'Skin', 'game_name' => 'CS2'],
            ['category_name' => 'Mount', 'game_name' => 'Ragnarok'],
            ['category_name' => 'Cosmetic', 'game_name' => 'Tower of Fantasy'],
            ['category_name' => 'Mount', 'game_name' => 'Tower of Fantasy'],
            ['category_name' => 'Misc', 'game_name' => 'Tower of Fantasy'],
            ['category_name' => 'Weapon', 'game_name' => 'Tower of Fantasy'],
            ['category_name' => 'Currency', 'game_name' => 'Tower of Fantasy'],
            ['category_name' => 'Equipment', 'game_name' => 'Tower of Fantasy'],
        ]);
    }
}