<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Item;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AuctionController extends Controller
{
    public function index()
    {
        $query = Auction::with(['item']);
        $request = request();

        // 🔍 SEARCH (item name)
        if ($request->filled('search')) {
            $query->whereHas('item', function ($q) use ($request) {
                $q->where('item_name', 'like', "%{$request->search}%");
            });
        }

        // ↕️ SORT
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');

        $allowedSorts = [
            'starting_price',
            'current_price',
            'status',
            'start_time',
            'end_time',
            'created_at'
        ];

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'created_at';
        }

        $auctions = $query
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->withQueryString();

        return view('admin.auctions.index', compact(
            'auctions',
            'sort',
            'direction'
        ));
    }

    public function create()
    {
        $items = Item::doesntHave('auction')->get();
        return view('admin.auctions.create', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'starting_price' => 'required|numeric|min:1',
            'min_increment' => 'required|numeric|min:1',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        Auction::create([
            'item_id' => $request->item_id,
            'starting_price' => $request->starting_price,
            'current_price' => $request->starting_price,
            'min_increment' => $request->min_increment,
            'start_time' => Carbon::parse($request->start_time),
            'end_time' => Carbon::parse($request->end_time),
            'status' => 'active',
        ]);

        return redirect()->route('admin.auctions.index')
            ->with('success', 'Auction berhasil dibuat');
    }

    public function edit(Auction $auction)
    {
        return view('admin.auctions.edit', compact('auction'));
    }

    public function update(Request $request, Auction $auction)
    {
        $request->validate([
            'end_time' => 'required|date|after:now',
            'status' => 'required|in:active,closed',
        ]);

        $auction->update([
            'end_time' => $request->end_time,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.auctions.index')
            ->with('success', 'Auction berhasil diupdate');
    }

    public function close(Auction $auction)
    {
        if ($auction->status !== 'active') {
            return back()->with('error', 'Auction sudah ditutup.');
        }

        $auction->update([
            'status' => 'closed',
            'end_time' => now(),
        ]);

        return back()->with('success', 'Auction berhasil ditutup.');
    }

    public function destroy(Auction $auction)
    {
        $auction->delete();

        return back()->with('success', 'Auction berhasil dihapus');
    }
}