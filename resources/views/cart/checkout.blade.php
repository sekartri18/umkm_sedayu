<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - UMKM Sedayu</title>
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
<body class="bg-gray-50 text-dark font-sans antialiased pb-10">
    <div class="max-w-5xl mx-auto px-4 py-6">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('cart.index') }}" class="w-9 h-9 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-600 hover:text-primary transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h1 class="text-xl font-extrabold text-gray-900">Checkout</h1>
        </div>

        @if($errors->any())
            <div class="mb-4 rounded-xl bg-red-50 text-red-700 border border-red-200 px-4 py-3 text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <form action="{{ route('cart.processCheckout') }}" method="POST" class="lg:col-span-2 bg-white border border-gray-100 rounded-2xl p-5 space-y-4">
                @csrf
                <h2 class="font-bold text-gray-900 text-lg">Informasi Penerima</h2>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" name="customer_name" value="{{ old('customer_name', auth()->user()->name ?? '') }}" class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-50 border p-2.5 text-sm" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nomor WhatsApp</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-50 border p-2.5 text-sm" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Alamat Pengiriman</label>
                    <textarea name="address" rows="3" class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-50 border p-2.5 text-sm" required>{{ old('address') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm">
                        <label class="border border-gray-200 rounded-lg px-3 py-2 flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="payment_method" value="cod" {{ old('payment_method', 'cod') === 'cod' ? 'checked' : '' }}>
                            Bayar di Tempat (COD)
                        </label>
                        <label class="border border-gray-200 rounded-lg px-3 py-2 flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="payment_method" value="transfer" {{ old('payment_method') === 'transfer' ? 'checked' : '' }}>
                            Transfer Bank
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                    <textarea name="notes" rows="2" class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-50 border p-2.5 text-sm">{{ old('notes') }}</textarea>
                </div>

                <button type="submit" class="w-full bg-primary hover:bg-emerald-600 text-white font-bold text-sm py-3 rounded-xl transition">Konfirmasi Checkout</button>
            </form>

            <aside class="bg-white rounded-2xl border border-gray-100 p-5 h-fit sticky top-5">
                <h3 class="font-bold text-gray-900 mb-3">Ringkasan Pesanan</h3>
                <div class="space-y-3 max-h-72 overflow-y-auto pr-1">
                    @foreach($cartItems as $item)
                        <div class="border border-gray-100 rounded-lg p-3">
                            <p class="text-[11px] text-emerald-600 font-semibold">{{ $item['umkm_name'] }}</p>
                            <p class="text-sm font-semibold text-gray-900 line-clamp-2">{{ $item['name'] }}</p>
                            <div class="flex justify-between text-xs text-gray-600 mt-1">
                                <span>{{ $item['quantity'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                                <span>Rp {{ number_format($item['quantity'] * $item['price'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 border-t pt-3 space-y-2">
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Total Item</span>
                        <span>{{ $totalItems }}</span>
                    </div>
                    <div class="flex justify-between text-sm font-extrabold text-gray-900">
                        <span>Total Bayar</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</body>
</html>
