<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Kategori UMKM
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">
            
            <!-- Form Tambah Kategori -->
            <div class="w-full md:w-1/3">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-4">Tambah Kategori Baru</h3>
                    
                    @if(session('error'))
                        <div class="bg-red-50 text-red-600 p-3 rounded-lg text-sm mb-4">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('admin.category.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                            <input type="text" name="name" required class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm" placeholder="Contoh: Pertanian">
                        </div>
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ikon / Emoji</label>
                            <input type="text" name="icon" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm" placeholder="Contoh: 🌾">
                            <p class="text-xs text-gray-500 mt-1">Gunakan Windows + Titik (.) untuk memunculkan emoji.</p>
                        </div>
                        <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2 px-4 rounded-lg transition">Simpan Kategori</button>
                    </form>
                </div>
            </div>

            <!-- Tabel Daftar Kategori -->
            <div class="w-full md:w-2/3">
                @if(session('success'))
                    <div class="bg-green-50 text-green-700 p-3 rounded-lg text-sm mb-4">{{ session('success') }}</div>
                @endif

                <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="py-3 px-6 text-sm font-bold text-gray-600">Ikon</th>
                                <th class="py-3 px-6 text-sm font-bold text-gray-600">Nama Kategori</th>
                                <th class="py-3 px-6 text-sm font-bold text-gray-600 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($categories as $category)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-3 px-6 text-2xl">{{ $category->icon ?? '📦' }}</td>
                                    <td class="py-3 px-6 font-semibold text-gray-900">{{ $category->name }}</td>
                                    <td class="py-3 px-6 flex justify-end gap-2">
                                        <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-xs bg-red-100 text-red-600 hover:bg-red-200 px-3 py-1.5 rounded-lg font-bold transition">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-8 text-center text-gray-500">Belum ada kategori yang ditambahkan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
