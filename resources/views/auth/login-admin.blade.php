<x-app-layout>
    <x-slot name="title">Login Admin - Desa Makét</x-slot>

    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 flex items-center justify-center p-6">
        <div class="max-w-md w-full">
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-12 text-center text-white">
                    <div class="mx-auto w-20 h-20 bg-white rounded-2xl flex items-center justify-center text-5xl mb-4 shadow-inner">
                        🖥️
                    </div>
                    <h2 class="text-3xl font-bold">Petugas Administrasi</h2>
                    <p class="text-blue-100 mt-1">Admin Desa Makét</p>
                </div>

                <div class="p-8">
                    <form method="POST" action="{{ route('login.admin.post') }}">
                        @csrf

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Username / Email</label>
                                <input type="text" name="username" required value="{{ old('username') }}"
                                       placeholder="admin@desa.local atau admin"
                                       class="w-full px-5 py-4 border border-gray-300 rounded-2xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
                                @error('username')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                                <input type="password" name="password" required
                                       class="w-full px-5 py-4 border border-gray-300 rounded-2xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
                                <p class="text-xs text-gray-500 mt-2">Demo: admin@desa.local / admin123</p>
                            </div>

                            <button type="submit"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 rounded-2xl text-lg transition shadow-md">
                                MASUK SEBAGAI ADMIN
                            </button>
                        </div>
                    </form>

                    <div class="mt-8 text-center">
                        <a href="{{ route('dashboard') }}" 
                           class="text-gray-500 hover:text-blue-600 flex items-center justify-center gap-2">
                            ← Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
