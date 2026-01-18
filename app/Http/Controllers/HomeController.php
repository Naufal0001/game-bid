<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction; // <--- Jangan lupa import Model ini

class HomeController extends Controller
{
    /**
     * Menampilkan halaman depan (Landing Page).
     */
    public function index()
    {
        // Logika yang tadinya ada di route, sekarang pindah ke sini
        $auctions = Auction::latest()->take(6)->get();

        return view('welcome', compact('auctions'));
    }
}