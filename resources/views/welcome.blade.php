<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UMKM Sedayu - Direktori Produk Lokal</title>
    <!-- Font Inter dari Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: { primary: '#10B981', dark: '#1F2937' }
                }
            }
        }
    </script>
    <!-- CSS Tambahan untuk menyembunyikan scrollbar -->
    <style>
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-gray-50 text-dark font-sans pb-24 antialiased">

    <!-- 1. Sticky Header & Search Bar dengan Tombol Login/Register -->
    <header class="sticky top-0 bg-white z-50 px-4 py-4 shadow-sm border-b border-gray-100">
        <div class="flex justify-between items-center mb-3">
            <h1 class="text-xl font-bold text-primary">UMKM Sedayu</h1>
            
            <!-- Menu Otentikasi -->
            <div class="flex items-center gap-3">
                @auth
                    {{-- Jika Pengguna Sudah Login --}}
                    <a href="{{ url('/dashboard') }}" class="text-xs font-bold bg-green-100 text-primary px-4 py-2 rounded-full hover:bg-green-200 transition shadow-sm flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path></svg>
                        Dashboard
                    </a>
                @else
                    {{-- Jika Pengguna Belum Login (Guest) --}}
                    <a href="{{ route('login') }}" class="text-xs font-semibold text-gray-600 hover:text-primary transition">Masuk</a>
                    
                    <!-- Dropdown Daftar (Diperbarui dengan ID untuk JavaScript) -->
                    <div class="relative relative-dropdown">
                        <button id="tombolDaftar" class="text-xs font-bold bg-primary text-white px-4 py-2 rounded-full hover:bg-green-600 transition shadow-sm flex items-center gap-1 focus:outline-none">
                            Daftar
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        
                        <!-- Isi Dropdown (Ditambahkan class 'hidden' secara default) -->
                        <div id="menuDaftar" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden z-50">
                            <a href="{{ route('register') }}" class="block px-4 py-3 text-xs font-medium text-gray-700 hover:bg-green-50 hover:text-primary border-b border-gray-50 transition">
                                Daftar Pembeli
                            </a>
                            <a href="{{ route('penjual.register') }}" class="block px-4 py-3 text-xs font-medium text-gray-700 hover:bg-green-50 hover:text-primary transition">
                                Buka Toko (Penjual)
                            </a>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
        
        <div class="relative">
            <input type="text" placeholder="Cari produk atau UMKM..." class="w-full bg-gray-100 text-sm rounded-full py-2.5 pl-10 pr-4 focus:outline-none focus:ring-2 focus:ring-primary/50">
            <svg class="w-4 h-4 text-gray-400 absolute left-4 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
    </header>
 
    <!-- 2. Hero Banner -->
    <section class="px-4 mt-4">
        <div class="bg-primary rounded-xl p-6 text-white relative overflow-hidden shadow-md">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full -mr-10 -mt-10"></div>
            <h2 class="text-2xl font-bold mb-2 relative z-10 leading-tight">Temukan Produk Lokal Terbaik Sedayu</h2>
            <p class="text-sm opacity-90 mb-4 relative z-10">Dukung perekonomian desa dengan membeli produk karya warga.</p>
            <button class="bg-white text-primary text-sm font-semibold py-2 px-4 rounded-full relative z-10 shadow">
                Jelajahi Sekarang
            </button>
        </div>
    </section>

    <!-- 3. Quick Categories -->
    <section class="px-4 mt-6">
        <div class="grid grid-cols-4 gap-2">
            @foreach($categories as $category)
            <div class="flex flex-col items-center gap-1.5">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-primary shadow-sm">
                    <!-- Ikon Default -->
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <span class="text-[11px] font-medium text-gray-600">{{ $category->name }}</span>
            </div>
            @endforeach
        </div>
    </section>

    <!-- 4. Featured MSME (Horizontal Scroll) -->
    <section class="mt-8">
        <div class="flex justify-between items-end px-4 mb-3">
            <h3 class="text-lg font-bold text-dark">UMKM Pilihan</h3>
            <a href="#" class="text-xs font-medium text-primary">Lihat Semua</a>
        </div>
        
        <div class="flex overflow-x-auto gap-4 px-4 pb-4 snap-x hide-scroll">
            @foreach($umkms as $umkm)
            <div class="min-w-[160px] bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden snap-start flex flex-col">
                
                <!-- Link menuju Halaman Detail UMKM -->
                <a href="{{ route('umkm.show', $umkm->id) }}" class="block">
                    <div class="h-[140px] bg-gray-200 relative">
                        <!-- Menggunakan foto UMKM jika ada, jika tidak gunakan placeholder -->
                        @if($umkm->image)
                            <img src="{{ asset('storage/' . $umkm->image) }}" alt="{{ $umkm->name }}" class="w-full h-full object-cover">
                        @else
                            <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=300&q=80" alt="{{ $umkm->name }}" class="w-full h-full object-cover">
                        @endif
                        
                        <span class="absolute top-2 right-2 bg-white/90 backdrop-blur text-primary text-[10px] font-bold px-2 py-1 rounded">
                            {{ $umkm->category->name }}
                        </span>
                    </div>
                    
                    <div class="p-2.5 flex flex-col">
                        <h4 class="text-sm font-semibold text-dark truncate">{{ $umkm->name }}</h4>
                        <div class="flex items-center text-[11px] text-gray-500 mt-1">
                            <span class="text-yellow-400">★</span>
                            <span class="ml-1 font-medium">4.8</span>
                            <span class="mx-1">•</span>
                            <span class="truncate">{{ $umkm->address }}</span>
                        </div>
                    </div>
                </a>

                <!-- Tombol WhatsApp dengan Logika Login -->
                <div class="p-2.5 pt-0 mt-auto">
                    @auth
                        @php
                            $namaPembeli = auth()->user()->name;
                            $pesan = "Halo " . $umkm->name . ", saya " . $namaPembeli . " melihat usaha Anda di website UMKM Sedayu dan tertarik untuk bertanya lebih lanjut.";
                            $actionUrl = "https://wa.me/" . $umkm->whatsapp_number . "?text=" . urlencode($pesan);
                            $target = "_blank";
                        @endphp
                    @else
                        @php
                            $actionUrl = route('login');
                            $target = "_self";
                        @endphp
                    @endauth

                    <a href="{{ $actionUrl }}" target="{{ $target }}" class="w-full bg-green-500 hover:bg-green-600 text-white text-xs font-medium py-1.5 rounded-md flex items-center justify-center gap-1 transition">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 0C5.394 0 0 5.394 0 12.031c0 2.146.561 4.238 1.624 6.079L.304 23.696l5.748-1.506c1.77.989 3.774 1.512 5.86 1.512 6.637 0 12.031-5.394 12.031-12.031C23.943 5.394 18.549 0 12.031 0zm0 21.656c-1.802 0-3.571-.484-5.116-1.4l-.367-.217-3.8.995 1.015-3.705-.239-.379c-1.004-1.597-1.533-3.447-1.533-5.378 0-5.513 4.486-9.999 9.999-9.999 5.514 0 9.999 4.486 9.999 9.999 0 5.513-4.485 9.999-9.999 9.999zm5.492-7.518c-.301-.151-1.782-.879-2.058-.98-.276-.101-.478-.151-.679.151-.201.302-.779.98-.955 1.181-.176.201-.352.226-.653.075-2.031-1.025-3.342-1.921-4.629-3.804-.176-.251-.019-.387.132-.538.135-.135.302-.352.453-.528.151-.176.201-.301.302-.502.101-.201.05-.377-.025-.528-.075-.151-.679-1.635-.93-2.239-.245-.589-.494-.509-.679-.519-.176-.01-.378-.01-.579-.01-.201 0-.528.075-.804.377-.276.302-1.055 1.031-1.055 2.515 0 1.484 1.08 2.917 1.231 3.118.151.201 2.127 3.249 5.154 4.557 2.05.885 2.76.755 3.287.63.606-.145 1.782-.729 2.033-1.433.251-.704.251-1.308.176-1.433-.075-.126-.276-.201-.577-.352z"/></svg>
                        Hubungi
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- 5. Bottom Navigation Bar -->
    <nav class="fixed bottom-0 w-full bg-white border-t border-gray-100 flex justify-around py-3 z-50 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
        <a href="#" class="flex flex-col items-center text-primary">
            <svg class="w-6 h-6 mb-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
            <span class="text-[10px] font-medium">Beranda</span>
        </a>
        <a href="#" class="flex flex-col items-center text-gray-400 hover:text-primary transition">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            <span class="text-[10px] font-medium">Kategori</span>
        </a>
        <a href="#" class="flex flex-col items-center text-gray-400 hover:text-primary transition">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="text-[10px] font-medium">Bantuan</span>
        </a>
    </nav>

    <!-- Script JavaScript Sederhana untuk Dropdown Daftar -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tombolDaftar = document.getElementById('tombolDaftar');
            const menuDaftar = document.getElementById('menuDaftar');

            if (tombolDaftar && menuDaftar) {
                // Tampilkan/Sembunyikan menu saat tombol diklik
                tombolDaftar.addEventListener('click', function(event) {
                    event.stopPropagation(); // Mencegah klik menyebar ke elemen lain
                    menuDaftar.classList.toggle('hidden');
                });

                // Sembunyikan menu saat pengguna mengklik di area luar dropdown
                document.addEventListener('click', function(event) {
                    if (!tombolDaftar.contains(event.target) && !menuDaftar.contains(event.target)) {
                        menuDaftar.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>
</html>