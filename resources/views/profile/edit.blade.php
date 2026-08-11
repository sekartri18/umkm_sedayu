<x-buyer-layout>
    <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto">
        <div class="space-y-6">
            <main class="space-y-6">
                <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-6 w-full">
                    <h4 class="text-lg font-bold mb-4">Informasi Akun</h4>
                    <div class="w-full">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-6 w-full">
                    <h4 class="text-lg font-bold mb-4">Ubah Kata Sandi</h4>
                    <div class="w-full">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-6 w-full">
                    <h4 class="text-lg font-bold mb-4">Hapus Akun</h4>
                    <div class="w-full">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-buyer-layout>
