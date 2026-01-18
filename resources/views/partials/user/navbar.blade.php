<nav class="bg-yellow-400 border-b-4 border-black sticky top-0 z-50 font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            
            <div class="flex items-center gap-2 flex-shrink-0">
                <div class="w-10 h-10 bg-black text-white flex items-center justify-center font-black text-xl border-2 border-white shadow-[2px_2px_0px_0px_rgba(255,255,255,0.5)]">G</div>
                <a href="{{ url('/') }}" class="text-2xl font-black italic tracking-tighter hover:text-white transition-colors" style="-webkit-text-stroke: 1px black;">GAMEBID</a>
            </div>

            @auth
            <div class="hidden md:flex items-center gap-1 absolute left-1/2 transform -translate-x-1/2">
                <a href="{{ route('auctions.index') }}" class="px-4 py-2 font-bold uppercase border-2 border-transparent hover:bg-black hover:text-white hover:border-black transition-all transform hover:-translate-y-1">
                    Auctions
                </a>
                <a href="{{ route('items.index') }}" class="px-4 py-2 font-bold uppercase border-2 border-transparent hover:bg-black hover:text-white hover:border-black transition-all transform hover:-translate-y-1">
                    My Items
                </a>
                <a href="{{ route('history.index') }}" class="px-4 py-2 font-bold uppercase border-2 border-transparent hover:bg-black hover:text-white hover:border-black transition-all transform hover:-translate-y-1">
                    History
                </a>
            </div>
            @endauth

            <div class="flex items-center gap-4">
                
                @guest
                    <a href="{{ route('login') }}" class="font-bold text-black uppercase tracking-wider hover:underline decoration-4 underline-offset-4 mr-2">
                        Login
                    </a>

                    <a href="{{ route('register') }}" class="inline-block px-6 py-2 bg-black text-white font-bold border-2 border-transparent shadow-[4px_4px_0px_0px_rgba(255,255,255,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all uppercase">
                        Join Now
                    </a>
                @endguest

                @auth
                    <div class="flex items-center gap-3">
                        
                        <a href="{{ route('profile.edit') }}" class="group flex items-center gap-3 px-4 py-2 bg-white border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all cursor-pointer">
                            <div class="w-6 h-6 bg-teal-400 border border-black rounded-full overflow-hidden">
                                <svg class="w-full h-full text-black" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            </div>
                            <span class="font-black uppercase text-sm tracking-wide group-hover:text-pink-500 transition-colors">
                                {{ Auth::user()->name }}
                            </span>
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="p-2 bg-red-500 border-2 border-black text-white hover:bg-red-600 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all" title="Logout">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>

                    </div>
                @endauth

            </div>
        </div>
    </div>
</nav>