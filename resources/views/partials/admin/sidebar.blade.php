<aside class="w-64 bg-yellow-400 border-r-3 border-black min-h-screen flex flex-col">
    <div class="h-20 flex items-center justify-center border-b-3 border-black bg-white">
        <h1 class="text-2xl font-black italic tracking-tighter">Gamebid Admin</h1>
    </div>

    <nav class="flex-1 p-4 space-y-3">

        <a href="{{ route('admin.dashboard') }}"
            class="block px-4 py-3 bg-white border-3 border-black shadow-neo font-bold hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all">
            Dashboard
        </a>

        <a href="{{ route('admin.users.index') }}"
            class="block px-4 py-3 bg-transparent border-3 border-transparent hover:bg-white hover:border-black hover:shadow-neo font-bold transition-all">
            User Management
        </a>

        <a href="{{ route('admin.users.verify.index') }}"
            class="block px-4 py-3 bg-transparent border-3 border-transparent hover:bg-white hover:border-black hover:shadow-neo font-bold transition-all">
            User Verification
        </a>
        <a href="{{ route('admin.auctions.index') }}"
            class="block px-4 py-3 bg-transparent border-3 border-transparent hover:bg-white hover:border-black hover:shadow-neo font-bold transition-all">
            Auction Management
        </a>
        <a href="{{ route('admin.items.index') }}"
            class="block px-4 py-3 bg-transparent border-3 border-transparent hover:bg-white hover:border-black hover:shadow-neo font-bold transition-all">
            Item Management
        </a>
        <a href="{{ route('admin.transactions.index') }}"
            class="block px-4 py-3 bg-transparent border-3 border-transparent hover:bg-white hover:border-black hover:shadow-neo font-bold transition-all">
            Transaction Management
        </a>
        <a href="#"
            class="block px-4 py-3 bg-transparent border-3 border-transparent hover:bg-white hover:border-black hover:shadow-neo font-bold transition-all">
            Payment
        </a>
        <a href="{{ route('admin.reports.transactions') }}"
            class="block px-4 py-3 bg-transparent border-3 border-transparent hover:bg-white hover:border-black hover:shadow-neo font-bold transition-all">
            Reports
        </a>

    </nav>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <div :href="route('logout')" class="p-4 border-t-3 border-black bg-red-400">
            <button class="w-full font-black text-white text-left uppercase">Logout</button>
        </div>
    </form>
</aside>
