<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BidController extends Controller
{
    /**
     * Simpan bid baru
     */
    public function store(Request $request, $auctionId)
    {
        $auction = Auction::lockForUpdate()->findOrFail($auctionId);

        // Validasi auction aktif
        if (! $auction->isActive()) {
            return back()->withErrors('Auction sudah berakhir.');
        }

        $request->validate([
            'bid_price' => 'required|numeric|min:' . ($auction->current_price + $auction->min_increment),
        ]);

        DB::transaction(function () use ($request, $auction) {
            Bid::create([
                'auction_id' => $auction->id,
                'user_id' => Auth::id(),
                'bid_price' => $request->bid_price,
                'bid_time' => Carbon::now(),
            ]);

            $auction->update([
                'current_price' => $request->bid_price,
            ]);
        });

        return back()->with('success', 'Bid berhasil dikirim!');
    }

    public function buyout(Auction $auction)
    {
        if (! $auction->isActive()) {
            return back()->withErrors('Auction sudah berakhir.');
        }

        if (! $auction->buyout_price) {
            return back()->withErrors('Buyout tidak tersedia.');
        }

        \DB::transaction(function () use ($auction) {

            // Lock row
            $auction->lockForUpdate();

            $auction->update([
                'current_price' => $auction->buyout_price,
                'winner_id' => auth()->id(),
                'is_buyout' => true,
                'status' => 'closed',
                'end_time' => now(),
            ]);

            Transaction::create([
                'auction_id' => $auction->id,
                'buyer_id' => auth()->id(),
                'total_price' => $auction->buyout_price,
                'transaction_date' => now(),
                'status' => 'unpaid',
            ]);
        });

        return redirect()
            ->route('auctions.show', $auction)
            ->with('success', 'Buyout berhasil! Anda memenangkan auction.');
    }
}