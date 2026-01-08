<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\Auction;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $auction = Auction::first();

        if ($auction) {
            Transaction::create([
                'auction_id' => $auction->id,
                'buyer_id' => 2,
                'total_price' => $auction->current_price,
                'transaction_date' => Carbon::now(),
                'status' => 'paid',
            ]);
        }
    }
}