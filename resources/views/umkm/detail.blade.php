<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $umkm->name }} - UMKM Sedayu</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
<body class="bg-gray-50 text-dark font-sans pb-24 antialiased">

    <!-- 1. Header dengan Tombol Kembali -->
    <header class="fixed top-0 w-full bg-white/80 backdrop-blur-md z-50 px-4 py-4 shadow-sm flex items-center gap-3">
        <a href="{{ url('/') }}" class="bg-gray-100 p-2 rounded-full text-gray-600 hover:text-primary transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <h1 class="text-lg font-bold truncate">{{ $umkm->name }}</h1>
    </header>

    <!-- 2. Cover Image -->
    <div class="w-full h-64 bg-gray-300 mt-16 relative">
        <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=800&q=80" alt="{{ $umkm->name }}" class="w-full h-full object-cover">
        <div class="absolute bottom-0 w-full h-1/2 bg-gradient-to-t from-black/60 to-transparent"></div>
    </div>

    <!-- 3. Informasi Utama UMKM -->
    <div class="px-4 py-5 bg-white -mt-4 relative z-10 rounded-t-2xl shadow-sm border-b border-gray-100">
        <div class="flex justify-between items-start mb-2">
            <div>
                <span class="inline-block px-2.5 py-1 bg-green-100 text-primary text-[11px] font-bold rounded-md mb-2">
                    {{ $umkm->category->name }}
                </span>
                <h2 class="text-2xl font-bold leading-tight mb-1">{{ $umkm->name }}</h2>
                <p class="text-sm text-gray-500 font-medium flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    {{ $umkm->address }}
                </p>
            </div>
        </div>
        
        <div class="mt-4">
            <h3 class="text-sm font-semibold mb-2">Deskripsi Usaha</h3>
            <p class="text-sm text-gray-600 leading-relaxed">
                {{ $umkm->description ?? 'UMKM ini merupakan salah satu usaha kebanggaan Desa Sedayu. Menyediakan produk berkualitas tinggi yang dibuat langsung oleh warga setempat.' }}
            </p>
            <p class="text-sm text-gray-600 leading-relaxed mt-2">
                <strong>Pemilik:</strong> {{ $umkm->owner_name }}
            </p>
        </div>
    </div>

    <!-- 4. Katalog / Produk Dummy -->
    <div class="px-4 py-6">
        <h3 class="text-lg font-bold mb-4">Katalog Produk</h3>
        
        <!-- Grid Produk -->
        <div class="grid grid-cols-2 gap-3">
            <!-- Contoh Card Produk Dummy 1 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="h-32 bg-gray-200">
                    <img src="https://images.unsplash.com/photo-1596870230751-ebdfce98ec42?auto=format&fit=crop&w=300&q=80" alt="Produk 1" class="w-full h-full object-cover">
                </div>
                <div class="p-3">
                    <h4 class="text-xs font-semibold text-dark mb-1 line-clamp-2">Celana Merah Pendek Anak Laki-Laki (Kasual)</h4>
                    <p class="text-primary font-bold text-sm">Rp 45.000</p>
                </div>
            </div>

            <!-- Contoh Card Produk Dummy 2 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="h-32 bg-gray-200">
                    <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?auto=format&fit=crop&w=300&q=80" alt="Produk 2" class="w-full h-full object-cover">
                </div>
                <div class="p-3">
                    <h4 class="text-xs font-semibold text-dark mb-1 line-clamp-2">Kaus Katun Combed Premium (Berbagai Warna)</h4>
                    <p class="text-primary font-bold text-sm">Rp 60.000</p>
                </div>
            </div>
            
            <!-- Contoh Card Produk Dummy 3 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="h-32 bg-gray-200">
                    <img src="https://images.unsplash.com/photo-1581655353564-df123a1eb820?auto=format&fit=crop&w=300&q=80" alt="Produk 3" class="w-full h-full object-cover">
                </div>
                <div class="p-3">
                    <h4 class="text-xs font-semibold text-dark mb-1 line-clamp-2">Setelan Harian Nyaman</h4>
                    <p class="text-primary font-bold text-sm">Rp 85.000</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. Floating Bottom Button (Call to Action WhatsApp) -->
    @php
        $pesan = "Halo " . $umkm->owner_name . " (" . $umkm->name . "), saya melihat usaha Anda di website UMKM Sedayu dan tertarik untuk melakukan pemesanan atau bertanya lebih lanjut mengenai produk Anda.";
        $waLink = "https://wa.me/" . $umkm->whatsapp_number . "?text=" . urlencode($pesan);
    @endphp
    
    <div class="fixed bottom-0 w-full bg-white border-t border-gray-100 p-4 z-50 shadow-[0_-4px_15px_-3px_rgba(0,0,0,0.1)]">
        <a href="{{ $waLink }}" target="_blank" class="w-full bg-[#25D366] hover:bg-[#1ebd5a] text-white font-bold py-3.5 rounded-xl flex items-center justify-center gap-2 transition shadow-md">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 0C5.394 0 0 5.394 0 12.031c0 2.146.561 4.238 1.624 6.079L.304 23.696l5.748-1.506c1.77.989 3.774 1.512 5.86 1.512 6.637 0 12.031-5.394 12.031-12.031C23.943 5.394 18.549 0 12.031 0zm0 21.656c-1.802 0-3.571-.484-5.116-1.4l-.367-.217-3.8.995 1.015-3.705-.239-.379c-1.004-1.597-1.533-3.447-1.533-5.378 0-5.513 4.486-9.999 9.999-9.999 5.514 0 9.999 4.486 9.999 9.999 0 5.513-4.485 9.999-9.999 9.999zm5.492-7.518c-.301-.151-1.782-.879-2.058-.98-.276-.101-.478-.151-.679.151-.201.302-.779.98-.955 1.181-.176.201-.352.226-.653.075-2.031-1.025-3.342-1.921-4.629-3.804-.176-.251-.019-.387.132-.538.135-.135.302-.352.453-.528.151-.176.201-.301.302-.502.101-.201.05-.377-.025-.528-.075-.151-.679-1.635-.93-2.239-.245-.589-.494-.509-.679-.519-.176-.01-.378-.01-.579-.01-.201 0-.528.075-.804.377-.276.302-1.055 1.031-1.055 2.515 0 1.484 1.08 2.917 1.231 3.118.151.201 2.127 3.249 5.154 4.557 2.05.885 2.76.755 3.287.63.606-.145 1.782-.729 2.033-1.433.251-.704.251-1.308.176-1.433-.075-.126-.276-.201-.577-.352z"/></svg>
            Hubungi Penjual via WhatsApp
        </a>
    </div>

</body>
</html>