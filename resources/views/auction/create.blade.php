@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-pink-50 py-12 font-sans flex justify-center items-center">
    <div class="w-full max-w-xl px-4">
        
        <div class="bg-white border-4 border-black p-8 shadow-[12px_12px_0px_0px_rgba(0,0,0,1)]">
            <h1 class="text-3xl font-black uppercase mb-8 border-b-4 border-black pb-4 text-center">
                BUAT LELANG BARU
            </h1>

            {{-- Info Alert --}}
            <div class="bg-blue-100 border-2 border-black p-3 mb-6 text-sm font-bold text-blue-900">
                INFO: Hanya item yang sudah di-upload di menu "My Items" dan berstatus <span class="bg-green-400 px-1 border border-black text-black">APPROVED</span> yang muncul disini.
            </div>

            <form action="{{ route('auctions.store') }}" method="POST" class="space-y-6">
                @csrf
                
                {{-- PILIH ITEM (Live Search Native) --}}
                <div>
                    <label class="block font-black uppercase mb-2">Pilih Item dari Inventory</label>
                    
                    @if($items->count() > 0)
                        <div class="relative">
                            {{-- Menggunakan Select biasa agar ID terkirim akurat --}}
                            <select name="item_id" class="w-full border-4 border-black p-4 font-black text-lg focus:outline-none focus:bg-yellow-50 cursor-pointer appearance-none bg-white">
                                <option value="" disabled selected>-- KLIK UNTUK MEMILIH ITEM --</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->item_name }} ({{ $item->category->game_name }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        <p class="text-xs font-bold text-gray-500 mt-2">* Gambar & Deskripsi otomatis diambil dari data item.</p>
                    @else
                        <div class="bg-red-100 border-2 border-black p-4 text-center">
                            <p class="font-black text-red-600">TIDAK ADA ITEM SIAP LELANG</p>
                            <a href="{{ route('items.create') }}" class="underline font-bold text-sm">Upload & Verifikasi Item Dulu Disini</a>
                        </div>
                    @endif
                </div>

                {{-- FORM HARGA & WAKTU (Sama seperti sebelumnya) --}}
                @if($items->count() > 0)
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-black uppercase mb-2 text-green-700">Open Price</label>
                            <input type="number" name="start_price" class="w-full border-4 border-black p-3 font-bold focus:bg-green-50" placeholder="Rp 0" required>
                        </div>
                        <div>
                            <label class="block font-black uppercase mb-2 text-pink-600">Buyout Price</label>
                            <input type="number" name="buyout_price" class="w-full border-4 border-black p-3 font-bold focus:bg-pink-50" placeholder="Rp 0" required>
                        </div>
                    </div>

                    <div>
                        <label class="block font-black uppercase mb-2">Selesai Pada</label>
                        <input type="datetime-local" name="end_time" class="w-full border-4 border-black p-3 font-bold focus:bg-yellow-50" required>
                    </div>

                    <button type="submit" class="w-full py-4 bg-black text-white font-black text-xl border-4 border-transparent hover:bg-white hover:text-black hover:border-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.5)] hover:shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] uppercase mt-4">
                        TERBITKAN SEKARANG
                    </button>
                @endif

            </form>
        </div>
    </div>
</div>
@endsection