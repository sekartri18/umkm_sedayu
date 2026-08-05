<x-buyer-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="lg:-ml-64">
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100 p-6 sm:p-8 lg:pl-8">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Barang Favorit</h2>
                            <p class="text-sm text-gray-500 mt-1">Koleksi barang yang Anda tandai untuk nanti dibeli.</p>
                        </div>
                        <a href="{{ url('/?search=') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 transition">
                            Jelajahi UMKM
                        </a>
                    </div>

                    @if($favorites->isEmpty())
                        <div class="text-center py-16 rounded-3xl border border-dashed border-gray-200 bg-gray-50">
                            <p class="text-lg font-semibold text-gray-900 mb-2">Belum ada barang favorit</p>
                            <p class="text-sm text-gray-500">Tandai produk yang kamu suka, lalu temukan kembali di sini dengan cepat.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                            @foreach($favorites as $product)
                                <div class="rounded-3xl border border-gray-100 bg-white shadow-sm overflow-hidden flex flex-col">
                                    <a href="{{ route('product.show', $product->id) }}" class="block">
                                        <div class="h-44 bg-gray-100 overflow-hidden">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                        <div class="p-5">
                                            <p class="text-xs font-semibold text-emerald-600 mb-1">{{ $product->umkm->name }}</p>
                                            <h3 class="text-lg font-bold text-gray-900 line-clamp-2">{{ $product->name }}</h3>
                                            <p class="mt-2 text-primary font-black text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                            <p class="text-xs text-gray-500 mt-1">Stok: {{ $product->stock }}</p>
                                        </div>
                                    </a>

                                    <div class="px-5 pb-5 mt-auto flex gap-2">
                                        <a href="{{ route('product.show', $product->id) }}" class="flex-1 inline-flex items-center justify-center rounded-2xl border border-gray-200 px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                                            Lihat Produk
                                        </a>
                                        <form action="{{ route('buyer.favorites.destroy', $product->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" aria-label="Hapus dari favorit" title="Hapus dari favorit" class="inline-flex items-center justify-center rounded-2xl bg-red-50 px-3 py-3 text-red-600 hover:bg-red-100 transition">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.53L12 21.35z"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-buyer-layout>
