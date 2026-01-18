<x-guest-layout>
    <div class="bg-[#FFFBEB] p-6 sm:p-10 border-[4px] border-black shadow-[10px_10px_0px_0px_rgba(0,0,0,1)]">
        
        <div class="mb-6 text-center">
            <h2 class="text-4xl font-black uppercase tracking-tighter leading-none">
                <span class="text-black">SECURE AREA</span>
            </h2>
            <div class="h-1.5 w-16 bg-black mx-auto mt-3"></div>
        </div>

        <div class="mb-6 text-sm font-bold text-black text-justify leading-relaxed">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
            @csrf

            <div class="group">
                <div class="bg-white border-[4px] border-black p-0 transition-all focus-within:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]">
                    <input id="password" class="block w-full border-none focus:ring-0 font-bold p-4 text-sm placeholder-gray-500 bg-transparent text-black"
                           type="password" name="password"
                           placeholder="Current Password" required autocomplete="current-password" autofocus />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1 font-bold text-xs text-red-600" />
            </div>

            <button type="submit" class="w-full bg-pink-500 text-white font-black py-4 uppercase italic text-xl border-[4px] border-black shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all active:scale-95">
                {{ __('Confirm') }}
            </button>

            <a href="{{ url()->previous() }}" class="w-full flex justify-center items-center bg-white border-[4px] border-black text-black font-black py-3 uppercase text-sm shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all active:scale-95 mt-2">
                Cancel
            </a>
        </form>
    </div>
</x-guest-layout>