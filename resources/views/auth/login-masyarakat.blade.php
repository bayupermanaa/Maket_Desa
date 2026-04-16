<x-app-layout>
    <x-slot name="title">Login Masyarakat - Desa Makét</x-slot>

    <div class="min-h-screen bg-gradient-to-br from-orange-50 to-amber-50 flex items-center justify-center p-6">
        <div class="max-w-md w-full">
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                
                <!-- Header -->
                <div class="bg-gradient-to-r from-orange-600 to-amber-500 px-8 py-12 text-center text-white">
                    <div class="mx-auto w-20 h-20 bg-white rounded-2xl flex items-center justify-center text-5xl mb-4 shadow-inner">
                        👤
                    </div>
                    <h2 class="text-3xl font-bold">Masyarakat</h2>
                    <p class="text-orange-100 mt-1">Warga Desa Makét</p>
                </div>

                <!-- Form -->
                <div class="p-8">
                   <form method="POST" action="{{ route('login.masyarakat.post') }}">
    @csrf

    <div class="space-y-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">NIK atau Email</label>
            <input type="text" 
                   name="nik_email" 
                   required
                   class="w-full px-5 py-4 border border-gray-300 rounded-2xl focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
            <input type="password" 
                   name="password" 
                   required
                   class="w-full px-5 py-4 border border-gray-300 rounded-2xl focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100">
        </div>

        <button type="submit"
                class="w-full bg-orange-600 hover:bg-orange-700 text-white font-semibold py-4 rounded-2xl text-lg transition">
            MASUK SEBAGAI MASYARAKAT
        </button>
    </div>
</form>

                    <div class="mt-8 text-center">
                        <a href="{{ route('dashboard') }}" 
                           class="text-gray-500 hover:text-orange-600 flex items-center justify-center gap-2">
                            ← Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>