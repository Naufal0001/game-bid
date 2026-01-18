<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function show(Transaction $transaction)
    {
        abort_if($transaction->buyer_id !== auth()->id(), 403);

        return view('transactions.show', compact('transaction'));
    }

    public function uploadProof(Request $request, Transaction $transaction)
    {
        abort_if($transaction->buyer_id !== auth()->id(), 403);

        $request->validate([
            'payment_proof' => 'required|image|max:2048'
        ]);

        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        $transaction->update([
            'payment_proof' => $path,
            'status' => 'waiting_verification'
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil dikirim');
    }
}
