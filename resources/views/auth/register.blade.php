<x-guest-layout>
    <div class="fixed inset-0 w-full h-full bg-[#FFFBEB] flex items-center justify-center overflow-hidden font-sans">

        <div
            class="absolute top-0 right-0 w-64 h-full bg-yellow-300 border-l-4 border-black transform skew-x-12 origin-top-right z-0 pointer-events-none opacity-100">
        </div>
        <div
            class="absolute bottom-0 left-0 w-40 h-40 bg-teal-400 border-4 border-black rounded-full z-0 transform -translate-x-10 translate-y-10 pointer-events-none">
        </div>

        <div class="relative z-10 w-full max-w-md px-4">
            <div class="bg-white p-6 sm:p-8 border-[4px] border-black shadow-[10px_10px_0px_0px_rgba(0,0,0,1)]">

                <div class="mb-5 text-center">
                    <h2 class="text-4xl md:text-5xl font-black uppercase tracking-tighter leading-none">
                        <span class="text-black text-2xl md:text-3xl">JOIN</span><br>
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-teal-400 via-purple-500 to-pink-500"
                            style="-webkit-text-stroke: 1.5px black;">
                            GAMEBID
                        </span>
                    </h2>
                    <div class="h-1.5 w-16 bg-black mx-auto mt-3"></div>
                    <p class="font-bold text-black text-xs mt-3 tracking-wide uppercase">Create Your Account</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-3">
                    @csrf

                    <div class="group">
                        <div
                            class="bg-white border-[3px] border-black p-0 transition-all focus-within:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] focus-within:-translate-y-1">
                            <input id="username"
                                class="block w-full border-none focus:ring-0 font-bold p-3 text-sm placeholder-gray-500 bg-transparent text-black"
                                type="text" name="username" :value="old('username')" placeholder="Username" required
                                autofocus autocomplete="username" />
                        </div>
                        <x-input-error :messages="$errors->get('username')" class="mt-1 font-bold text-xs text-red-600" />
                    </div>

                    <div class="group">
                        <div
                            class="bg-white border-[3px] border-black p-0 transition-all focus-within:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] focus-within:-translate-y-1">
                            <input id="email"
                                class="block w-full border-none focus:ring-0 font-bold p-3 text-sm placeholder-gray-500 bg-transparent text-black"
                                type="email" name="email" :value="old('email')" placeholder="Email Address"
                                required autocomplete="email" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1 font-bold text-xs text-red-600" />
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="group">
                            <div
                                class="bg-white border-[3px] border-black p-0 transition-all focus-within:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] focus-within:-translate-y-1">
                                <input id="password"
                                    class="block w-full border-none focus:ring-0 font-bold p-3 text-sm placeholder-gray-500 bg-transparent text-black"
                                    type="password" name="password" placeholder="Password" required
                                    autocomplete="new-password" />
                            </div>
                        </div>

                        <div class="group">
                            <div
                                class="bg-white border-[3px] border-black p-0 transition-all focus-within:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] focus-within:-translate-y-1">
                                <input id="password_confirmation"
                                    class="block w-full border-none focus:ring-0 font-bold p-3 text-sm placeholder-gray-500 bg-transparent text-black"
                                    type="password" name="password_confirmation" placeholder="Confirm" required
                                    autocomplete="new-password" />
                            </div>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1 font-bold text-xs text-red-600" />

                    <button type="submit"
                        class="w-full bg-pink-500 text-white font-black py-3 uppercase italic text-xl border-[4px] border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all active:scale-95 mt-2">
                        REGISTER NOW
                    </button>

                    <div class="grid grid-cols-2 gap-3 mt-4">
                        <a href="{{ url('auth/google') }}"
                            class="flex justify-center items-center bg-yellow-400 border-[3px] border-black text-black font-black py-2 uppercase text-xs shadow-[3px_3px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[1px] hover:translate-y-[1px] hover:shadow-none transition-all">
                            <img src="https://www.svgrepo.com/show/355037/google.svg" class="w-4 h-4 mr-2"
                                alt="Google">
                            Google
                        </a>
                        <a href="{{ url('/') }}"
                            class="flex justify-center items-center bg-white border-[3px] border-black text-black font-black py-2 uppercase text-xs shadow-[3px_3px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[1px] hover:translate-y-[1px] hover:shadow-none transition-all">
                            Back
                        </a>
                    </div>

                    <div class="text-center font-bold text-xs mt-4">
                        <span>Already have an account?</span>
                        <a href="{{ route('login') }}"
                            class="text-pink-600 hover:text-black bg-pink-100 px-1 border border-black ml-1 uppercase">
                            Log In Here
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
