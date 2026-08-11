<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{ asset('logo.svg') }}" type="image/svg+xml">

        <title>{{ config('app.name', 'UMKM Sedayu') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900">
        <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">
            
            <!-- Memanggil File Sidebar -->
            @include('layouts.navigation')

            <!-- Area Konten Utama -->
            <div class="flex-1 flex flex-col overflow-hidden lg:ml-64">
                
                <!-- Navbar Atas (Profil & Tombol Mobile) -->
                <header class="bg-white shadow-sm border-b border-gray-100 z-10 no-print">
                    <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                        <!-- Mobile hamburger is rendered inside the navigation component to avoid duplicates -->
                        <div class="flex-1 lg:hidden"></div>

                        <!-- Dropdown Profil User (Posisi Kanan) -->
                        <div class="ml-auto flex items-center">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 transition focus:outline-none">
                                        <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold mr-2 shadow-sm">
                                            {{ substr(Auth::user()->name, 0, 1) }}
                                        </div>
                                        <div class="hidden sm:block">{{ Auth::user()->name }}</div>
                                        <div class="ml-1 hidden sm:block">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault(); this.closest('form').submit();">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
                </header>

                <!-- Area Konten (Bisa di-scroll) -->
                <main class="flex-1 overflow-y-auto bg-gray-50">
                    <!-- Judul Halaman -->
                    @if (isset($header))
                        <div class="bg-white shadow-sm border-b border-gray-100 no-print">
                            <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </div>
                    @endif

                    <!-- Isi Halaman -->
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
