<x-seller-layout>
    <x-slot name="header">Ringkasan Bisnis: {{ $umkm->name }}</x-slot>

    <!-- Informasi Toko -->
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-20 h-20 rounded-2xl overflow-hidden bg-gray-100 border border-gray-200 shrink-0">
                    @if($umkm->image)
                        <img src="{{ asset('storage/' . $umkm->image) }}" alt="{{ $umkm->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                </div>

                <div>
                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-xs font-semibold mb-3">
                        {{ $umkm->category->name ?? 'UMKM' }}
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $umkm->name }}</h2>
                    <p class="text-sm text-gray-500">{{ $umkm->address }}</p>
                    <p class="text-sm text-gray-500 mt-1">Pemilik: {{ $umkm->owner_name }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                <div class="rounded-xl bg-gray-50 px-4 py-3">
                    <p class="text-gray-500 mb-1">Total Produk</p>
                    <p class="text-lg font-bold text-gray-900">{{ $umkm->products_count ?? $products->count() }}</p>
                </div>
                <div class="rounded-xl bg-gray-50 px-4 py-3">
                    <p class="text-gray-500 mb-1">Kontak Toko</p>
                    <p class="text-lg font-bold text-gray-900">{{ $umkm->whatsapp_number ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 4 Kotak Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Kotak GMV -->
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">GMV (Pendapatan)</p>
                    <h3 class="text-2xl font-bold text-gray-900">Rp 12.500.000</h3>
                </div>
                <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <p class="text-xs text-emerald-500 font-medium mt-3 flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg> +15% bulan ini</p>
        </div>

        <!-- Kotak Pembeli -->
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Total Pembeli</p>
                    <h3 class="text-2xl font-bold text-gray-900">142</h3>
                </div>
                <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
            <p class="text-xs text-emerald-500 font-medium mt-3 flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg> +5% bulan ini</p>
        </div>

        <!-- Kotak Pesanan SKU -->
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Pesanan (SKU)</p>
                    <h3 class="text-2xl font-bold text-gray-900">328</h3>
                </div>
                <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
            </div>
            <p class="text-xs text-emerald-500 font-medium mt-3 flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg> +22% bulan ini</p>
        </div>

        <!-- Kotak Pengunjung -->
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Pengunjung Toko</p>
                    <h3 class="text-2xl font-bold text-gray-900">1,204</h3>
                </div>
                <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </div>
            </div>
            <p class="text-xs text-red-500 font-medium mt-3 flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg> -2% bulan ini</p>
        </div>
    </div>

    <!-- Katalog Produk Toko -->
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm mb-8">
        <div class="flex items-center justify-between gap-4 mb-5">
            <div>
                <h3 class="font-bold text-lg text-gray-900">Katalog Produk Toko</h3>
                <p class="text-sm text-gray-500">Produk yang ditambahkan penjual akan tampil otomatis di sini.</p>
            </div>
            <a href="{{ route('produk.index') }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700">Kelola produk</a>
        </div>

        @if($products->isEmpty())
            <div class="rounded-2xl border border-dashed border-gray-200 bg-gray-50 px-6 py-10 text-center">
                <p class="text-sm font-semibold text-gray-900">Belum ada produk di toko ini</p>
                <p class="text-sm text-gray-500 mt-1">Tambahkan produk dari menu Produk agar katalog dashboard ikut terisi.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
                @foreach($products->take(8) as $product)
                    <div class="rounded-2xl border border-gray-100 overflow-hidden shadow-sm bg-gray-50 flex flex-col">
                        <div class="h-40 bg-white border-b border-gray-100">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </div>

                        <div class="p-4 flex-1 flex flex-col">
                            <div class="flex items-start justify-between gap-3 mb-2">
                                <h4 class="font-bold text-gray-900 line-clamp-2">{{ $product->name }}</h4>
                                <span class="shrink-0 rounded-full bg-emerald-50 text-emerald-600 text-[11px] font-bold px-2 py-1">Stok {{ $product->stock }}</span>
                            </div>
                            <p class="text-emerald-600 font-bold text-sm mb-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500 line-clamp-3 flex-1">{{ $product->description ?? 'Tidak ada deskripsi produk.' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Area Grafik Statistik -->
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <h3 class="font-bold text-lg mb-4 text-gray-900">Tren Penjualan (12 Bulan Terakhir)</h3>
        <div class="w-full h-72">
            <canvas id="penjualanChart"></canvas>
        </div>
    </div>

    <!-- Script Inisialisasi Chart.js -->
    <script>
        const ctx = document.getElementById('penjualanChart').getContext('2d');
        const penjualanChart = new Chart(ctx, {
            type: 'line',
            data: {
                // Diperbarui menjadi 12 Bulan
                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                datasets: [{
                    label: 'Pendapatan (Rp Juta)',
                    // Data angka ditambahkan hingga 12 item agar sejajar dengan label bulan
                    data: [4.5, 6.2, 5.8, 8.4, 10.1, 12.5, 11.0, 13.2, 14.8, 15.5, 17.0, 20.4],
                    borderColor: '#10B981', // Warna Emerald Tailwind
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4, // Membuat garis melengkung
                    pointBackgroundColor: '#10B981',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [4, 4] } },
                    x: { grid: { display: false } }
                }
            }
        });
    </script>
</x-seller-layout>