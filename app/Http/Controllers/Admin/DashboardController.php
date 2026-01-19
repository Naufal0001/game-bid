<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use App\Models\Auction;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // SUMMARY
        $summary = [
            'users' => User::count(),
            'items' => Item::count(),
            'auctions' => Auction::count(),
            'income' => Transaction::where('status', 'paid')->sum('final_price'),
        ];

        // CHART 1: Monthly Income
        $monthlyIncome = Transaction::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(final_price) as total')
        )
            ->where('status', 'paid')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        // CHART 2: Auction Status
        $auctionStatus = Auction::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // CHART 3: Transaction Status
        $transactionStatus = Transaction::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('admin.dashboard', compact(
            'summary',
            'monthlyIncome',
            'auctionStatus',
            'transactionStatus'
        ));
    }
}
