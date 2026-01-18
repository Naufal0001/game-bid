@extends('layouts.app')

@section('content')

<div class="relative min-h-screen overflow-hidden bg-yellow-50 flex items-center justify-center p-6 border-b-4 border-black">

    <div class="absolute top-0 right-0 w-1/3 h-full bg-yellow-300 border-l-4 border-black transform skew-x-12 origin-top-right z-0"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-teal-400 border-4 border-black rounded-full z-0 transform -translate-x-10 translate-y-10"></div>

    <div class="relative z-10 w-full max-w-4xl bg-white border-4 border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] p-8 md:p-16 text-center">
        
        <h1 class="text-5xl md:text-7xl font-black mb-6 leading-tight uppercase">
            WELCOME TO <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-pink-500" style="-webkit-text-stroke: 2px black;">
                GAMEBID
            </span>
        </h1>

        <p class="text-lg md:text-xl font-bold text-gray-800 mb-10 max-w-2xl mx-auto">
            Platform lelang item game paling brutal. 
            Lihat auction, lakukan bid, dan menangkan item favoritmu.
        </p>

        <div class="flex flex-col md:flex-row gap-6 justify-center">
            <a href="#browse-section" class="inline-block px-8 py-3 bg-pink-500 text-white border-4 border-black font-black uppercase tracking-wider shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all">
                BROWSE AUCTIONS
            </a>
            
            @guest
            <a href="{{ route('register') }}" class="inline-block px-8 py-3 bg-yellow-400 text-black border-4 border-black font-black uppercase tracking-wider shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all">
                START SELLING
            </a>
            @endguest
        </div>

    </div>
    
    <div class="absolute bottom-10 animate-bounce">
        <svg class="w-10 h-10 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
    </div>

</div>

<div id="browse-section" class="bg-white py-20 px-4 md:px-12">
    
    <div class="max-w-7xl mx-auto mb-16 text-center">
        <h2 class="text-4xl md:text-5xl font-black uppercase italic tracking-tighter inline-block bg-yellow-400 px-4 py-2 border-4 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transform -rotate-2">
            FRESH DROPS
        </h2>
        <p class="mt-6 text-xl font-bold text-gray-600">Barang rampasan terbaru yang siap diperebutkan!</p>
    </div>

    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        
        @forelse($auctions as $auction)
            <div class="group relative bg-white border-4 border-black p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] hover:-translate-y-2 transition-all duration-200 flex flex-col h-full">
                
                <div class="absolute top-2 right-2 z-10">
                    <span class="bg-red-500 text-white text-xs font-black px-2 py-1 border-2 border-black uppercase">LIVE</span>
                </div>

                <div class="h-48 bg-gray-100 border-2 border-black mb-4 flex items-center justify-center overflow-hidden">
                    <img src="{{ $auction->image_url ?? asset('images/placeholder.png') }}" alt="{{ $auction->title ?? 'Item Misterius' }}" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-200">
                </div>

                <div class="flex-grow">
                    <h3 class="text-xl font-black uppercase leading-tight mb-2 truncate">
                        {{ $auction->title ?? 'Item Misterius' }}
                    </h3>
                    <p class="text-sm text-gray-600 font-bold mb-4 line-clamp-2">
                        {{ $auction->description ?? 'Deskripsi item belum ditambahkan oleh penjual.' }}
                    </p>
                </div>

                <div class="mt-4 pt-4 border-t-2 border-black flex items-end justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">CURRENT BID</p>
                        <p class="text-xl font-black text-teal-600">
                            Rp {{ number_format($auction->start_price ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                    
                    <a href="{{ route('auctions.show', $auction->id) }}" class="px-6 py-2 bg-black text-white font-black uppercase text-sm border-2 border-transparent hover:bg-gray-800 hover:scale-105 transition-transform">
                        BID
                    </a>
                </div>
            </div>
        
        @empty
            <div class="col-span-full text-center py-12 border-4 border-dashed border-gray-300 rounded-lg">
                <p class="text-2xl font-black text-gray-400 uppercase">BELUM ADA LELANG AKTIF</p>
                <p class="text-gray-500 font-bold mt-2">Jadilah yang pertama menjual item!</p>
                <a href="{{ route('auctions.create') }}" class="mt-4 inline-block text-blue-600 font-bold underline">Buat Lelang Baru</a>
            </div>
        @endforelse

    </div>

    <div class="text-center mt-16">
        <a href="{{ route('auctions.index') }}" class="inline-block px-10 py-4 bg-white text-black font-black uppercase tracking-widest border-4 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:bg-black hover:text-white transition-all">
            VIEW ALL AUCTIONS
        </a>
    </div>

</div>

@endsection