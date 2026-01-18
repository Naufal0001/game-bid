<x-guest-layout>
    <div class="bg-[#FFFBEB] p-6 sm:p-10 border-[4px] border-black shadow-[10px_10px_0px_0px_rgba(0,0,0,1)]">
        
        <div class="mb-6 text-center">
            <h2 class="text-4xl font-black uppercase tracking-tighter leading-none">
                <span class="text-black">VERIFY EMAIL</span>
            </h2>
            <div class="h-1.5 w-16 bg-black mx-auto mt-3"></div>
        </div>

        <div class="mb-6 text-sm font-bold text-black text-justify leading-relaxed">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-6 p-4 border-[3px] border-green-600 bg-green-100 font-black text-sm text-green-800 uppercase text-center shadow-[4px_4px_0px_0px_#059669]">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="space-y-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="w-full bg-pink-500 text-white font-black py-4 uppercase italic text-lg border-[4px] border-black shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all active:scale-95">
                    {{ __('Resend Verification Email') }}
                </button>
            </form>

            <div class="flex items-center py-1">
                <div class="flex-grow h-1 bg-black"></div>
                <span class="mx-4 font-black text-xs">OR</span>
                <div class="flex-grow h-1 bg-black"></div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full bg-white text-black font-black py-3 uppercase text-sm border-[4px] border-black shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all active:scale-95">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>