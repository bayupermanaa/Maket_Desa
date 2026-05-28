<x-app-layout>
    <!-- Hero Section Full ke Atas -->
     <section class="relative min-h-screen bg-gradient-to-r from-blue-700 to-blue-500 text-white flex items-center">

        <div class="container mx-auto px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row items-center justify-center gap-12 -translate-y-8 md:-translate-y-12">
                
                <!-- Logo Desa -->
                <div class="flex-shrink-0">
                    <img
                        src="{{ asset('images/LOGO DESA.png') }}"
                        alt="Logo Desa Maket"
                        class="w-64 h-64 md:w-72 md:h-72 object-contain drop-shadow-[0_18px_28px_rgba(0,0,0,0.35)]"
                        onerror="this.src='https://via.placeholder.com/208/92400e/ffffff?text=Logo+Maket'; this.onerror=null;"
                    >
                </div>

                <!-- Teks Selamat Datang -->
                <div class="text-center md:text-left">
                    <h1 class="text-5xl md:text-7xl font-bold tracking-tight leading-none mb-6">
                        Selamat Datang di<br>Maket Desa Buruan
                    </h1>
                    <p class="text-xl md:text-2xl opacity-90 mb-4">
                        Kecamatan Blahbatuh, Kabupaten Gianyar, Provinsi Bali
                    </p>
                    <p class="text-lg opacity-80">
                        Luas Wilayah: 12 km² | Kepadatan: 204 jiwa/km²
                    </p>
                </div>
            </div>

            <!-- Tombol CTA -->
            <div class="mt-16 text-center">
                <a href="{{ route('dashboard') }}" 
                   class="inline-block bg-white text-blue-700 hover:bg-blue-50 font-bold py-5 px-14 rounded-full shadow-2xl text-2xl transition transform hover:scale-105">
                    Lihat Statistik & APBD Desa →
                </a>
            </div>
        </div>

        <!-- Overlay gelap (opsional) -->
        <div class="absolute inset-0 bg-black/10"></div>
    </section>
</x-app-layout>
