<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'UMKM Sedayu') }} - Akun Pembeli</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    
    <!-- Navbar Atas (Bisa pakai navbar bawaan, kita panggil komponen navigasi yang sudah ada) -->
    @include('layouts.navigation')

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row gap-8">
            
            <!-- SIDEBAR KIRI -->
            <aside class="w-full md:w-64 shrink-0">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <!-- Info User Singkat -->
                    <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-100">
                        <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-xl">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 line-clamp-1">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">Member UMKM Sedayu</p>
                        </div>
                    </div>

                    <!-- Menu Navigasi -->
                    <nav class="space-y-1">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-xl {{ request()->routeIs('dashboard') ? 'bg-emerald-50 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition">
                            Dashboard Akun
                        </a>
                        <a href="{{ route('buyer.orders') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-xl {{ request()->routeIs('buyer.orders') ? 'bg-emerald-50 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition">
                            Pesanan Saya
                        </a>
                        <a href="{{ route('buyer.favorites') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-xl {{ request()->routeIs('buyer.favorites') ? 'bg-emerald-50 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition">
                            Barang Favorit
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition">
                            Chat Toko
                        </a>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition mt-4 pt-4 border-t border-gray-100">
                            Pengaturan Profil
                        </a>
                    </nav>
                </div>
            </aside>

            <!-- AREA KONTEN UTAMA KANAN -->
            <main class="flex-1">
                {{ $slot }}
            </main>

        </div>
    </div>
</body>
</html>