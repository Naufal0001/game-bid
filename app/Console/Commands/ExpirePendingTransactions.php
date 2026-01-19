<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class ExpirePendingTransactions extends Command
{
    protected $signature = 'transactions:expire';
    protected $description = 'Auto-expire pending transactions past payment deadline';

    public function handle(): int
    {
        DB::transaction(function () {

            $transactions = Transaction::with(['auction.item', 'payment'])
                ->where('status', 'pending')
                ->where('payment_deadline', '<', now())
                ->get();

            foreach ($transactions as $trx) {

                // 1️⃣ Expire transaction
                $trx->update([
                    'status' => 'expired'
                ]);

                // 2️⃣ Expire payment
                if ($trx->payment) {
                    $trx->payment->update([
                        'payment_status' => 'expired'
                    ]);
                }

                // 3️⃣ Expire auction
                $trx->auction->update([
                    'status' => 'expired'
                ]);

                // 4️⃣ Kembalikan item
                $trx->auction->item->update([
                    'status' => 'verified'
                ]);
            }
        });

        $this->info('Expired transactions processed successfully.');

        return Command::SUCCESS;
    }
}
