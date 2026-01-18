<x-guest-layout>
    <div class="bg-[#FFFBEB] p-6 sm:p-10 border-[4px] border-black shadow-[10px_10px_0px_0px_rgba(0,0,0,1)]">
        
        <div class="mb-6 text-center">
            <h2 class="text-4xl font-black uppercase tracking-tighter leading-none">
                <span class="text-black">RESET PASSWORD</span>
            </h2>
            <div class="h-1.5 w-16 bg-black mx-auto mt-3"></div>
        </div>

        <div class="mb-6 text-sm font-bold text-black text-justify leading-relaxed">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <x-auth-session-status class="mb-4 font-bold text-pink-600 uppercase text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <div class="group">
                <div class="bg-white border-[4px] border-black p-0 transition-all focus-within:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]">
                    <input id="email" class="block w-full border-none focus:ring-0 font-bold p-4 text-sm placeholder-gray-500 bg-transparent text-black" 
                           type="email" name="email" :value="old('email')" 
                           placeholder="Email Address" required autofocus />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1 font-bold text-xs text-red-600" />
            </div>

            <button type="submit" class="w-full bg-pink-500 text-white font-black py-4 uppercase italic text-lg border-[4px] border-black shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all active:scale-95">
                Email Password Reset Link
            </button>

            <div class="flex items-center justify-center pt-2">
                <a class="font-bold text-xs text-gray-600 hover:text-pink-600 underline decoration-2 underline-offset-4 uppercase" href="{{ route('login') }}">
                    < Back to Login
                </a>
            </div>

            <div class="flex items-center py-2">
                <div class="flex-grow h-1 bg-black"></div>
                <div class="flex-grow h-1 bg-black"></div>
            </div>

            <a href="{{ url('/') }}" class="w-full flex justify-center items-center bg-white border-[4px] border-black text-black font-black py-3 uppercase text-sm shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all active:scale-95">
                ← Back to Home
            </a>
        </form>
    </div>
</x-guest-layout>