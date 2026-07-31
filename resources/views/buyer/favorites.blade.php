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

                <div class="text-center py-16 rounded-3xl border border-dashed border-gray-200 bg-gray-50">
                    <p class="text-lg font-semibold text-gray-900 mb-2">Belum ada barang favorit</p>
                    <p class="text-sm text-gray-500">Tandai produk yang kamu suka, lalu temukan kembali di sini dengan cepat.</p>
                </div>
            </div>
        </div>
    </div>
</x-buyer-layout>
