<x-seller-layout>
    <x-slot name="header">Manajemen Produk</x-slot>

    <div class="flex justify-between items-center mb-6">
        <h3 class="font-bold text-lg text-gray-900">Daftar Katalog Anda</h3>
        <a href="{{ route('produk.create') }}" class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg font-medium text-sm transition shadow-sm">
            + Tambah Produk Baru
        </a>
    </div>

    <!-- Tampilkan Tabel atau Grid Produk di sini sama seperti rancangan sebelumnya -->
    <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm text-center">
        <p class="text-gray-500">Area ini akan menampilkan daftar lengkap produk (Pakaian, Celana, dll) yang Anda miliki.</p>
    </div>
</x-seller-layout>