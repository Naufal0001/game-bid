<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        // Pastikan kamu nanti membuat file view: resources/views/items/index.blade.php
        // Untuk sementara kita return text dulu agar tidak error
        return "Ini halaman List Item User"; 
        // return view('items.index'); <--- Nanti ganti jadi ini kalau view sudah dibuat
    }
}
