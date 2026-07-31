<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="lg:-ml-64">
                <div class="space-y-6 lg:pl-8">
                    <main class="space-y-6">
                    <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-6">
                        <h4 class="text-lg font-bold mb-4">Informasi Akun</h4>
                        <div class="max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-6">
                        <h4 class="text-lg font-bold mb-4">Ubah Kata Sandi</h4>
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-6">
                        <h4 class="text-lg font-bold mb-4">Hapus Akun</h4>
                        <div class="max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</x-app-layout>