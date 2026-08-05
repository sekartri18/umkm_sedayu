<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Center - UMKM Sedayu</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'] }, colors: { primary: '#10B981', dark: '#1F2937' } } }
        }
    </script>
</head>
<body class="bg-gray-50 text-dark font-sans antialiased overflow-hidden">

    <link rel="icon" href="{{ asset('logo.svg') }}" type="image/svg+xml">
    <div class="flex h-screen w-full">
        <!-- Sidebar (Kiri) -->
        <aside class="w-64 bg-white border-r border-gray-100 flex flex-col hidden md:flex shrink-0 shadow-sm z-10">
            <div class="p-6 border-b border-gray-50">
                <h1 class="text-xl font-bold text-primary flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    Seller Center
                </h1>
            </div>
            <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-emerald-50 text-emerald-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>
                <a href="{{ route('produk.index') }}" class="{{ request()->routeIs('produk.*') ? 'bg-emerald-50 text-emerald-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Produk
                </a>
                <a href="{{ route('pesanan.index') }}" class="{{ request()->routeIs('pesanan.*') ? 'bg-emerald-50 text-emerald-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Pesanan
                </a>
                <!-- Menu Keuangan -->
                <a href="{{ route('keuangan.index') }}" class="{{ request()->routeIs('keuangan.*') ? 'bg-emerald-50 text-emerald-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Keuangan
                </a>
                <!-- Menu Pengaturan Baru -->
                <a href="{{ route('pengaturan.index') }}" class="{{ request()->routeIs('pengaturan.*') ? 'bg-emerald-50 text-emerald-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Pengaturan
                </a>
            </nav>
        </aside>

        <!-- Area Konten Utama -->
        <main class="flex-1 flex flex-col h-screen overflow-hidden">
            <header class="bg-white border-b border-gray-100 px-6 py-4 flex justify-between items-center shrink-0 shadow-sm z-10">
                <h2 class="font-bold text-lg text-gray-800">{{ $header ?? 'Seller Center' }}</h2>
                <div class="flex items-center gap-4">
                    <span class="text-sm font-medium text-gray-600 border-r border-gray-200 pr-4">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-red-500 hover:text-red-700 font-medium">Keluar</button>
                    </form>
                </div>
            </header>

            <div class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                {{ $slot }}
            </div>
        </main>
    </div>

</body>
</html>
