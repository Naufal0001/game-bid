@extends('layouts.admin')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-6">

        {{-- TITLE --}}
        <h1 class="text-2xl font-bold mb-4">Item Verification</h1>

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

            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search item / seller"
                class="border-4 border-black px-3 py-2 w-64">

            <select name="status" class="border-4 border-black px-3 py-2">
                <option value="">All Status</option>
                @foreach (['pending', 'verified', 'rejected', 'in_auction', 'sold'] as $st)
                    <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $st)) }}
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
                            {!! sort_link('Item', 'item_name', $sort, $direction) !!}
                        </th>
                        <th class="p-3 text-left">Seller</th>
                        <th class="p-3 text-left">
                            {!! sort_link('Status', 'status', $sort, $direction) !!}
                        </th>
                        <th class="p-3 text-left">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($items as $item)
                        <tr class="border-b-2 border-black hover:bg-gray-50">

                            <td class="p-3 font-semibold">
                                {{ $item->item_name }}
                            </td>

                            <td class="p-3">
                                {{ $item->user->username }}
                            </td>

                            <td class="p-3">
                                @php
                                    $badge = match ($item->status) {
                                        'pending' => 'bg-yellow-300',
                                        'verified' => 'bg-green-300',
                                        'sold' => 'bg-gray-300',
                                        'in_auction' => 'bg-blue-300',
                                        default => 'bg-red-300',
                                    };
                                @endphp

                                <span class="px-2 py-1 border-2 border-black font-bold text-sm {{ $badge }}">
                                    {{ strtoupper(str_replace('_', ' ', $item->status)) }}
                                </span>
                            </td>

                            <td class="p-3">
                                @if ($item->status === 'pending')
                                    <div class="flex gap-2">
                                        <form method="POST" action="{{ route('admin.items.approve', $item) }}">
                                            @csrf
                                            <button
                                                class="border-2 border-black bg-green-500 text-white px-3 py-1 font-bold
                                                   shadow-[2px_2px_0_#000]
                                                   hover:translate-x-[1px] hover:translate-y-[1px]">
                                                Approve
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('admin.items.reject', $item) }}">
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
                            <td colspan="4" class="p-4 text-center text-gray-500">
                                Tidak ada item
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="mt-4">
            {{ $items->links() }}
        </div>

    </div>
@endsection
