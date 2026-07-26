<x-seller-layout>
    <x-slot name="header">Manajemen Produk</x-slot>

    <div class="flex justify-between items-center mb-6">
        <h3 class="font-bold text-lg text-gray-900">Daftar Katalog Anda</h3>
        <!-- Tombol ini sekarang memicu Pop-up Modal, bukan pindah halaman -->
        <button type="button" id="openModalBtn" class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg font-medium text-sm transition shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Produk Baru
        </button>
    </div>

    <!-- Menampilkan Alert Jika Sukses -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Logika Menampilkan Grid Produk -->
    @if($products->isEmpty())
        <div class="bg-white p-12 rounded-2xl border border-gray-100 shadow-sm text-center">
            <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
            </svg>
            <h3 class="mt-4 text-sm font-bold text-gray-900">Belum ada produk</h3>
            <p class="mt-1 text-sm text-gray-500">Mulai tambahkan produk pertama Anda agar pembeli bisa melihat katalog toko.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition flex flex-col">
                    
                    <!-- Area Gambar -->
                    <div class="h-48 bg-gray-50 relative border-b border-gray-100">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center w-full h-full text-gray-300">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Area Teks & Tombol -->
                    <div class="p-4 flex-grow flex flex-col">
                        <div class="flex items-start justify-between gap-2 mb-1">
                            <h4 class="font-bold text-gray-900 line-clamp-1" title="{{ $product->name }}">{{ $product->name }}</h4>
                            <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-full font-bold">Stok: {{ $product->stock }}</span>
                        </div>
                        <p class="text-emerald-600 font-bold text-sm mb-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-500 line-clamp-2 mb-4 flex-grow">{{ $product->description ?? 'Tidak ada deskripsi produk.' }}</p>
                        
                        <!-- Tombol Aksi (Edit & Hapus) -->
                        <div class="flex gap-2 mt-auto">
                            <a href="{{ route('produk.edit', $product->id) }}" class="flex-1 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 py-2 rounded-lg text-xs font-bold text-center transition">Edit</a>
                            
                            <form action="{{ route('produk.destroy', $product->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini dari etalase?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-50 text-red-600 hover:bg-red-100 py-2 rounded-lg text-xs font-bold text-center transition">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- ========================================== -->
    <!-- MODAL POP-UP: TAMBAH PRODUK BARU           -->
    <!-- ========================================== -->
    <div id="addProductModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Latar Belakang Gelap / Overlay -->
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity backdrop-blur-sm" id="modalOverlay"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <!-- Panel Modal -->
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-gray-100">
                
                <!-- Header Modal -->
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900" id="modal-title">Tambah Produk Baru</h3>
                        <p class="text-xs text-gray-500 mt-1">Lengkapi detail produk yang ingin Anda jual.</p>
                    </div>
                    <button type="button" id="closeModalBtn" class="text-gray-400 hover:text-gray-600 bg-white hover:bg-gray-100 p-2 rounded-full transition focus:outline-none">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <!-- Body Modal (Form) -->
                <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="px-6 py-5 space-y-5">
                        
                        <!-- Nama Produk -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full rounded-lg border-gray-300 bg-gray-50 border p-2.5 text-sm focus:border-emerald-500 focus:ring-emerald-500 outline-none transition" placeholder="Contoh: Baju Kemeja Pria">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Harga & Stok (Sejajar) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Input Harga dengan Format Otomatis -->
                            <div>
                                <label for="price_display" class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 text-sm font-medium">Rp</span>
                                    
                                    <!-- Input teks yang terlihat pengguna (dengan titik) -->
                                    <input type="text" id="price_display" value="{{ old('price') }}" required class="w-full rounded-lg border-gray-300 bg-gray-50 border p-2.5 pl-10 text-sm focus:border-emerald-500 focus:ring-emerald-500 outline-none transition" placeholder="45.000">
                                    
                                    <!-- Input tersembunyi (angka murni tanpa titik) untuk dikirim ke server -->
                                    <input type="hidden" name="price" id="price_hidden" value="{{ old('price') }}">
                                </div>
                                @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Input Stok -->
                            <div>
                                <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stok Awal <span class="text-red-500">*</span></label>
                                <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}" min="0" required class="w-full rounded-lg border-gray-300 bg-gray-50 border p-2.5 text-sm focus:border-emerald-500 focus:ring-emerald-500 outline-none transition">
                                @error('stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Produk</label>
                            <textarea name="description" id="description" rows="3" class="w-full rounded-lg border-gray-300 bg-gray-50 border p-2.5 text-sm focus:border-emerald-500 focus:ring-emerald-500 outline-none transition resize-none" placeholder="Tuliskan detail spesifikasi produk Anda di sini...">{{ old('description') }}</textarea>
                            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Upload Foto -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Katalog Produk</label>
                            <div class="mt-1 flex flex-col items-center justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-emerald-400 hover:bg-emerald-50 transition relative overflow-hidden bg-gray-50">
                                <div id="uploadUI" class="space-y-1 text-center flex flex-col items-center">
                                    <svg class="mx-auto h-8 w-8 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                    <p class="text-sm text-gray-600 font-medium mt-2">Pilih Foto atau Drag & Drop</p>
                                    <p class="text-[11px] text-gray-500">PNG, JPG, WEBP hingga 4MB</p>
                                </div>
                                <div id="filePreview" class="hidden text-center z-10">
                                    <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <p class="text-sm font-bold text-emerald-600">Foto Siap Diunggah!</p>
                                    <p id="fileName" class="text-xs text-gray-600 mt-1 truncate max-w-[200px]"></p>
                                </div>
                                <input type="file" id="imageInput" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" accept="image/png, image/jpeg, image/jpg, image/webp">
                            </div>
                            @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                    </div>
                    
                    <!-- Footer Modal -->
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end gap-3 rounded-b-2xl">
                        <button type="button" id="cancelModalBtn" class="bg-white border border-gray-300 text-gray-700 py-2 px-4 rounded-lg font-bold text-sm hover:bg-gray-50 transition focus:outline-none">Batal</button>
                        <button type="submit" class="bg-emerald-500 text-white py-2 px-6 rounded-lg font-bold text-sm shadow-sm hover:bg-emerald-600 transition focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">Simpan Produk</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Script Javascript Utama -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // 1. Logika Pop-up Modal
            const modal = document.getElementById('addProductModal');
            const openBtn = document.getElementById('openModalBtn');
            const closeBtn = document.getElementById('closeModalBtn');
            const cancelBtn = document.getElementById('cancelModalBtn');
            const overlay = document.getElementById('modalOverlay');

            function toggleModal() {
                modal.classList.toggle('hidden');
            }

            openBtn.addEventListener('click', toggleModal);
            closeBtn.addEventListener('click', toggleModal);
            cancelBtn.addEventListener('click', toggleModal);
            overlay.addEventListener('click', toggleModal); // Klik di luar box untuk menutup

            // 2. Logika Auto-Format Harga (Rupiah dengan titik)
            const priceDisplay = document.getElementById('price_display');
            const priceHidden = document.getElementById('price_hidden');

            priceDisplay.addEventListener('keyup', function(e) {
                // Hapus semua karakter selain angka
                let val = this.value.replace(/[^0-9]/g, ''); 
                
                if (val !== '') {
                    // Simpan angka murni ke input hidden untuk di-submit ke database
                    priceHidden.value = val;
                    // Format angka dengan titik pemisah ribuan standar Indonesia
                    this.value = new Intl.NumberFormat('id-ID').format(val);
                } else {
                    priceHidden.value = '';
                    this.value = '';
                }
            });

            // 3. Logika Preview Nama Foto
            const imageInput = document.getElementById('imageInput');
            const uploadUI = document.getElementById('uploadUI');
            const filePreview = document.getElementById('filePreview');
            const fileNameDisplay = document.getElementById('fileName');

            imageInput.addEventListener('change', function(e) {
                if (e.target.files.length > 0) {
                    uploadUI.classList.add('hidden');
                    filePreview.classList.remove('hidden');
                    fileNameDisplay.textContent = e.target.files[0].name;
                } else {
                    uploadUI.classList.remove('hidden');
                    filePreview.classList.add('hidden');
                }
            });
            
            // Periksa jika ada error form saat submit, modal harus otomatis terbuka kembali
            @if($errors->any())
                modal.classList.remove('hidden');
            @endif
        });
    </script>
</x-seller-layout>