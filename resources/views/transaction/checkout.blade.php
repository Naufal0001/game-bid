@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-green-50 py-12 flex justify-center items-center font-sans">
    <div class="w-full max-w-4xl px-4 grid grid-cols-1 md:grid-cols-2 gap-8">
        
        {{-- BAGIAN KIRI: DETAIL TAGIHAN --}}
        <div class="space-y-6">
            <div class="bg-white border-4 border-black p-6 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]">
                <h2 class="font-black uppercase text-2xl mb-4 border-b-4 border-black pb-2">Detail Tagihan</h2>
                
                <div class="flex gap-4 mb-4">
                    {{-- Gambar Item --}}
                    <img src="{{ asset($auction->item->image) }}" class="w-24 h-24 object-cover border-2 border-black">
                    <div>
                        <div class="text-xs font-bold bg-black text-white px-2 py-0.5 inline-block mb-1">{{ $auction->item->category->game_name }}</div>
                        <h3 class="font-black text-xl uppercase leading-tight">{{ $auction->item->item_name }}</h3>
                        <p class="text-sm font-bold text-gray-500">Winner: {{ Auth::user()->username }}</p>
                    </div>
                </div>

                <div class="bg-yellow-100 border-2 border-black p-4 mb-4">
                    <p class="text-xs font-bold uppercase text-gray-600">Total Yang Harus Dibayar</p>
                    {{-- Logic Harga: Jika ada current_price pakai itu, jika tidak (langsung buyout) pakai buyout_price --}}
                    <p class="text-4xl font-black text-black">
                        Rp {{ number_format($auction->current_price ?? $auction->buyout_price, 0, ',', '.') }}
                    </p>
                </div>

                <div class="text-sm font-bold text-gray-700 space-y-2">
                    <p>Silakan transfer ke rekening Admin:</p>
                    <ul class="list-disc pl-5">
                        <li>BCA: <span class="bg-black text-white px-1">123-456-7890</span> (a.n GameBid Admin)</li>
                        <li>DANA: <span class="bg-black text-white px-1">0812-3456-7890</span></li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- BAGIAN KANAN: FORM KONFIRMASI --}}
        <div class="bg-white border-4 border-black p-8 shadow-[12px_12px_0px_0px_rgba(0,0,0,1)]">
            <h1 class="text-2xl font-black uppercase mb-6 border-b-4 border-black pb-4 text-center">
                KONFIRMASI PEMBAYARAN
            </h1>

            <form action="{{ route('transactions.store', $auction->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                
                <div class="bg-blue-50 border-l-4 border-blue-500 p-3 text-xs font-bold text-blue-800 mb-4">
                    Data username & UID diperlukan agar penjual bisa memproses pengiriman item ke akun game Anda.
                </div>

                <div>
                    <label class="block font-black uppercase mb-1">Username Game Anda</label>
                    <input type="text" name="game_username" class="w-full border-4 border-black p-3 font-bold focus:bg-yellow-50" placeholder="Contoh: Zenxlay#123" required>
                </div>

                <div>
                    <label class="block font-black uppercase mb-1">UID / ID Game Anda</label>
                    <input type="text" name="game_uid" class="w-full border-4 border-black p-3 font-bold focus:bg-yellow-50" placeholder="Contoh: 88291022" required>
                </div>

                <div>
                    <label class="block font-black uppercase mb-1">Bukti Transfer (Screenshot)</label>
                    <input type="file" name="payment_proof" class="w-full border-4 border-black p-2 bg-gray-100 font-bold text-sm" required>
                </div>

                <button type="submit" class="w-full py-4 bg-green-500 text-white font-black text-xl border-4 border-black hover:bg-green-400 hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transition-all uppercase mt-4">
                    KIRIM BUKTI BAYAR 🚀
                </button>
            </form>
        </div>

    </div>
</div>
@endsection