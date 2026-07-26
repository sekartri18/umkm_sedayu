<x-seller-layout>
    <x-slot name="header">Keuangan & Saldo</x-slot>

    <!-- Ringkasan Saldo -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Saldo Aktif (Bisa ditarik) -->
        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl p-6 text-white shadow-md relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full -mr-10 -mt-10"></div>
            <p class="text-sm font-medium text-emerald-100 mb-1 relative z-10">Saldo Aktif (Bisa Ditarik)</p>
            <h3 class="text-3xl font-bold mb-4 relative z-10">Rp {{ number_format($saldoAktif, 0, ',', '.') }}</h3>
            <button class="bg-white text-emerald-600 text-sm font-bold py-2 px-4 rounded-lg w-full hover:bg-gray-50 transition relative z-10 shadow-sm">
                Tarik Saldo
            </button>
        </div>

        <!-- Saldo Tertunda (Pesanan belum selesai) -->
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex flex-col justify-center">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Saldo Tertunda</p>
                    <h3 class="text-xl font-bold text-gray-900">Rp {{ number_format($saldoTertunda, 0, ',', '.') }}</h3>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-2">Dana dari pesanan yang sedang diproses atau dikirim. Akan cair setelah pembeli mengonfirmasi pesanan diterima.</p>
        </div>

        <!-- Total Penghasilan -->
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex flex-col justify-center">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Penghasilan</p>
                    <h3 class="text-xl font-bold text-gray-900">Rp {{ number_format($totalPenghasilan, 0, ',', '.') }}</h3>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-2">Total pendapatan keseluruhan sejak Anda membuka toko di UMKM Sedayu.</p>
        </div>
    </div>

    <!-- Riwayat Transaksi -->
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <h3 class="font-bold text-lg text-gray-900 mb-6">Riwayat Transaksi Terbaru</h3>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="py-3 px-4 text-sm font-semibold text-gray-600 rounded-tl-lg">Tanggal</th>
                        <th class="py-3 px-4 text-sm font-semibold text-gray-600">ID Referensi</th>
                        <th class="py-3 px-4 text-sm font-semibold text-gray-600">Keterangan</th>
                        <th class="py-3 px-4 text-sm font-semibold text-gray-600">Nominal</th>
                        <th class="py-3 px-4 text-sm font-semibold text-gray-600 text-right rounded-tr-lg">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    
                    @forelse($riwayatTransaksi as $transaksi)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-4 px-4 text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($transaksi['tanggal'])->translatedFormat('d M Y') }}
                            </td>
                            <td class="py-4 px-4 text-sm font-medium text-gray-900">{{ $transaksi['id_referensi'] }}</td>
                            <td class="py-4 px-4 text-sm text-gray-600">
                                {!! $transaksi['keterangan'] !!}
                            </td>
                            <td class="py-4 px-4 text-sm font-bold {{ $transaksi['status'] === 'selesai' ? 'text-emerald-600' : 'text-orange-500' }}">
                                + Rp {{ number_format($transaksi['nominal'], 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-4 text-right text-sm">
                                @if($transaksi['status'] === 'selesai')
                                    <span class="bg-emerald-100 text-emerald-700 py-1 px-3 rounded-full text-[11px] font-bold uppercase tracking-wider">Selesai</span>
                                @else
                                    <span class="bg-orange-100 text-orange-700 py-1 px-3 rounded-full text-[11px] font-bold uppercase tracking-wider">Tertunda</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-sm text-gray-500">
                                Belum ada riwayat transaksi tercatat.
                            </td>
                        </tr>
                    @endforelse
                    
                </tbody>
            </table>
        </div>
    </div>
</x-seller-layout>