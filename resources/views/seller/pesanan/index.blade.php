<x-seller-layout>
    <x-slot name="header">Manajemen Pesanan Masuk</x-slot>

    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <h3 class="font-bold text-lg text-gray-900 mb-4">Daftar Pesanan Belum Diproses</h3>
        
        <!-- Placeholder Tabel Pesanan -->
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="py-3 px-4 text-sm font-semibold text-gray-600">ID Pesanan</th>
                    <th class="py-3 px-4 text-sm font-semibold text-gray-600">Nama Pembeli</th>
                    <th class="py-3 px-4 text-sm font-semibold text-gray-600">Produk</th>
                    <th class="py-3 px-4 text-sm font-semibold text-gray-600">Status</th>
                    <th class="py-3 px-4 text-sm font-semibold text-gray-600 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="5" class="py-8 text-center text-sm text-gray-500">Belum ada pesanan masuk saat ini.</td>
                </tr>
            </tbody>
        </table>
    </div>
</x-seller-layout>