<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // 1. QUERY DIPERBAIKI
        // Ambil Auction jika: User pernah BID -ATAU- User adalah PEMENANG (untuk kasus Buyout)
        $auctions = Auction::where(function($query) use ($userId) {
            $query->whereHas('bids', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->orWhere('winner_id', $userId);
        })
        ->with(['item.category', 'bids', 'winner'])
        ->latest('updated_at')
        ->get()
        ->map(function ($auction) use ($userId) {
            
            // 2. LOGIKA STATUS DIPERBAIKI
            // Lelang dianggap SELESAI jika status != active ATAU waktu sudah habis
            $isEnded = $auction->status !== 'active' || now() > $auction->end_time;

            // Cari nominal bid terakhir user
            $myBidRecord = $auction->bids->where('user_id', $userId)->sortByDesc('bid_price')->first();
            $myLastBid = $myBidRecord ? $myBidRecord->bid_price : 0;

            // FIX BUYOUT: Jika user menang tapi tidak punya record bid (karena buyout),
            // maka harga bid dia adalah harga akhir lelang.
            if ($auction->winner_id == $userId && $myLastBid == 0) {
                $myLastBid = $auction->current_price;
            }

            // TENTUKAN LABEL STATUS
            if ($isEnded) {
                // Jika lelang sudah selesai, cek apakah user pemenangnya
                $auction->user_status = ($auction->winner_id == $userId) ? 'WON' : 'LOST';
            } else {
                // Jika lelang masih jalan
                // Cek apakah user adalah pemegang bid tertinggi (winner_id sementara)
                $isHighestBidder = $auction->winner_id == $userId;
                $auction->user_status = $isHighestBidder ? 'WINNING' : 'OUTBID';
            }

            $auction->my_last_bid = $myLastBid;
            return $auction;
        });

        return view('history.index', compact('auctions'));
    }
}