<x-guest-layout>
    <div class="bg-[#FFFBEB] p-6 sm:p-10 border-[4px] border-black shadow-[10px_10px_0px_0px_rgba(0,0,0,1)]">
        
        <div class="mb-8 text-center">
            <h2 class="text-5xl font-black uppercase tracking-tighter leading-none">
                <span class="text-black text-3xl">WELCOME TO</span><br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-400 via-purple-500 to-pink-500" 
                      style="-webkit-text-stroke: 2px black;">
                    GAMEBID
                </span>
            </h2>
            <div class="h-1.5 w-16 bg-black mx-auto mt-3"></div>
            <p class="font-bold text-black text-sm mt-3 tracking-wide">Platform Lelang Item Game Paling Negro</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div class="group">
                <div class="bg-white border-[4px] border-black p-0 transition-all focus-within:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]">
                    <input id="email" class="block w-full border-none focus:ring-0 font-bold p-4 text-sm placeholder-gray-500 bg-transparent text-black" 
                           type="email" name="email" :value="old('email')" 
                           placeholder="Email Address" required autofocus />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1 font-bold text-xs text-red-600" />
            </div>

            <div class="group">
                <div class="bg-white border-[4px] border-black p-0 transition-all focus-within:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]">
                    <input id="password" class="block w-full border-none focus:ring-0 font-bold p-4 text-sm placeholder-gray-500 bg-transparent text-black"
                           type="password" name="password"
                           placeholder="Password" required />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1 font-bold text-xs text-red-600" />
            </div>

            <div class="flex items-center justify-between font-bold text-xs">
                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                    <input id="remember_me" type="checkbox" class="border-[3px] border-black text-pink-600 focus:ring-0 w-4 h-4 rounded-none bg-white" name="remember">
                    <span class="ms-2">Remember me</span>
                </label>
                <a class="hover:text-pink-600 underline decoration-2 underline-offset-4" href="{{ route('password.request') }}">
                    Forgot Password?
                </a>
            </div>

            <button type="submit" class="w-full bg-pink-500 text-white font-black py-4 uppercase italic text-xl border-[4px] border-black shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all active:scale-95">
                Log In
            </button>

            <div class="text-center font-bold text-xs mt-2">
                <span>Don't have an account?</span>
                <a href="{{ route('register') }}" class="text-pink-600 hover:text-pink-800 underline decoration-2 underline-offset-2 ml-1">
                    Register Now
                </a>
            </div>

            <div class="flex items-center py-2">
                <div class="flex-grow h-1 bg-black"></div>
                <span class="mx-4 font-black text-xs">OR</span>
                <div class="flex-grow h-1 bg-black"></div>
            </div>

            <a href="{{ url('auth/google') }}" class="w-full flex justify-center items-center bg-yellow-400 border-[4px] border-black text-black font-black py-4 uppercase text-sm shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all active:scale-95">
                <img src="https://www.svgrepo.com/show/355037/google.svg" class="w-5 h-5 mr-3" alt="Google">
                Login with Gmail
            </a>

            <a href="{{ url('/') }}" class="w-full flex justify-center items-center bg-white border-[4px] border-black text-black font-black py-3 uppercase text-sm shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all active:scale-95 mt-4">
                ← Back to Home
            </a>
        </form>
    </div>
</x-guest-layout>