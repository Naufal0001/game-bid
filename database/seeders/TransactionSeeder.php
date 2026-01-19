<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\Auction;
use App\Models\User;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil satu auction yang sudah ada (status active/closed)
        $auction = Auction::first();
        
        // Ambil satu user (pembeli)
        $buyer = User::where('id', '!=', $auction->item->user_id)->first();

        if ($auction && $buyer) {
            Transaction::create([
                'auction_id'    => $auction->id,
                'user_id'       => $buyer->id,       // DULU: buyer_id, SEKARANG: user_id
                'final_price'   => 150000,           // DULU: total_price, SEKARANG: final_price
                'game_username' => 'GamerPro123',    // KOLOM BARU
                'game_uid'      => '88291022',       // KOLOM BARU
                'payment_proof' => 'payments/dummy.jpg', // KOLOM BARU
                'status'        => 'pending',
                'created_at' => now(),
                'payment_deadline' => now()->addHours(1), // KOLOM BARU
            ]);
            
            // Update status auction agar sinkron
            $auction->update(['status' => 'pending_payment']);
        }
    }
}