@extends('layouts.app')

@section('content')
<div class="card shadow">
    <div class="card-header fw-bold">
        Detail Transaksi
    </div>

    <div class="card-body">
        <p><strong>Item:</strong> {{ $transaction->auction->item->name }}</p>
        <p><strong>Seller:</strong> {{ $transaction->seller->name }}</p>
        <p><strong>Total:</strong> Rp {{ number_format($transaction->amount) }}</p>

        <p>
            <strong>Status:</strong>
            <span class="badge bg-warning text-dark">
                {{ strtoupper($transaction->status) }}
            </span>
        </p>

        {{-- INFO REKENING --}}
        @if($transaction->status === 'pending')
            <div class="alert alert-info">
                <strong>Transfer ke:</strong><br>
                BCA 1234567890<br>
                a.n GameBid Official
            </div>
        @endif

        {{-- FORM UPLOAD --}}
        @if($transaction->status === 'pending')
            <form method="POST"
                  action="{{ route('transactions.uploadProof', $transaction) }}"
                  enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Upload Bukti Pembayaran</label>
                    <input type="file" name="payment_proof" class="form-control" required>
                </div>

                <button class="btn btn-primary">
                    📤 Kirim Bukti
                </button>
            </form>
        @endif

        {{-- MENUNGGU --}}
        @if($transaction->status === 'waiting_verification')
            <div class="alert alert-warning mt-3">
                ⏳ Menunggu verifikasi admin
            </div>
        @endif

        {{-- SUKSES --}}
        @if($transaction->status === 'paid')
            <div class="alert alert-success mt-3">
                ✅ Pembayaran berhasil diverifikasi
            </div>
        @endif
    </div>
</div>
@endsection
