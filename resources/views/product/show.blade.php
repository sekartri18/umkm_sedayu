<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="icon" href="{{ asset('logo.svg') }}" type="image/svg+xml">
    <title>{{ $product->name }} - UMKM Sedayu</title>
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
<body class="text-dark font-sans antialiased pb-24 md:pb-10">
    @php
        $cartItemCount = collect(session('cart', []))->sum('quantity');
        $isFavorited = auth()->check() && auth()->user()->favoriteProducts()->whereKey($product->id)->exists();
    @endphp

    <!-- HEADER -->
    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-gray-100 px-5 py-3 md:py-4 shadow-sm">
        <div class="max-w-5xl mx-auto flex items-center justify-between">
            <a href="javascript:history.back()" class="flex items-center gap-2 text-gray-600 hover:text-primary transition font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span class="hidden md:inline">Kembali</span>
            </a>
            
            <a href="{{ route('cart.index') }}" class="relative flex items-center gap-2 text-gray-600 hover:text-primary transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                @if($cartItemCount > 0)
                    <span class="absolute -top-1 -right-1.5 min-w-[16px] h-[16px] px-1 rounded-full bg-red-500 text-white text-[9px] font-bold flex items-center justify-center border-2 border-white">{{ $cartItemCount }}</span>
                @endif
            </a>
        </div>
    </header>

    <div class="max-w-5xl mx-auto px-5 md:px-8 mt-6 md:mt-10">
        
        <!-- BAGIAN PRODUK UTAMA -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex flex-row items-stretch mb-10">
            
            <!-- Foto Produk -->
            <div class="w-[45%] sm:w-[46%] md:w-1/2 bg-gray-100 aspect-[4/5] sm:aspect-square md:aspect-auto md:min-h-[500px] relative group shrink-0">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @else
                    <div class="absolute inset-0 flex items-center justify-center text-gray-300">
                        <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                @endif
            </div>

            <!-- Detail Produk -->
            <div class="w-[55%] sm:w-[54%] md:w-1/2 p-3 sm:p-5 md:p-10 flex flex-col">
                <div class="flex-1">
                    <a href="{{ route('umkm.show', $product->umkm->id) }}" class="inline-flex items-center gap-2 mb-4 text-sm font-semibold text-emerald-600 hover:text-emerald-700 bg-emerald-50 px-3 py-1.5 rounded-lg transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        {{ $product->umkm->name }}
                    </a>
                    
                    <h1 class="text-lg sm:text-2xl md:text-4xl font-extrabold text-gray-900 mb-2 leading-tight">{{ $product->name }}</h1>
                    
                    <div class="flex flex-wrap items-center gap-2 sm:gap-4 mb-4 sm:mb-6">
                        <span class="text-xl sm:text-3xl font-black text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        @if($product->stock > 0)
                            <span class="bg-blue-50 text-blue-600 text-xs font-bold px-2 py-1 rounded-md">Stok: {{ $product->stock }}</span>
                        @else
                            <span class="bg-red-50 text-red-600 text-xs font-bold px-2 py-1 rounded-md">Stok Habis</span>
                        @endif
                    </div>

                    <div class="border-t border-gray-100 pt-6 mb-6">
                        <h3 class="font-bold text-gray-900 mb-3 text-lg">Deskripsi Produk</h3>
                        <p class="text-gray-600 text-sm md:text-base leading-relaxed whitespace-pre-line">{{ $product->description ?? 'Tidak ada deskripsi untuk produk ini.' }}</p>
                    </div>
                </div>

                <!-- Aksi Beli -->
                <div class="mt-6 sm:mt-8 pt-4 sm:pt-6 border-t border-gray-100">
                    <div class="flex items-center gap-2 sm:gap-3">
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full bg-white border border-primary text-primary hover:bg-emerald-50 font-semibold py-2.5 sm:py-3.5 px-3 sm:px-6 rounded-xl transition flex items-center justify-center gap-1.5 sm:gap-2 text-sm sm:text-base">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    <span class="whitespace-nowrap">Masukkan Keranjang</span>
                                </button>
                            </form>
                        @else
                            <button disabled class="w-full bg-gray-200 text-gray-500 font-semibold py-2.5 sm:py-3.5 px-3 sm:px-6 rounded-xl cursor-not-allowed flex items-center justify-center gap-1.5 sm:gap-2 text-sm sm:text-base">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                <span class="whitespace-nowrap">Stok Habis</span>
                            </button>
                        @endif

                        @auth
                            <form action="{{ route('buyer.favorites.toggle', $product->id) }}" method="POST" class="shrink-0">
                                @csrf
                                <button type="submit" aria-label="{{ $isFavorited ? 'Hapus dari favorit' : 'Tambah ke favorit' }}" title="{{ $isFavorited ? 'Hapus dari favorit' : 'Tambah ke favorit' }}" class="h-full rounded-xl border px-2.5 sm:px-3 py-2.5 sm:py-3.5 transition {{ $isFavorited ? 'border-red-200 bg-red-50 text-red-600 hover:bg-red-100' : 'border-gray-200 bg-white text-gray-700 hover:bg-gray-50' }}">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="{{ $isFavorited ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.53L12 21.35z"></path>
                                    </svg>
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- BAGIAN ULASAN PRODUK -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-10 mb-10">
            <h3 class="font-bold text-xl text-gray-900 mb-6 flex items-center gap-2">
                <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                Ulasan Pembeli ({{ $product->reviews->count() ?? 0 }})
            </h3>

            <!-- Daftar Komentar -->
            <div class="space-y-5">
                @forelse($product->reviews()->latest()->get() ?? [] as $review)
                    <div class="border-b border-gray-100 pb-5 last:border-0 last:pb-0">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold">
                                {{ substr($review->user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 text-sm">{{ $review->user->name }}</p>
                                <div class="flex items-center gap-1 text-xs text-gray-500 mt-0.5">
                                    <span class="text-yellow-400 font-bold">
                                        {{ str_repeat('⭐', $review->rating) }}
                                    </span>
                                    <span class="mx-1">•</span>
                                    <span>{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm ml-13 pl-13">{{ $review->comment }}</p>
                        @if($review->review_photo)
                            <div class="mt-3 ml-13 pl-13">
                                <img src="{{ asset('storage/' . $review->review_photo) }}" alt="Foto Ulasan dari {{ $review->user->name }}" class="w-full max-w-[180px] sm:max-w-[220px] h-32 sm:h-40 rounded-2xl shadow-sm border border-gray-200 object-cover">
                            </div>
                        @endif
                        @if($review->review_video)
                            <div class="mt-3 ml-13 pl-13">
                                <video controls class="w-full max-w-[280px] sm:max-w-[320px] rounded-2xl shadow-sm border border-gray-200 bg-black">
                                    <source src="{{ asset('storage/' . $review->review_video) }}" type="video/mp4">
                                    Browser Anda tidak mendukung pemutaran video.
                                </video>
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-4 text-sm">Belum ada ulasan untuk produk ini.</p>
                @endforelse
            </div>
        </div>

        <!-- PRODUK LAIN DARI TOKO INI -->
        @if($otherProducts->isNotEmpty())
            <div class="mb-10">
                <h3 class="font-bold text-xl text-gray-900 mb-6">Produk Lain dari {{ $product->umkm->name }}</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                    @foreach($otherProducts as $other)
                        <a href="{{ route('product.show', $other->id) }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden block hover:-translate-y-1 hover:shadow-md transition-all">
                            <div class="h-32 md:h-40 bg-gray-100 relative">
                                @if($other->image)
                                    <img src="{{ asset('storage/' . $other->image) }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="p-3 md:p-4">
                                <h4 class="font-bold text-sm text-gray-900 line-clamp-2 mb-1">{{ $other->name }}</h4>
                                <p class="text-primary font-extrabold text-sm mb-2">Rp {{ number_format($other->price, 0, ',', '.') }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</body>
</html>
