<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::insert([
            ['category_name' => 'Weapon', 'game_name' => 'Valorant'],
            ['category_name' => 'Skin', 'game_name' => 'CS2'],
            ['category_name' => 'Mount', 'game_name' => 'Ragnarok'],
        ]);
    }
}