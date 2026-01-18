<x-guest-layout>
    <div class="bg-[#FFFBEB] p-6 sm:p-10 border-[4px] border-black shadow-[10px_10px_0px_0px_rgba(0,0,0,1)]">
        
        <div class="mb-6 text-center">
            <h2 class="text-4xl font-black uppercase tracking-tighter leading-none">
                <span class="text-black">SET NEW PASSWORD</span>
            </h2>
            <div class="h-1.5 w-16 bg-black mx-auto mt-3"></div>
            <p class="font-bold text-black text-sm mt-3 tracking-wide">Please enter your new password below.</p>
        </div>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="group">
                <div class="bg-white border-[4px] border-black p-0 transition-all focus-within:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]">
                    <input id="email" class="block w-full border-none focus:ring-0 font-bold p-4 text-sm placeholder-gray-500 bg-transparent text-black" 
                           type="email" name="email" :value="old('email', $request->email)" 
                           placeholder="Email Address" required autofocus autocomplete="username" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1 font-bold text-xs text-red-600" />
            </div>

            <div class="group">
                <div class="bg-white border-[4px] border-black p-0 transition-all focus-within:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]">
                    <input id="password" class="block w-full border-none focus:ring-0 font-bold p-4 text-sm placeholder-gray-500 bg-transparent text-black"
                           type="password" name="password"
                           placeholder="New Password" required autocomplete="new-password" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1 font-bold text-xs text-red-600" />
            </div>

            <div class="group">
                <div class="bg-white border-[4px] border-black p-0 transition-all focus-within:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]">
                    <input id="password_confirmation" class="block w-full border-none focus:ring-0 font-bold p-4 text-sm placeholder-gray-500 bg-transparent text-black"
                           type="password" name="password_confirmation"
                           placeholder="Confirm New Password" required autocomplete="new-password" />
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 font-bold text-xs text-red-600" />
            </div>

            <button type="submit" class="w-full bg-pink-500 text-white font-black py-4 uppercase italic text-xl border-[4px] border-black shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all active:scale-95 mt-2">
                Reset Password
            </button>
            
            <div class="flex items-center justify-center pt-2">
                <a class="font-bold text-xs text-gray-600 hover:text-pink-600 underline decoration-2 underline-offset-4 uppercase" href="{{ route('login') }}">
                    Cancel & Return to Login
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>