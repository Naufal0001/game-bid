@extends('layouts.admin')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-6">

        {{-- TITLE --}}
        <h1 class="text-2xl font-bold mb-4">Admin – Auction</h1>

        {{-- SEARCH --}}
        <form method="GET" class="mb-4 flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search item / seller"
                class="border-4 border-black px-3 py-2 w-64">

            <button
                class="border-4 border-black bg-yellow-400 px-4 font-bold
                   shadow-[3px_3px_0_#000]
                   hover:translate-x-[1px] hover:translate-y-[1px]">
                Search
            </button>
        </form>

        @php
            function sort_link($label, $column, $sort, $direction)
            {
                $dir = $sort === $column && $direction === 'asc' ? 'desc' : 'asc';

                return "<a class='underline font-bold' href='?" .
                    http_build_query(
                        array_merge(request()->all(), [
                            'sort' => $column,
                            'direction' => $dir,
                        ]),
                    ) .
                    "'>{$label}</a>";
            }
        @endphp

        {{-- TABLE CARD --}}
        <div class="border-4 border-black bg-white shadow-[6px_6px_0_#000]">

            <table class="w-full">
                <thead class="bg-gray-100 border-b-4 border-black">
                    <tr>
                        <th class="p-3 text-left">
                            {!! sort_link('Item', 'created_at', $sort, $direction) !!}
                        </th>
                        <th class="p-3 text-left">Seller</th>
                        <th class="p-3 text-left">
                            {!! sort_link('Start Price', 'starting_price', $sort, $direction) !!}
                        </th>
                        <th class="p-3 text-left">
                            {!! sort_link('Current Price', 'current_price', $sort, $direction) !!}
                        </th>
                        <th class="p-3 text-left">
                            {!! sort_link('Status', 'status', $sort, $direction) !!}
                        </th>
                        <th class="p-3 text-left">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($auctions as $auction)
                        <tr class="border-b-2 border-black hover:bg-gray-50">

                            <td class="p-3 font-semibold">
                                {{ $auction->item->item_name }}
                            </td>

                            <td class="p-3">
                                {{ $auction->user->username }}
                            </td>

                            <td class="p-3">
                                Rp {{ number_format($auction->starting_price) }}
                            </td>

                            <td class="p-3">
                                Rp {{ number_format($auction->current_price) }}
                            </td>

                            <td class="p-3">
                                @if ($auction->status === 'active')
                                    <span class="px-2 py-1 border-2 border-black bg-green-300 text-sm font-bold">
                                        ACTIVE
                                    </span>
                                @elseif ($auction->status === 'pending_payment')
                                    <span class="px-2 py-1 border-2 border-black bg-yellow-300 text-sm font-bold">
                                        PENDING PAYMENT
                                    </span>
                                @else
                                    <span class="px-2 py-1 border-2 border-black bg-gray-300 text-sm font-bold">
                                        CLOSED
                                    </span>
                                @endif
                            </td>

                            <td class="p-3">
                                @if ($auction->status === 'active')
                                    <form method="POST" action="{{ route('admin.auctions.close', $auction) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button
                                            class="border-2 border-black bg-red-500 text-white px-3 py-1 font-bold
                                               shadow-[2px_2px_0_#000]
                                               hover:translate-x-[1px] hover:translate-y-[1px]">
                                            Force Close
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-500 text-sm font-semibold">
                                        Closed
                                    </span>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-4 text-center text-gray-500">
                                Tidak ada auction
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="mt-4">
            {{ $auctions->links() }}
        </div>

    </div>
@endsection
