<x-app-layout>
    <x-slot name="title">Login Kepala Desa - Desa Makét</x-slot>

    <div class="min-h-screen bg-gradient-to-br from-emerald-50 to-teal-50 flex items-center justify-center p-6">
        <div class="max-w-md w-full">
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                
                <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-8 py-12 text-center text-white">
                    <div class="mx-auto w-20 h-20 bg-white rounded-2xl flex items-center justify-center text-5xl mb-4 shadow-inner">
                        👑
                    </div>
                    <h2 class="text-3xl font-bold">Kepala Desa</h2>
                    <p class="text-emerald-100 mt-1">I Ketut Sumardana</p>
                </div>

                <div class="p-8">
                    <form method="POST" action="{{ route('login.kepala-desa.post') }}">
                        @csrf

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Username / Email</label>
                                <input type="text" name="username" required value="{{ old('username') }}"
                                       placeholder="kepala@desa.local atau kepala"
                                       class="w-full px-5 py-4 border border-gray-300 rounded-2xl focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                                @error('username')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                                <input type="password" name="password" required
                                       class="w-full px-5 py-4 border border-gray-300 rounded-2xl focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                                <p class="text-xs text-gray-500 mt-2">Demo: kepala@desa.local / kepala123</p>
                            </div>

                            <button type="submit"
                                    class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-4 rounded-2xl text-lg transition shadow-md">
                                MASUK SEBAGAI KEPALA DESA
                            </button>
                        </div>
                    </form>

                    <div class="mt-8 text-center">
                        <a href="{{ route('dashboard') }}" 
                           class="text-gray-500 hover:text-emerald-600 flex items-center justify-center gap-2">
                            ← Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
