<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GameBid - Neo Auction</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>body { font-family: 'Montserrat', sans-serif; }</style>
</head>
<body class="antialiased bg-yellow-50 text-black flex flex-col min-h-screen">
    
    @include('partials.user.navbar')

    <main class="flex-grow">
        @yield('content')
    </main>

    @include('partials.user.footer')

</body>
</html>