<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                        soft: '0 10px 30px -12px rgba(16, 185, 129, 0.35)'
                    }
                }
            }
        }
    </script>
    <style>
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
        .hero-glow {
            background: radial-gradient(circle at 15% 20%, rgba(16,185,129,0.25), transparent 45%),
                        radial-gradient(circle at 90% 10%, rgba(52,211,153,0.22), transparent 40%),
                        linear-gradient(145deg, #047857 0%, #10B981 45%, #34D399 100%);
        }
        .stagger {
            opacity: 0;
            transform: translateY(10px);
            animation: rise .55s ease-out forwards;
        }
        .stagger:nth-child(2) { animation-delay: .08s; }
        .stagger:nth-child(3) { animation-delay: .16s; }
        .stagger:nth-child(4) { animation-delay: .24s; }
        @keyframes rise {
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-slate-50 text-dark font-sans pb-24 antialiased">
    @php
        $cartItemCount = collect(session('cart', []))->sum('quantity');
    @endphp

    <div class="fixed inset-0 pointer-events-none -z-10">
        <div class="absolute -top-20 -left-24 w-72 h-72 bg-emerald-200/45 blur-3xl rounded-full"></div>
        <div class="absolute top-20 -right-16 w-72 h-72 bg-teal-200/35 blur-3xl rounded-full"></div>
    </div>

    <header class="sticky top-0 z-50 backdrop-blur bg-white/90 border-b border-emerald-50">
        <div class="max-w-6xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between gap-3 mb-4">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2">
                    <span class="w-9 h-9 rounded-xl bg-primary text-white flex items-center justify-center shadow-soft">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9-4 9 4M4 10h16v10a1 1 0 01-1 1H5a1 1 0 01-1-1V10z"></path></svg>
                    </span>
                    <div>
                        <h1 class="text-base sm:text-lg font-extrabold text-primary leading-tight">UMKM Sedayu</h1>
                        <p class="text-[11px] text-gray-500 leading-none">Belanja produk lokal warga</p>
                    </div>
                </a>

                <div class="flex items-center gap-2 sm:gap-3">
                    <a href="{{ route('cart.index') }}" class="relative text-xs font-bold bg-white border border-emerald-100 text-primary px-3 py-2 rounded-full hover:bg-emerald-50 transition">
                        Keranjang
                        @if($cartItemCount > 0)
                            <span class="absolute -top-1.5 -right-1.5 min-w-[18px] h-[18px] px-1 rounded-full bg-primary text-white text-[10px] flex items-center justify-center">{{ $cartItemCount > 9 ? '9+' : $cartItemCount }}</span>
                        @endif
                    </a>

                    @auth
                        <span class="hidden sm:inline-flex text-xs font-semibold text-gray-600 bg-gray-100 px-3 py-2 rounded-full">
                            Halo, {{ auth()->user()->name }}
                        </span>
                        @if(auth()->user()->umkm)
                            <a href="{{ route('dashboard') }}" class="text-xs font-bold bg-emerald-100 text-primary px-3 py-2 rounded-full hover:bg-emerald-200 transition">Dashboard Toko</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-xs font-bold bg-gray-800 text-white px-3 py-2 rounded-full hover:bg-gray-700 transition">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-xs font-semibold text-gray-700 hover:text-primary transition">Masuk</a>
                        <div class="relative">
                            <button id="tombolDaftar" class="text-xs font-bold bg-primary text-white px-4 py-2 rounded-full hover:bg-emerald-600 transition shadow-sm flex items-center gap-1">
                                Daftar
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div id="menuDaftar" class="hidden absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden z-50">
                                <a href="{{ route('register') }}" class="block px-4 py-3 text-xs font-medium text-gray-700 hover:bg-emerald-50 hover:text-primary border-b border-gray-50 transition">Daftar Pembeli</a>
                                <a href="{{ route('penjual.register') }}" class="block px-4 py-3 text-xs font-medium text-gray-700 hover:bg-emerald-50 hover:text-primary transition">Buka Toko (Penjual)</a>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>

            <div class="relative">
                <input type="text" placeholder="Cari produk, kategori, atau nama UMKM..." class="w-full bg-emerald-50/70 border border-emerald-100 text-sm rounded-2xl py-3 pl-11 pr-4 focus:outline-none focus:ring-2 focus:ring-primary/40">
                <svg class="w-4 h-4 text-emerald-500 absolute left-4 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4">
        <section class="mt-5 hero-glow rounded-3xl p-6 sm:p-8 text-white shadow-soft overflow-hidden relative">
            <div class="absolute top-0 right-0 w-48 h-48 bg-white/10 rounded-full -translate-y-14 translate-x-16"></div>
            <div class="absolute bottom-0 left-0 w-52 h-52 bg-black/10 rounded-full translate-y-20 -translate-x-16"></div>
            <div class="relative z-10 max-w-2xl">
                <p class="text-xs font-semibold tracking-[0.2em] uppercase text-emerald-50 mb-3">Pasar Digital Sedayu</p>
                <h2 class="text-2xl sm:text-4xl font-extrabold leading-tight mb-3">Belanja Lebih Dekat, Langsung dari Pelaku UMKM Desa</h2>
                <p class="text-sm sm:text-base text-emerald-50/95 mb-6">Temukan produk pilihan warga Sedayu, hubungi penjual dengan cepat, dan bantu ekonomi lokal tumbuh setiap hari.</p>
                <div class="flex flex-wrap gap-3">
                    <a href="#umkm-list" class="bg-white text-primary font-bold px-5 py-2.5 rounded-full text-sm hover:bg-emerald-50 transition">Jelajahi Toko</a>
                    <a href="#kategori" class="bg-black/20 text-white font-bold px-5 py-2.5 rounded-full text-sm hover:bg-black/30 transition">Lihat Kategori</a>
                </div>
            </div>
        </section>

        <section id="kategori" class="mt-8">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-lg font-bold text-gray-900">Kategori Populer</h3>
                <span class="text-xs text-gray-500">{{ $categories->count() }} kategori</span>
            </div>
            <div class="flex gap-2 overflow-x-auto hide-scroll pb-2">
                @foreach($categories as $category)
                    <a href="#" class="stagger shrink-0 inline-flex items-center gap-2 bg-white border border-emerald-100 text-gray-700 rounded-full px-4 py-2 text-xs font-semibold hover:border-emerald-300 hover:text-primary transition">
                        <span class="w-6 h-6 rounded-full bg-emerald-100 text-primary flex items-center justify-center">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </span>
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </section>

        <section id="umkm-list" class="mt-8 pb-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-extrabold text-gray-900">UMKM Pilihan Hari Ini</h3>
                <span class="text-xs bg-emerald-100 text-primary font-bold px-3 py-1.5 rounded-full">{{ $umkms->count() }} toko aktif</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($umkms as $umkm)
                    <article class="stagger bg-white rounded-2xl border border-emerald-50 overflow-hidden shadow-sm hover:shadow-soft transition duration-300 flex flex-col">
                        <a href="{{ route('umkm.show', $umkm->id) }}" class="block">
                            <div class="h-44 bg-gray-200 relative overflow-hidden">
                                @if($umkm->image)
                                    <img src="{{ asset('storage/' . $umkm->image) }}" alt="{{ $umkm->name }}" class="w-full h-full object-cover">
                                @else
                                    <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=400&q=80" alt="{{ $umkm->name }}" class="w-full h-full object-cover">
                                @endif
                                <div class="absolute inset-x-0 bottom-0 p-3 bg-gradient-to-t from-black/45 to-transparent">
                                    <span class="inline-flex bg-white/95 text-primary text-[11px] font-bold px-2.5 py-1 rounded-full">{{ $umkm->category->name }}</span>
                                </div>
                            </div>
                        </a>

                        <div class="p-4 flex-1 flex flex-col">
                            <a href="{{ route('umkm.show', $umkm->id) }}" class="font-bold text-gray-900 text-base line-clamp-1 hover:text-primary transition">{{ $umkm->name }}</a>
                            <p class="text-xs text-gray-500 mt-2 line-clamp-2">{{ $umkm->address }}</p>

                            <div class="mt-3 flex items-center justify-between text-[11px] text-gray-500">
                                <span class="inline-flex items-center gap-1"><span class="text-yellow-400">★</span>4.8</span>
                                <span class="inline-flex items-center gap-1 text-emerald-600 font-semibold">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path></svg>
                                    UMKM Terverifikasi
                                </span>
                            </div>

                            <div class="mt-4 grid grid-cols-2 gap-2">
                                <a href="{{ route('umkm.show', $umkm->id) }}" class="text-center text-xs font-bold bg-emerald-50 text-primary py-2 rounded-lg hover:bg-emerald-100 transition">Lihat Toko</a>

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

                                <a href="{{ $actionUrl }}" target="{{ $target }}" class="text-center text-xs font-bold bg-primary text-white py-2 rounded-lg hover:bg-emerald-600 transition">Hubungi</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    </main>

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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tombolDaftar = document.getElementById('tombolDaftar');
            const menuDaftar = document.getElementById('menuDaftar');

            if (tombolDaftar && menuDaftar) {
                tombolDaftar.addEventListener('click', function(event) {
                    event.stopPropagation();
                    menuDaftar.classList.toggle('hidden');
                });

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