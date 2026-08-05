<x-buyer-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-emerald-50 border border-emerald-100 rounded-3xl p-6 sm:p-8 mb-8 shadow-sm">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <h1 class="text-3xl font-bold text-emerald-900 mb-2">Dashboard Pembeli</h1>
                        <p class="text-gray-700">Kamu sedang berada di halaman buyer. Lihat ringkasan pesanan, favorit, dan jelajahi UMKM lokal.</p>
                        <p class="mt-3 text-sm text-gray-600">Hai, {{ $user->name }} — gunakan menu samping untuk buka Pesanan Saya, Barang Favorit, dan pengaturan akun.</p>
                    </div>
                    <div class="flex items-center gap-3 w-full lg:w-96 justify-end">
                        <a href="{{ route('buyer.orders') }}" class="hidden sm:inline-flex items-center gap-2 rounded-2xl border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">Pesanan Saya</a>
                        <form action="{{ route('home') }}" method="GET" class="w-full">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk atau toko..." class="w-full rounded-2xl border border-gray-200 bg-gray-50 py-3 pl-4 pr-24 text-sm text-gray-900 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 transition" />
                            <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700 transition">Cari</button>
                        </div>
                    </form>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-8">
                    <div class="bg-blue-50 border border-blue-100 rounded-3xl p-6 shadow-sm">
                        <p class="text-sm font-semibold text-blue-600 mb-1">Pesanan Aktif</p>
                        <p class="text-3xl font-black text-blue-900">{{ $activeOrders }}</p>
                    </div>
                    <div class="bg-purple-50 border border-purple-100 rounded-3xl p-6 shadow-sm">
                        <p class="text-sm font-semibold text-purple-600 mb-1">Menunggu Bayar</p>
                        <p class="text-3xl font-black text-purple-900">{{ $pendingPayment }}</p>
                    </div>
                    <div class="bg-orange-50 border border-orange-100 rounded-3xl p-6 shadow-sm">
                        <p class="text-sm font-semibold text-orange-600 mb-1">Barang Favorit</p>
                        <p class="text-3xl font-black text-orange-900">{{ $favoriteCount }}</p>
                    </div>
                </div>
            </div>

            <div class="grid gap-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <a href="{{ route('buyer.orders') }}" class="group rounded-3xl border border-gray-200 bg-white p-6 shadow-sm hover:border-primary hover:shadow-md transition">
                        <div class="flex items-center justify-between gap-3 mb-4">
                            <div>
                                <p class="text-sm font-semibold text-gray-500">Pesanan Saya</p>
                                <h3 class="mt-2 text-xl font-bold text-gray-900">{{ $activeOrders }}</h3>
                            </div>
                            <div class="rounded-2xl bg-emerald-50 p-3 text-emerald-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M9 3v4M15 3v4M5 21h14a2 2 0 002-2V8H3v11a2 2 0 002 2z"></path></svg>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500">Lihat status pesanan dan riwayat belanja Anda.</p>
                    </a>

                    <a href="{{ route('buyer.favorites') }}" class="group rounded-3xl border border-gray-200 bg-white p-6 shadow-sm hover:border-primary hover:shadow-md transition">
                        <div class="flex items-center justify-between gap-3 mb-4">
                            <div>
                                <p class="text-sm font-semibold text-gray-500">Barang Favorit</p>
                                <h3 class="mt-2 text-xl font-bold text-gray-900">{{ $favoriteCount }}</h3>
                            </div>
                            <div class="rounded-2xl bg-orange-50 p-3 text-orange-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z"></path></svg>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500">Kelola daftar barang favorit Anda di sini.</p>
                    </a>

                    <a href="{{ url('/?search=') }}" class="group rounded-3xl border border-gray-200 bg-white p-6 shadow-sm hover:border-primary hover:shadow-md transition">
                        <div class="flex items-center justify-between gap-3 mb-4">
                            <div>
                                <p class="text-sm font-semibold text-gray-500">Jelajahi UMKM</p>
                                <h3 class="mt-2 text-xl font-bold text-gray-900">Telusuri</h3>
                            </div>
                            <div class="rounded-2xl bg-blue-50 p-3 text-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11l4-4 4 4m0 6l-4 4-4-4"></path></svg>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500">Temukan UMKM dan produk baru dengan cepat.</p>
                    </a>
                </div>

                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Kategori Populer</h3>
                            <p class="text-sm text-gray-500 mt-1">Segera pilih kategori untuk menemukan UMKM dan produk favoritmu.</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
                        @foreach($categories as $category)
                            <a href="{{ url('/?search=' . $category->name) }}" class="rounded-3xl border border-gray-200 bg-gray-50 p-4 text-center text-sm font-semibold text-gray-900 hover:border-primary hover:bg-primary/10 transition">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">UMKM Terbaru</h3>
                            <p class="text-sm text-gray-500 mt-1">Temukan usaha lokal terbaru yang siap menerima pesananmu.</p>
                        </div>
                        <a href="{{ url('/?search=') }}" class="text-sm font-semibold text-primary hover:text-emerald-700">Lihat Semua</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                        @forelse($umkms->take(9) as $umkm)
                            <a href="{{ route('umkm.show', $umkm->id) }}" class="group overflow-hidden rounded-[28px] border border-gray-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                                <div class="h-44 bg-gray-100 overflow-hidden">
                                    @if($umkm->image)
                                        <img src="{{ asset('storage/' . $umkm->image) }}" alt="{{ $umkm->name }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
                                    @else
                                        <div class="flex h-full items-center justify-center text-gray-400">Foto belum tersedia</div>
                                    @endif
                                </div>
                                <div class="p-5">
                                    <h4 class="text-base font-bold text-gray-900 mb-2">{{ $umkm->name }}</h4>
                                    <p class="text-sm text-gray-500 mb-2">{{ $umkm->category->name ?? 'Lainnya' }}</p>
                                    <p class="text-sm text-gray-600 line-clamp-2">{{ Str::limit($umkm->address, 80) }}</p>
                                </div>
                            </a>
                        @empty
                            <div class="col-span-full py-14 text-center text-gray-500">
                                Belum ada UMKM yang ditemukan. Coba kata kunci lain di pencarian.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-buyer-layout>
