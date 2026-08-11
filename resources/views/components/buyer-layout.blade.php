<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('logo.svg') }}" type="image/svg+xml">
    <title>{{ config('app.name', 'UMKM Sedayu') }} - Akun Pembeli</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    
    <!-- Navbar Atas (Bisa pakai navbar bawaan, kita panggil komponen navigasi yang sudah ada) -->
    @include('layouts.navigation')

    <div class="flex-1 flex flex-col overflow-hidden lg:ml-64">
        <main class="flex-1 overflow-y-auto bg-gray-50">
            <div class="mx-auto max-w-full md:max-w-7xl py-8 px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>
