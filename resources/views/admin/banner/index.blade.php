<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Banner Depan</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">
            
            <!-- Form Upload Banner -->
            <div class="w-full md:w-1/3">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-4">Unggah Banner Baru</h3>
                    
                    @if(session('error'))
                        <div class="bg-red-50 text-red-600 p-3 rounded-lg text-sm mb-4">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Promosi (Opsional)</label>
                            <input type="text" name="title" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm" placeholder="Contoh: Diskon Kemerdekaan">
                        </div>
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-1">File Gambar Banner</label>
                            <input type="file" name="image" required accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                            <p class="text-[10px] text-gray-500 mt-1">Format: JPG/PNG/WEBP. Rasio rekomendasi 16:9 (Landscape).</p>
                        </div>
                        <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2 px-4 rounded-lg transition">Unggah Banner</button>
                    </form>
                </div>
            </div>

            <!-- Daftar Banner Aktif -->
            <div class="w-full md:w-2/3">
                @if(session('success'))
                    <div class="bg-green-50 text-green-700 p-3 rounded-lg text-sm mb-4">{{ session('success') }}</div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($banners as $banner)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative group">
                            <img src="{{ asset('storage/' . $banner->image) }}" class="w-full h-32 object-cover" alt="Banner">
                            <div class="p-3 flex justify-between items-center">
                                <span class="text-sm font-semibold text-gray-800">{{ $banner->title ?? 'Tanpa Judul' }}</span>
                                <form action="{{ route('admin.banner.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Hapus banner ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs bg-red-100 text-red-600 hover:bg-red-200 px-3 py-1.5 rounded-lg font-bold transition">Hapus</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-8 text-center bg-white rounded-2xl border border-gray-100 text-gray-500">
                            Belum ada banner yang diunggah.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>