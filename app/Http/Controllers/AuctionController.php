<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    /**
     * Menampilkan semua auction aktif dengan fitur Filter & Search
     */
    public function index(Request $request)
    {
        // 1. Mulai Query Builder dengan Eager Loading
        $query = Auction::with(['item.category', 'bids'])
            ->where('status', 'active'); 

        // [LOGIKA PENCARIAN]
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('item', function($q) use ($search) {
                $q->where('item_name', 'LIKE', "%{$search}%");
            });
        }

        // [FITUR FILTERING]
        // 2. Filter Kategori Game
        if ($request->filled('game')) {
            $query->whereHas('item.category', function($q) use ($request) {
                $q->whereIn('game_name', $request->game);
            });
        }

        // 3. Filter Tipe Item
        if ($request->filled('category')) {
            $query->whereHas('item.category', function($q) use ($request) {
                $q->whereIn('category_name', $request->category);
            });
        }

        // 4. Filter Range Harga (Berdasarkan Buyout Price)
        if ($request->filled('min_price')) {
            $query->where('buyout_price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('buyout_price', '<=', $request->max_price);
        }

        // 5. Eksekusi
        $auctions = $query->orderBy('end_time', 'asc')
            ->paginate(9)
            ->withQueryString();

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

    /**
     * Memproses tawaran (Bid) dari user
     */
    public function bid(Request $request, Auction $auction)
    {
        // 1. Validasi Input
        $request->validate([
            'bid_price' => 'required|numeric',
        ]);

        // 2. Cek apakah user menawar barang sendiri
        if ($auction->item->user_id == auth()->id()) {
            return back()->with('error', 'Anda tidak bisa menawar barang sendiri!');
        }

        // 3. Tentukan harga minimal bid berikutnya
        $minBid = $auction->current_price 
            ? $auction->current_price + $auction->min_increment 
            : $auction->starting_price; 

        if ($request->bid_price < $minBid) {
            return back()->with('error', 'Tawaran terlalu rendah! Minimal: Rp ' . number_format($minBid, 0, ',', '.'));
        }

        // 4. Update harga di tabel Auctions
        $auction->update([
            'current_price' => $request->bid_price,
            'winner_id' => auth()->id(),
        ]);

        // 5. Simpan riwayat ke tabel Bids
        Bid::create([
            'auction_id' => $auction->id,
            'user_id' => auth()->id(),
            'bid_price' => $request->bid_price,
            'bid_time' => now(),
        ]);

        return back()->with('success', 'Tawaran berhasil masuk!');
    }

    /**
     * Memproses pembelian langsung (Buyout)
     */
    public function buyout(Auction $auction)
    {
        // 1. Cek validasi dasar
        if ($auction->status !== 'active') {
            return back()->with('error', 'Lelang ini sudah berakhir.');
        }

        if ($auction->item->user_id == auth()->id()) {
            return back()->with('error', 'Anda tidak bisa membeli barang sendiri!');
        }

        // 2. Update status Auction jadi Closed/Sold
        $auction->update([
            'status' => 'closed',
            'winner_id' => auth()->id(),
            'current_price' => $auction->buyout_price,
            'end_time' => now(),
        ]);

        return redirect()->route('auctions.show', $auction->id)
            ->with('success', 'Selamat! Anda berhasil memenangkan item ini via Buyout!');
    }

    // =========================================================================
    // FITUR MY AUCTIONS & CREATE (UPDATED FOR INVENTORY SYSTEM)
    // =========================================================================

    /**
     * Menampilkan halaman "My Auctions"
     */
    public function myAuctions()
    {
        $auctions = Auction::whereHas('item', function($query) {
            $query->where('user_id', auth()->id());
        })->with('item')->latest()->get();

        return view('auction.my_auctions', compact('auctions'));
    }

    /**
     * Menampilkan Form Buat Auction (Pilih Item dari Inventory)
     */
    public function create()
    {
        // Cek status user
        if (auth()->user()->status !== 'active') { 
            return redirect()->route('auctions.my_auctions')
                ->with('error', 'Akun belum verifikasi.');
        }

        // AMBIL ITEM YANG:
        // 1. Milik user yang login
        // 2. Status item 'approved' (Terverifikasi)
        // 3. TIDAK sedang dilelang (untuk mencegah double auction pada item yang sama)
        $items = Item::where('user_id', auth()->id())
                    ->where('status', 'approved') 
                    ->whereDoesntHave('auctions', function($q) {
                        $q->where('status', 'active'); 
                    })
                    ->get();

        return view('auction.create', compact('items'));
    }

    /**
     * Menyimpan Auction Baru (Link ke Item yang sudah ada)
     */
    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'item_id'       => 'required|exists:items,id', // Pilih ID Item
            'start_price'   => 'required|numeric|min:0',
            'buyout_price'  => 'required|numeric|gt:start_price',
            'end_time'      => 'required|date|after:now',
        ]);

        // 2. Ambil Item
        $item = Item::findOrFail($request->item_id);

        // 3. Validasi Kepemilikan & Status (Security Check)
        if($item->user_id !== auth()->id() || $item->status !== 'approved') {
            return back()->with('error', 'Item tidak valid atau belum diverifikasi.');
        }

        // 4. Buat Auction
        Auction::create([
            'item_id'        => $item->id,
            'user_id'        => auth()->id(),
            'starting_price' => $request->start_price,
            'current_price'  => null,
            'buyout_price'   => $request->buyout_price,
            'min_increment'  => 10000,
            'start_time'     => now(),
            'end_time'       => $request->end_time,
            'status'         => 'active',
        ]);

        return redirect()->route('auctions.my_auctions')->with('success', 'Lelang berhasil diterbitkan!');
    }
}