<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    // Menampilkan daftar item milik user
    public function index()
    {
        $items = Item::where('user_id', auth()->id())->latest()->get();
        return view('items.index', compact('items'));
    }

    // Form upload item baru
    public function create()
    {
        return view('items.create');
    }

    // Simpan item ke database (Status: Pending)
    public function store(Request $request)
    {
        $request->validate([
            'item_name'   => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'required|image|max:2048',
            'game'        => 'required|string',
            'category'    => 'required|string',
        ]);

        $path = $request->file('image')->store('items', 'public');

        // Cari/Buat Kategori
        $category = Category::firstOrCreate(
            ['game_name' => $request->game, 'category_name' => $request->category]
        );

        Item::create([
            'user_id'     => auth()->id(),
            'category_id' => $category->id,
            'item_name'   => $request->item_name,
            'description' => $request->description,
            'image'       => 'storage/' . $path,
            'rarity'      => 'Common', 
            'status'      => 'pending', // <--- PENTING: Default Pending
            'is_verified' => false,
        ]);

        return redirect()->route('items.index')->with('success', 'Item berhasil ditambah! Menunggu verifikasi admin.');
    }
}