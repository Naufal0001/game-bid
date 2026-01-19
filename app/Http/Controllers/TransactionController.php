<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // Halaman Form Pembayaran (Checkout)
    public function checkout(Auction $auction)
    {
        // Security Check: Hanya pemenang & status closed yang boleh akses
        if (auth()->id() !== $auction->winner_id || $auction->status !== 'closed') {
            return redirect()->route('auctions.show', $auction->id)
                ->with('error', 'Akses ditolak.');
        }

        return view('transaction.checkout', compact('auction'));
    }

    // Proses Simpan Pembayaran
    public function store(Request $request, Auction $auction)
    {
        $request->validate([
            'game_username' => 'required|string',
            'game_uid'      => 'required|string',
            'payment_proof' => 'required|image|max:2048', // Max 2MB
        ]);

        // Upload Bukti
        $path = $request->file('payment_proof')->store('payments', 'public');

        // Simpan Transaksi
        Transaction::create([
            'auction_id'    => $auction->id,
            'user_id'       => auth()->id(),
            'final_price'   => $auction->current_price ?? $auction->buyout_price,
            'game_username' => $request->game_username,
            'game_uid'      => $request->game_uid,
            'payment_proof' => 'storage/' . $path,
            'status'        => 'pending',
            'created_at'    => now(),
            'payment_deadline' => now()->addHours(1),
        ]);

        // Update Status Auction jadi 'pending_payment' (Menunggu Admin)
        $auction->update(['status' => 'pending_payment']);

        return redirect()->route('auctions.show', $auction->id)
            ->with('success', 'Pembayaran dikirim! Menunggu konfirmasi admin.');
    }
}