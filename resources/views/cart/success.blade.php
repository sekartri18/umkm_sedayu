<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Berhasil - UMKM Sedayu</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: { primary: '#10B981', dark: '#1F2937' }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-dark font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center px-4 py-8">
    <link rel="icon" href="{{ asset('logo.svg') }}" type="image/svg+xml">
        <div class="max-w-2xl w-full bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8">
            <div class="w-14 h-14 rounded-full bg-emerald-100 text-primary flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>

            <h1 class="text-2xl font-extrabold text-center text-gray-900">Checkout Berhasil</h1>
            <p class="text-sm text-gray-500 text-center mt-2">Pesanan kamu sudah tercatat di sistem UMKM Sedayu.</p>

            <div class="mt-6 rounded-2xl border border-emerald-100 bg-emerald-50 p-4">
                <p class="text-xs text-gray-500">Kode Pesanan</p>
                <p class="text-lg font-extrabold text-primary">{{ $checkout['order_code'] }}</p>
                <p class="text-xs text-gray-500 mt-2">Waktu Checkout: {{ $checkout['checkout_at'] }}</p>
            </div>

            <div class="mt-5 space-y-2 text-sm">
                <div class="flex justify-between text-gray-600">
                    <span>Nama Penerima</span>
                    <span class="font-semibold text-gray-900">{{ $checkout['customer_name'] }}</span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>Total Item</span>
                    <span class="font-semibold text-gray-900">{{ $checkout['total_items'] }}</span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>Total Pembayaran</span>
                    <span class="font-semibold text-gray-900">Rp {{ number_format($checkout['subtotal'], 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>Metode</span>
                    <span class="font-semibold text-gray-900">{{ $checkout['payment_method'] === 'cod' ? 'COD' : 'Transfer Bank' }}</span>
                </div>
            </div>

            <div class="mt-7 grid grid-cols-1 sm:grid-cols-2 gap-3">
                <a href="{{ url('/') }}" class="text-center bg-primary hover:bg-emerald-600 text-white font-bold text-sm py-3 rounded-xl transition">Kembali ke Beranda</a>
                <a href="{{ route('cart.index') }}" class="text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-sm py-3 rounded-xl transition">Lihat Keranjang</a>
            </div>
        </div>
    </div>
</body>
</html>
