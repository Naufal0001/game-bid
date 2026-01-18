@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-yellow-50 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <h1 class="text-4xl font-black uppercase italic tracking-tighter mb-8 md:text-left text-center">
            <span class="bg-black text-white px-4 py-1 transform -skew-x-12 inline-block">KATALOG</span>
        </h1>

        <div class="flex flex-col md:flex-row gap-8">
            
            <aside class="w-full md:w-1/4">
                <form action="{{ route('auctions.index') }}" method="GET" class="bg-white border-4 border-black p-6 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] sticky top-24">
                    
                    <h3 class="text-xl font-black uppercase border-b-4 border-black pb-2 mb-6">FILTER BARANG</h3>

                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    <div class="mb-6">
                        <h4 class="font-bold text-lg mb-3 bg-yellow-400 inline-block px-2 border-2 border-black">GAME</h4>
                        <div class="space-y-2">
                            @foreach(['CS2', 'Tower of Fantasy', 'Valorant', 'Ragnarok'] as $gameName)
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <input type="checkbox" name="game[]" value="{{ $gameName }}" 
                                        {{ in_array($gameName, request('game', [])) ? 'checked' : '' }}
                                        class="appearance-none w-5 h-5 border-2 border-black checked:bg-black checked:text-white focus:ring-0 cursor-pointer relative">
                                    <span class="font-bold text-gray-700 group-hover:text-black">{{ $gameName }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="font-bold text-lg mb-3 bg-teal-400 inline-block px-2 border-2 border-black">TIPE ITEM</h4>
                        <div class="space-y-2">
                            @foreach(['Account', 'Misc', 'Currency', 'Mount', 'Cosmetic', 'Equipment'] as $catName)
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <input type="checkbox" name="category[]" value="{{ $catName }}" 
                                        {{ in_array($catName, request('category', [])) ? 'checked' : '' }}
                                        class="w-5 h-5 border-2 border-black text-black focus:ring-0 rounded-none cursor-pointer">
                                    <span class="font-bold text-gray-700 group-hover:text-black">{{ $catName }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="font-bold text-lg mb-3 bg-pink-400 inline-block px-2 border-2 border-black">HARGA (IDR)</h4>
                        <div class="flex flex-col gap-3">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="w-full border-2 border-black p-2 font-bold focus:outline-none focus:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transition-all">
                            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="w-full border-2 border-black p-2 font-bold focus:outline-none focus:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transition-all">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-3 bg-black text-white font-black uppercase tracking-widest border-2 border-transparent hover:bg-white hover:text-black hover:border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,0.5)] hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transition-all">
                        TERAPKAN
                    </button>
                    
                    @if(request()->hasAny(['game', 'category', 'min_price', 'max_price', 'search']))
                        <a href="{{ route('auctions.index') }}" class="block text-center mt-3 text-xs font-bold underline text-red-600">Reset Filter</a>
                    @endif
                </form>
            </aside>

            <div class="w-full md:w-3/4">

                <form action="{{ route('auctions.index') }}" method="GET" class="mb-8">
                    
                    @foreach(request()->except(['search', 'page']) as $key => $value)
                        @if(is_array($value))
                            @foreach($value as $v)
                                <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                            @endforeach
                        @else
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach

                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="relative flex-grow">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Cari item yang kamu butuhkan..." 
                                   class="w-full pl-12 pr-4 py-4 border-4 border-black font-bold text-lg uppercase focus:outline-none focus:bg-white focus:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transition-all placeholder-gray-400">
                        </div>

                        <button type="submit" class="px-8 py-4 bg-black text-white font-black uppercase tracking-widest border-4 border-transparent hover:bg-yellow-400 hover:text-black hover:border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,0.5)] hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transition-all flex items-center justify-center gap-2">
                            CARI
                        </button>
                    </div>
                </form>

                @if($auctions->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($auctions as $auction)
                            <div class="group bg-white border-4 border-black shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:-translate-y-1 hover:shadow-[10px_10px_0px_0px_rgba(0,0,0,1)] transition-all duration-200 flex flex-col h-full relative">
                                
                                <div class="absolute top-0 left-0 bg-yellow-400 border-b-2 border-r-2 border-black px-3 py-1 z-10">
                                    <span class="font-black text-xs uppercase">
                                        {{ $auction->item->category->game_name ?? 'UNKNOWN' }}
                                    </span>
                                </div>

                                <div class="h-48 w-full border-b-4 border-black bg-gray-100 overflow-hidden relative">
                                    <img src="{{ $auction->item->image ? asset($auction->item->image) : asset('images/placeholder.png') }}" 
                                         alt="{{ $auction->item->name ?? 'Item' }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    
                                    <div class="absolute bottom-0 right-0 bg-black text-white text-xs font-bold px-2 py-1">
                                        {{ $auction->item->category->category_name ?? 'ITEM' }}
                                    </div>
                                </div>

                                <div class="p-4 flex-grow flex flex-col justify-between">
                                    <div>
                                        <h2 class="text-xl font-black uppercase leading-tight line-clamp-2 mb-2">
                                            {{ $auction->item->item_name ?? $auction->title }}
                                        </h2>
                                        <p class="text-xs text-gray-500 font-bold line-clamp-2 mb-2">
                                            {{ $auction->item->description ?? 'No description' }}
                                        </p>
                                        
                                        {{-- [MODIFIKASI] Logic Timer diperbaiki di sini --}}
                                        <p class="text-xs font-bold text-gray-400">
                                            Ends: 
                                            <span class="text-red-500 auction-timer" 
                                                  data-end="{{ $auction->end_time }}" 
                                                  data-status="{{ $auction->status }}">
                                                Checking...
                                            </span>
                                        </p>
                                        {{-- [AKHIR MODIFIKASI] --}}

                                    </div>

                                    <div class="mt-4 pt-4 border-t-2 border-dashed border-gray-300">
                                        <p class="text-xs font-bold text-gray-400 uppercase">Current Bid</p>
                                        <p class="text-2xl font-black text-teal-600 tracking-tight">
                                            Rp {{ number_format($auction->current_price ?? $auction->starting_price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>

                                <a href="{{ route('auctions.show', $auction->id) }}" class="block w-full py-3 bg-black text-white text-center font-black uppercase tracking-widest hover:bg-yellow-400 hover:text-black border-t-4 border-black transition-colors">
                                    LIHAT DETAIL
                                </a>

                            </div>
                        @endforeach
                    </div>

                    <div class="mt-10">
                        {{ $auctions->links() }}
                    </div>

                @else
                    <div class="bg-white border-4 border-black p-10 text-center shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]">
                        <h3 class="text-2xl font-black uppercase mb-2">TIDAK ADA HASIL</h3>
                        <p class="font-medium text-gray-600">Barang dengan kata kunci atau filter tersebut tidak ditemukan.</p>
                        <a href="{{ route('auctions.index') }}" class="inline-block mt-4 px-6 py-2 bg-yellow-400 border-2 border-black font-bold shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] active:translate-x-1 active:translate-y-1 active:shadow-none">Reset Pencarian</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT TAMBAHAN UNTUK TIMER (TANPA MENGUBAH VISUAL) --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const timers = document.querySelectorAll('.auction-timer');

        function updateTimers() {
            const now = new Date().getTime();

            timers.forEach(timer => {
                const endTime = new Date(timer.getAttribute('data-end')).getTime();
                const status = timer.getAttribute('data-status');
                const distance = endTime - now;

                if (status !== 'active') {
                    timer.innerHTML = "SELESAI";
                    // Menjaga class text-red-500 dari design asli, atau bisa diubah warnanya jika mau
                    // timer.classList.remove('text-red-500'); 
                    // timer.classList.add('text-gray-500');
                    return;
                }

                if (distance < 0) {
                    timer.innerHTML = "EXPIRED";
                } else {
                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    
                    let output = "";
                    if(days > 0) output += days + "d ";
                    output += hours + "h " + minutes + "m";
                    
                    timer.innerHTML = output;
                }
            });
        }

        updateTimers();
        setInterval(updateTimers, 60000); // Update setiap 1 menit agar tidak berat
    });
</script>
@endsection