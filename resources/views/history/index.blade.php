@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-pink-50 py-12 font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <h1 class="text-5xl font-black uppercase italic mb-8" style="-webkit-text-stroke: 1px black;">
            RIWAYAT BIDDING
        </h1>

        <div class="bg-white border-4 border-black shadow-[12px_12px_0px_0px_rgba(0,0,0,1)] overflow-hidden">
            @if($auctions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-black text-white uppercase text-sm leading-normal">
                                <th class="py-4 px-6 font-black border-r-2 border-gray-700">Item</th>
                                <th class="py-4 px-6 font-black border-r-2 border-gray-700 text-center">Status Kamu</th>
                                <th class="py-4 px-6 font-black border-r-2 border-gray-700 text-right">Bid Terakhirmu</th>
                                <th class="py-4 px-6 font-black border-r-2 border-gray-700 text-right">Harga Saat Ini</th>
                                <th class="py-4 px-6 font-black text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800 font-bold text-sm">
                            @foreach($auctions as $auction)
                            <tr class="border-b-4 border-black hover:bg-yellow-50 transition-colors">
                                
                                {{-- 1. INFO ITEM --}}
                                <td class="py-4 px-6 border-r-4 border-black">
                                    <div class="flex items-center gap-4">
                                        <div class="w-16 h-16 border-2 border-black overflow-hidden bg-gray-200 flex-shrink-0">
                                            <img src="{{ asset($auction->item->image) }}" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <div class="text-xs font-black bg-black text-white px-2 py-0.5 inline-block mb-1 transform -skew-x-12">
                                                {{ $auction->item->category->game_name }}
                                            </div>
                                            <div class="uppercase font-black text-lg leading-tight">{{ $auction->item->item_name }}</div>
                                            <div class="text-[10px] text-gray-500">{{ $auction->created_at->format('d M Y') }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- 2. STATUS KAMU (Logic Warna) --}}
                                <td class="py-4 px-6 text-center border-r-4 border-black">
                                    @if($auction->user_status == 'WINNING')
                                        <span class="bg-green-400 text-black border-2 border-black px-3 py-1 font-black text-xs uppercase shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                                            MEMIMPIN 🔥
                                        </span>
                                    @elseif($auction->user_status == 'OUTBID')
                                        <span class="bg-red-500 text-white border-2 border-black px-3 py-1 font-black text-xs uppercase shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] animate-pulse">
                                            DISALIP! ⚠️
                                        </span>
                                    @elseif($auction->user_status == 'WON')
                                        <span class="bg-yellow-400 text-black border-2 border-black px-3 py-1 font-black text-xs uppercase shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                                            MENANG 🏆
                                        </span>
                                    @else
                                        <span class="bg-gray-300 text-gray-600 border-2 border-black px-3 py-1 font-black text-xs uppercase">
                                            KALAH 💀
                                        </span>
                                    @endif
                                </td>

                                {{-- 3. BID TERAKHIR SAYA --}}
                                <td class="py-4 px-6 text-right border-r-4 border-black font-mono text-gray-600">
                                    Rp {{ number_format($auction->my_last_bid, 0, ',', '.') }}
                                </td>

                                {{-- 4. HARGA SAAT INI --}}
                                <td class="py-4 px-6 text-right border-r-4 border-black font-mono text-xl font-black">
                                    Rp {{ number_format($auction->current_price ?? $auction->starting_price, 0, ',', '.') }}
                                </td>

                                {{-- 5. AKSI --}}
                                <td class="py-4 px-6 text-center">
                                    <a href="{{ route('auctions.show', $auction->id) }}" class="inline-block bg-white text-black border-2 border-black px-4 py-2 font-black uppercase text-xs hover:bg-black hover:text-white transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px]">
                                        LIHAT
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                {{-- EMPTY STATE --}}
                <div class="p-12 text-center flex flex-col items-center">
                    <div class="text-6xl mb-4">👻</div>
                    <h2 class="text-3xl font-black uppercase mb-2">BELUM ADA RIWAYAT</h2>
                    <p class="font-bold text-gray-500 mb-6">Kamu belum pernah melakukan bid di barang apapun.</p>
                    <a href="{{ route('auctions.index') }}" class="bg-black text-white px-8 py-3 font-black uppercase border-4 border-transparent hover:bg-white hover:text-black hover:border-black transition-all">
                        Mulai Berburu Barang
                    </a>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection