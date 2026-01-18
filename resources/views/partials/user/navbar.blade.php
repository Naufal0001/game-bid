<nav class="bg-yellow-400 border-b-4 border-black sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-black text-white flex items-center justify-center font-black text-xl border-2 border-white">G</div>
                <a href="{{ url('/') }}" class="text-2xl font-black italic tracking-tighter hover:underline decoration-4">GAMEBID</a>
            </div>

            <div class="flex items-center gap-4">
                
                @guest
                    <a href="{{ route('login') }}" class="font-bold text-black uppercase tracking-wider hover:underline decoration-2 underline-offset-4 mr-2">
                        Login
                    </a>

                    <a href="{{ route('register') }}" class="inline-block px-6 py-2 bg-black text-white font-bold border-2 border-transparent shadow-[4px_4px_0px_0px_rgba(255,255,255,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all">
                        JOIN NOW
                    </a>
                @endguest

                @auth
                    <div class="hidden md:flex items-center gap-2 mr-4">
                        <div class="w-8 h-8 bg-teal-400 border-2 border-black rounded-full"></div>
                        <span class="font-bold uppercase">{{ Auth::user()->name }}</span>
                    </div>

                    <a href="{{ url('/dashboard') }}" class="font-bold text-sm border-2 border-black px-3 py-1 bg-white hover:bg-gray-100 shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] active:shadow-none active:translate-x-[2px] active:translate-y-[2px] transition-all">
                        DASHBOARD
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="font-bold text-sm border-2 border-black px-3 py-1 bg-red-500 text-white hover:bg-red-600 shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] active:shadow-none active:translate-x-[2px] active:translate-y-[2px] transition-all ml-2">
                            LOGOUT
                        </button>
                    </form>
                @endauth

            </div>
        </div>
    </div>
</nav>