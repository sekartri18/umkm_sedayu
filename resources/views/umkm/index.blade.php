<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - UMKM Sedayu</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: { fontFamily: { sans: ['Inter', 'sans-serif'] }, colors: { primary: '#10B981', dark: '#1F2937' } }
            }
        }
    </script>
    <!-- CSS khusus untuk optimasi cetak kertas -->
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background-color: white !important; }
            .print-table-container { box-shadow: none !important; border: none !important; padding: 0 !important; }
            table { width: 100% !important; border-collapse: collapse !important; }
            th, td { border: 1px solid #000 !important; padding: 12px 8px !important; color: #000 !important; }
            /* Memberikan ruang yang pas agar tabel nyaman dibaca secara fisik */
            tr { page-break-inside: avoid; }
        }
    </style>
</head>
<body class="bg-gray-100 text-dark font-sans antialiased">

    <div class="min-h-screen flex">
        <!-- Sidebar Navigation (Sembunyi saat dicetak) -->
        <aside class="w-64 bg-dark text-white flex flex-col no-print hidden md:flex">
            <div class="p-6 border-b border-gray-700">
                <h1 class="text-xl font-bold text-primary">Admin Sedayu</h1>
            </div>
            <nav class="flex-1 p-4">
                <a href="{{ route('admin.umkm.index') }}" class="block px-4 py-2.5 bg-gray-800 rounded-lg text-white font-medium mb-2">
                    Data UMKM
                </a>
                <a href="{{ url('/') }}" class="block px-4 py-2.5 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg transition">
                    Lihat Website
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 md:p-8">
            <div class="flex justify-between items-center mb-6 no-print">
                <h2 class="text-2xl font-bold text-gray-800">Kelola Data UMKM</h2>
                <div class="flex gap-3">
                    <button onclick="window.print()" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-medium transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Cetak Data
                    </button>
                    <a href="#" class="bg-primary hover:bg-green-600 text-white px-4 py-2 rounded-lg font-medium transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah UMKM
                    </a>
                </div>
            </div>

            <!-- Tabel Data -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden print-table-container">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="py-4 px-6 text-sm font-semibold text-gray-600 w-12 text-center">No</th>
                                <th class="py-4 px-6 text-sm font-semibold text-gray-600">Nama Usaha</th>
                                <th class="py-4 px-6 text-sm font-semibold text-gray-600">Pemilik</th>
                                <th class="py-4 px-6 text-sm font-semibold text-gray-600">Kategori</th>
                                <th class="py-4 px-6 text-sm font-semibold text-gray-600">No. WhatsApp</th>
                                <th class="py-4 px-6 text-sm font-semibold text-gray-600 text-right no-print">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($umkms as $index => $umkm)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-4 px-6 text-sm text-gray-700 text-center">{{ $index + 1 }}</td>
                                <td class="py-4 px-6 text-sm font-semibold text-gray-900">{{ $umkm->name }}</td>
                                <td class="py-4 px-6 text-sm text-gray-700">{{ $umkm->owner_name }}</td>
                                <td class="py-4 px-6 text-sm text-gray-700">
                                    <span class="bg-green-100 text-primary px-2.5 py-1 rounded-md text-xs font-medium">
                                        {{ $umkm->category->name }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-sm text-gray-700 font-medium">
                                    +{{ $umkm->whatsapp_number }}
                                </td>
                                <td class="py-4 px-6 text-sm text-right no-print">
                                    <div class="flex justify-end gap-2">
                                        <a href="#" class="text-blue-500 hover:text-blue-700 bg-blue-50 p-2 rounded-md transition">Edit</a>
                                        <a href="#" class="text-red-500 hover:text-red-700 bg-red-50 p-2 rounded-md transition">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            
                            @if($umkms->isEmpty())
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-500">Belum ada data UMKM.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>