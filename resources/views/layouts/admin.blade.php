<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,700;0,900;1,900&display=swap" rel="stylesheet">
    <style>body { font-family: 'Montserrat', sans-serif; }</style>
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

</body>
</html>