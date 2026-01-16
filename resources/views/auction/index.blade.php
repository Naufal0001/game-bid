@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-6">Daftar Auction</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse ($auctions as $auction)
                <div class="bg-white rounded shadow p-4">
                    <h2 class="font-semibold text-lg">
                        {{ $auction->item->item_name }}
                    </h2>

                    <p class="text-sm text-gray-500">
                        {{ $auction->item->category->game_name }}
                    </p>

                    <p class="mt-2">
                        Harga Saat Ini:
                        <span class="font-bold text-green-600">
                            Rp {{ number_format($auction->current_price) }}
                        </span>
                    </p>

                    <p class="text-sm text-gray-500 mt-1">
                        Berakhir:
                        {{ $auction->end_time->diffForHumans() }}
                    </p>

                    <a href="{{ route('auctions.show', $auction->id) }}"
                        class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Lihat Detail
                    </a>
                </div>
            @empty
                <p>Tidak ada auction aktif.</p>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $auctions->links() }}
        </div>
    </div>
@endsection
