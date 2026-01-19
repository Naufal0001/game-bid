<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index() {
        $query = Item::with('user');
        $request = request();

        // 🔍 SEARCH (item name / seller)
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('item_name', 'like', "%{$request->search}%")
                  ->orWhereHas('user', function ($uq) use ($request) {
                      $uq->where('username', 'like', "%{$request->search}%");
                  });
            });
        }

        // 🎯 FILTER STATUS
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // ↕️ SORT
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        $allowedSorts = ['item_name', 'status', 'created_at'];

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'created_at';
        }

        $items = $query
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->withQueryString();

        return view('admin.items.index', compact(
            'items', 'sort', 'direction'
        ));
    }

    public function approve(Item $item) {
        if ($item->status !== 'pending') {
            return back()->with('error', 'Item tidak dapat diverifikasi.');
        }

        $item->update(['status' => 'verified']);

        return back()->with('success', 'Item berhasil diverifikasi.');
    }

    public function reject(Item $item) {
        if ($item->status !== 'pending') {
            return back()->with('error', 'Item tidak dapat ditolak.');
        }

        $item->update(['status' => 'rejected']);

        return back()->with('success', 'Item ditolak.');
    }
}