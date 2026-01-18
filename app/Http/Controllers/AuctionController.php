<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    /**
     * Menampilkan semua auction aktif
     */
    public function index()
    {
        $auctions = Auction::with(['item.category', 'bids'])
            ->where('status', 'active')
            ->orderBy('end_time', 'asc')
            ->paginate(10);

        return view('auction.index', compact('auctions'));
    }

    /**
     * Menampilkan detail auction
     */
    public function show($id)
    {
        $auction = Auction::with([
                'item.user',
                'item.category',
                'bids.user',
                'winner'
            ])
            ->findOrFail($id);

        return view('auction.show', compact('auction'));
    }
}