<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with([
                'auction.item',
                'payment'
            ])
            ->where('buyer_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }
}
