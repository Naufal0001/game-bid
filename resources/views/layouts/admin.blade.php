<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.admin.head')
</head>

<body class="bg-white text-black antialiased">

    <div class="flex h-screen overflow-hidden">
        @include('partials.admin.sidebar')
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
            @include('partials.admin.navbar')
            <main class="w-full flex-grow p-6">
                <div class="w-full min-h-[200px]">
                    @yield('content')
                </div>
            </main>
            @include('partials.admin.footer')
        </div>
    </div>
    @include('partials.admin.scripts')
</body>

</html>
