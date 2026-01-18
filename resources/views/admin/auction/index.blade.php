@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Admin – Auction</h1>

        <a href="{{ route('admin.auctions.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
            + Buat Auction
        </a>

        <table class="w-full border">
            <tr class="bg-gray-100">
                <th class="p-2 border">Item</th>
                <th class="p-2 border">Harga</th>
                <th class="p-2 border">Status</th>
                <th class="p-2 border">Aksi</th>
            </tr>

            @foreach ($auctions as $auction)
                <tr>
                    <td class="p-2 border">{{ $auction->item->item_name }}</td>
                    <td class="p-2 border">Rp {{ number_format($auction->current_price) }}</td>
                    <td class="p-2 border">{{ $auction->status }}</td>
                    <td class="p-2 border">
                        <a href="{{ route('admin.auctions.edit', $auction) }}" class="text-blue-600">Edit</a>

                        <form action="{{ route('admin.auctions.destroy', $auction) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Hapus auction?')" class="text-red-600 ml-2">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>

        <div class="mt-4">
            {{ $auctions->links() }}
        </div>
    </div>
@endsection
