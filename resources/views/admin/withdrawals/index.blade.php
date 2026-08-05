<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight print:hidden">
            Manajemen Penarikan Dana UMKM
        </h2>
    </x-slot>

    <!-- CSS khusus untuk mengoptimalkan pencetakan kertas manual -->
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

    <div class="py-12" id="print-area">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-lg text-gray-900">Daftar Antrean Penarikan (Withdrawal)</h3>
                    <button onclick="window.print()" class="print:hidden text-sm font-bold text-emerald-600 bg-emerald-50 px-4 py-2 rounded-lg hover:bg-emerald-100 transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Cetak Antrean
                    </button>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="border border-gray-200 py-3 px-4 text-sm font-bold text-gray-700">Waktu Pengajuan</th>
                                <th class="border border-gray-200 py-3 px-4 text-sm font-bold text-gray-700">Nama Toko</th>
                                <th class="border border-gray-200 py-3 px-4 text-sm font-bold text-gray-700">Rekening Tujuan</th>
                                <th class="border border-gray-200 py-3 px-4 text-sm font-bold text-gray-700 text-right">Nominal</th>
                                <th class="border border-gray-200 py-3 px-4 text-sm font-bold text-gray-700 text-center print:hidden">Status</th>
                                <th class="border border-gray-200 py-3 px-4 text-sm font-bold text-gray-700 text-center print:hidden">Aksi (Validasi)</th>
                                <th class="border border-gray-200 py-3 px-4 text-sm font-bold text-gray-700 text-center w-32 kolom-cetak">Cek (Manual)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($withdrawals as $wd)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="border border-gray-200 py-4 px-4 text-sm text-gray-600">
                                        {{ $wd->created_at->format('d M Y, H:i') }}
                                    </td>
                                    <td class="border border-gray-200 py-4 px-4 text-sm font-bold text-gray-900">
                                        {{ $wd->umkm->name ?? 'Toko Tidak Diketahui' }}
                                    </td>
                                    <td class="border border-gray-200 py-4 px-4 text-sm text-gray-800">
                                        @if($wd->umkm)
                                            <span class="font-bold">{{ $wd->umkm->bank_name }}</span> - {{ $wd->umkm->bank_account }}<br>
                                            <span class="text-xs text-gray-500">a.n {{ $wd->umkm->bank_owner }}</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="border border-gray-200 py-4 px-4 text-sm text-right font-bold text-gray-900">
                                        Rp {{ number_format($wd->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="border border-gray-200 py-4 px-4 text-center text-sm print:hidden">
                                        @if($wd->status === 'success')
                                            <span class="bg-emerald-100 text-emerald-700 py-1 px-3 rounded-full text-[11px] font-bold uppercase tracking-wider">Selesai</span>
                                        @elseif($wd->status === 'pending')
                                            <span class="bg-orange-100 text-orange-700 py-1 px-3 rounded-full text-[11px] font-bold uppercase tracking-wider">Menunggu</span>
                                        @else
                                            <span class="bg-red-100 text-red-700 py-1 px-3 rounded-full text-[11px] font-bold uppercase tracking-wider">Gagal</span>
                                        @endif
                                    </td>
                                    <td class="border border-gray-200 py-4 px-4 text-center print:hidden">
                                        @if($wd->status === 'pending')
                                            <form action="{{ route('admin.withdrawals.approve', $wd->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" onclick="return confirm('PENTING: Apakah Anda sudah mentransfer uang Rp {{ number_format($wd->amount, 0, ',', '.') }} secara manual ke rekening {{ $wd->umkm->bank_name }} {{ $wd->umkm->bank_account }}? Tekan OK jika transfer SUDAH BERHASIL.')" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-1.5 px-4 rounded-lg shadow-sm transition text-xs">
                                                    Tandai Selesai
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-400 font-medium">Telah Diproses</span>
                                        @endif
                                    </td>
                                    <td class="border border-gray-200 py-4 px-4 kolom-cetak"></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="border border-gray-200 py-8 text-center text-sm text-gray-500">
                                        Belum ada antrean permintaan penarikan dana.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
