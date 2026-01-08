<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::role('user')->get();
        $categories = Category::all();

        foreach ($users as $user) {
            Item::create([
                'user_id' => $user->id,
                'category_id' => $categories->random()->id,
                'item_name' => 'Rare Item ' . rand(1, 100),
                'rarity' => 'Epic',
                'description' => 'Item langka untuk game',
                'status' => 'approved',
                'is_verified' => true,
            ]);
        }
    }
}