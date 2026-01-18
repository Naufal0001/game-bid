@extends('layouts.admin')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">
            Verifikasi Seller
        </h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow rounded">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 border">Username</th>
                        <th class="p-3 border">Email</th>
                        <th class="p-3 border">Status</th>
                        <th class="p-3 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td class="p-3 border">{{ $user->username }}</td>
                            <td class="p-3 border">{{ $user->email }}</td>
                            <td class="p-3 border">
                                <span class="bg-yellow-200 px-2 py-1 rounded text-sm">
                                    {{ $user->status }}
                                </span>
                            </td>
                            <td class="p-3 border space-x-2">
                                <form action="{{ route('admin.users.verify.approve', $user) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    <button class="bg-green-600 text-white px-3 py-1 rounded">
                                        Approve
                                    </button>
                                </form>

                                <form action="{{ route('admin.users.verify.reject', $user) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    <button class="bg-red-600 text-white px-3 py-1 rounded">
                                        Reject
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-500">
                                Tidak ada user pending verifikasi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
