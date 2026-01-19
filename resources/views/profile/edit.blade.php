@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-yellow-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 font-sans">

        <div class="max-w-md w-full space-y-8">

            <div
                class="bg-white border-4 border-black p-8 shadow-[12px_12px_0px_0px_rgba(0,0,0,1)] relative overflow-hidden">

                <div
                    class="absolute top-0 right-0 w-24 h-24 bg-yellow-400 border-b-4 border-l-4 border-black rounded-bl-full -mr-2 -mt-2 z-0">
                </div>
                <div
                    class="absolute bottom-0 left-0 w-16 h-16 bg-teal-400 border-t-4 border-r-4 border-black rounded-tr-full -ml-2 -mb-2 z-0">
                </div>

                <div class="relative z-10 flex flex-col items-center text-center">

                    <div class="relative mb-6">
                        <div
                            class="w-40 h-40 rounded-full border-4 border-black overflow-hidden bg-gray-200 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                            <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->username) . '&background=000&color=fff&size=256' }}"
                                alt="Avatar" class="w-full h-full object-cover">
                        </div>
                        @if (Auth::user()->email_verified_at)
                            <div class="absolute bottom-2 right-2 bg-green-500 text-white p-1 rounded-full border-2 border-black"
                                title="Verified">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <h2
                        class="text-3xl font-black uppercase tracking-tighter mb-1 bg-white border-2 border-black px-4 py-1 transform -skew-x-6 inline-block">
                        {{ Auth::user()->username }}
                    </h2>

                    <p class="text-gray-600 font-bold mb-6 text-sm bg-gray-100 px-2 border border-black mt-2">
                        {{ Auth::user()->email }}
                    </p>

                    <div class="w-full grid grid-cols-2 gap-4 mb-8">
                        <div
                            class="bg-pink-100 border-2 border-black p-2 flex flex-col items-center shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                            <span class="text-[10px] font-black uppercase text-gray-500">STATUS</span>
                            <span class="font-bold uppercase text-green-600">
                                {{ Auth::user()->status ?? 'ACTIVE' }}
                            </span>
                        </div>
                        <div
                            class="bg-blue-100 border-2 border-black p-2 flex flex-col items-center shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                            <span class="text-[10px] font-black uppercase text-gray-500">BERGABUNG</span>
                            <span class="font-bold uppercase text-gray-800">
                                {{ Auth::user()->created_at->format('M Y') }}
                            </span>
                        </div>
                    </div>

                    <a href="{{ route('home') }}" class="w-full group relative inline-block focus:outline-none focus:ring">
                        <span
                            class="absolute inset-0 translate-x-1.5 translate-y-1.5 bg-yellow-400 transition-transform group-hover:translate-y-0 group-hover:translate-x-0 border-4 border-black"></span>

                        <span
                            class="relative inline-block w-full border-4 border-current px-8 py-3 text-sm font-black uppercase tracking-widest text-black group-active:text-opacity-75 bg-white">
                            KEMBALI KE HOME
                        </span>
                    </a>

                    {{-- 
                <button class="mt-4 text-xs font-bold underline hover:text-yellow-600 uppercase">
                    Edit Profil
                </button> 
                --}}

                </div>
            </div>

        </div>
    </div>
@endsection
