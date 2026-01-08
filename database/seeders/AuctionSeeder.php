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
        $items = Item::all();

        foreach ($items as $item) {
            Auction::create([
                'item_id' => $item->id,
                'starting_price' => 10000,
                'current_price' => 10000,
                'buyout_price' => 50000,
                'min_increment' => 5000,
                'start_time' => Carbon::now()->subHours(1),
                'end_time' => Carbon::now()->addHours(24),
                'status' => 'active',
            ]);
        }
    }
}