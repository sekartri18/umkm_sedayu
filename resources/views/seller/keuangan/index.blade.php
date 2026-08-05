<x-seller-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight print:hidden">
            Keuangan & Saldo
        </h2>
    </x-slot>

    <!-- CSS khusus untuk mengoptimalkan tampilan saat dicetak ke kertas -->
    <style>
        @media print {
            body * { visibility: hidden; }
            #print-area, #print-area * { visibility: visible; }
            #print-area { position: absolute; left: 0; top: 0; width: 100%; padding: 20px; }
            .print\:hidden { display: none !important; }
            table td, table th { padding: 12px 8px !important; font-size: 14px; border: 1px solid #000 !important; }
            table th { background-color: #f3f4f6 !important; -webkit-print-color-adjust: exact; }
            .kolom-cetak { display: table-cell !important; } 
        }
        .kolom-cetak { display: none; } 
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" id="print-area">
            
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl px-4 py-3 text-sm font-bold shadow-sm print:hidden">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm font-bold shadow-sm print:hidden">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Ringkasan Saldo -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 print:hidden">
                
                <!-- Saldo Aktif -->
                <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl p-6 text-white shadow-md relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full -mr-10 -mt-10"></div>
                    <p class="text-sm font-medium text-emerald-100 mb-1 relative z-10">Saldo Aktif (Bisa Ditarik)</p>
                    <h3 class="text-3xl font-bold mb-4 relative z-10">Rp {{ number_format($saldoAktif, 0, ',', '.') }}</h3>
                    <!-- Perbaikan Tombol: Menggunakan onclick JS murni -->
                    <button type="button" onclick="document.getElementById('withdrawModal').classList.remove('hidden')" class="bg-white text-emerald-600 text-sm font-bold py-2 px-4 rounded-lg w-full hover:bg-gray-50 transition relative z-10 shadow-sm">
                        Tarik Saldo
                    </button>
                </div>

                <!-- Saldo Tertunda -->
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
                    <p class="text-xs text-gray-400 mt-2">Dana dari pesanan non-COD yang sedang diproses atau dikirim.</p>
                </div>

                <!-- Total Penghasilan -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex flex-col justify-center">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Pencairan</p>
                            <h3 class="text-xl font-bold text-gray-900">Rp {{ number_format($totalPenghasilan, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">Total pendapatan bersih sistem yang telah masuk ke dompet Anda.</p>
                </div>
            </div>

            <!-- Riwayat Transaksi -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-lg text-gray-900">Riwayat Mutasi & Pembukuan</h3>
                    <button onclick="window.print()" class="print:hidden text-sm font-bold text-emerald-600 bg-emerald-50 px-4 py-2 rounded-lg hover:bg-emerald-100 transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Cetak Laporan
                    </button>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="border border-gray-200 py-3 px-4 text-sm font-bold text-gray-700">Tanggal</th>
                                <th class="border border-gray-200 py-3 px-4 text-sm font-bold text-gray-700">Keterangan</th>
                                <th class="border border-gray-200 py-3 px-4 text-sm font-bold text-gray-700 text-right">Uang Masuk</th>
                                <th class="border border-gray-200 py-3 px-4 text-sm font-bold text-gray-700 text-right">Uang Keluar</th>
                                <th class="border border-gray-200 py-3 px-4 text-sm font-bold text-gray-700 text-center print:hidden">Status</th>
                                <th class="border border-gray-200 py-3 px-4 text-sm font-bold text-gray-700 text-center w-32 kolom-cetak">Cek (Manual)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayatTransaksi as $transaksi)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="border border-gray-200 py-4 px-4 text-sm text-gray-600">
                                        {{ $transaksi->created_at->format('d M Y, H:i') }}
                                    </td>
                                    <td class="border border-gray-200 py-4 px-4 text-sm text-gray-800">
                                        {{ $transaksi->description }}
                                    </td>
                                    <td class="border border-gray-200 py-4 px-4 text-sm text-right font-bold text-emerald-600">
                                        {{ $transaksi->type === 'income' ? '+ Rp ' . number_format($transaksi->amount, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="border border-gray-200 py-4 px-4 text-sm text-right font-bold text-red-500">
                                        {{ $transaksi->type === 'withdrawal' ? '- Rp ' . number_format($transaksi->amount, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="border border-gray-200 py-4 px-4 text-center text-sm print:hidden">
                                        @if($transaksi->status === 'success')
                                            <span class="bg-emerald-100 text-emerald-700 py-1 px-3 rounded-full text-[11px] font-bold uppercase tracking-wider">Selesai</span>
                                        @elseif($transaksi->status === 'pending')
                                            <span class="bg-orange-100 text-orange-700 py-1 px-3 rounded-full text-[11px] font-bold uppercase tracking-wider">Diproses</span>
                                        @endif
                                    </td>
                                    <td class="border border-gray-200 py-4 px-4 kolom-cetak"></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="border border-gray-200 py-8 text-center text-sm text-gray-500">
                                        Belum ada riwayat transaksi tercatat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- MODAL TARIK SALDO (DIUBAH KE VANILLA JS) -->
        <div id="withdrawModal" class="hidden fixed inset-0 z-50 overflow-y-auto print:hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                
                <!-- Background overlay (Klik luar untuk menutup) -->
                <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" onclick="document.getElementById('withdrawModal').classList.add('hidden')"></div>
                
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal Content -->
                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100 relative z-10">
                    
                    <form action="{{ route('keuangan.tarik') }}" method="POST">
                        @csrf
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-xl font-bold text-gray-900 mb-1">Tarik Saldo Penghasilan</h3>
                            <p class="text-sm text-gray-500 mb-5">Dana akan ditransfer ke rekening bank yang telah Anda daftarkan.</p>
                            
                            <!-- Info Rekening -->
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 mb-5">
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Tujuan Transfer</p>
                                @if($umkm->bank_name && $umkm->bank_account)
                                    <p class="font-bold text-gray-900">{{ $umkm->bank_name }} - {{ $umkm->bank_account }}</p>
                                    <p class="text-sm text-gray-600">a.n {{ $umkm->bank_owner }}</p>
                                @else
                                    <p class="text-sm text-red-500 font-semibold">Rekening belum diatur. Silakan atur di menu Pengaturan.</p>
                                @endif
                            </div>

                            <div class="mb-2 text-left">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nominal Penarikan (Rp) <span class="text-red-500">*</span></label>
                                <input type="number" name="amount" min="10000" max="{{ $saldoAktif }}" required placeholder="Minimal 10000" class="w-full border-gray-300 bg-gray-50 rounded-xl shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-base py-3 px-4 font-bold text-gray-900">
                                <p class="text-xs text-gray-500 mt-2">Maksimal penarikan: Rp {{ number_format($saldoAktif, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
                            <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-5 py-2.5 bg-emerald-600 text-base font-bold text-white hover:bg-emerald-700 focus:outline-none transition sm:ml-3 sm:w-auto sm:text-sm">
                                Ajukan Penarikan
                            </button>
                            <!-- Tombol Batal -->
                            <button type="button" onclick="document.getElementById('withdrawModal').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-5 py-2.5 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 focus:outline-none transition sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-seller-layout>