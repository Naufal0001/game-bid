<?php

namespace Database\Seeders;

use App\Models\Auction;
use App\Models\Item;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AuctionSeeder extends Seeder
{
    public function run(): void
    {
            Auction::create([
                'item_id' => 1,
                'seller_id' => 2,
                'starting_price' => 10000000,
                'current_price' => 10000000,
                'buyout_price' => 50000000,
                'min_increment' => 500000,
                'start_time' => Carbon::now()->subHours(1),
                'end_time' => Carbon::now()->addHours(24),
                'status' => 'active',
            ]);
            Auction::create([
                'item_id' => 2,
                'seller_id' => 2,
                'starting_price' => 100000,
                'current_price' => 100000,
                'buyout_price' => 500000,
                'min_increment' => 5000,
                'start_time' => Carbon::now()->subHours(1),
                'end_time' => Carbon::now()->addHours(24),
                'status' => 'active',
            ]);
            Auction::create([
                'item_id' => 3,
                'seller_id' => 3,
                'starting_price' => 10000,
                'current_price' => 10000,
                'buyout_price' => 50000,
                'min_increment' => 5000,
                'start_time' => Carbon::now()->subHours(1),
                'end_time' => Carbon::now()->addHours(24),
                'status' => 'active',
            ]);
            Auction::create([
                'item_id' => 4,
                'seller_id' => 3,
                'starting_price' => 18000,
                'current_price' => 18000,
                'buyout_price' => 50000,
                'min_increment' => 5000,
                'start_time' => Carbon::now()->subHours(1),
                'end_time' => Carbon::now()->addHours(24),
                'status' => 'active',
            ]);
            Auction::create([
                'item_id' => 5,
                'seller_id' => 4,
                'starting_price' => 20000,
                'current_price' => 20000,
                'buyout_price' => 70000,
                'min_increment' => 5000,
                'start_time' => Carbon::now()->subHours(1),
                'end_time' => Carbon::now()->addHours(24),
                'status' => 'active',
            ]);
            Auction::create([
                'item_id' => 6,
                'seller_id' => 4,
                'starting_price' => 700000,
                'current_price' => 700000,
                'buyout_price' => 3000000,
                'min_increment' => 50000,
                'start_time' => Carbon::now()->subHours(1),
                'end_time' => Carbon::now()->addHours(24),
                'status' => 'active',
            ]);
            Auction::create([
                'item_id' => 7,
                'seller_id' => 5,
                'starting_price' => 100000,
                'current_price' => 100000,
                'buyout_price' => 500000,
                'min_increment' => 5000,
                'start_time' => Carbon::now()->subHours(1),
                'end_time' => Carbon::now()->addHours(24),
                'status' => 'active',
            ]);
            Auction::create([
                'item_id' => 8,
                'seller_id' => 5,
                'starting_price' => 60000,
                'current_price' => 60000,
                'buyout_price' => 200000,
                'min_increment' => 5000,
                'start_time' => Carbon::now()->subHours(1),
                'end_time' => Carbon::now()->addHours(24),
                'status' => 'active',
            ]);
            Auction::create([
                'item_id' => 9,
                'seller_id' => 6,
                'starting_price' => 300000,
                'current_price' => 300000,
                'buyout_price' => 700000,
                'min_increment' => 5000,
                'start_time' => Carbon::now()->subHours(1),
                'end_time' => Carbon::now()->addHours(24),
                'status' => 'active',
            ]);
    }
}