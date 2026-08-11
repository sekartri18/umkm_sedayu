<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="icon" href="{{ asset('logo.svg') }}" type="image/svg+xml">
    <title>Jelajahi UMKM Sedayu</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: { primary: '#10B981', dark: '#1F2937' },
                }
            }
        }
    </script>
    <style>body { background-color: #f3f4f6; }</style>
</head>
<body class="text-dark font-sans antialiased">
    @php
        $cartItemCount = collect(session('cart', []))->sum('quantity');
    @endphp

    <div class="max-w-7xl mx-auto bg-white min-h-screen relative shadow-sm pb-10">
        
        <!-- HEADER PENCARIAN -->
        <header class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-gray-100 px-5 pt-4 pb-3 md:py-4">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2">
                    <span class="w-8 h-8 md:w-10 md:h-10 rounded-lg bg-primary text-white flex items-center justify-center shadow-sm">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9-4 9 4M4 10h16v10a1 1 0 01-1 1H5a1 1 0 01-1-1V10z"></path></svg>
                    </span>
                    <h1 class="text-base md:text-xl font-extrabold text-primary leading-tight">UMKM Sedayu</h1>
                </a>

                <!-- Form Pencarian Langsung Aktif -->
                <form action="{{ route('umkm.list') }}" method="GET" class="relative flex-1 max-w-2xl w-full">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari UMKM atau kategori..." class="w-full bg-gray-50 border border-gray-200 text-sm rounded-xl py-3 pl-10 pr-12 focus:outline-none focus:ring-1 focus:ring-primary/50 focus:border-primary/50 transition">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <button type="submit" class="absolute right-2 top-2 bg-primary hover:bg-emerald-600 text-white p-1.5 rounded-lg transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </form>

                <div class="hidden md:flex items-center gap-4">
                    <a href="{{ route('cart.index') }}" class="relative flex items-center gap-2 text-gray-600 hover:text-primary transition font-medium">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Keranjang
                        @if($cartItemCount > 0)
                            <span class="absolute -top-1.5 -left-2 min-w-[18px] h-[18px] px-1 rounded-full bg-red-500 text-white text-[10px] font-bold flex items-center justify-center">{{ $cartItemCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 bg-gray-50 border border-gray-200 px-4 py-2 rounded-xl text-gray-700 hover:bg-gray-100 transition">
                        <span class="text-sm font-semibold">{{ auth()->check() ? auth()->user()->name : 'Masuk / Daftar' }}</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- KONTEN UTAMA: DAFTAR UMKM -->
        <div class="px-5 md:px-8 max-w-5xl mx-auto py-8">
            <div class="mb-8">
                <a href="{{ url('/') }}" class="text-sm text-gray-500 hover:text-primary mb-2 inline-block">&larr; Kembali ke Beranda</a>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900">
                    {{ request('search') ? 'Hasil Pencarian' : 'Semua UMKM Sedayu' }}
                </h2>
                @if(request('search'))
                    <p class="text-gray-500 mt-2">Menampilkan hasil untuk: <span class="font-bold text-primary">"{{ request('search') }}"</span></p>
                @endif
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @forelse($umkms as $umkm)
                    <a href="{{ route('umkm.show', $umkm->id) }}" class="bg-white rounded-2xl md:rounded-3xl shadow-sm border border-gray-100 overflow-hidden block hover:-translate-y-1 hover:shadow-md transition-all">
                        <div class="h-32 md:h-48 bg-gray-100 relative">
                                @if($umkm->image)
                                    <img src="{{ asset($umkm->image) }}" class="w-full h-full object-cover">
                            @else
                                <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover opacity-50">
                            @endif
                        </div>
                        <div class="p-4 md:p-5">
                            <h4 class="font-bold text-sm md:text-lg text-gray-900 line-clamp-1 mb-1">{{ $umkm->name }}</h4>
                            <span class="inline-block bg-emerald-50 text-primary text-[10px] md:text-xs font-bold px-2 py-1 rounded uppercase tracking-wider mb-2">
                                {{ $umkm->category->name ?? 'Lainnya' }}
                            </span>
                            <div class="flex items-center gap-1 text-[10px] md:text-sm font-medium text-gray-500">
                                <svg class="w-4 h-4 text-yellow-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                <span class="text-gray-700 font-semibold">4.8</span>
                                <span class="mx-1">•</span>
                                <span class="truncate">{{ Str::limit(str_replace(['Jalan ', 'Desa '], '', $umkm->address), 15) }}</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full py-16 text-center">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-1">UMKM Tidak Ditemukan</h3>
                        <p class="text-gray-500 text-sm">Coba gunakan kata kunci pencarian yang berbeda.</p>
                        <a href="{{ route('umkm.list') }}" class="inline-block mt-4 text-primary font-semibold hover:underline">Lihat Semua UMKM</a>
                    </div>
                @endforelse
            </div>

            <!-- Menampilkan Pagination (Halaman 1, 2, 3...) -->
            <div class="mt-10">
                {{ $umkms->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</body>
</html>
