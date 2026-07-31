<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pesanan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 sm:p-8 border border-gray-100">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Daftar Pesanan Saya</h2>

                @if($orders->isEmpty())
                    <div class="text-center py-12 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                        <p class="text-gray-500 mb-4">Kamu belum memiliki pesanan saat ini.</p>
                        <a href="{{ url('/') }}" class="px-6 py-2 bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700 transition">Mulai Belanja</a>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach($orders as $order)
                            <div class="border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                                <div class="bg-gray-50 px-5 py-3 border-b border-gray-200 flex justify-between items-center text-sm">
                                    <span class="font-bold text-gray-900">Order ID: #{{ $order->id }}</span>
                                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 font-bold uppercase tracking-wider rounded-md text-[11px]">
                                        {{ $order->status ?? 'Diproses' }}
                                    </span>
                                </div>
                                <div class="p-5">
                                    @foreach($order->items as $item)
                                        <div class="flex justify-between items-center mb-2 pb-2 border-b border-gray-100 last:border-0 last:mb-0 last:pb-0">
                                            <div>
                                                <p class="font-bold text-gray-900">{{ $item->product->name ?? 'Nama Produk' }}</p>
                                                <p class="text-sm text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                            </div>
                                            <p class="font-bold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="bg-gray-50 px-5 py-3 border-t border-gray-200 text-right">
                                    <span class="text-sm text-gray-600 mr-2">Total Belanja:</span>
                                    <span class="text-lg font-black text-emerald-600">Rp {{ number_format($order->subtotal ?? 0, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>