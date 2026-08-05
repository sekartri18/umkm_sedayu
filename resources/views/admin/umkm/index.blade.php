<x-app-layout> <!-- Sesuaikan dengan layout admin Anda -->
    <x-slot name="header">
        <div class="flex justify-between items-center no-print">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Verifikasi & Manajemen UMKM
            </h2>
            <button onclick="window.print()" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm hover:bg-gray-700">
                Cetak Daftar ke Kertas
            </button>
        </div>
    </x-slot>

    <style>
        /* Format Khusus Kertas Manual */
        @media print {
            body * { visibility: hidden; }
            #print-area, #print-area * { visibility: visible; }
            #print-area { position: absolute; left: 0; top: 0; width: 100%; }
            .no-print { display: none !important; }
            .print-only { display: table-cell !important; }
            table { border-collapse: collapse; width: 100%; }
            th, td { border: 1px solid #000 !important; padding: 12px !important; color: #000 !important; }
        }
    </style>

    <div class="py-12" id="print-area">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="print-only hidden mb-6 text-center">
                <h1 class="text-2xl font-bold uppercase">Dokumen Rekapitulasi Verifikasi UMKM</h1>
                <p class="text-sm">Tanggal Cetak: {{ now()->format('d M Y') }}</p>
            </div>

            @if(session('success'))
                <div class="no-print bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-gray-600">
                            <th class="py-4 px-6 text-sm font-bold">Nama Toko</th>
                            <th class="py-4 px-6 text-sm font-bold">Pemilik / Kontak</th>
                            <th class="py-4 px-6 text-sm font-bold">Status Saat Ini</th>
                            <th class="py-4 px-6 text-sm font-bold no-print text-right">Aksi Manajemen</th>
                            <!-- Kolom Khusus Kertas -->
                            <th class="print-only hidden py-4 px-6 text-sm font-bold w-1/4">Catatan Manual / Paraf</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($umkms as $umkm)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-4 px-6">
                                    <p class="font-bold text-gray-900">{{ $umkm->name }}</p>
                                    <p class="text-xs text-gray-500">{{ Str::limit($umkm->address, 40) }}</p>
                                </td>
                                <td class="py-4 px-6">
                                    <p class="text-sm text-gray-800 font-medium">{{ $umkm->user->name ?? 'User Tidak Ditemukan' }}</p>
                                    <p class="text-xs text-gray-500">{{ $umkm->whatsapp_number ?? '-' }}</p>
                                </td>
                                <td class="py-4 px-6">
                                    @if($umkm->status === 'approved')
                                        <span class="bg-emerald-100 text-emerald-700 py-1 px-3 rounded-full text-xs font-bold uppercase">Disetujui</span>
                                    @elseif($umkm->status === 'suspended')
                                        <span class="bg-red-100 text-red-700 py-1 px-3 rounded-full text-xs font-bold uppercase">Ditangguhkan</span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-700 py-1 px-3 rounded-full text-xs font-bold uppercase">Pending</span>
                                    @endif
                                </td>
                                
                                <td class="py-4 px-6 no-print">
                                    <form action="{{ route('admin.umkm.status', $umkm->id) }}" method="POST" class="flex justify-end gap-2">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" class="text-sm border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500" onchange="this.form.submit()">
                                            <option value="pending" {{ $umkm->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="approved" {{ $umkm->status === 'approved' ? 'selected' : '' }}>Setujui</option>
                                            <option value="suspended" {{ $umkm->status === 'suspended' ? 'selected' : '' }}>Suspend (Banned)</option>
                                        </select>
                                    </form>
                                </td>

                                <!-- Ruang Kosong Khusus Kertas -->
                                <td class="print-only hidden"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
