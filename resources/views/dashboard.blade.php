@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">
            Dashboard User
        </h1>

        <div class="bg-white shadow rounded p-6">
            <p class="text-gray-700">
                Selamat datang, <span class="font-semibold">{{ $user->username }}</span>
            </p>

            <p class="text-sm text-gray-500 mt-2">
                Dari sini Anda dapat melihat auction, melakukan bid, dan melihat transaksi.
            </p>

            <div class="mt-4 space-y-2">
                <a href="{{ route('auctions.index') }}" class="text-blue-600 block">
                    → Lihat Auction
                </a>

                <a href="{{ route('transactions.index') }}" class="text-blue-600 block">
                    → Transaksi Saya
                </a>

                @can('create auction')
                    <a href="{{ route('seller.auctions.index') }}" class="text-blue-600 block">
                        → Kelola Auction Saya
                    </a>
                @endcan

                @cannot('create auction')
                    <p class="text-sm text-gray-400">
                        Akun Anda belum terverifikasi untuk membuat auction.
                    </p>
                @endcannot
            </div>
        </div>
    </div>
@endsection
