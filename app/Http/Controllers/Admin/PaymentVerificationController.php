<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class PaymentVerificationController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('status', 'waiting_verification')->get();
        return view('admin.payments.index', compact('transactions'));
    }

    public function approve(Transaction $transaction)
    {
        $transaction->update(['status' => 'paid']);
        return back();
    }

    public function reject(Transaction $transaction)
    {
        $transaction->update(['status' => 'rejected']);
        return back();
    }
}

