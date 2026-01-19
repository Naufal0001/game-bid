@extends('layouts.admin')

@section('content')
    <div class="grid grid-cols-4 gap-4 mb-6">
        @php
            $cards = [
                ['label' => 'Users', 'value' => $summary['users']],
                ['label' => 'Items', 'value' => $summary['items']],
                ['label' => 'Auctions', 'value' => $summary['auctions']],
            ];
        @endphp

        @foreach ($cards as $card)
            <div class="bg-white border-4 border-black shadow-[6px_6px_0_0_#000] p-4">
                <p class="text-sm font-bold uppercase tracking-wide">
                    {{ $card['label'] }}
                </p>
                <p class="text-3xl font-extrabold mt-2">
                    {{ $card['value'] }}
                </p>
            </div>
        @endforeach

        {{-- Income --}}
        <div class="bg-green-100 border-4 border-black shadow-[6px_6px_0_0_#000] p-4">
            <p class="text-sm font-bold uppercase tracking-wide">
                Total Income
            </p>
            <p class="text-3xl font-extrabold mt-2">
                Rp {{ number_format($summary['income']) }}
            </p>
        </div>
    </div>


    <x-neo-card title="Recent Activitys" class="mb-6">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b-3 border-black">
                    <th class="py-3 font-black">USER</th>
                    <th class="py-3 font-black">ACTION</th>
                    <th class="py-3 font-black">DATE</th>
                    <th class="py-3 font-black text-right">STATUS</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b-2 border-gray-200 hover:bg-yellow-50">
                    <td class="py-3 font-bold">Thalibul Ichlas</td>
                    <td class="py-3">Login</td>
                    <td class="py-3">10 Jan 2024</td>
                    <td class="py-3 text-right">
                        <span class="bg-green-300 border-2 border-black px-2 py-1 text-xs font-bold">ACTIVE</span>
                    </td>
                </tr>
                <tr class="hover:bg-yellow-50">
                    <td class="py-3 font-bold">Arik asep</td>
                    <td class="py-3">Purchase</td>
                    <td class="py-3">11 Jan 2024</td>
                    <td class="py-3 text-right">
                        <span class="bg-yellow-300 border-2 border-black px-2 py-1 text-xs font-bold">PENDING</span>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="mt-6 flex gap-4">
            <x-neo-button color="yellow">View All</x-neo-button>
            <x-neo-button color="white">Export PDF</x-neo-button>
        </div>

    </x-neo-card>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mt-6">

        <x-neo-card title="Monthly Income">
            <div class="h-56">
                <canvas id="incomeChart"></canvas>
            </div>
        </x-neo-card>

        <x-neo-card title="Transaction Status">
            <div class="h-56 flex items-center justify-center">
                <canvas id="transactionChart"></canvas>
            </div>
        </x-neo-card>

        <x-neo-card title="Auction Status">
            <div class="h-56">
                <canvas id="auctionChart"></canvas>
            </div>
        </x-neo-card>

    </div>
@endsection
