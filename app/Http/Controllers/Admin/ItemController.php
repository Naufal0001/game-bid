<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index() {
        $items = Item::where('status', 'pending')->with('user', 'category')->latest()->get();
        return view('admin.items.index', compact('items'));
    }

    public function approve(Item $item) {
        $item->update(['status' => 'approved', 'is_verified' => true]);
        return back()->with('success', 'Item disetujui.');
    }

    public function reject(Item $item) {
        $item->update(['status' => 'rejected']);
        return back()->with('success', 'Item ditolak.');
    }
}