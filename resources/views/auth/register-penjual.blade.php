<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Penjual - UMKM Sedayu</title>
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
<body class="bg-gray-50 text-dark font-sans antialiased min-h-screen flex flex-col justify-center py-10 sm:px-6 lg:px-8">

    <link rel="icon" href="{{ asset('logo.svg') }}" type="image/svg+xml">
    <div class="sm:mx-auto sm:w-full sm:max-w-md px-4">
        <a href="{{ url('/') }}" class="flex justify-center mb-6">
            <div class="w-12 h-12 bg-primary rounded-xl flex items-center justify-center text-white shadow-md">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
        </a>
        <h2 class="text-center text-2xl font-bold tracking-tight text-gray-900">Buka Toko Digital Anda</h2>
        <p class="mt-2 text-center text-sm text-gray-600">Bergabunglah dan jangkau lebih banyak pembeli di Sedayu.</p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-xl px-4">
        <div class="bg-white py-8 px-6 shadow-sm sm:rounded-2xl sm:px-10 border border-gray-100">
            <form action="{{ route('penjual.register') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- Section 1: Informasi Akun -->
                <div>
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 border-b pb-2">1. Informasi Pemilik</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap (Sesuai KTP)</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-50 border p-2.5 text-sm focus:border-primary focus:ring-primary outline-none transition">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-50 border p-2.5 text-sm focus:border-primary focus:ring-primary outline-none transition">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                                <input type="password" name="password" id="password" required class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-50 border p-2.5 text-sm focus:border-primary focus:ring-primary outline-none transition">
                                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Ulangi Kata Sandi</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" required class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-50 border p-2.5 text-sm focus:border-primary focus:ring-primary outline-none transition">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Informasi Usaha -->
                <div class="pt-4">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 border-b pb-2">2. Profil Usaha (UMKM)</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="umkm_name" class="block text-sm font-medium text-gray-700">Nama Usaha / Toko</label>
                            <input type="text" name="umkm_name" id="umkm_name" value="{{ old('umkm_name') }}" required class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-50 border p-2.5 text-sm focus:border-primary focus:ring-primary outline-none transition">
                            @error('umkm_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori Usaha</label>
                                <select name="category_id" id="category_id" required class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-50 border p-2.5 text-sm focus:border-primary focus:ring-primary outline-none transition">
                                    <option value="" disabled selected>-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="whatsapp_number" class="block text-sm font-medium text-gray-700">Nomor WhatsApp Aktif</label>
                                <div class="relative mt-1 rounded-md shadow-sm">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 text-sm pointer-events-none">+62</span>
                                    <input type="text" name="whatsapp_number" id="whatsapp_number" value="{{ old('whatsapp_number') }}" placeholder="81234567890" required class="block w-full rounded-lg border-gray-300 bg-gray-50 border p-2.5 pl-10 text-sm focus:border-primary focus:ring-primary outline-none transition">
                                </div>
                                <p class="text-[10px] text-gray-500 mt-1">Isi tanpa awalan 0, contoh: 812...</p>
                                @error('whatsapp_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700">Foto Profil Toko</label>
                            <div class="mt-1 flex items-center gap-4">
                                <div class="w-20 h-20 rounded-2xl border border-dashed border-gray-300 bg-gray-50 overflow-hidden flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <input type="file" name="image" id="image" accept="image/*" class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                            </div>
                            <p class="text-[11px] text-gray-500 mt-1">Opsional. Upload foto toko agar langsung tampil di dashboard dan halaman toko.</p>
                            @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- ---------------- BAGIAN ALAMAT & LINK MAPS ---------------- -->
                        <div>
                            <h4 class="block text-sm font-medium text-gray-700 mb-2">Lokasi Usaha <span class="text-red-500">*</span></h4>
                            
                            <div class="space-y-3 p-4 bg-gray-50 border border-gray-200 rounded-xl">
                                <!-- Input Teks Alamat -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Jalan / Patokan (Tampil di Web)</label>
                                    <input type="text" id="alamat_teks" required placeholder="Contoh: Pertigaan Cengang Kidul, Desa Sedayu..." class="block w-full rounded-lg border-gray-300 bg-white border p-2.5 text-sm focus:border-primary focus:ring-primary outline-none transition">
                                </div>

                                <!-- Input Link Maps -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Link Google Maps (Tujuan saat diklik)</label>
                                    <input type="url" id="alamat_link" placeholder="Paste link share dari Google Maps (https://maps.app.goo.gl/...)" class="block w-full rounded-lg border-gray-300 bg-white border p-2.5 text-sm focus:border-primary focus:ring-primary outline-none transition">
                                    <p class="text-[10px] text-gray-500 mt-1">Buka aplikasi Google Maps > Cari lokasi Anda > Klik Bagikan (Share) > Salin Tautan (Copy Link), lalu paste di sini.</p>
                                </div>
                                
                                <!-- Input Tersembunyi (Dikirim ke Database) -->
                                <input type="hidden" name="address" id="address_real" value="{{ old('address') }}">
                            </div>
                            @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <!-- ----------------------------------------------------------- -->
                        
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-primary hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition">
                        Daftarkan Usaha Saya
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Sudah memiliki akun? 
                    <a href="{{ route('login') }}" class="font-semibold text-primary hover:text-green-600 transition">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Script Penggabung Alamat dan Link -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const inputTeks = document.getElementById('alamat_teks');
            const inputLink = document.getElementById('alamat_link');
            const inputReal = document.getElementById('address_real');

            function syncAddress() {
                // Gabungkan teks dan link dengan pemisah khusus " ||| "
                let teks = inputTeks.value.trim();
                let link = inputLink.value.trim();
                
                if(link !== "") {
                    inputReal.value = teks + " ||| " + link;
                } else {
                    inputReal.value = teks;
                }
            }

            // Jalankan fungsi setiap kali penjual mengetik/paste
            inputTeks.addEventListener('input', syncAddress);
            inputLink.addEventListener('input', syncAddress);
        });
    </script>
</body>
</html>
