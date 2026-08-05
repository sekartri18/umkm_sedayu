<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('produk.index') }}" class="text-gray-500 hover:text-gray-700 bg-gray-100 hover:bg-gray-200 p-2 rounded-full transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tambah Produk Baru
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6 sm:p-8">
                    
                    <div class="mb-6 border-b border-gray-100 pb-4">
                        <h3 class="text-lg font-bold text-gray-900">Detail Produk</h3>
                        <p class="text-sm text-gray-500">Masukkan informasi detail mengenai produk yang ingin Anda jual. Pastikan foto yang diunggah menarik dan jelas.</p>
                    </div>

                    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- 1. Nama Produk -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full rounded-lg border-gray-300 bg-gray-50 border p-2.5 text-sm focus:border-emerald-500 focus:ring-emerald-500 outline-none transition">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- 2. Harga & Stok Produk (Dibariskan sejajar) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 text-sm font-medium">Rp</span>
                                    <input type="number" name="price" id="price" value="{{ old('price') }}" min="0" required class="w-full rounded-lg border-gray-300 bg-gray-50 border p-2.5 pl-10 text-sm focus:border-emerald-500 focus:ring-emerald-500 outline-none transition">
                                </div>
                                @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stok Awal <span class="text-red-500">*</span></label>
                                <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}" min="0" placeholder="Contoh: 50" required class="w-full rounded-lg border-gray-300 bg-gray-50 border p-2.5 text-sm focus:border-emerald-500 focus:ring-emerald-500 outline-none transition">
                                @error('stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- 3. Deskripsi Produk -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Produk</label>
                            <textarea name="description" id="description" rows="4" class="w-full rounded-lg border-gray-300 bg-gray-50 border p-2.5 text-sm focus:border-emerald-500 focus:ring-emerald-500 outline-none transition resize-none">{{ old('description') }}</textarea>
                            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- 4. Upload Foto Produk -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Katalog Produk</label>
                            
                            <div class="mt-1 flex flex-col items-center justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-emerald-400 hover:bg-emerald-50 transition relative overflow-hidden bg-gray-50">
                                
                                <!-- Tampilan sebelum foto dipilih -->
                                <div id="uploadUI" class="space-y-1 text-center flex flex-col items-center">
                                    <svg class="mx-auto h-10 w-10 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <p class="text-sm text-gray-600 font-medium mt-2">Pilih Foto atau Drag & Drop</p>
                                    <p class="text-xs text-gray-500">PNG, JPG, WEBP hingga 4MB</p>
                                </div>

                                <!-- Indikator saat foto berhasil dipilih -->
                                <div id="filePreview" class="hidden text-center z-10">
                                    <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <p class="text-sm font-bold text-emerald-600">Foto Siap Diunggah!</p>
                                    <p id="fileName" class="text-xs text-gray-600 mt-1"></p>
                                    <p class="text-[10px] text-gray-400 mt-2">(Klik area ini jika ingin mengganti foto)</p>
                                </div>

                                <!-- Input File -->
                                <input type="file" id="imageInput" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" accept="image/png, image/jpeg, image/jpg, image/webp">
                            </div>
                            @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Tombol Submit -->
                        <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                            <a href="{{ route('produk.index') }}" class="bg-white border border-gray-300 text-gray-700 py-2.5 px-6 rounded-lg font-bold hover:bg-gray-50 transition">Batal</a>
                            <button type="submit" class="bg-emerald-500 text-white py-2.5 px-6 rounded-lg font-bold shadow-sm hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition">
                                Simpan Produk
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Script untuk menampilkan nama file yang dipilih -->
    <script>
        const imageInput = document.getElementById('imageInput');
        const uploadUI = document.getElementById('uploadUI');
        const filePreview = document.getElementById('filePreview');
        const fileNameDisplay = document.getElementById('fileName');

        imageInput.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                // Sembunyikan ikon awal, tampilkan status sukses
                uploadUI.classList.add('hidden');
                filePreview.classList.remove('hidden');
                // Tampilkan nama file
                fileNameDisplay.textContent = e.target.files[0].name;
            } else {
                // Kembalikan ke tampilan awal jika batal memilih
                uploadUI.classList.remove('hidden');
                filePreview.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
