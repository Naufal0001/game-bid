@extends('layouts.admin')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-6">

        {{-- TITLE --}}
        <h1 class="text-2xl font-bold mb-4">Verifikasi Seller</h1>

        {{-- FLASH MESSAGE --}}
        @if (session('success'))
            <div class="border-4 border-black bg-green-200 p-3 mb-4 shadow-[4px_4px_0_#000]">
                {{ session('success') }}
            </div>
        @endif

        {{-- SEARCH --}}
        <form method="GET" class="mb-4 flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search username / email"
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
                            {!! sort_link('Username', 'username', $sort, $direction) !!}
                        </th>
                        <th class="p-3 text-left">
                            {!! sort_link('Email', 'email', $sort, $direction) !!}
                        </th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-left">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-b-2 border-black hover:bg-gray-50">
                            <td class="p-3">{{ $user->username }}</td>
                            <td class="p-3">{{ $user->email }}</td>
                            <td class="p-3">
                                <span class="px-2 py-1 border-2 border-black bg-yellow-300 text-sm font-bold">
                                    PENDING
                                </span>
                            </td>
                            <td class="p-3 flex gap-2">

                                {{-- APPROVE --}}
                                <form method="POST" action="{{ route('admin.user-verification.approve', $user) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button
                                        class="border-2 border-black bg-green-400 px-3 py-1 font-bold
                                           shadow-[2px_2px_0_#000]
                                           hover:translate-x-[1px] hover:translate-y-[1px]">
                                        Approve
                                    </button>
                                </form>

                                {{-- REJECT --}}
                                <form method="POST" action="{{ route('admin.user-verification.reject', $user) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button
                                        class="border-2 border-black bg-red-400 px-3 py-1 font-bold
                                           shadow-[2px_2px_0_#000]
                                           hover:translate-x-[1px] hover:translate-y-[1px]">
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

        {{-- PAGINATION --}}
        <div class="mt-4">
            {{ $users->links() }}
        </div>

    </div>
@endsection
