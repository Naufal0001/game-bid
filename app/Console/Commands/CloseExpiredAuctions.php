<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auction;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class CloseExpiredAuctions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auction:close-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Close expired auctions and determine winners';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $auctions = Auction::where('status', 'active')
            ->where('end_time', '<=', now())
            ->get();

        foreach ($auctions as $auction) {
            DB::transaction(function () use ($auction) {

                // Ambil bid tertinggi
                $highestBid = $auction->bids()
                    ->orderByDesc('bid_price')
                    ->first();

                if ($highestBid) {
                    $auction->update([
                        'current_price' => $highestBid->bid_price,
                        'winner_id' => $highestBid->user_id,
                        'status' => 'closed',
                    ]);

                    Transaction::firstOrCreate([
                        'auction_id' => $auction->id,
                    ], [
                        'buyer_id' => $highestBid->user_id,
                        'total_price' => $highestBid->bid_price,
                        'transaction_date' => now(),
                        'status' => 'unpaid',
                    ]);
                } else {
                    // Tidak ada bid
                    $auction->update([
                        'status' => 'closed',
                    ]);
                }
            });
        }

        $this->info('Expired auctions processed successfully.');
    }
}
