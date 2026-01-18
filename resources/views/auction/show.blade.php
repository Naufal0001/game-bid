@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-yellow-50 py-12 font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- ALERT MESSAGES --}}
        @if(session('success'))
            <div class="bg-green-400 border-4 border-black p-4 mb-8 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] flex items-center gap-3 animate-bounce">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                <span class="font-black text-xl uppercase">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500 text-white border-4 border-black p-4 mb-8 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] flex items-center gap-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-black text-xl uppercase">{{ session('error') }}</span>
            </div>
        @endif
        {{-- END ALERT MESSAGES --}}

        {{-- HEADER SECTION --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <a href="{{ route('auctions.index') }}" class="inline-block mb-4 text-sm font-black uppercase tracking-widest border-b-2 border-black hover:bg-black hover:text-white transition-all">
                    &larr; KEMBALI KE KATALOG
                </a>
                <div class="flex items-center gap-2 mb-2">
                    <span class="bg-black text-white px-3 py-1 text-xs font-bold uppercase transform -skew-x-12">
                        {{ $auction->item->category->game_name ?? 'GAME' }}
                    </span>
                    <span class="bg-pink-500 text-white px-3 py-1 text-xs font-bold uppercase transform -skew-x-12 border-2 border-black">
                        {{ $auction->item->category->category_name ?? 'ITEM' }}
                    </span>
                </div>
                <h1 class="text-4xl md:text-6xl font-black uppercase italic leading-none" style="-webkit-text-stroke: 1px black;">
                    {{ $auction->item->item_name }}
                </h1>
            </div>
            
            <div class="bg-white border-4 border-black px-6 py-2 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                <span class="text-xs font-bold uppercase text-gray-500 block">STATUS LELANG</span>
                
                {{-- LOGIC BADGE STATUS --}}
                @php
                    $isActive = $auction->status == 'active' && now() < $auction->end_time;
                    $isPending = $auction->status == 'pending_payment';
                    $isDone = $auction->status == 'done';
                @endphp

                <span id="status-badge" class="text-xl font-black uppercase 
                    {{ $isActive ? 'text-green-600' : ($isDone ? 'text-blue-600' : ($isPending ? 'text-yellow-600' : 'text-red-600')) }}">
                    @if($isActive) SEDANG BERLANGSUNG
                    @elseif($isPending) MENUNGGU VERIFIKASI
                    @elseif($isDone) SELESAI
                    @else BERAKHIR
                    @endif
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- KOLOM KIRI (GAMBAR & DESKRIPSI) --}}
            <div class="lg:col-span-7 space-y-8">
                <div class="bg-white border-4 border-black p-2 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] relative">
                    @if($isActive)
                        <div id="hot-badge" class="absolute -top-4 -left-4 bg-yellow-400 text-black border-4 border-black w-20 h-20 rounded-full flex items-center justify-center font-black text-xl z-10 animate-pulse">HOT!</div>
                    @endif
                    <div class="border-2 border-black overflow-hidden h-96 bg-gray-100 flex items-center justify-center">
                        <img src="{{ $auction->item->image ? asset($auction->item->image) : asset('images/placeholder.png') }}" 
                             alt="{{ $auction->item->item_name }}" 
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </div>
                </div>

                <div class="bg-white border-4 border-black p-6 md:p-8 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]">
                    <h3 class="text-2xl font-black uppercase mb-6 flex items-center gap-3 border-b-4 border-black pb-4">
                        <span class="w-6 h-6 bg-teal-400 border-2 border-black block"></span>
                        DETAIL ITEM
                    </h3>
                    <div class="prose max-w-none text-lg font-medium text-gray-800 leading-relaxed mb-8">
                        {{ $auction->item->description }}
                    </div>
                    <div class="bg-yellow-50 border-2 border-black p-4 flex items-center gap-4">
                        <div class="w-12 h-12 bg-black text-white flex items-center justify-center font-black text-xl rounded-full border-2 border-white shadow-sm">
                            {{ substr($auction->item->user->username ?? '?', 0, 1) }}
                        </div>
                        <div>
                            <p class="text-xs font-bold uppercase text-gray-500">DIJUAL OLEH</p>
                            <p class="text-xl font-black uppercase">{{ $auction->item->user->username ?? 'Unknown User' }}</p>
                        </div>
                        <div class="ml-auto">
                            <span class="bg-green-500 text-white text-xs px-2 py-1 font-bold border-2 border-black uppercase">Verified</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN (TIMER, BID, BUYOUT, PAYMENT) --}}
            <div class="lg:col-span-5 space-y-6">
                
                {{-- CARD HARGA & TIMER --}}
                <div class="bg-black text-white border-4 border-black p-6 shadow-[8px_8px_0px_0px_rgba(100,100,100,1)] relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gray-800 rounded-full mix-blend-overlay filter blur-xl opacity-50 transform translate-x-10 -translate-y-10"></div>
                    <p class="text-sm font-bold text-gray-400 uppercase mb-1 tracking-widest">
                        {{ $auction->status == 'active' ? 'CURRENT BID' : 'FINAL PRICE' }}
                    </p>
                    <h2 class="text-5xl md:text-6xl font-black text-yellow-400 mb-6 tracking-tighter">
                        <span class="text-2xl align-top text-white mr-1">Rp</span>{{ number_format($auction->current_price ?? $auction->starting_price, 0, ',', '.') }}
                    </h2>
                    
                    @if($isActive)
                        <div class="bg-gray-900 border-2 border-gray-700 p-4 flex justify-between items-center relative z-10">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-red-500 rounded-full animate-ping"></div>
                                <span class="font-bold uppercase text-sm text-gray-300">Sisa Waktu</span>
                            </div>
                            <span id="countdown" class="font-mono text-2xl font-bold text-red-500 tracking-widest">--:--:--</span>
                        </div>
                    @endif
                </div>

                {{-- FORM / STATUS CONTAINER --}}
                <div id="action-forms-container">
                    
                    @if($isActive)
                        {{-- ========== KONDISI: LELANG AKTIF ========== --}}

                        @if(Auth::id() !== $auction->item->user_id)
                            
                            {{-- FORM BIDDING --}}
                            <div class="bg-white border-4 border-black p-6 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]">
                                <form action="{{ route('auctions.bid', $auction->id) }}" method="POST">
                                    @csrf
                                    <label class="block font-black uppercase mb-3 text-lg">MASUKKAN TAWARAN</label>
                                    <div class="flex relative mb-2">
                                        <span class="bg-gray-200 border-y-4 border-l-4 border-black flex items-center px-4 font-black text-xl text-gray-500">Rp</span>
                                        <input type="number" 
                                            name="bid_price" 
                                            class="w-full border-4 border-black p-4 font-black text-2xl focus:outline-none focus:bg-yellow-50 focus:ring-0" 
                                            placeholder="{{ $auction->current_price ? $auction->current_price + $auction->min_increment : $auction->starting_price }}"
                                            min="{{ $auction->current_price ? $auction->current_price + $auction->min_increment : $auction->starting_price }}">
                                    </div>
                                    <p class="text-xs font-bold text-gray-500 mb-4 text-right">
                                        Minimal Bid: Rp {{ number_format($auction->current_price ? $auction->current_price + $auction->min_increment : $auction->starting_price, 0, ',', '.') }}
                                    </p>
                                    <button type="submit" class="w-full py-4 bg-teal-400 text-black font-black text-xl border-4 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none hover:bg-teal-300 transition-all uppercase tracking-widest flex items-center justify-center gap-2">
                                        <span>KIRIM TAWARAN</span>
                                        <svg class="w-6 h-6 border-2 border-black rounded-full bg-white p-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                    </button>
                                </form>
                            </div>

                            {{-- TOMBOL BUYOUT --}}
                            <form action="{{ route('auctions.buyout', $auction->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="group relative w-full py-5 bg-pink-500 text-white font-black text-xl border-4 border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] hover:bg-pink-400 hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transition-all uppercase overflow-hidden mt-6">
                                    <div class="absolute inset-0 bg-white/10 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-500"></div>
                                    <div class="relative flex flex-col items-center leading-tight">
                                        <span class="text-sm opacity-90 font-bold tracking-widest mb-1">JANGAN TUNGGU LAMA!</span>
                                        <span class="text-2xl drop-shadow-md">BUYOUT: Rp {{ number_format($auction->buyout_price, 0, ',', '.') }}</span>
                                    </div>
                                </button>
                            </form>
                        
                        @else
                            {{-- PESAN UNTUK PEMILIK BARANG --}}
                            <div class="bg-gray-100 border-4 border-black p-6 text-center shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                                <div class="inline-block bg-black text-white p-2 rounded-full mb-3">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <h3 class="font-black text-xl uppercase text-gray-800 mb-1">BARANG INI MILIK ANDA</h3>
                                <p class="text-sm font-bold text-gray-500">Anda tidak dapat melakukan penawaran atau pembelian pada barang lelang sendiri.</p>
                            </div>
                        @endif

                    @else
                        {{-- ========== KONDISI: LELANG BERAKHIR / SELESAI ========== --}}
                        
                        @php $showGenericEndedMsg = true; @endphp

                        {{-- JIKA YANG LOGIN ADALAH PEMENANG --}}
                        @if(Auth::id() == $auction->winner_id)
                            
                            {{-- CASE 1: BELUM BAYAR (CLOSED) --}}
                            @if($auction->status == 'closed')
                                @php $showGenericEndedMsg = false; @endphp
                                <div class="bg-green-100 border-4 border-black p-6 text-center shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] animate-pulse">
                                    <h3 class="font-black text-2xl uppercase text-green-800 mb-2">🎉 SELAMAT! ANDA MENANG!</h3>
                                    <p class="text-sm font-bold text-gray-700 mb-4">Segera selesaikan pembayaran untuk mengklaim item ini.</p>
                                    
                                    {{-- TOMBOL KE HALAMAN CHECKOUT --}}
                                    <a href="{{ route('transactions.checkout', $auction->id) }}" class="inline-block w-full py-4 bg-black text-white font-black text-xl border-4 border-transparent hover:bg-white hover:text-black hover:border-black transition-all uppercase cursor-pointer">
                                        BAYAR SEKARANG &rarr;
                                    </a>
                                </div>

                            {{-- CASE 2: SUDAH BAYAR, MENUNGGU VERIFIKASI (PENDING_PAYMENT) --}}
                            @elseif($auction->status == 'pending_payment')
                                @php $showGenericEndedMsg = false; @endphp
                                <div class="bg-yellow-100 border-4 border-black p-6 text-center shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                                    <h3 class="font-black text-xl uppercase text-yellow-800 mb-2">⏳ PEMBAYARAN SEDANG DIPROSES</h3>
                                    <p class="text-sm font-bold text-gray-600">Admin sedang memverifikasi bukti pembayaran Anda. Harap tunggu.</p>
                                </div>

                            {{-- CASE 3: SELESAI (DONE) --}}
                            @elseif($auction->status == 'done')
                                @php $showGenericEndedMsg = false; @endphp
                                <div class="bg-blue-100 border-4 border-black p-6 text-center shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                                    <h3 class="font-black text-xl uppercase text-blue-800 mb-2">✅ TRANSAKSI SELESAI</h3>
                                    <p class="text-sm font-bold text-gray-600">Selamat! Item ini sudah resmi menjadi milik Anda.</p>
                                </div>
                            @endif

                        @endif

                        {{-- PESAN DEFAULT: LELANG BERAKHIR (Untuk user kalah, publik, atau pemilik barang) --}}
                        @if($showGenericEndedMsg)
                            <div class="bg-red-100 border-4 border-black p-6 text-center shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                                <h3 class="font-black text-xl uppercase text-red-600 mb-1">LELANG TELAH BERAKHIR</h3>
                                <p class="text-sm font-bold text-gray-600">
                                    @if(Auth::id() == $auction->item->user_id)
                                        Barang Anda telah terjual / berakhir. Cek status pembayaran pembeli.
                                    @else
                                        Terima kasih telah berpartisipasi.
                                    @endif
                                </p>
                            </div>
                        @endif

                    @endif
                </div>
                {{-- END WRAPPER --}}


                <div class="bg-white border-4 border-black p-6 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] mt-6">
                    <h3 class="font-black uppercase border-b-4 border-black pb-3 mb-4 text-xl flex justify-between items-center">
                        RIWAYAT BID
                        <span class="bg-black text-white text-xs px-2 py-1 rounded-none">{{ $auction->bids->count() }} BIDS</span>
                    </h3>
                    
                    <div class="space-y-3 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                        @forelse($auction->bids->sortByDesc('created_at') as $bid)
                            <div class="flex justify-between items-center border-b-2 border-dashed border-gray-300 pb-2 hover:bg-gray-50 transition-colors p-2">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-gray-200 border-2 border-black rounded-full flex items-center justify-center font-bold text-xs">
                                        {{ substr($bid->user->username ?? '?', 0, 1) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-bold text-sm uppercase">{{ $bid->user->username ?? 'User' }}</span>
                                        <span class="text-[10px] font-bold text-gray-400">{{ $bid->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                <span class="font-mono font-black text-teal-600">
                                    Rp {{ number_format($bid->bid_price, 0, ',', '.') }}
                                </span>
                            </div>
                        @empty
                            <div class="text-center py-6 text-gray-400 font-bold italic">
                                Belum ada penawaran. Jadilah yang pertama!
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    const endTime = new Date("{{ $auction->end_time }}").getTime();
    
    // GUARD CLAUSE (PENTING): Pastikan status lelang memang active sebelum menjalankan timer
    const auctionStatus = "{{ $auction->status }}";
    const isActive = "{{ $isActive }}";

    // Timer hanya jalan jika status 'active' DAN PHP bilang masih active
    if (auctionStatus === 'active' && isActive) {
        const timer = setInterval(function() {
            const now = new Date().getTime();
            const distance = endTime - now;

            // LOGIC JIKA WAKTU HABIS (Realtime Check)
            if (distance < 0) {
                clearInterval(timer);
                
                // 1. Ubah Timer Text
                const countdownEl = document.getElementById("countdown");
                if(countdownEl) {
                    countdownEl.innerHTML = "EXPIRED";
                    countdownEl.classList.add("text-gray-500");
                }
                
                // 2. Ubah Badge Status
                const badge = document.getElementById("status-badge");
                if(badge) {
                    badge.innerHTML = "BERAKHIR";
                    badge.className = "text-xl font-black uppercase text-red-600";
                }

                // 3. Hapus Badge HOT
                const hotBadge = document.getElementById("hot-badge");
                if(hotBadge) hotBadge.style.display = "none";

                // 4. Ganti Form dengan Pesan Refresh (Agar tombol bayar tidak tertimpa salah)
                const formsContainer = document.getElementById("action-forms-container");
                if(formsContainer) {
                    formsContainer.innerHTML = `
                        <div class="bg-red-100 border-4 border-black p-6 text-center shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                            <h3 class="font-black text-xl uppercase text-red-600 mb-1">WAKTU HABIS</h3>
                            <p class="text-sm font-bold text-gray-600">Silakan refresh halaman untuk melihat status akhir lelang.</p>
                            <button onclick="location.reload()" class="mt-3 bg-black text-white px-4 py-2 font-bold uppercase text-xs">REFRESH HALAMAN</button>
                        </div>
                    `;
                }

                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            const countdownEl = document.getElementById("countdown");
            if(countdownEl) {
                countdownEl.innerHTML = (days > 0 ? days + "d " : "") + hours + "h " + minutes + "m " + seconds + "s ";
            }
        }, 1000);
    }
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 8px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-left: 2px solid black; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: black; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #333; }
</style>
@endsection