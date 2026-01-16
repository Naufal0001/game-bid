@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto p-6">
        <h1 class="text-xl font-bold mb-4">Buat Auction</h1>

        <form method="POST" action="{{ route('admin.auctions.store') }}">
            @csrf

            <select name="item_id" class="w-full border p-2 mb-3">
                @foreach ($items as $item)
                    <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                @endforeach
            </select>

            <input type="number" name="starting_price" class="w-full border p-2 mb-3" placeholder="Harga Awal">
            <input type="number" name="min_increment" class="w-full border p-2 mb-3" placeholder="Minimal Increment">
            <input type="datetime-local" name="start_time" class="w-full border p-2 mb-3">
            <input type="datetime-local" name="end_time" class="w-full border p-2 mb-3">

            <button class="bg-green-600 text-white px-4 py-2 rounded">
                Simpan
            </button>
        </form>
    </div>
@endsection
