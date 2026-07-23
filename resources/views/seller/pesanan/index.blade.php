<x-seller-layout>
    <x-slot name="header">Manajemen Pesanan Masuk</x-slot>

    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between gap-4 mb-4">
            <div>
                <h3 class="font-bold text-lg text-gray-900">Daftar Pesanan Masuk</h3>
                <p class="text-sm text-gray-500">Pesanan pembeli yang berisi produk toko Anda akan tampil di sini.</p>
            </div>
            <span class="text-xs font-semibold bg-emerald-100 text-primary px-3 py-1.5 rounded-full">{{ isset($orders) ? $orders->count() : 0 }} pesanan</span>
        </div>

        @if(empty($orders) || $orders->isEmpty())
            <div class="py-10 text-center text-sm text-gray-500">Belum ada pesanan masuk saat ini.</div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="py-3 px-4 text-sm font-semibold text-gray-600">ID Pesanan</th>
                            <th class="py-3 px-4 text-sm font-semibold text-gray-600">Nama Pembeli</th>
                            <th class="py-3 px-4 text-sm font-semibold text-gray-600">Produk</th>
                            <th class="py-3 px-4 text-sm font-semibold text-gray-600">Total</th>
                            <th class="py-3 px-4 text-sm font-semibold text-gray-600">Status</th>
                            <th class="py-3 px-4 text-sm font-semibold text-gray-600 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            @php
                                $sellerItems = $order->items->where('umkm_id', $umkm->id);
                                $productNames = $sellerItems->pluck('product_name')->take(2)->implode(', ');
                                if ($sellerItems->count() > 2) {
                                    $productNames .= ' +'.($sellerItems->count() - 2).' lainnya';
                                }
                                $sellerSubtotal = $sellerItems->sum('subtotal');
                            @endphp
                            <tr class="border-b border-gray-100 hover:bg-gray-50/70">
                                <td class="py-4 px-4 text-sm font-semibold text-gray-900">{{ $order->order_code }}</td>
                                <td class="py-4 px-4 text-sm text-gray-700">{{ $order->customer_name }}</td>
                                <td class="py-4 px-4 text-sm text-gray-700">{{ $productNames }}</td>
                                <td class="py-4 px-4 text-sm font-semibold text-gray-900">Rp {{ number_format($sellerSubtotal, 0, ',', '.') }}</td>
                                <td class="py-4 px-4 text-sm">
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-primary">{{ ucfirst($order->status) }}</span>
                                </td>
                                <td class="py-4 px-4 text-sm text-right">
                                    <span class="text-xs text-gray-500">{{ optional($order->checked_out_at)->format('d M Y, H:i') }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-seller-layout>