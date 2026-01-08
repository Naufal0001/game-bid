<?php

namespace Database\Seeders;

use App\Models\Bid;
use App\Models\Auction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BidSeeder extends Seeder
{
    public function run(): void
    {
        $auctions = Auction::all();
        $users = User::role('user')->get();

        foreach ($auctions as $auction) {
            $bidPrice = $auction->starting_price;

            for ($i = 0; $i < rand(1, 3); $i++) {
                $bidPrice += $auction->min_increment;

                Bid::create([
                    'auction_id' => $auction->id,
                    'user_id' => $users->random()->id,
                    'bid_price' => $bidPrice,
                    'bid_time' => Carbon::now(),
                ]);

                $auction->update(['current_price' => $bidPrice]);
            }
        }
    }
}