<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - UMKM Sedayu</title>
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
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <a href="{{ url('/') }}" class="w-9 h-9 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-600 hover:text-primary transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <h1 class="text-xl font-extrabold text-gray-900">Keranjang Belanja</h1>
            </div>
            <span class="text-xs font-semibold bg-emerald-100 text-primary px-3 py-1.5 rounded-full">{{ $totalItems }} item</span>
        </div>

        @if(session('success'))
            <div class="mb-4 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 px-4 py-3 text-sm font-medium">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="mb-4 rounded-xl bg-red-50 text-red-700 border border-red-200 px-4 py-3 text-sm font-medium">{{ session('error') }}</div>
        @endif

        @if(empty($cartItems))
            <div class="bg-white rounded-2xl border border-gray-100 p-10 text-center">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2m0 0L7 13h10l3-8H5.4M7 13l-1 5h12m-9 3a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"></path></svg>
                <h2 class="font-bold text-gray-900 mb-1">Keranjang masih kosong</h2>
                <p class="text-sm text-gray-500 mb-5">Yuk, tambahkan produk dari toko UMKM favoritmu.</p>
                <a href="{{ url('/') }}" class="inline-flex bg-primary hover:bg-emerald-600 text-white text-sm font-bold px-5 py-2.5 rounded-xl transition">Lanjut Belanja</a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cartItems as $item)
                        <div class="bg-white rounded-2xl border border-gray-100 p-4 flex gap-4">
                            <div class="w-24 h-24 rounded-xl overflow-hidden bg-gray-100 shrink-0">
                                @if($item['image'])
                                    <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16"></path></svg>
                                    </div>
                                @endif
                            </div>

                            <div class="flex-1">
                                <p class="text-[11px] text-emerald-600 font-semibold mb-1">{{ $item['umkm_name'] }}</p>
                                <h3 class="font-bold text-gray-900 leading-snug">{{ $item['name'] }}</h3>
                                <p class="text-sm text-primary font-extrabold mt-1">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                <p class="text-[11px] text-gray-500 mt-1">Stok tersedia: {{ $item['stock'] }}</p>

                                <div class="mt-3 flex items-center justify-between gap-3">
                                    <form action="{{ route('cart.update', $item['product_id']) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" min="0" max="{{ $item['stock'] }}" value="{{ $item['quantity'] }}" class="w-20 rounded-lg border-gray-300 bg-gray-50 border p-2 text-sm" />
                                        <button type="submit" class="text-xs font-bold bg-emerald-50 text-emerald-700 px-3 py-2 rounded-lg hover:bg-emerald-100 transition">Update</button>
                                    </form>

                                    <form action="{{ route('cart.remove', $item['product_id']) }}" method="POST" onsubmit="return confirm('Hapus produk dari keranjang?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-bold bg-red-50 text-red-600 px-3 py-2 rounded-lg hover:bg-red-100 transition">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <aside class="bg-white rounded-2xl border border-gray-100 p-5 h-fit sticky top-5">
                    <h3 class="font-bold text-gray-900 mb-4">Ringkasan Belanja</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between text-gray-600">
                            <span>Total Item</span>
                            <span>{{ $totalItems }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="border-t pt-3 flex justify-between font-extrabold text-gray-900">
                            <span>Total Bayar</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <a href="{{ route('cart.checkout') }}" class="mt-5 w-full inline-flex justify-center bg-primary hover:bg-emerald-600 text-white font-bold text-sm py-3 rounded-xl transition">Lanjut Checkout</a>
                    <a href="{{ url('/') }}" class="mt-2 w-full inline-flex justify-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-sm py-3 rounded-xl transition">Tambah Produk Lagi</a>
                </aside>
            </div>
        @endif
    </div>
</body>
</html>
