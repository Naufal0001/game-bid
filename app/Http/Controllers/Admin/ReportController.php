<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function transactions(Request $request)
    {
        $query = Transaction::with([
            'user',
            'auction.item'
        ]);

        // 📅 FILTER TANGGAL
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        // 🎯 FILTER STATUS
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transactions = $query
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        // 📊 SUMMARY
        $summary = [
            'total_transactions' => $query->count(),
            'approved_transactions' => (clone $query)->where('status', 'paid')->count(),
            'failed_transactions' => (clone $query)->whereIn('status', ['rejected', 'expired'])->count(),
            'total_income' => (clone $query)->where('status', 'paid')->sum('final_price'),
        ];

        return view('admin.reports.transactions', compact(
            'transactions',
            'summary'
        ));
    }
}
