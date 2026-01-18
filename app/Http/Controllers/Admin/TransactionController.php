<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // List Transaksi Masuk
    public function index()
    {
        $transactions = Transaction::with(['auction.item', 'user'])->latest()->get();
        return view('admin.transactions.index', compact('transactions'));
    }

    // Admin Approve Pembayaran
    public function approve(Transaction $transaction)
    {
        // 1. Update status transaksi
        $transaction->update(['status' => 'approved']);

        // 2. Update status auction jadi 'done' (Selesai)
        $transaction->auction->update(['status' => 'done']);

        return back()->with('success', 'Transaksi disetujui. Barang resmi terjual.');
    }

    // Admin Reject (Opsional)
    public function reject(Transaction $transaction)
    {
        $transaction->update(['status' => 'rejected']);
        // Balikin status auction ke closed agar user bisa upload ulang
        $transaction->auction->update(['status' => 'closed']); 
        
        return back()->with('success', 'Transaksi ditolak (Bukti tidak valid).');
    }
}