@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-6">Transaksi Saya</h1>

        @forelse ($transactions as $transaction)
            <div class="bg-white shadow rounded p-4 mb-4">
                <h2 class="font-semibold text-lg">
                    {{ $transaction->auction->item->item_name }}
                </h2>

                <p class="text-gray-600">
                    Harga Akhir:
                    <span class="font-bold text-green-600">
                        Rp {{ number_format($transaction->total_price) }}
                    </span>
                </p>

                <p class="mt-1">
                    Status Transaksi:
                    <span
                        class="px-2 py-1 rounded text-sm
                    {{ $transaction->status === 'paid' ? 'bg-green-200' : 'bg-yellow-200' }}">
                        {{ strtoupper($transaction->status) }}
                    </span>
                </p>

                <p class="text-sm text-gray-500 mt-1">
                    Tanggal: {{ $transaction->transaction_date->format('d M Y') }}
                </p>

                {{-- PAYMENT INFO --}}
                @if ($transaction->payment)
                    <p class="mt-2 text-sm text-gray-600">
                        Metode Pembayaran: {{ $transaction->payment->payment_method }}
                    </p>
                @else
                    <p class="mt-2 text-sm text-red-600">
                        Belum ada pembayaran
                    </p>
                @endif
            </div>
        @empty
            <p>Belum ada transaksi.</p>
        @endforelse

        <div class="mt-6">
            {{ $transactions->links() }}
        </div>
    </div>
@endsection
