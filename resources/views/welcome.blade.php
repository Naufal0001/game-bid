@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-12 text-center">
        <h1 class="text-3xl font-bold mb-4">
            Selamat Datang di GameBid
        </h1>

        <p class="text-gray-600 mb-6">
            Platform lelang item game. Lihat auction, lakukan bid, dan menangkan item favoritmu.
        </p>

        <div class="space-x-4">
            <a href="{{ route('auctions.index') }}" class="bg-blue-600 text-white px-6 py-2 rounded">
                Lihat Auction
            </a>

            <a href="{{ route('login') }}" class="bg-gray-200 px-6 py-2 rounded">
                Login
            </a>

            <a href="{{ route('register') }}" class="bg-green-600 text-white px-6 py-2 rounded">
                Daftar
            </a>
        </div>
    </div>
@endsection
