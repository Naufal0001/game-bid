@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-yellow-50 py-12 font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-6">
            <div>
                <h1 class="text-5xl font-black uppercase italic tracking-tighter mb-2" style="-webkit-text-stroke: 1px black;">
                    MY AUCTIONS
                </h1>
                <p class="font-bold text-gray-600 uppercase tracking-widest">
                    Kelola barang lelang milikmu di sini
                </p>
            </div>

            @if(auth()->user()->status === 'active') 
                <a href="{{ route('auctions.create') }}" class="group relative inline-block focus:outline-none focus:ring">
                    <span class="absolute inset-0 translate-x-2 translate-y-2 bg-pink-500 transition-transform group-hover:translate-y-0 group-hover:translate-x-0 border-4 border-black"></span>
                    <span class="relative inline-block border-4 border-current px-8 py-3 text-xl font-black uppercase tracking-widest text-black group-active:text-opacity-75 bg-white">
                        + BUAT AUCTION
                    </span>
                </a>
            @else
                <div class="bg-red-200 border-4 border-black p-4 text-center max-w-sm transform rotate-2">
                    <p class="font-black uppercase text-red-600 text-sm">
                        AKUN BELUM DIVERIFIKASI
                    </p>
                    <p class="text-xs font-bold mt-1">
                        Hubungi admin untuk membuka fitur buat lelang.
                    </p>
                </div>
            @endif
        </div>

        @if($auctions->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($auctions as $auction)
                <div class="group relative block bg-white border-4 border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-[4px] hover:translate-y-[4px] transition-all duration-200">
                    
                    <div class="h-48 border-b-4 border-black overflow-hidden bg-gray-100 relative">
                        <img src="{{ $auction->item->image ? asset($auction->item->image) : asset('images/placeholder.png') }}" 
                             alt="{{ $auction->title }}" 
                             class="w-full h-full object-cover">
                        
                        <span class="absolute top-2 right-2 px-3 py-1 text-xs font-black uppercase border-2 border-black {{ $auction->status == 'active' ? 'bg-green-400 text-black' : 'bg-red-500 text-white' }}">
                            {{ $auction->status }}
                        </span>
                    </div>

                    <div class="p-6">
                        <h3 class="text-xl font-black uppercase leading-tight mb-2 line-clamp-1">
                            {{ $auction->title }}
                        </h3>
                        
                        <div class="flex justify-between items-end mt-4">
                            <div>
                                <p class="text-xs font-bold text-gray-500 uppercase">Current Price</p>
                                <p class="text-lg font-black text-teal-600">
                                    Rp {{ number_format($auction->current_price ?? $auction->starting_price, 0, ',', '.') }}
                                </p>
                            </div>
                            <a href="{{ route('auctions.show', $auction->id) }}" class="text-sm font-black underline hover:text-pink-500 uppercase">
                                Lihat Detail &rarr;
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-20 border-4 border-dashed border-gray-400 bg-gray-50">
                <div class="text-6xl mb-4">📦</div>
                <h2 class="text-3xl font-black uppercase text-gray-400 mb-2">Belum Ada Barang</h2>
                <p class="text-gray-500 font-bold max-w-md text-center">
                    Kamu belum melelang item apapun. Klik tombol di atas untuk mulai menjadi sultan!
                </p>
            </div>
        @endif

    </div>
</div>
@endsection