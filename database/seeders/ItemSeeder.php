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

       
            Item::create([
                'user_id' => 2,
                'category_id' => 1,
                'item_name' => 'AKUN VALO GACOR',
                'rarity' => 'Epic',
                'description' => 'Akun 90 skins, termasuk prime+valorant points 100k',
                'image' => 'images/valo.jpeg',
                'status' => 'approved',
                'is_verified' => true,
            ]);

            Item::create([
                'user_id' => 3,
                'category_id' => 4,
                'item_name' => 'SEASIDE VACATION (kutang)',
                'rarity' => 'Epic',
                'description' => 'Rare swimsuit cosmetic tanium gachapon',
                'image' => 'images/seaside.webp',
                'status' => 'approved',
                'is_verified' => true,
            ]);
             Item::create([
                'user_id' => 4,
                'category_id' => 8,
                'item_name' => 'Algorithm Data',
                'rarity' => 'Epic',
                'description' => 'Super ultra rare data fragment dropped from worldboss with 0.001% chance',
                'image' => 'images/algodata.webp',
                'status' => 'approved',
                'is_verified' => true,
            ]);
            Item::create([
                'user_id' => 5,
                'category_id' => 8,
                'item_name' => 'Tof Byte',
                'rarity' => 'Epic',
                'description' => 'Just dropped after farming for 20 hours lmao',
                'image' => 'images/byte.webp',
                'status' => 'approved',
                'is_verified' => true,
            ]);
            Item::create([
                'user_id' => 6,
                'category_id' => 6,
                'item_name' => 'Tata Comics',
                'rarity' => 'Epic',
                'description' => 'idk if this is rare but here you go',
                'image' => 'images/comic.webp',
                'status' => 'approved',
                'is_verified' => true,
            ]);
            Item::create([
                'user_id' => 7,
                'category_id' => 2,
                'item_name' => 'AWP NAGA (lupa nama)',
                'rarity' => 'Epic',
                'description' => 'Hoki drop dari case, harting PM',
                'image' => 'images/cs2.webp',
                'status' => 'approved',
                'is_verified' => true,
            ]);
            Item::create([
                'user_id' => 4,
                'category_id' => 7,
                'item_name' => 'EVOLUTION CUBE',
                'rarity' => 'Epic',
                'description' => 'Rare Altered SSR weapon',
                'image' => 'images/evocube.webp',
                'status' => 'approved',
                'is_verified' => true,
            ]);
            Item::create([
                'user_id' => 3,
                'category_id' => 3,
                'item_name' => 'Heavenly Hound',
                'rarity' => 'Epic',
                'description' => 'Legendary mount just dropped from worldboss with 0.05% chance',
                'image' => 'images/ragnarok.png',
                'status' => 'approved',
                'is_verified' => true,
            ]);
            Item::create([
                'user_id' => 5,
                'category_id' => 5,
                'item_name' => 'Speedy Lightwheel',
                'rarity' => 'Epic',
                'description' => 'Mount with high speed and acceleration stats, fit for couple (rideable up to 2 max players)',
                'image' => 'images/lightwheel.webp',
                'status' => 'approved',
                'is_verified' => true,
            ]);
    }
}