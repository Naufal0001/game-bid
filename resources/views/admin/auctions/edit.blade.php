@extends('layouts.admin')

@section('content')
    <div class="max-w-xl mx-auto p-6">
        <h1 class="text-xl font-bold mb-4">Edit Auction</h1>

        <form method="POST" action="{{ route('admin.auctions.update', $auction) }}">
            @csrf @method('PUT')

            <label>Status</label>
            <select name="status" class="w-full border p-2 mb-3">
                <option value="active" @selected($auction->status == 'active')>Active</option>
                <option value="closed" @selected($auction->status == 'closed')>Closed</option>
            </select>

            <label>End Time</label>
            <input type="datetime-local" name="end_time" value="{{ $auction->end_time->format('Y-m-d\TH:i') }}"
                class="w-full border p-2 mb-3">

            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Update
            </button>
        </form>
    </div>
@endsection
