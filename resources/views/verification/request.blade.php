@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">
            Ajukan Verifikasi Seller
        </h1>

        <div class="bg-white shadow rounded p-6">
            <p class="text-gray-600 mb-4">
                Untuk dapat membuat lelang, akun Anda harus diverifikasi oleh admin.
            </p>

            <form action="{{ route('verification.store') }}" method="POST">
                @csrf

                <p class="text-sm text-gray-500 mb-4">
                    Dengan mengajukan verifikasi, Anda menyatakan bahwa data akun Anda valid.
                </p>

                <button class="bg-blue-600 text-white px-4 py-2 rounded">
                    Ajukan Verifikasi
                </button>
            </form>
        </div>
    </div>
@endsection
