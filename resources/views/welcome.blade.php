@extends('layouts.app')

@section('content')
    <div
        class="relative min-h-screen overflow-hidden bg-yellow-50 flex items-center justify-center p-6 border-b-4 border-black">

        <div
            class="absolute top-0 right-0 w-1/3 h-full bg-yellow-300 border-l-4 border-black transform skew-x-12 origin-top-right z-0">
        </div>
        <div
            class="absolute bottom-0 left-0 w-64 h-64 bg-teal-400 border-4 border-black rounded-full z-0 transform -translate-x-10 translate-y-10">
        </div>
        <div class="absolute top-20 left-10 text-6xl font-black text-black opacity-10 select-none">$$$</div>
        <div class="absolute bottom-40 right-10 text-6xl font-black text-black opacity-10 select-none">BID</div>

        <div
            class="relative z-10 w-full max-w-4xl bg-white border-4 border-black shadow-[12px_12px_0px_0px_rgba(0,0,0,1)] p-8 md:p-16 text-center">

            <h1 class="text-5xl md:text-7xl font-black mb-8 leading-tight uppercase">
                WELCOME TO <br>

                <div
                    class="relative inline-block mt-4 transform -rotate-2 hover:rotate-0 transition-transform duration-300 cursor-default">
                    <span class="absolute top-0 left-0 w-full h-full bg-black translate-x-2 translate-y-2"></span>
                    <span
                        class="relative block bg-gradient-to-r from-teal-400 via-yellow-300 to-pink-500 border-4 border-black px-8 py-2">
                        <span class="text-transparent bg-clip-text bg-black drop-shadow-sm tracking-tighter"
                            style="-webkit-text-stroke: 0px;">
                            GAMEBID
                        </span>
                    </span>
                </div>
            </h1>

            <p class="text-lg md:text-xl font-bold text-gray-800 mb-10 max-w-2xl mx-auto leading-relaxed">
                Platform lelang item game paling <span class="bg-black text-white px-1">brutal</span>.
                Lihat auction, lakukan bid, dan menangkan item favoritmu.
            </p>

            <div class="flex flex-col md:flex-row gap-6 justify-center">
                <a href="#browse-section"
                    class="inline-block px-8 py-4 bg-pink-500 text-white border-4 border-black font-black uppercase tracking-wider shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none hover:bg-pink-600 transition-all">
                    BROWSE AUCTIONS
                </a>

                @guest
                    <a href="{{ route('register') }}"
                        class="inline-block px-8 py-4 bg-yellow-400 text-black border-4 border-black font-black uppercase tracking-wider shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none hover:bg-yellow-500 transition-all">
                        START SELLING
                    </a>
                @endguest
            </div>

        </div>

        <div class="absolute bottom-10 animate-bounce">
            <a href="#browse-section">
                <svg class="w-12 h-12 text-black hover:text-pink-600 transition-colors" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M19 14l-7 7m0 0l-7-7m7 7V3">
                    </path>
                </svg>
            </a>
        </div>

    </div>

    <div id="browse-section" class="bg-white py-24 px-4 md:px-12 relative">

        <div class="absolute inset-0 opacity-10"
            style="background-image: radial-gradient(#000 2px, transparent 2px); background-size: 30px 30px;"></div>

        <div class="relative z-10 max-w-7xl mx-auto">
            <div class="mb-16 text-center">
                <h2
                    class="text-4xl md:text-5xl font-black uppercase italic tracking-tighter inline-block bg-yellow-400 px-6 py-3 border-4 border-black shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] transform -rotate-1">
                    FRESH DROPS 🔥
                </h2>
                <p class="mt-6 text-xl font-bold text-gray-600">Barang rampasan terbaru yang siap diperebutkan!</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                @forelse($auctions as $auction)
                    <div
                        class="group relative bg-white border-4 border-black p-4 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:shadow-[10px_10px_0px_0px_rgba(0,0,0,1)] hover:-translate-y-2 transition-all duration-200 flex flex-col h-full">

                        <div class="absolute top-2 right-2 z-10">
                            <span
                                class="bg-red-600 text-white text-xs font-black px-2 py-1 border-2 border-black uppercase animate-pulse">LIVE</span>
                        </div>

                        <div
                            class="h-48 bg-gray-100 border-2 border-black mb-4 flex items-center justify-center overflow-hidden">
                            <img src="{{ $auction->item->image ?? asset('images/placeholder.webp') }}"
                                alt="{{ $auction->title ?? 'Item Misterius' }}"
                                class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-200">
                        </div>

                        <div class="flex-grow">
                            <h3 class="text-xl font-black uppercase leading-tight mb-2 truncate">
                                {{ $auction->item->item_name ?? 'Item Misterius' }}
                            </h3>
                            <p class="text-sm text-gray-600 font-bold mb-4 line-clamp-2">
                                {{ $auction->item->description ?? 'Deskripsi item belum ditambahkan oleh penjual.' }}
                            </p>
                        </div>

                        <div class="mt-4 pt-4 border-t-2 border-black flex items-end justify-between">
                            <div>
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">CURRENT BID</p>
                                <p class="text-xl font-black text-teal-600">
                                    Rp {{ number_format($auction->current_price ?? 0, 0, ',', '.') }}
                                </p>
                            </div>

                            <a href="{{ route('auctions.show', $auction->id) }}"
                                class="px-6 py-2 bg-black text-white font-black uppercase text-sm border-2 border-transparent hover:bg-gray-800 hover:scale-105 transition-transform">
                                BID
                            </a>
                        </div>
                    </div>

                @empty
                    <div class="col-span-full text-center py-12 border-4 border-dashed border-gray-300 rounded-lg">
                        <p class="text-2xl font-black text-gray-400 uppercase">BELUM ADA LELANG AKTIF</p>
                        <p class="text-gray-500 font-bold mt-2">Jadilah yang pertama menjual item!</p>
                        <a href="{{ route('auctions.create') }}"
                            class="mt-4 inline-block text-blue-600 font-bold underline">Buat Lelang Baru</a>
                    </div>
                @endforelse

            </div>

            <div class="text-center mt-20">
                <a href="{{ route('auctions.index') }}"
                    class="inline-block px-12 py-4 bg-white text-black font-black uppercase tracking-widest border-4 border-black shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:bg-black hover:text-white hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all">
                    VIEW ALL AUCTIONS
                </a>
            </div>
        </div>
    </div>
@endsection
