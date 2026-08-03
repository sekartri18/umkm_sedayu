<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>UMKM Sedayu - Direktori Produk Lokal</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: { primary: '#10B981', dark: '#1F2937' },
                    boxShadow: {
                        soft: '0 10px 30px -12px rgba(16, 185, 129, 0.35)',
                        up: '0 -4px 20px -10px rgba(0,0,0,0.1)'
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #f3f4f6; }
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Animasi Transisi Slider */
        .slide { transition: opacity 0.8s ease-in-out; }
        .slide-active { opacity: 1; z-index: 10; }
        .slide-hidden { opacity: 0; z-index: 0; pointer-events: none; }
    </style>
</head>
<body class="text-dark font-sans antialiased">
    @php
        $cartItemCount = collect(session('cart', []))->sum('quantity');
        
        // Memetakan Ikon untuk kategori
        $iconMap = [
            'makanan' => '🍔',
            'pakaian' => '👗',
            'kerajinan' => '🧺',
            'pertanian' => '🌾',
            'jasa' => '🛠️',
            'lainnya' => '📦'
        ];
    @endphp

    <!-- Container Utama (Responsif: Lebar di PC, menyesuaikan di HP) -->
    <div class="max-w-7xl mx-auto bg-white min-h-screen relative shadow-sm pb-24 md:pb-10">
        
        <!-- HEADER & NAVIGASI ATAS -->
        <header class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-gray-100 px-5 pt-4 pb-3 md:py-4">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                
                <div class="flex items-center justify-between">
                    <!-- Logo & Judul -->
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-2">
                        <span class="w-8 h-8 md:w-10 md:h-10 rounded-lg bg-primary text-white flex items-center justify-center shadow-soft">
                            <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9-4 9 4M4 10h16v10a1 1 0 01-1 1H5a1 1 0 01-1-1V10z"></path></svg>
                        </span>
                        <div>
                            <h1 class="text-base md:text-xl font-extrabold text-primary leading-tight">UMKM Sedayu</h1>
                        </div>
                    </a>

                    <!-- Ikon Keranjang & Profil (Versi Mobile, pindah ke kanan di PC) -->
                    <div class="flex items-center gap-3 md:hidden">
                        <a href="{{ route('cart.index') }}" class="relative text-gray-600 hover:text-primary transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            @if($cartItemCount > 0)
                                <span class="absolute -top-1 -right-1.5 min-w-[16px] h-[16px] px-1 rounded-full bg-red-500 text-white text-[9px] font-bold flex items-center justify-center border-2 border-white">{{ $cartItemCount > 9 ? '9+' : $cartItemCount }}</span>
                            @endif
                        </a>

                        <div class="relative">
                            <button id="tombolDaftarMobile" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-gray-200 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </button>
                            <div id="menuDaftarMobile" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden z-50">
                                @auth
                                    <div class="px-4 py-3 border-b border-gray-50 bg-gray-50/50">
                                        <p class="text-[10px] text-gray-500 font-medium">Masuk sebagai</p>
                                        <p class="text-xs font-bold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                    </div>
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 transition">Profil</a>
                                    <a href="{{ route('buyer.orders') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 transition">Pesanan Saya</a>
                                    <a href="{{ route('buyer.favorites') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 transition">Barang Favorit</a>
                                    @if(auth()->user()->umkm)
                                        <a href="{{ route('dashboard') }}" class="block px-4 py-2.5 text-xs font-semibold text-primary hover:bg-emerald-50 transition">Dashboard Toko</a>
                                    @endif
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left block px-4 py-2.5 text-xs font-semibold text-red-600 hover:bg-red-50 transition">Logout</button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-primary transition border-b border-gray-50">Masuk Akun</a>
                                    <a href="{{ route('register') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-primary transition border-b border-gray-50">Daftar Pembeli</a>
                                    <a href="{{ route('penjual.register') }}" class="block px-4 py-2.5 text-xs font-semibold text-primary bg-emerald-50/50 hover:bg-emerald-50 transition">Buka Toko (Penjual)</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Pencarian (Arahkan ke Rute UMKM List) -->
                <form action="{{ route('umkm.list') }}" method="GET" class="relative flex-1 max-w-2xl w-full">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk, kategori, atau nama UMKM..." class="w-full bg-gray-50 border border-gray-200 text-[13px] md:text-sm rounded-xl py-2.5 md:py-3 pl-10 pr-12 focus:outline-none focus:ring-1 focus:ring-primary/50 focus:border-primary/50 transition">
                    <svg class="w-4 h-4 md:w-5 md:h-5 text-gray-400 absolute left-3.5 top-3 md:top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <button type="submit" class="absolute right-2 top-1.5 md:top-2 bg-primary hover:bg-emerald-600 text-white p-1.5 rounded-lg transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </form>

                <!-- Ikon Keranjang & Profil (Versi Desktop) -->
                <div class="hidden md:flex items-center gap-4">
                    <a href="{{ route('cart.index') }}" class="relative flex items-center gap-2 text-gray-600 hover:text-primary transition font-medium">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Keranjang
                        @if($cartItemCount > 0)
                            <span class="absolute -top-1.5 -left-2 min-w-[18px] h-[18px] px-1 rounded-full bg-red-500 text-white text-[10px] font-bold flex items-center justify-center border-2 border-white">{{ $cartItemCount > 9 ? '9+' : $cartItemCount }}</span>
                        @endif
                    </a>

                    <div class="relative">
                        <button id="tombolDaftarDesktop" class="flex items-center gap-2 bg-gray-50 border border-gray-200 px-4 py-2 rounded-xl text-gray-700 hover:bg-gray-100 transition focus:outline-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span class="text-sm font-semibold">{{ auth()->check() ? auth()->user()->name : 'Masuk / Daftar' }}</span>
                        </button>
                        <div id="menuDaftarDesktop" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden z-50">
                            @auth
                                <div class="px-4 py-3 border-b border-gray-50 bg-gray-50/50">
                                    <p class="text-[10px] text-gray-500 font-medium">Masuk sebagai</p>
                                    <p class="text-xs font-bold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                </div>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 transition">Profil</a>
                                <a href="{{ route('buyer.orders') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 transition">Pesanan Saya</a>
                                <a href="{{ route('buyer.favorites') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 transition">Barang Favorit</a>
                                @if(auth()->user()->umkm)
                                    <a href="{{ route('dashboard') }}" class="block px-4 py-2.5 text-xs font-semibold text-primary hover:bg-emerald-50 transition">Dashboard Toko</a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left block px-4 py-2.5 text-xs font-semibold text-red-600 hover:bg-red-50 transition">Logout</button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-primary transition border-b border-gray-50">Masuk Akun</a>
                                <a href="{{ route('register') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-primary transition border-b border-gray-50">Daftar Pembeli</a>
                                <a href="{{ route('penjual.register') }}" class="block px-4 py-2.5 text-xs font-semibold text-primary bg-emerald-50/50 hover:bg-emerald-50 transition">Buka Toko (Penjual)</a>
                            @endauth
                        </div>
                    </div>
                </div>

            </div>
        </header>

        <div class="px-5 md:px-8 max-w-5xl mx-auto">
            <!-- 1. HERO BANNER (SLIDER OTOMATIS & MANUAL DARI DATABASE) -->
            <div class="relative w-full h-44 md:h-80 lg:h-96 rounded-2xl overflow-hidden shadow-sm mt-4 md:mt-8 mb-8 group" id="slider-container">
                
                @if($banners->isEmpty())
                    <!-- Fallback Banner Jika Admin Belum Mengunggah Apa-apa -->
                    <div class="slide slide-active absolute inset-0 w-full h-full">
                        <img src="https://images.unsplash.com/photo-1604719312566-8912e9227c6a?auto=format&fit=crop&w=1200&q=80" alt="Banner Default" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-r from-gray-900/80 to-transparent"></div>
                        <div class="absolute inset-0 p-6 md:p-12 flex flex-col justify-center items-start">
                            <h2 class="text-white text-lg md:text-4xl font-extrabold mb-3 leading-tight max-w-[200px] md:max-w-md">Belanja Langsung dari Pelaku UMKM Desa</h2>
                        </div>
                    </div>
                @else
                    <!-- Looping Data Banner Dinamis dari Database -->
                    @foreach($banners as $index => $banner)
                        <div class="slide {{ $index === 0 ? 'slide-active' : 'slide-hidden' }} absolute inset-0 w-full h-full">
                            <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover">
                            <!-- Overlay Gelap Tipis agar Teks (Jika ada) lebih terbaca -->
                            <div class="absolute inset-0 bg-black/20"></div>
                        </div>
                    @endforeach
                @endif

                <!-- Tombol Navigasi Manual -->
                <button id="prevBtn" class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/30 hover:bg-white/50 text-white w-8 h-8 md:w-10 md:h-10 rounded-full flex items-center justify-center backdrop-blur-sm opacity-0 group-hover:opacity-100 transition z-20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button id="nextBtn" class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/30 hover:bg-white/50 text-white w-8 h-8 md:w-10 md:h-10 rounded-full flex items-center justify-center backdrop-blur-sm opacity-0 group-hover:opacity-100 transition z-20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>

                <!-- Indikator Slide -->
                <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2 z-20">
                    @forelse($banners as $index => $banner)
                        <div class="dot w-2 h-2 rounded-full {{ $index === 0 ? 'bg-white' : 'bg-white/40' }} transition cursor-pointer"></div>
                    @empty
                        <div class="dot w-2 h-2 rounded-full bg-white transition cursor-pointer"></div>
                    @endforelse
                </div>
            </div>

            <!-- 2. KATEGORI MENU DENGAN IKON & PERTANIAN -->
            <div id="kategori" class="mb-10 md:mb-14">
                <div class="flex items-center justify-between mb-4 md:mb-6">
                    <h3 class="font-bold text-gray-900 text-base md:text-xl">Kategori Populer</h3>
                </div>
                <!-- Grid fleksibel: scroll horizontal di HP, grid rapi di Laptop -->
                <div class="flex md:grid md:grid-cols-6 gap-4 overflow-x-auto hide-scroll pb-2 snap-x">
                    
                    @foreach($categories as $category)
                        @php
                            $catKey = strtolower($category->name);
                            // Cek apakah ada ikon di mapping, jika tidak gunakan logo box
                            $icon = $iconMap[$catKey] ?? '📦';
                        @endphp
                        <a href="{{ route('umkm.list', ['search' => $category->name]) }}" class="flex flex-col items-center gap-2 md:gap-3 shrink-0 snap-start group w-20 md:w-full">
                            <div class="w-16 h-16 md:w-24 md:h-24 rounded-full bg-emerald-50 flex items-center justify-center text-3xl md:text-4xl border border-emerald-100 shadow-sm group-hover:bg-primary group-hover:shadow-md transition duration-300">
                                <span class="group-hover:scale-110 transition-transform">{{ $icon }}</span>
                            </div>
                            <span class="text-[11px] md:text-sm font-semibold text-gray-700 group-hover:text-primary text-center leading-tight">{{ $category->name }}</span>
                        </a>
                    @endforeach

                    <!-- Penambahan Statis Kategori "Pertanian" Jika belum ada di Database -->
                    @if(!$categories->contains('name', 'Pertanian') && !$categories->contains('name', 'pertanian'))
                        <a href="{{ route('umkm.list', ['search' => 'Pertanian']) }}" class="flex flex-col items-center gap-2 md:gap-3 shrink-0 snap-start group w-20 md:w-full">
                            <div class="w-16 h-16 md:w-24 md:h-24 rounded-full bg-emerald-50 flex items-center justify-center text-3xl md:text-4xl border border-emerald-100 shadow-sm group-hover:bg-primary group-hover:shadow-md transition duration-300">
                                <span class="group-hover:scale-110 transition-transform">🌾</span>
                            </div>
                            <span class="text-[11px] md:text-sm font-semibold text-gray-700 group-hover:text-primary text-center leading-tight">Pertanian</span>
                        </a>
                    @endif
                </div>
            </div>

            <!-- 3. UMKM PILIHAN (Dibuat Grid Menurun) -->
            <div id="umkm-list" class="mb-10 md:mb-14">
                <div class="flex justify-between items-end mb-4 md:mb-6">
                    <h3 class="font-bold text-gray-900 text-base md:text-xl">UMKM Pilihan</h3>
                    <!-- Tombol Lihat Semua yang mengarah ke halaman pencarian UMKM -->
                    <a href="{{ route('umkm.list') }}" class="text-[11px] md:text-sm font-bold text-primary hover:text-emerald-700 hover:underline">Lihat Semua ></a>
                </div>
                
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 pb-4">
                    @forelse($umkms as $umkm)
                        <a href="{{ route('umkm.show', $umkm->id) }}" class="bg-white rounded-2xl md:rounded-3xl shadow-sm border border-gray-100 overflow-hidden block hover:-translate-y-1 hover:shadow-md transition-all">
                            <div class="h-32 md:h-40 bg-gray-100 relative">
                                @if($umkm->image)
                                    <img src="{{ asset('storage/' . $umkm->image) }}" class="w-full h-full object-cover">
                                @else
                                    <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover opacity-50">
                                @endif
                            </div>
                            <div class="p-3 md:p-4">
                                <h4 class="font-bold text-[13px] md:text-base text-gray-900 line-clamp-1 mb-1 md:mb-2">{{ $umkm->name }}</h4>
                                <span class="inline-block bg-emerald-50 text-primary text-[9px] md:text-[10px] font-bold px-2 py-0.5 md:py-1 rounded uppercase tracking-wider mb-2">
                                    {{ $umkm->category->name ?? 'Lainnya' }}
                                </span>
                                <div class="flex items-center gap-1 text-[10px] md:text-xs font-medium text-gray-500 truncate">
                                    <svg class="w-3 h-3 md:w-4 md:h-4 text-yellow-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    @php
                                        $avgRating = \App\Models\Review::whereIn('product_id', $umkm->products->pluck('id'))->avg('rating');
                                    @endphp
                                    <span class="text-gray-700 font-semibold">{{ $avgRating > 0 ? number_format($avgRating, 1) : '0.0' }}</span>
                                    <span class="mx-0.5 md:mx-1">•</span>
                                    <span class="truncate">{{ Str::limit(str_replace(['Jalan ', 'Desa '], '', $umkm->address), 15) }}</span>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full py-10 text-center text-gray-500">
                            Pencarian tidak menemukan UMKM yang sesuai.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div> <!-- End Container -->

    <!-- 6. BOTTOM NAVIGATION (Hanya Muncul di Mobile/HP) -->
    <nav class="md:hidden fixed bottom-0 w-full bg-white border-t border-gray-100 flex justify-around items-center h-16 shadow-up z-50">
        <a href="/" class="flex flex-col items-center justify-center w-full h-full text-primary relative">
            <div class="absolute top-0 w-8 h-1 bg-primary rounded-b-full"></div>
            <svg class="w-5 h-5 mb-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
            <span class="text-[9px] font-bold">Beranda</span>
        </a>
        <a href="{{ route('cart.index') }}" class="flex flex-col items-center justify-center w-full h-full text-gray-400 hover:text-gray-600 transition relative">
            <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            <span class="text-[9px] font-medium">Keranjang</span>
            @if($cartItemCount > 0)
                <span class="absolute top-1 right-2 min-w-[14px] h-[14px] px-1 rounded-full bg-red-500 text-white text-[8px] font-bold flex items-center justify-center border-2 border-white">{{ $cartItemCount > 9 ? '9+' : $cartItemCount }}</span>
            @endif
        </a>
        <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center w-full h-full text-gray-400 hover:text-gray-600 transition">
            <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A10.97 10.97 0 0112 15c2.485 0 4.773.78 6.879 2.104M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <span class="text-[9px] font-medium">Profil</span>
        </a>
    </nav>

    <!-- Script Utama (Slider & Dropdown) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // 1. Logika Dropdown Akun (Mobile & Desktop)
            const setupDropdown = (btnId, menuId) => {
                const btn = document.getElementById(btnId);
                const menu = document.getElementById(menuId);
                if (btn && menu) {
                    btn.addEventListener('click', (e) => { e.stopPropagation(); menu.classList.toggle('hidden'); });
                    document.addEventListener('click', (e) => {
                        if (!btn.contains(e.target) && !menu.contains(e.target)) menu.classList.add('hidden');
                    });
                }
            };
            setupDropdown('tombolDaftarMobile', 'menuDaftarMobile');
            setupDropdown('tombolDaftarDesktop', 'menuDaftarDesktop');

            // 2. Logika Slider Hero Banner
            const slides = document.querySelectorAll('.slide');
            const dots = document.querySelectorAll('.dot');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            let currentSlide = 0;
            let slideInterval;

            const updateSlider = () => {
                slides.forEach((slide, index) => {
                    if(index === currentSlide) {
                        slide.classList.remove('slide-hidden');
                        slide.classList.add('slide-active');
                        if(dots[index]) dots[index].classList.replace('bg-white/40', 'bg-white');
                    } else {
                        slide.classList.add('slide-hidden');
                        slide.classList.remove('slide-active');
                        if(dots[index]) dots[index].classList.replace('bg-white', 'bg-white/40');
                    }
                });
            };

            const nextSlide = () => { 
                if(slides.length > 0) {
                    currentSlide = (currentSlide + 1) % slides.length; 
                    updateSlider(); 
                }
            };
            
            const prevSlide = () => { 
                if(slides.length > 0) {
                    currentSlide = (currentSlide - 1 + slides.length) % slides.length; 
                    updateSlider(); 
                }
            };

            // Tombol Navigasi Manual
            if(nextBtn) nextBtn.addEventListener('click', () => { nextSlide(); resetInterval(); });
            if(prevBtn) prevBtn.addEventListener('click', () => { prevSlide(); resetInterval(); });

            // Klik dot indikator
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => { currentSlide = index; updateSlider(); resetInterval(); });
            });

            // Auto Play Slider (Setiap 5 detik)
            const startInterval = () => { slideInterval = setInterval(nextSlide, 5000); };
            const resetInterval = () => { clearInterval(slideInterval); startInterval(); };
            
            if(slides.length > 1) {
                startInterval();
            }
        });
    </script>
</body>
</html>