<aside class="w-72 bg-gray-900 text-white min-h-screen p-6 flex-shrink-0">
    @php
        $isKepala = request()->routeIs('kepala.*');
        $routePrefix = $isKepala ? 'kepala' : 'admin';
        $notifikasiSuratSidebar = $isKepala
            ? \App\Models\PengajuanSurat::where('status', \App\Models\PengajuanSurat::STATUS_DIAJUKAN_KE_KEPALA)->count()
            : \App\Models\PengajuanSurat::where('status', \App\Models\PengajuanSurat::STATUS_MENUNGGU)->count();
    @endphp

    <a href="{{ route($routePrefix . '.dashboard') }}" class="flex items-center gap-3 mb-10">
        <div class="w-16 h-16 rounded-2xl overflow-hidden flex-shrink-0 bg-white flex items-center justify-center">
            <img
                src="{{ asset('images/logo.png') }}"
                alt="Logo Desa Maket"
                class="w-full h-full object-contain"
                onerror="this.src='https://via.placeholder.com/64?text=Logo'">
        </div>
        <div>
            <h1 class="text-xl font-semibold">Desa Maket</h1>
            <p class="text-xs text-gray-400">{{ $isKepala ? 'Kepala Desa Panel' : 'Admin Panel' }}</p>
        </div>
    </a>

    <nav class="space-y-1">
        <a href="{{ route($routePrefix . '.dashboard') }}"
           class="flex items-center gap-3 px-5 py-4 rounded-2xl font-medium transition {{ request()->routeIs($routePrefix . '.dashboard') ? 'bg-orange-600 text-white' : 'hover:bg-gray-800' }}">
            🏠 Dashboard
        </a>

        @unless($isKepala)
            <a href="/admin/data-penduduk"
               class="flex items-center gap-3 px-5 py-4 rounded-2xl font-medium transition {{ request()->is('admin/data-penduduk*') ? 'bg-orange-600 text-white' : 'hover:bg-gray-800' }}">
                👥 Data Penduduk
            </a>
        @endunless

        <a href="{{ route($routePrefix . '.pengajuan-surat.index') }}"
           class="flex items-center justify-between gap-3 px-5 py-4 rounded-2xl font-medium transition {{ request()->routeIs($routePrefix . '.pengajuan-surat.*') ? 'bg-orange-600 text-white' : 'hover:bg-gray-800' }}">
            📄 Pengajuan Surat
            @if($notifikasiSuratSidebar > 0)
                <span class="min-w-6 h-6 px-2 rounded-full bg-red-500 text-white text-xs font-semibold flex items-center justify-center">
                    {{ $notifikasiSuratSidebar }}
                </span>
            @endif
        </a>

        <a href="{{ route($routePrefix . '.pengaduan') }}"
           class="flex items-center gap-3 px-5 py-4 rounded-2xl font-medium transition {{ request()->routeIs($routePrefix . '.pengaduan*') ? 'bg-orange-600 text-white' : 'hover:bg-gray-800' }}">
            📢 Pengaduan Masyarakat
        </a>

        <a href="{{ route($routePrefix . '.laporan-statistik.index') }}"
           class="flex items-center gap-3 px-5 py-4 rounded-2xl font-medium transition {{ request()->routeIs($routePrefix . '.laporan-statistik.*') ? 'bg-orange-600 text-white' : 'hover:bg-gray-800' }}">
            📊 Laporan & Statistik
        </a>

        @unless($isKepala)
            <a href="{{ route('admin.keuangan') }}"
               class="flex items-center gap-3 px-5 py-4 rounded-2xl font-medium transition {{ request()->routeIs('admin.keuangan*') ? 'bg-orange-600 text-white' : 'hover:bg-gray-800' }}">
                💰 Keuangan Desa
            </a>

            <a href="{{ route('admin.artikel.index') }}"
               class="flex items-center gap-3 px-5 py-4 rounded-2xl font-medium transition {{ request()->routeIs('admin.artikel.*') ? 'bg-orange-600 text-white' : 'hover:bg-gray-800' }}">
                📰 Artikel Desa
            </a>

            <a href="{{ route('admin.berita.index') }}"
               class="flex items-center gap-3 px-5 py-4 rounded-2xl font-medium transition {{ request()->routeIs('admin.berita.*') ? 'bg-orange-600 text-white' : 'hover:bg-gray-800' }}">
                🗞️ Berita Desa
            </a>

            <a href="{{ route('admin.aparatur-desa.index') }}"
               class="flex items-center gap-3 px-5 py-4 rounded-2xl font-medium transition {{ request()->routeIs('admin.aparatur-desa.*') ? 'bg-orange-600 text-white' : 'hover:bg-gray-800' }}">
                🏛️ Aparatur Desa
            </a>

            <a href="{{ route('admin.program.index') }}"
               class="flex items-center gap-3 px-5 py-4 rounded-2xl font-medium transition {{ request()->routeIs('admin.program.*') ? 'bg-orange-600 text-white' : 'hover:bg-gray-800' }}">
                📋 Program Desa
            </a>

            <a href="{{ route('admin.settings-desa.edit') }}"
               class="flex items-center gap-3 px-5 py-4 rounded-2xl font-medium transition {{ request()->routeIs('admin.settings-desa.*') ? 'bg-orange-600 text-white' : 'hover:bg-gray-800' }}">
                ⚙️ CMS Dashboard Desa
            </a>
        @endunless
    </nav>
</aside>
