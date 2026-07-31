<div x-data="{ open: false }">
    <!-- CSS Pintar untuk menyesuaikan konten utama dengan lebar Sidebar -->
    <!-- (Agar kamu tidak perlu repot mengedit file layout lainnya!) -->
    <style>
        @media (min-width: 1024px) {
            main, header.bg-white {
                padding-left: 16rem !important; /* Menggeser selebar w-64 */
                transition: padding-left 0.3s ease-in-out;
            }
        }
    </style>

    <!-- 1. MOBILE TOPBAR (Hanya tampil di layar kecil / HP) -->
    <div class="lg:hidden bg-white border-b border-gray-100 px-4 py-3 flex justify-between items-center z-20 relative shadow-sm no-print">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-emerald-500 text-white flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9-4 9 4M4 10h16v10a1 1 0 01-1 1H5a1 1 0 01-1-1V10z"></path></svg>
            </div>
            <span class="font-extrabold text-emerald-600">UMKM Sedayu</span>
        </a>
        
        <!-- Tombol Hamburger Mobile -->
        <button @click="open = ! open" class="text-gray-500 hover:text-emerald-600 focus:outline-none transition bg-gray-50 p-2 rounded-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- 2. OVERLAY GELAP (Untuk Mobile saat sidebar terbuka) -->
    <div x-show="open" class="fixed inset-0 z-30 bg-gray-900 bg-opacity-50 transition-opacity lg:hidden" @click="open = false" style="display: none;"></div>

    <!-- 3. SIDEBAR UTAMA MODERN -->
    <nav :class="open ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-gray-100 flex flex-col justify-between transition-transform duration-300 transform lg:translate-x-0 no-print shadow-xl lg:shadow-none">
        
        <div class="overflow-y-auto">
            <!-- Logo Sidebar (PC / Desktop) -->
            <div class="hidden lg:flex items-center justify-center h-16 border-b border-gray-100 px-6 bg-white shrink-0">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 hover:scale-105 transition-transform">
                    <div class="w-8 h-8 rounded-lg bg-emerald-500 text-white flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9-4 9 4M4 10h16v10a1 1 0 01-1 1H5a1 1 0 01-1-1V10z"></path></svg>
                    </div>
                    <span class="text-lg font-extrabold text-emerald-600 tracking-tight">UMKM Sedayu</span>
                </a>
            </div>

            <!-- Daftar Link Menu Sidebar -->
            <div class="px-4 py-6 space-y-2">
                
                <!-- Menu Umum -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-emerald-50 text-emerald-600 font-bold shadow-sm border border-emerald-100' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>

                <!-- Menu Khusus Admin -->
                @if(Auth::user()->role === 'admin')
                    <div class="pt-6 pb-2">
                        <p class="px-4 text-[10px] font-black tracking-widest text-gray-400 uppercase">Menu Administrator</p>
                    </div>
                    
                    <a href="{{ route('admin.umkm.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->routeIs('admin.umkm.*') ? 'bg-emerald-50 text-emerald-600 font-bold shadow-sm border border-emerald-100' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Verifikasi UMKM
                    </a>

                    <!-- Catatan: Menu Manajemen Kategori sudah berhasil dihapus di sini -->

                    <a href="{{ route('admin.banner.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->routeIs('admin.banner.*') ? 'bg-emerald-50 text-emerald-600 font-bold shadow-sm border border-emerald-100' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Manajemen Banner
                    </a>

                    <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->routeIs('admin.orders.*') ? 'bg-emerald-50 text-emerald-600 font-bold shadow-sm border border-emerald-100' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Transaksi Global
                    </a>
                @endif
            </div>
        </div>

        @if(auth()->user()->role === 'pembeli' || auth()->user()->role === 'buyer')
            <div class="px-4 py-4 border-t border-gray-100 bg-gray-50">
                <p class="text-[10px] font-black tracking-widest text-gray-400 uppercase mb-3">Menu Pembeli</p>
                <a href="{{ route('buyer.orders') }}" class="flex w-full items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->routeIs('buyer.orders') ? 'bg-emerald-50 text-emerald-700 shadow-sm border border-emerald-100' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"></path></svg>
                    Pesanan Saya
                </a>
                <a href="{{ route('buyer.favorites') }}" class="mt-2 flex w-full items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->routeIs('buyer.favorites') ? 'bg-emerald-50 text-emerald-700 shadow-sm border border-emerald-100' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 20.682l-7.682-7.682a4.5 4.5 0 010-6.364z" /></svg>
                    Barang Favorit
                </a>
                <a href="#" class="mt-2 flex w-full items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 text-gray-500 hover:bg-gray-50 hover:text-gray-900">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16h6M4 7h16a2 2 0 012 2v7a2 2 0 01-2 2H4a2 2 0 01-2-2V9a2 2 0 012-2z" /></svg>
                    Chat Toko
                </a>
            </div>
        @endif

        <!-- Bagian Bawah Sidebar (Informasi Profil User & Tombol Keluar) -->
        <div class="px-4 py-5 border-t border-gray-100 bg-gray-50 shrink-0">
            <div class="flex items-center gap-3 px-4 py-3 mb-4 rounded-2xl bg-white border border-gray-200 shadow-sm">
                <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-base shadow-sm">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[11px] text-gray-500 truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <div class="space-y-3">
                <a href="{{ route('profile.edit') }}" class="flex w-full items-center gap-3 px-4 py-3 rounded-2xl bg-white border border-gray-200 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition font-medium justify-start">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    Pengaturan Profil
                </a>

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-start gap-3 px-4 py-3 rounded-2xl bg-white border border-red-100 text-sm text-red-600 hover:bg-red-50 transition font-medium">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </nav>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const setupDropdown = (btnId, menuId) => {
            const btn = document.getElementById(btnId);
            const menu = document.getElementById(menuId);
            if (!btn || !menu) return;
            btn.addEventListener('click', (e) => { e.stopPropagation(); menu.classList.toggle('hidden'); });
            document.addEventListener('click', (e) => {
                if (!btn.contains(e.target) && !menu.contains(e.target)) menu.classList.add('hidden');
            });
        };

        setupDropdown('tombolDaftarDesktop', 'menuDaftarDesktop');
        setupDropdown('tombolDaftarMobile', 'menuDaftarMobile');
    });
</script>