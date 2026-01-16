@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">
            {{ $auction->item->item_name }}
        </h1>

        <p class="text-gray-600 mb-2">
            Kategori: {{ $auction->item->category->category_name }}
        </p>

        <p class="mb-4">
            Penjual:
            <span class="font-semibold">
                {{ $auction->item->user->username }}
            </span>
        </p>

        <div class="bg-white shadow rounded p-4 mb-6">
            <p>
                Harga Saat Ini:
                <span class="text-xl font-bold text-green-600">
                    Rp {{ number_format($auction->current_price) }}
                </span>
            </p>

            <p class="mt-2">
                Minimal Kenaikan:
                Rp {{ number_format($auction->min_increment) }}
            </p>

            <p class="mt-2 text-sm text-gray-500">
                Berakhir pada: {{ $auction->end_time->format('d M Y H:i') }}
            </p>
        </div>

        <div x-data="countdown('{{ $auction->end_time->toIso8601String() }}')" x-init="start()" class="bg-white shadow rounded p-4 mb-6">
            <h2 class="font-bold mb-2">Sisa Waktu</h2>

            <div class="flex gap-4 text-center">
                <div>
                    <p class="text-xl font-bold" x-text="days()"></p>
                    <p class="text-sm text-gray-500">Hari</p>
                </div>
                <div>
                    <p class="text-xl font-bold" x-text="hours()"></p>
                    <p class="text-sm text-gray-500">Jam</p>
                </div>
                <div>
                    <p class="text-xl font-bold" x-text="minutes()"></p>
                    <p class="text-sm text-gray-500">Menit</p>
                </div>
                <div>
                    <p class="text-xl font-bold" x-text="seconds()"></p>
                    <p class="text-sm text-gray-500">Detik</p>
                </div>
            </div>

            <p x-show="remaining === 0" class="mt-3 text-red-600 font-semibold">
                Auction Berakhir
            </p>

            @if ($auction->is_buyout)
                <p class="text-red-600 font-bold">
                    Auction ditutup via Buyout
                </p>
            @endif
        </div>

        {{-- FORM BID --}}
        @auth
            @if ($auction->buyout_price && $auction->isActive())
                <form action="{{ route('bids.store', $auction->id) }}" method="POST" class="bg-gray-100 p-4 rounded mb-6">
                    @csrf

                    <label class="block mb-2 font-semibold">
                        Nominal Bid
                    </label>

                    <input type="number" name="bid_price" min="{{ $auction->current_price + $auction->min_increment }}"
                        class="w-full border rounded px-3 py-2 mb-3" required>

                    <button type="submit" :disabled="remaining === 0"
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 disabled:opacity-50">
                        Kirim Bid
                    </button>
                </form>
                <form action="{{ route('auctions.buyout', $auction) }}" method="POST"
                    onsubmit="return confirm('Beli langsung dengan harga buyout?')" class="mb-4">
                    @csrf
                    <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 w-full">
                        Buyout – Rp {{ number_format($auction->buyout_price) }}
                    </button>
                </form>
            @else
                <p class="text-red-600 font-semibold">
                    Auction sudah berakhir.
                </p>
            @endif
        @else
            <p class="text-sm">
                <a href="{{ route('login') }}" class="text-blue-600 underline">
                    Login
                </a>
                untuk melakukan bid.
            </p>
        @endauth

        {{-- BID HISTORY --}}
        <div class="bg-white shadow rounded p-4">
            <h2 class="font-bold mb-4">Riwayat Bid</h2>

            <ul>
                @forelse ($auction->bids as $bid)
                    <li class="border-b py-2 flex justify-between">
                        <span>{{ $bid->user->username }}</span>
                        <span class="font-semibold">
                            Rp {{ number_format($bid->bid_price) }}
                        </span>
                    </li>
                @empty
                    <li>Belum ada bid.</li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function countdown(endTime) {
            return {
                end: new Date(endTime).getTime(),
                remaining: 0,
                timer: null,

                start() {
                    this.update();
                    this.timer = setInterval(() => {
                        this.update();
                    }, 1000);
                },

                update() {
                    const now = new Date().getTime();
                    this.remaining = Math.floor((this.end - now) / 1000);

                    if (this.remaining <= 0) {
                        clearInterval(this.timer);
                        this.remaining = 0;
                    }
                },

                days() {
                    return Math.floor(this.remaining / 86400);
                },

                hours() {
                    return Math.floor((this.remaining % 86400) / 3600);
                },

                minutes() {
                    return Math.floor((this.remaining % 3600) / 60);
                },

                seconds() {
                    return this.remaining % 60;
                }
            }
        }
    </script>
@endpush
