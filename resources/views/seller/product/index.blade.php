<x-seller-layout>
    <x-slot name="header">Manajemen Produk</x-slot>

    <div class="flex justify-between items-center mb-6">
        <h3 class="font-bold text-lg text-gray-900">Daftar Katalog Anda</h3>
        <a href="{{ route('produk.create') }}" class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg font-medium text-sm transition shadow-sm">
            + Tambah Produk Baru
        </a>
    </div>

    <!-- Menampilkan Alert Jika Sukses Tambah/Edit/Hapus Produk -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Logika Menampilkan Grid Produk -->
    @if($products->isEmpty())
        <div class="bg-white p-12 rounded-2xl border border-gray-100 shadow-sm text-center">
            <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
            </svg>
            <h3 class="mt-4 text-sm font-bold text-gray-900">Belum ada produk</h3>
            <p class="mt-1 text-sm text-gray-500">Mulai tambahkan produk pertama Anda agar pembeli bisa melihat katalog toko.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition flex flex-col">
                    
                    <!-- Area Gambar -->
                    <div class="h-48 bg-gray-50 relative border-b border-gray-100">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center w-full h-full text-gray-300">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Area Teks & Tombol -->
                    <div class="p-4 flex-grow flex flex-col">
                        <h4 class="font-bold text-gray-900 mb-1 line-clamp-1" title="{{ $product->name }}">{{ $product->name }}</h4>
                        <p class="text-emerald-600 font-bold text-sm mb-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-500 line-clamp-2 mb-4 flex-grow">{{ $product->description ?? 'Tidak ada deskripsi produk.' }}</p>
                        
                        <!-- Tombol Aksi (Edit & Hapus) yang sudah dibuat fungsional -->
                        <div class="flex gap-2 mt-auto">
                            <!-- Tombol Edit -->
                            <a href="{{ route('produk.edit', $product->id) }}" class="flex-1 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 py-2 rounded-lg text-xs font-bold text-center transition">Edit</a>
                            
                            <!-- Tombol Hapus (Menggunakan Form agar aman) -->
                            <form action="{{ route('produk.destroy', $product->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini dari etalase?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-50 text-red-600 hover:bg-red-100 py-2 rounded-lg text-xs font-bold text-center transition">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-seller-layout>