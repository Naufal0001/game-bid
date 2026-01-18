@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-yellow-50 py-12 font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-black uppercase italic" style="-webkit-text-stroke: 1px black;">MY INVENTORY</h1>
            <a href="{{ route('items.create') }}" class="bg-black text-white px-6 py-3 font-black uppercase border-4 border-transparent hover:bg-white hover:text-black hover:border-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.5)]">
                + UPLOAD ITEM BARU
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($items as $item)
            <div class="bg-white border-4 border-black p-4 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] relative">
                
                {{-- BADGE STATUS --}}
                <div class="absolute top-2 right-2 px-2 py-1 text-xs font-black uppercase border-2 border-black
                    {{ $item->status == 'approved' ? 'bg-green-400' : ($item->status == 'rejected' ? 'bg-red-500 text-white' : 'bg-yellow-400') }}">
                    {{ $item->status }}
                </div>

                <div class="h-40 bg-gray-100 border-2 border-black mb-4 overflow-hidden">
                    <img src="{{ asset($item->image) }}" class="w-full h-full object-cover">
                </div>
                
                <h3 class="font-black text-xl uppercase leading-none mb-1">{{ $item->item_name }}</h3>
                <p class="text-xs font-bold text-gray-500 mb-2">{{ $item->category->game_name }} - {{ $item->category->category_name }}</p>
                
                @if($item->status == 'approved')
                    <p class="text-xs font-bold text-green-600 uppercase">SIAP DILELANG</p>
                @else
                    <p class="text-xs font-bold text-gray-400 italic">Menunggu verifikasi admin...</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection