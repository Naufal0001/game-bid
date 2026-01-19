@extends('layouts.admin')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-6">

        {{-- TITLE --}}
        <h1 class="text-2xl font-bold mb-4">Transaction Management</h1>

        {{-- FLASH MESSAGE --}}
        @if (session('success'))
            <div class="border-4 border-black bg-green-200 p-3 mb-4 font-bold">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="border-4 border-black bg-red-200 p-3 mb-4 font-bold">
                {{ session('error') }}
            </div>
        @endif

        {{-- FILTER --}}
        <form method="GET" class="mb-4 flex gap-2 flex-wrap">

            <input name="search" value="{{ request('search') }}" placeholder="Buyer / Item"
                class="border-4 border-black px-3 py-2 w-64">

            <select name="status" class="border-4 border-black px-3 py-2">
                <option value="">All Status</option>
                @foreach (['pending', 'approved', 'rejected', 'expired'] as $st)
                    <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>
                        {{ ucfirst($st) }}
                    </option>
                @endforeach
            </select>

            <button
                class="border-4 border-black bg-yellow-400 px-4 font-bold
                   shadow-[3px_3px_0_#000]
                   hover:translate-x-[1px] hover:translate-y-[1px]">
                Filter
            </button>
        </form>

        {{-- TABLE CARD --}}
        <div class="border-4 border-black bg-white shadow-[6px_6px_0_#000]">

            <table class="w-full">
                <thead class="bg-gray-100 border-b-4 border-black">
                    <tr>
                        <th class="p-3 text-left">Buyer</th>
                        <th class="p-3 text-left">Item</th>
                        <th class="p-3 text-left">Total</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-left">Bukti</th>
                        <th class="p-3 text-left">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($transactions as $trx)
                        <tr class="border-b-2 border-black hover:bg-gray-50">

                            <td class="p-3 font-semibold">
                                {{ $trx->user->username }}
                            </td>

                            <td class="p-3">
                                {{ $trx->auction->item->item_name }}
                            </td>

                            <td class="p-3 font-bold">
                                Rp {{ number_format($trx->final_price) }}
                            </td>

                            <td class="p-3">
                                @php
                                    $badge = match ($trx->status) {
                                        'pending' => 'bg-yellow-300',
                                        'approved' => 'bg-green-300',
                                        'rejected' => 'bg-red-300',
                                        'expired' => 'bg-gray-300',
                                        default => 'bg-gray-200',
                                    };
                                @endphp

                                <span class="px-2 py-1 border-2 border-black font-bold text-sm {{ $badge }}">
                                    {{ strtoupper($trx->status) }}
                                </span>
                            </td>

                            <td class="p-3">
                                @if ($trx->payment?->payment_proof)
                                    <a href="{{ asset('storage/' . $trx->payment->payment_proof) }}" target="_blank"
                                        class="underline font-bold">
                                        Lihat
                                    </a>
                                @else
                                    <span class="text-gray-500 font-semibold">-</span>
                                @endif
                            </td>

                            <td class="p-3">
                                @if ($trx->status === 'pending')
                                    <div class="flex gap-2">
                                        <form method="POST" action="{{ route('admin.transactions.approve', $trx) }}">
                                            @csrf
                                            <button
                                                class="border-2 border-black bg-green-500 text-white px-3 py-1 font-bold
                                                   shadow-[2px_2px_0_#000]
                                                   hover:translate-x-[1px] hover:translate-y-[1px]">
                                                Approve
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('admin.transactions.reject', $trx) }}">
                                            @csrf
                                            <button
                                                class="border-2 border-black bg-red-500 text-white px-3 py-1 font-bold
                                                   shadow-[2px_2px_0_#000]
                                                   hover:translate-x-[1px] hover:translate-y-[1px]">
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-gray-500 font-semibold text-sm">
                                        No action
                                    </span>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-4 text-center text-gray-500">
                                Tidak ada transaksi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="mt-4">
            {{ $transactions->links() }}
        </div>

    </div>
@endsection
