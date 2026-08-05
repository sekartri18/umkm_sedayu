<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pesanan Saya') }}
        </h2>
    </x-slot>

    <!-- Tambahkan orderId di dalam state Alpine.js -->
    <div class="py-12" x-data="{ showReviewModal: false, productId: '', productName: '', orderId: '', openOrder: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl px-4 py-3 text-sm font-bold shadow-sm flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm font-bold shadow-sm flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('error') }}
                </div>
            @endif

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
                                
                                <div class="bg-gray-50 px-5 py-4 border-b border-gray-200 flex justify-between items-center text-sm cursor-pointer hover:bg-gray-100 transition" @click="openOrder === {{ $order->id }} ? openOrder = null : openOrder = {{ $order->id }}">
                                    <div class="flex items-center gap-3">
                                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-300" :class="openOrder === {{ $order->id }} ? 'rotate-180 text-emerald-600' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        <span class="font-bold text-gray-900">Order ID: #{{ $order->id }}</span>
                                        <span class="hidden sm:inline text-gray-500 text-xs px-2 border-l border-gray-300">{{ $order->created_at->format('d M Y, H:i') }}</span>
                                    </div>
                                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 font-bold uppercase tracking-wider rounded-md text-[11px]">
                                        {{ $order->status ?? 'Baru' }}
                                    </span>
                                </div>

                                <div x-show="openOrder === {{ $order->id }}" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="bg-white border-b border-gray-100">
                                    <div class="p-5 bg-emerald-50/30 text-sm grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <p class="text-gray-500 mb-1 text-xs font-bold uppercase tracking-wider">Informasi Pengiriman</p>
                                            <p class="font-bold text-gray-900">{{ $order->customer_name }}</p>
                                            <p class="text-gray-700">{{ $order->phone }}</p>
                                            <p class="text-gray-700 mt-1 leading-relaxed">{{ $order->address }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 mb-1 text-xs font-bold uppercase tracking-wider">Detail Pembayaran</p>
                                            <p class="font-bold text-gray-900 uppercase">{{ $order->payment_method }}</p>
                                            @if($order->notes)
                                                <p class="text-gray-500 mt-3 mb-1 text-xs font-bold uppercase tracking-wider">Catatan Pembeli</p>
                                                <p class="text-gray-700 italic bg-white p-2 rounded-lg border border-gray-100">"{{ $order->notes }}"</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="p-5">
                                    @foreach($order->items as $item)
                                        <div class="flex justify-between items-start mb-4 pb-4 border-b border-gray-100 last:border-0 last:mb-0 last:pb-0">
                                            <div>
                                                <p class="font-bold text-gray-900 text-base">{{ $item->product->name ?? 'Nama Produk' }}</p>
                                                <p class="text-sm text-gray-500 mb-3">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                                
                                                <!-- Logika Menampilkan Tombol Ulasan atau Label Ulasan Terkirim -->
                                                @if(strtolower($order->status) === 'selesai')
                                                    @php
                                                        // Pengecekan: Apakah produk INI pada pesanan INI sudah diulas?
                                                        $hasReviewed = \App\Models\Review::where('user_id', auth()->id())
                                                            ->where('product_id', $item->product->id ?? 0)
                                                            ->where('order_id', $order->id)
                                                            ->exists();
                                                    @endphp
                                                    
                                                    @if(!$hasReviewed)
                                                        <button type="button" @click="showReviewModal = true; productId = '{{ $item->product->id ?? '' }}'; productName = {{ json_encode($item->product->name ?? 'Produk') }}; orderId = '{{ $order->id }}'" class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 px-3 py-1.5 rounded-lg hover:bg-emerald-100 hover:text-emerald-700 transition shadow-sm">
                                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                                            Beri Ulasan
                                                        </button>
                                                    @else
                                                        <span class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-500 bg-gray-50 border border-gray-100 px-3 py-1.5 rounded-lg shadow-sm">
                                                            <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                                            Ulasan Terkirim
                                                        </span>
                                                    @endif
                                                @endif
                                            </div>
                                            <p class="font-bold text-gray-900 mt-0.5">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <!-- Footer Total Belanja & Aksi Pesanan -->
                                <div class="bg-gray-50 px-5 py-4 border-t border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">
                                    
                                    <button @click="openOrder === {{ $order->id }} ? openOrder = null : openOrder = {{ $order->id }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition flex items-center gap-1">
                                        <span x-text="openOrder === {{ $order->id }} ? 'Tutup Detail' : 'Lihat Detail'"></span>
                                    </button>

                                    <div class="flex items-center gap-4 w-full md:w-auto justify-between md:justify-end">
                                        <div>
                                            <span class="text-sm text-gray-600 mr-2">Total Belanja:</span>
                                            <span class="text-lg font-black text-emerald-600">Rp {{ number_format($order->subtotal ?? 0, 0, ',', '.') }}</span>
                                        </div>

                                        <!-- TOMBOL KONFIRMASI PESANAN DITERIMA -->
                                        @if(strtolower($order->status) === 'dikirim')
                                            <form action="{{ route('buyer.orders.complete', $order->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <!-- PERBAIKAN WARNA TOMBOL DI SINI: diganti menjadi bg-emerald-600 -->
                                                <button type="submit" onclick="return confirm('Apakah Anda yakin pesanan sudah diterima dengan baik? Dana akan diteruskan ke penjual.')" class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold py-2 px-4 rounded-xl shadow-soft transition">
                                                    Pesanan Diterima
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Modal Ulasan (Tetap sama) -->
        <div x-show="showReviewModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showReviewModal" x-transition.opacity class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" @click="showReviewModal = false" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="showReviewModal" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
                    
                    <form :action="'/produk-detail/' + productId + '/ulasan'" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="order_id" :value="orderId">
                        
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                    <h3 class="text-xl font-bold text-gray-900 mb-1" id="modal-title">
                                        Beri Penilaian Produk
                                    </h3>
                                    <p class="text-sm text-gray-500 mb-5">Anda akan memberikan ulasan untuk produk <span class="font-bold text-emerald-600" x-text="productName"></span>.</p>
                                    
                                    <div class="mb-5 text-left">
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Bintang Penilaian <span class="text-red-500">*</span></label>
                                        <select name="rating" required class="w-full border-gray-200 bg-gray-50 rounded-xl shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm py-3 px-4">
                                            <option value="">-- Silakan Pilih Bintang --</option>
                                            <option value="5">⭐⭐⭐⭐⭐ (5/5) - Sangat Memuaskan</option>
                                            <option value="4">⭐⭐⭐⭐ (4/5) - Memuaskan</option>
                                            <option value="3">⭐⭐⭐ (3/5) - Cukup Baik</option>
                                            <option value="2">⭐⭐ (2/5) - Kurang Baik</option>
                                            <option value="1">⭐ (1/5) - Sangat Mengecewakan</option>
                                        </select>
                                    </div>

                                    <div class="mb-2 text-left">
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Tuliskan Pengalaman Anda <span class="text-red-500">*</span></label>
                                        <textarea name="comment" rows="4" required placeholder="Bagaimana kualitas produk ini menurut Anda? Tuliskan di sini..." class="w-full border-gray-200 bg-gray-50 rounded-xl shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm py-3 px-4"></textarea>
                                    </div>
                                    <div class="mb-4 text-left">
                                        <label for="review_photo" class="block text-sm font-bold text-gray-700 mb-2">Foto Ulasan (opsional)</label>
                                        <input id="review_photo" type="file" name="review_photo" accept="image/*" class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" />
                                        <p class="text-xs text-gray-500 mt-1">Unggah foto produk untuk mendukung ulasan Anda. Maksimal 4MB.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
                            <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-5 py-2.5 bg-emerald-600 text-base font-bold text-white hover:bg-emerald-700 focus:outline-none transition sm:ml-3 sm:w-auto sm:text-sm">
                                Kirim Ulasan
                            </button>
                            <button type="button" @click="showReviewModal = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-5 py-2.5 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 focus:outline-none transition sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
