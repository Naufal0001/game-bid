@extends('layouts.admin')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-6">

        {{-- TITLE --}}
        <h1 class="text-2xl font-bold mb-6">Laporan Transaksi</h1>

        {{-- SUMMARY CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

            <div class="border-4 border-black bg-white p-4 shadow-[4px_4px_0_#000]">
                <p class="text-sm font-semibold">Total Transaksi</p>
                <p class="text-2xl font-bold">
                    {{ $summary['total_transactions'] }}
                </p>
            </div>

            <div class="border-4 border-black bg-green-200 p-4 shadow-[4px_4px_0_#000]">
                <p class="text-sm font-semibold">Approved</p>
                <p class="text-2xl font-bold">
                    {{ $summary['approved_transactions'] }}
                </p>
            </div>

            <div class="border-4 border-black bg-red-200 p-4 shadow-[4px_4px_0_#000]">
                <p class="text-sm font-semibold">Failed</p>
                <p class="text-2xl font-bold">
                    {{ $summary['failed_transactions'] }}
                </p>
            </div>

            <div class="border-4 border-black bg-blue-200 p-4 shadow-[4px_4px_0_#000]">
                <p class="text-sm font-semibold">Total Income</p>
                <p class="text-2xl font-bold">
                    Rp {{ number_format($summary['total_income']) }}
                </p>
            </div>

        </div>

        {{-- FILTER --}}
        <form method="GET" class="mb-4 flex flex-wrap gap-2">

            <input type="date" name="from" value="{{ request('from') }}" class="border-4 border-black px-3 py-2">

            <input type="date" name="to" value="{{ request('to') }}" class="border-4 border-black px-3 py-2">

            <select name="status" class="border-4 border-black px-3 py-2">
                <option value="">All Status</option>
                @foreach (['approved', 'rejected', 'expired'] as $st)
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
                        <th class="p-3 text-left">Tanggal</th>
                        <th class="p-3 text-left">Buyer</th>
                        <th class="p-3 text-left">Item</th>
                        <th class="p-3 text-left">Total</th>
                        <th class="p-3 text-left">Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($transactions as $trx)
                        <tr class="border-b-2 border-black hover:bg-gray-50">

                            <td class="p-3 font-semibold">
                                {{ $trx->created_at->format('d-m-Y') }}
                            </td>

                            <td class="p-3">
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
                                        'approved' => 'bg-green-300',
                                        'rejected' => 'bg-red-300',
                                        'expired' => 'bg-gray-300',
                                        default => 'bg-yellow-300',
                                    };
                                @endphp

                                <span class="px-2 py-1 border-2 border-black font-bold text-sm {{ $badge }}">
                                    {{ strtoupper($trx->status) }}
                                </span>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-500">
                                Tidak ada data
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
