<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Bid; // <--- PENTING: Jangan lupa import Model Bid
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
            ->where('status', 'active'); // Tetap hanya ambil yang aktif

        // [FIXED] LOGIKA PENCARIAN
        // ==================================================
        if ($request->filled('search')) {
            $search = $request->search;
            
            // Kita gunakan whereHas untuk memfilter Auction berdasarkan isi tabel Item
            $query->whereHas('item', function($q) use ($search) {
                // Cari kata kunci di kolom 'item_name' milik tabel items
                $q->where('item_name', 'LIKE', "%{$search}%");
            });
        }

        // ==================================================
        // FITUR FILTERING
        // ==================================================

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
     * [BARU] Memproses tawaran (Bid) dari user
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
        // Jika belum ada bid, min = start_price. Jika ada, min = current_price + min_increment
        $minBid = $auction->current_price 
            ? $auction->current_price + $auction->min_increment 
            : $auction->start_price;

        if ($request->bid_price < $minBid) {
            return back()->with('error', 'Tawaran terlalu rendah! Minimal: Rp ' . number_format($minBid, 0, ',', '.'));
        }

        // 4. Update harga di tabel Auctions
        $auction->update([
            'current_price' => $request->bid_price,
            'winner_id' => auth()->id(), // Set pemenang sementara
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
     * [BARU] Memproses pembelian langsung (Buyout)
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
            'current_price' => $auction->buyout_price, // Harga akhir = harga buyout
            'end_time' => now(), // Waktu berakhir dimajukan ke sekarang
        ]);

        // (Opsional: Disini Anda bisa menambahkan logika Transaksi/Invoice)

        return redirect()->route('auctions.show', $auction->id)
            ->with('success', 'Selamat! Anda berhasil memenangkan item ini via Buyout!');
    }
}