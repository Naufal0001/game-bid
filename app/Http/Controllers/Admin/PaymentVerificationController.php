<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentVerificationController extends Controller
{
    public function index()
    {
        $payments = Payment::where('status', 'pending')->get();
        return view('admin.payments.index', compact('payments'));
    }

    public function approve($id)
    {
        $payment = Payment::findOrFail($id);

        $payment->update(['status' => 'paid']);
        $payment->transaction->update(['status' => 'paid']);

        return back()->with('success', 'Pembayaran disetujui.');
    }

    public function reject($id)
    {
        Payment::findOrFail($id)->update(['status' => 'rejected']);
        return back()->with('error', 'Pembayaran ditolak.');
    }
}

