<x-seller-layout>
    <x-slot name="header">Pengaturan Toko</x-slot>

    <div class="max-w-4xl">
        <!-- Alert Sukses -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-8">
            <div class="p-6 sm:p-8 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-900">Profil & Keamanan Akun</h3>
                <p class="text-sm text-gray-500 mt-1">Kelola informasi toko dan tingkatkan keamanan akun Seller Anda di sini.</p>
            </div>

            <form action="{{ route('pengaturan.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- BAGIAN 1: PROFIL UTAMA -->
                <div class="p-6 sm:p-8 space-y-6">
                    <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider text-emerald-600 mb-2">1. Profil Utama</h4>
                    
                    <!-- Foto Profil Toko -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-4">Logo / Foto Toko</label>
                        <div class="flex items-center gap-6">
                            <div class="w-24 h-24 rounded-2xl bg-gray-50 border border-gray-200 overflow-hidden shrink-0 flex items-center justify-center text-gray-300">
                                @if($umkm->image)
                                    <img src="{{ asset('storage/' . $umkm->image) }}" alt="{{ $umkm->name }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                @endif
                            </div>
                            
                            <div class="flex-1">
                                <label for="imageInput" class="inline-flex items-center justify-center bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg text-sm font-bold cursor-pointer transition">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                    Pilih Foto Baru
                                    <input type="file" id="imageInput" name="image" class="hidden" accept="image/png, image/jpeg, image/jpg, image/webp">
                                </label>
                                <p class="text-xs text-gray-500 mt-2">Maksimal 4MB (PNG, JPG, WEBP).</p>
                                <p id="fileName" class="text-xs font-semibold text-emerald-600 mt-1 hidden"></p>
                                @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Toko <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $umkm->name) }}" required class="w-full rounded-lg border-gray-300 bg-gray-50 border p-2.5 text-sm focus:border-emerald-500 focus:ring-emerald-500 outline-none transition">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="whatsapp_number" class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp Aktif</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 text-sm font-bold">+62</span>
                                <input type="text" name="whatsapp_number" id="whatsapp_number" value="{{ old('whatsapp_number', $umkm->whatsapp_number) }}" placeholder="81234567890" class="w-full rounded-lg border-gray-300 bg-gray-50 border p-2.5 pl-12 text-sm focus:border-emerald-500 focus:ring-emerald-500 outline-none transition">
                            </div>
                            @error('whatsapp_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 2: LOKASI USAHA -->
                <div class="p-6 sm:p-8 space-y-6 border-t border-gray-100">
                    <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider text-emerald-600 mb-2">2. Lokasi Usaha</h4>
                    
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Nama Jalan / Patokan (Tampil di Web)</label>
                        <textarea name="address" id="address" rows="2" class="w-full rounded-lg border-gray-300 bg-gray-50 border p-2.5 text-sm focus:border-emerald-500 focus:ring-emerald-500 outline-none transition resize-none" placeholder="Contoh: Pertigaan Cengang Kidul, Desa Sedayu...">{{ old('address', $umkm->address) }}</textarea>
                        @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="maps_link" class="block text-sm font-medium text-gray-700 mb-1">Link Google Maps (Tujuan saat diklik)</label>
                        <input type="url" name="maps_link" id="maps_link" value="{{ old('maps_link', $umkm->maps_link) }}" class="w-full rounded-lg border-gray-300 bg-gray-50 border p-2.5 text-sm focus:border-emerald-500 focus:ring-emerald-500 outline-none transition" placeholder="Paste link share dari Google Maps (https://maps.app.goo.gl/...)">
                        <p class="text-[11px] text-gray-500 mt-1">Buka aplikasi Google Maps > Cari lokasi Anda > Klik Bagikan (Share) > Salin Tautan (Copy Link), lalu paste di sini.</p>
                        @error('maps_link') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- BAGIAN 3: KEAMANAN AKUN (GANTI KATA SANDI) -->
                <div class="p-6 sm:p-8 space-y-6 border-t border-gray-100 bg-gray-50/50">
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider text-emerald-600">3. Keamanan Akun</h4>
                        <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika Anda tidak ingin mengganti kata sandi.</p>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Saat Ini</label>
                            <input type="password" name="current_password" id="current_password" class="w-full md:w-2/3 rounded-lg border-gray-300 bg-white border p-2.5 text-sm focus:border-emerald-500 focus:ring-emerald-500 outline-none transition">
                            @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Baru</label>
                                <input type="password" name="password" id="password" class="w-full rounded-lg border-gray-300 bg-white border p-2.5 text-sm focus:border-emerald-500 focus:ring-emerald-500 outline-none transition">
                                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Ulangi Kata Sandi Baru</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full rounded-lg border-gray-300 bg-white border p-2.5 text-sm focus:border-emerald-500 focus:ring-emerald-500 outline-none transition">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TOMBOL SUBMIT -->
                <div class="bg-gray-50 px-6 py-5 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="bg-emerald-500 text-white py-2.5 px-8 rounded-lg font-bold shadow-sm hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition">
                        Simpan Semua Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Preview Nama File -->
    <script>
        const imageInput = document.getElementById('imageInput');
        const fileNameDisplay = document.getElementById('fileName');

        imageInput.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                fileNameDisplay.textContent = 'File dipilih: ' + e.target.files[0].name;
                fileNameDisplay.classList.remove('hidden');
            } else {
                fileNameDisplay.textContent = '';
                fileNameDisplay.classList.add('hidden');
            }
        });
    </script>
</x-seller-layout>