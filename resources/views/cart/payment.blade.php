<x-guest-layout>
    <div class="py-12 bg-gray-50 min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full bg-white p-8 rounded-2xl shadow-sm border border-gray-100 text-center mx-4">
            
            <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>

            <h2 class="text-2xl font-bold text-gray-900 mb-2">Selesaikan Pembayaran Anda</h2>
            <p class="text-gray-500 mb-2">Pesanan <span class="font-semibold text-gray-800">{{ $order->order_code }}</span> telah dibuat.</p>
            <p class="text-gray-500 mb-8">Total Tagihan: <span class="font-bold text-emerald-600 text-lg">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span></p>
            
            <button id="pay-button" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3.5 px-8 rounded-xl transition shadow-sm text-sm">
                Pilih Metode Pembayaran
            </button>
            <p class="text-xs text-gray-400 mt-4">Mendukung Transfer Bank, e-Wallet, dan QRIS.</p>
        </div>
    </div>

    <!-- Script Midtrans Snap (Sandbox) -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script type="text/javascript">
        // Ketika tombol ditekan, panggil Snap Popup
        document.getElementById('pay-button').onclick = function(){
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    // Jika pembayaran sukses, arahkan ke halaman sukses
                    window.location.href = "{{ route('cart.success') }}";
                },
                onPending: function(result){
                    alert("Menunggu pembayaran Anda!");
                },
                onError: function(result){
                    alert("Pembayaran gagal!");
                },
                onClose: function(){
                    alert('Anda menutup layar sebelum menyelesaikan pembayaran. Silakan klik tombol kembali untuk membayar.');
                }
            });
        };
    </script>
</x-guest-layout>