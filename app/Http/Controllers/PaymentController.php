<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function form($transactionId)
    {
        $transaction = Transaction::where('buyer_id', auth()->id())
            ->findOrFail($transactionId);

        return view('payments.form', compact('transaction'));
    }

    public function submit(Request $request, $transactionId)
    {
        $request->validate([
            'method' => 'required',
            'proof' => 'required|image|max:2048'
        ]);

        $path = $request->file('proof')->store('payments', 'public');

        Payment::create([
            'transaction_id' => $transactionId,
            'user_id' => auth()->id(),
            'method' => $request->method,
            'proof' => $path,
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Pembayaran dikirim, menunggu verifikasi admin.');
    }
}

