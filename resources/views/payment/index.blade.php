@extends('layouts.app')

@section('content')
<h4>Verifikasi Pembayaran</h4>

<table class="table table-bordered">
    <tr>
        <th>Buyer</th>
        <th>Item</th>
        <th>Bukti</th>
        <th>Aksi</th>
    </tr>

    @foreach($transactions as $t)
    <tr>
        <td>{{ $t->buyer->name }}</td>
        <td>{{ $t->auction->item->name }}</td>
        <td>
            <a href="{{ asset('storage/'.$t->payment_proof) }}" target="_blank">
                Lihat Bukti
            </a>
        </td>
        <td>
            <form method="POST" action="{{ route('admin.payments.approve', $t) }}" class="d-inline">
                @csrf
                <button class="btn btn-success btn-sm">✔</button>
            </form>

            <form method="POST" action="{{ route('admin.payments.reject', $t) }}" class="d-inline">
                @csrf
                <button class="btn btn-danger btn-sm">✖</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
