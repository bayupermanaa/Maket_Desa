<x-app-layout>
    <x-slot name="title">Login - Desa Makét</x-slot>

    <div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
        <div class="max-w-md w-full bg-white rounded-3xl shadow-2xl overflow-hidden">
            
            <div class="bg-orange-600 px-8 py-10 text-center text-white">
                <div class="mx-auto w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-4xl mb-4">
                    🏘️
                </div>
                <h1 class="text-2xl font-bold">Desa Makét</h1>
                <p class="text-orange-100">Sistem Informasi Desa</p>
            </div>

            <div class="p-8 text-center">
                <h2 class="text-xl font-semibold text-gray-700 mb-6">Pilih Role Login</h2>
                
                <div class="space-y-4">
                    <a href="{{ route('login.masyarakat') }}" 
                       class="block w-full text-left px-6 py-4 border border-gray-300 rounded-2xl hover:border-orange-500 hover:bg-orange-50 transition flex items-center gap-4">
                        <span class="text-3xl">👤</span>
                        <div>
                            <div class="font-medium">Masyarakat</div>
                            <div class="text-sm text-gray-500">Login sebagai Warga Desa</div>
                        </div>
                    </a>

                    <a href="{{ route('login.admin') }}" 
                       class="block w-full text-left px-6 py-4 border border-gray-300 rounded-2xl hover:border-blue-500 hover:bg-blue-50 transition flex items-center gap-4">
                        <span class="text-3xl">🖥️</span>
                        <div>
                            <div class="font-medium">Petugas Administrasi</div>
                            <div class="text-sm text-gray-500">Admin Desa</div>
                        </div>
                    </a>

                    <a href="{{ route('login.kepala-desa') }}" 
                       class="block w-full text-left px-6 py-4 border border-gray-300 rounded-2xl hover:border-emerald-500 hover:bg-emerald-50 transition flex items-center gap-4">
                        <span class="text-3xl">👑</span>
                        <div>
                            <div class="font-medium">Kepala Desa</div>
                            <div class="text-sm text-gray-500">Pimpinan Desa</div>
                        </div>
                    </a>
                </div>

                <div class="mt-8 text-sm text-gray-500">
                    <a href="{{ route('dashboard') }}" class="hover:text-orange-600">
                        ← Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>