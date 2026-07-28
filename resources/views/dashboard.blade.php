@if(auth()->user()->role === 'admin')
    <!-- ========================================== -->
    <!-- DASHBOARD KHUSUS ADMIN (GLOBAL LEDGER) -->
    <!-- ========================================== -->
    <x-app-layout>
        <x-slot name="header">
            <div class="flex justify-between items-center no-print">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Dashboard Admin') }}
                </h2>
                
                <button onclick="window.print()" class="bg-gray-800 text-white px-5 py-2.5 rounded-lg text-sm font-bold shadow-sm hover:bg-gray-700 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak Dokumen Fisik
                </button>
            </div>
        </x-slot>

        <!-- Pengaturan CSS khusus kertas A4 -->
        <style>
            @media print {
                body * { visibility: hidden; }
                #print-report, #print-report * { visibility: visible; }
                #print-report { position: absolute; left: 0; top: 0; width: 100%; }
                .no-print { display: none !important; }
                .print-border { border: 2px solid #374151 !important; box-shadow: none !important; }
                body { background-color: white !important; }
            }
        </style>

        <div class="py-12" id="print-report">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- KOP SURAT -->
                <div class="hidden print:block mb-10 text-center border-b-4 border-gray-800 pb-6">
                    <h1 class="text-3xl font-extrabold uppercase tracking-wide text-gray-900">Laporan Analitik Ekonomi Digital</h1>
                    <h2 class="text-xl font-bold uppercase text-gray-700 mt-1">Platform UMKM Sedayu</h2>
                    <p class="text-sm font-medium mt-3 text-gray-500">Tanggal Rekapitulasi: {{ now()->format('d F Y') }}</p>
                </div>

                <!-- KARTU STATISTIK -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6 print-border flex flex-col items-center justify-center text-center h-40">
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-2">Total UMKM Aktif</p>
                        <p class="text-4xl font-black text-gray-900">{{ $totalUmkm ?? 0 }} <span class="text-base font-medium text-gray-500">Toko</span></p>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6 print-border flex flex-col items-center justify-center text-center h-40">
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-2">Pengguna Terdaftar</p>
                        <p class="text-4xl font-black text-gray-900">{{ $totalCustomer ?? 0 }} <span class="text-base font-medium text-gray-500">Orang</span></p>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6 print-border flex flex-col items-center justify-center text-center h-40 bg-emerald-50/30 print:bg-white">
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-2">Perputaran Uang (GMV)</p>
                        <p class="text-3xl md:text-4xl font-black text-emerald-600 print:text-gray-900">Rp {{ isset($gmv) ? number_format($gmv, 0, ',', '.') : 0 }}</p>
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-100 text-blue-800 p-4 rounded-xl text-sm no-print flex gap-3 items-start">
                    <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <span class="font-bold">Tips Laporan:</span> Klik tombol "Cetak Dokumen Fisik" di kanan atas untuk mencetak dokumen ini.
                    </div>
                </div>

                <div class="hidden print:flex justify-end mt-24">
                    <div class="text-center">
                        <p class="mb-24 text-gray-800">Sedayu, {{ now()->format('d F Y') }}</p>
                        <p class="font-bold underline text-gray-900">Kepala Desa Sedayu</p>
                        <p class="text-gray-600">(.............................................)</p>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>

@elseif(isset($umkm))
    <!-- ========================================== -->
    <!-- DASHBOARD KHUSUS PENJUAL / UMKM -->
    <!-- ========================================== -->
    <x-seller-layout>
        <x-slot name="header">
            <div class="flex justify-between items-center w-full">
                <span>Ringkasan Bisnis: {{ $umkm->name }}</span>
            </div>
        </x-slot>

        <style>
            @media print {
                body { background: white !important; color: black !important; }
                .print\:hidden { display: none !important; }
                .shadow-sm, .shadow-md { box-shadow: none !important; border: 1px solid #e5e7eb !important; }
                .bg-white { background: white !important; }
                canvas { min-height: 300px !important; } 
            }
        </style>

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
                            {{ $umkm->category->name ?? 'Pakaian' }}
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $umkm->name }}</h2>
                        <p class="text-sm text-gray-500">{{ $umkm->address }}</p>
                        <p class="text-sm text-gray-500 mt-1">Pemilik: {{ Auth::user()->name }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                    <div class="rounded-xl bg-gray-50 px-4 py-3 border border-gray-100">
                        <p class="text-gray-500 mb-1 font-medium">Total Produk</p>
                        <p class="text-lg font-bold text-gray-900">{{ $umkm->products()->count() }}</p>
                    </div>
                    <div class="rounded-xl bg-gray-50 px-4 py-3 border border-gray-100">
                        <p class="text-gray-500 mb-1 font-medium">Kontak Toko</p>
                        <p class="text-lg font-bold text-gray-900">{{ $umkm->whatsapp_number ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">GMV (Pendapatan)</p>
                        <h3 class="text-2xl font-bold text-gray-900">Rp {{ number_format($gmv ?? 0, 0, ',', '.') }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Total Pembeli</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ number_format($totalPembeli ?? 0, 0, ',', '.') }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Pesanan (SKU)</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ number_format($totalSKU ?? 0, 0, ',', '.') }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Pengunjung Toko</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ number_format($pengunjung ?? 0, 0, ',', '.') }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm mb-8">
            <h3 class="font-bold text-lg mb-4 text-gray-900">Tren Penjualan (12 Bulan Terakhir)</h3>
            <div class="w-full h-72 relative">
                @if(isset($grafikPendapatan) && array_sum($grafikPendapatan) == 0)
                    <div class="absolute inset-0 flex flex-col items-center justify-center z-10 bg-white/80 backdrop-blur-sm rounded-xl print:hidden">
                        <p class="text-gray-500 font-medium">Belum ada data penjualan tercatat.</p>
                    </div>
                @endif
                <canvas id="penjualanChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm mb-8 print:hidden">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 border-b border-gray-100 pb-4">
                <div>
                    <h3 class="font-bold text-lg text-gray-900">Katalog Produk Toko</h3>
                    <p class="text-sm text-gray-500 mt-1">Produk terbaru yang ditambahkan penjual akan tampil otomatis di sini.</p>
                </div>
                <a href="{{ route('produk.index') }}" class="text-sm font-semibold bg-emerald-50 text-emerald-600 hover:bg-emerald-100 px-4 py-2 rounded-lg transition shrink-0">Kelola Produk</a>
            </div>

            @if(isset($recentProducts) && $recentProducts->isEmpty())
                <div class="rounded-2xl border border-dashed border-gray-200 bg-gray-50 px-6 py-10 text-center">
                    <p class="text-sm font-semibold text-gray-900">Belum ada produk di toko ini</p>
                    <p class="text-sm text-gray-500 mt-1">Tambahkan produk dari menu Produk agar katalog dashboard ikut terisi.</p>
                </div>
            @elseif(isset($recentProducts))
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($recentProducts as $product)
                        <div class="rounded-2xl border border-gray-100 overflow-hidden shadow-sm bg-gray-50 flex flex-col transition hover:shadow-md">
                            <div class="h-44 bg-white border-b border-gray-100 relative">
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
                                    <span class="shrink-0 rounded-md bg-white border border-gray-200 text-gray-600 text-[10px] font-bold px-2 py-1 shadow-sm">Stok {{ $product->stock }}</span>
                                </div>
                                <p class="text-emerald-600 font-bold text-sm mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-500 line-clamp-2 flex-1">{{ $product->description ?? 'Tidak ada deskripsi produk.' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                if(document.getElementById('penjualanChart')) {
                    const ctx = document.getElementById('penjualanChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: {!! isset($grafikBulan) ? json_encode($grafikBulan) : '[]' !!},
                            datasets: [{
                                label: 'Pendapatan (Rp)',
                                data: {!! isset($grafikPendapatan) ? json_encode($grafikPendapatan) : '[]' !!},
                                borderColor: '#10B981', 
                                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4, 
                                pointBackgroundColor: '#10B981',
                                pointRadius: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.dataset.label || '';
                                            if (label) { label += ': '; }
                                            if (context.parsed.y !== null) {
                                                label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                                            }
                                            return label;
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: { 
                                    beginAtZero: true, 
                                    grid: { borderDash: [4, 4] },
                                    ticks: {
                                        callback: function(value) {
                                            if (value >= 1000000) { return (value / 1000000) + ' Jt'; }
                                            if (value >= 1000) { return (value / 1000) + ' Rb'; }
                                            return value;
                                        }
                                    }
                                },
                                x: { grid: { display: false } }
                            }
                        }
                    });
                }
            });
        </script>
    </x-seller-layout>

@else
    <!-- ========================================== -->
    <!-- DASHBOARD KHUSUS PEMBELI (CUSTOMER BIASA)  -->
    <!-- ========================================== -->
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard Pembeli') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                    <div class="p-8 text-center flex flex-col items-center">
                        <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Selamat Datang, {{ auth()->user()->name }}!</h3>
                        <p class="text-gray-500 mb-6">Akun pembeli Anda sudah aktif. Anda bisa mulai mencari dan membeli produk-produk UMKM terbaik dari warga Desa Sedayu.</p>
                        
                        <div class="flex gap-4">
                            <a href="{{ url('/') }}" class="bg-primary hover:bg-emerald-600 text-white font-bold py-2.5 px-6 rounded-lg shadow-sm transition">Mulai Belanja</a>
                            <a href="{{ route('penjual.register') }}" class="bg-gray-50 border border-gray-200 text-gray-700 hover:bg-gray-100 font-bold py-2.5 px-6 rounded-lg transition">Buka Toko Sendiri</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
@endif