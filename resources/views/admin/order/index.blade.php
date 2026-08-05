<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center no-print">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Pemantauan Transaksi Global
            </h2>
            <button onclick="window.print()" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm hover:bg-gray-700">
                Cetak Laporan
            </button>
        </div>
    </x-slot>

    <style>
        @media print {
            body * { visibility: hidden; }
            #print-area, #print-area * { visibility: visible; }
            #print-area { position: absolute; left: 0; top: 0; width: 100%; }
            .no-print { display: none !important; }
            table { border-collapse: collapse; width: 100%; }
            th, td { border: 1px solid #000 !important; padding: 10px !important; color: #000 !important; }
        }
    </style>

    <div class="py-12" id="print-area">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="hidden print:block mb-6 text-center">
                <h1 class="text-2xl font-bold uppercase">Buku Besar Transaksi UMKM Sedayu</h1>
                <p class="text-sm">Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200 text-gray-600">
                                <th class="py-4 px-6 text-sm font-bold">Tanggal & Waktu</th>
                                <th class="py-4 px-6 text-sm font-bold">ID Transaksi</th>
                                <th class="py-4 px-6 text-sm font-bold">Nama Pembeli</th>
                                <th class="py-4 px-6 text-sm font-bold">Total Belanja</th>
                                <th class="py-4 px-6 text-sm font-bold">Status Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($orders as $order)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-4 px-6">
                                        <p class="font-bold text-gray-900">{{ $order->created_at->format('d M Y') }}</p>
                                        <p class="text-xs text-gray-500">{{ $order->created_at->format('H:i') }} WIB</p>
                                    </td>
                                    <td class="py-4 px-6 text-sm font-medium text-gray-800">
                                        #{{ $order->id }}
                                        <!-- Jika Anda menggunakan Midtrans Order ID (misal: order_id), ubah menjadi $order->order_id -->
                                    </td>
                                    <td class="py-4 px-6 text-sm text-gray-800">
                                        {{ $order->user->name ?? 'User Dihapus' }}
                                    </td>
                                    <td class="py-4 px-6 text-sm font-bold text-emerald-600">
                                        Rp {{ number_format($order->subtotal, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-6">
                                        @php
                                            $status = strtolower($order->status);
                                            $badgeClass = 'bg-gray-100 text-gray-700'; // Default
                                            
                                            if (in_array($status, ['success', 'settlement', 'berhasil'])) {
                                                $badgeClass = 'bg-emerald-100 text-emerald-700';
                                            } elseif (in_array($status, ['pending', 'menunggu'])) {
                                                $badgeClass = 'bg-yellow-100 text-yellow-700';
                                            } elseif (in_array($status, ['cancel', 'failed', 'expire', 'batal'])) {
                                                $badgeClass = 'bg-red-100 text-red-700';
                                            }
                                        @endphp
                                        <span class="{{ $badgeClass }} py-1 px-3 rounded-full text-xs font-bold uppercase">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-gray-500">Belum ada transaksi di platform ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination Links -->
                @if($orders->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 no-print">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
            
        </div>
    </div>
</x-app-layout>
