<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // List Transaksi Masuk
    public function index(Request $request)
    {
        $query = Transaction::with([
            'auction.item',
            'user',
            'payment'
        ]);

        // 🔍 SEARCH (buyer / item)
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('user', fn ($b) =>
                    $b->where('username', 'like', "%{$request->search}%")
                )->orWhereHas('auction.item', fn ($i) =>
                    $i->where('item_name', 'like', "%{$request->search}%")
                );
            });
        }

        // 🎯 FILTER STATUS
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // ↕️ SORT
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');

        $allowedSorts = ['created_at', 'final_price', 'status'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'created_at';
        }

        $transactions = $query
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->withQueryString();

        return view('admin.transactions.index', compact(
            'transactions', 'sort', 'direction'
        ));
    }

    // Admin Approve Pembayaran
    public function approve(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaksi tidak valid.');
        }

        $transaction->update(['status' => 'paid']);

        if ($transaction->payment) {
            $transaction->payment->update([
                'payment_status' => 'paid',
                'paid_at' => now()
            ]);
        }

        // Update auction & item
        $transaction->auction->update(['status' => 'closed']);
        $transaction->auction->item->update(['status' => 'sold']);

        return back()->with('success', 'Pembayaran disetujui.');
    }

    // Admin Reject (Opsional)
    public function reject(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaksi tidak valid.');
        }

        $transaction->update(['status' => 'rejected']);

        if ($transaction->payment) {
            $transaction->payment->update(['payment_status' => 'rejected']);
        }

        return back()->with('success', 'Pembayaran ditolak.');
    }
}