@extends('layouts.admin')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">
            Detail User
        </h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white shadow rounded p-6 space-y-2">
            <p><strong>Username:</strong> {{ $user->username }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Role:</strong> {{ $user->getRoleNames()->first() }}</p>
            <p><strong>Status:</strong> {{ $user->status }}</p>

            <hr class="my-4">

            @if (!$user->hasRole('admin'))
                <form action="{{ route('admin.users.status', $user) }}" method="POST" class="flex items-center gap-2">
                    @csrf
                    @method('PATCH')

                    <select name="status" class="border rounded px-3 py-1">
                        <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>
                            Active
                        </option>
                        <option value="suspended" {{ $user->status === 'suspended' ? 'selected' : '' }}>
                            Suspended
                        </option>
                    </select>

                    <button class="bg-blue-600 text-white px-4 py-1 rounded">
                        Update Status
                    </button>
                </form>
            @endif
        </div>
    </div>
@endsection
