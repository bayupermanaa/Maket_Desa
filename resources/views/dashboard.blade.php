<x-app-layout>
<div class="min-h-screen bg-gray-50">

    <style>
        [x-cloak]{display:none !important;}
        .scrollbar-samarkan {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        .scrollbar-samarkan::-webkit-scrollbar {
            display: none;
        }
    </style>

    @php
        $popupAktif = (bool) (data_get($data ?? null, 'popup_aktif') ?? false);
        $popupJudul = (string) (data_get($data ?? null, 'popup_judul') ?? '');
        $popupIsi = (string) (data_get($data ?? null, 'popup_isi') ?? '');
        $desaNama = (string) ($data->nama_desa ?? 'Maket Desa');
        $desaKecamatan = (string) ($data->kecamatan ?? 'Blahbatuh');
        $desaKabupaten = (string) ($data->kabupaten ?? 'Gianyar');
        $desaProvinsi = (string) ($data->provinsi ?? 'Bali');
        $lokasiLabel = trim($desaKecamatan . ', ' . $desaKabupaten . ', ' . $desaProvinsi, ', ');
    @endphp

    @if(false && $popupAktif && (trim($popupJudul) !== '' || trim($popupIsi) !== ''))
        <div
            x-data="{ open: true }"
            x-show="open"
            x-cloak
            x-teleport="body"
            class="fixed inset-0 z-[2147483647] flex items-center justify-center px-4 py-8"
            aria-labelledby="popup-title"
            role="dialog"
            aria-modal="true"
        >
            <div class="absolute inset-0 bg-black/60" x-on:click="open = false"></div>

            <div class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl overflow-hidden">
                <div class="p-6 sm:p-8 border-b">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <h2 id="popup-title" class="text-xl sm:text-2xl font-bold text-gray-900 truncate">
                                {{ $popupJudul !== '' ? $popupJudul : 'Informasi' }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-500">Ditampilkan otomatis saat membuka dashboard.</p>
                        </div>
                        <button
                            type="button"
                            class="shrink-0 inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-700"
                            aria-label="Tutup popup"
                            x-on:click="open = false"
                        >
                            ✕
                        </button>
                    </div>
                </div>

                <div class="p-6 sm:p-8">
                    <div class="prose prose-gray max-w-none">
                        @if(trim($popupIsi) !== '')
                            {!! nl2br(e($popupIsi)) !!}
                        @else
                            <p class="text-gray-600">Konten popup belum diisi.</p>
                        @endif
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button
                            type="button"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-semibold"
                            x-on:click="open = false"
                        >
                            Saya Mengerti
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Header -->
    <header class="bg-gradient-to-r from-blue-700 to-blue-500 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 flex-wrap">

                <!-- Info Desa -->
                <div class="flex items-center gap-4 min-w-0">
                    <img
                        src="{{ asset('images/LOGO DESA.png') }}"
                        alt="Logo Desa"
                        class="w-24 h-24 object-contain drop-shadow-[0_10px_18px_rgba(0,0,0,0.35)]"
                        onerror="this.style.display='none';"
                    >
                    <div class="min-w-0">
                        <h1 class="text-3xl lg:text-4xl font-bold truncate">
                            SELAMAT DATANG DI MAKET DESA <span class="text-yellow-300">{{ $data->nama_desa ?? 'Maket Desa' }}</span>
                        </h1>
                        <p class="mt-1 text-blue-100 text-lg truncate">
                            {{ $data->kecamatan ?? 'Blahbatuh' }}, {{ $data->kabupaten ?? 'Gianyar' }}, {{ $data->provinsi ?? 'Bali' }}
                        </p>
                    </div>
                </div>

                <!-- Statistik Singkat -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-center flex-wrap">
                    <div class="bg-white/20 backdrop-blur-md p-5 rounded-2xl min-w-0 overflow-hidden">
                        <h3 class="text-sm opacity-90 truncate">Luas Wilayah</h3>
                        <p class="text-2xl font-bold mt-1 truncate">{{ $data->luas_wilayah ?? '-' }}</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-md p-5 rounded-2xl min-w-0 overflow-hidden">
                        <h3 class="text-sm opacity-90 truncate">Kepadatan</h3>
                        <p class="text-2xl font-bold mt-1 truncate">{{ $data->kepadatan ?? '-' }}</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-md p-5 rounded-2xl min-w-0 overflow-hidden">
                        <h3 class="text-sm opacity-90 truncate">Jumlah Penduduk</h3>
                        <p class="text-2xl font-bold mt-1 truncate">{{ number_format($data->jumlah_penduduk ?? 0) }}</p>
                    </div>
                </div>
            </div>
        </div>


        <!-- Menu Bar -->
        <nav class="bg-white/10 backdrop-blur-md border-t border-white/20">
            <div class="max-w-7xl mx-auto px-6">
                <ul class="scrollbar-samarkan flex items-center h-14 text-sm font-medium overflow-x-auto whitespace-nowrap">
                    @foreach(['home'=>'🏠 Home','tentang'=>'ℹ️ Tentang Maket','penduduk'=>'👥 Penduduk','statistik'=>'📊 Statistik','kesehatan'=>'🩺 Kesehatan','wilayah'=>'🗺️ Wilayah','keuangan'=>'💰 Keuangan','program'=>'📋 Program','berita'=>'📰 Berita'] as $key=>$label)
                    <li>
                        <a href="#" onclick="showSection('{{ $key }}')"
                           class="menu-item flex items-center gap-2 px-6 h-full hover:bg-white/10 transition-colors {{ $loop->first ? 'active border-white' : '' }}">
                           {!! $label !!}
                        </a>
                    </li>
                    @endforeach
                    <li class="ml-auto pl-4">
                        @auth
                            @php
                                $dashboardRoute = 'dashboard';
                                if (auth()->user()->role === 'admin_desa') {
                                    $dashboardRoute = 'admin.dashboard';
                                } elseif (auth()->user()->role === 'masyarakat') {
                                    $dashboardRoute = 'dashboard.masyarakat';
                                }
                            @endphp
                            <a href="{{ route($dashboardRoute) }}"
                               class="flex items-center gap-2 bg-white text-black hover:bg-gray-100 px-6 py-2 rounded-2xl font-semibold transition-all">
                                🧭 Dashboard Saya
                            </a>
                        @else
                            <a href="{{ route('login') }}" 
                               class="flex items-center gap-2 bg-white text-black hover:bg-gray-100 px-6 py-2 rounded-2xl font-semibold transition-all">
                                🔑 Login
                            </a>
                        @endauth
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Konten Dinamis -->
    <main class="max-w-7xl mx-auto px-6 py-10">

        <!-- HOME SECTION -->
        <div id="section-home" class="section">
            <!-- Statistik 3 Card Real -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="bg-white rounded-3xl shadow p-8 text-center">
                    <div class="text-6xl mb-4">👥</div>
                    <h3 class="text-4xl font-bold">{{ number_format($totalPenduduk ?? 0) }}</h3>
                    <p class="text-gray-500 mt-2">Jumlah Penduduk</p>
                </div>
                <div class="bg-white rounded-3xl shadow p-8 text-center">
                    <div class="text-6xl mb-4">📄</div>
                    <h3 class="text-4xl font-bold text-orange-600">{{ number_format($totalPengajuanSurat ?? 0) }}</h3>
                    <p class="text-gray-500 mt-2">Pengajuan Surat</p>
                </div>
                <div class="bg-white rounded-3xl shadow p-8 text-center">
                    <div class="text-6xl mb-4">📢</div>
                    <h3 class="text-4xl font-bold text-red-600">{{ number_format($totalPengaduan ?? 0) }}</h3>
                    <p class="text-gray-500 mt-2">Pengaduan Masyarakat</p>
                </div>
            </div>

            <h2 class="text-3xl font-semibold text-gray-800 mb-6">
                Selamat Datang di Desa {{ $data->nama_desa ?? 'Maket Desa' }}
            </h2>

            <!-- Video + Kepala Desa -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-16">
                <!-- Video Profil -->
                <div class="lg:col-span-8">
                    <div class="bg-white rounded-3xl shadow p-6">
                        <h2 class="text-xl font-bold mb-5">🎬 Video Profil Desa</h2>
                        @if(!empty($data->video_desa))
                            @php
                                $url = trim($data->video_desa);
                                $videoId = '';
                                if(str_contains($url,'youtu.be/')) $videoId = explode('youtu.be/',$url)[1] ?? '';
                                elseif(str_contains($url,'watch?v=')) $videoId = explode('watch?v=',$url)[1] ?? '';
                                elseif(str_contains($url,'/embed/')) $videoId = explode('/embed/',$url)[1] ?? '';
                                $videoId = explode('?', $videoId)[0];
                            @endphp
                            @if($videoId)
                                <div class="aspect-video bg-black rounded-2xl overflow-hidden">
                                    <iframe
                                        id="desaYoutubeIframe"
                                        class="w-full h-full"
                                        data-video-id="{{ trim($videoId) }}"
                                        src="https://www.youtube.com/embed/{{ trim($videoId) }}?rel=0&playsinline=1&mute=1&autoplay=0&loop=1&playlist={{ trim($videoId) }}"
                                        frameborder="0"
                                        allow="autoplay; encrypted-media; picture-in-picture"
                                        allowfullscreen
                                    ></iframe>
                                </div>
                            @endif
                        @else
                            <div class="aspect-video bg-gray-100 rounded-2xl flex items-center justify-center py-16">
                                <span class="text-6xl">🎬</span>
                                <p class="text-gray-500">Belum ada video profil desa</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Kepala Desa -->
                <div class="lg:col-span-4">
                    @php
                        $fotoKades = asset('images/default-kepala-desa.jpeg');
                        if (!empty($data->kepala_desa_foto)) {
                            if (\Illuminate\Support\Str::startsWith($data->kepala_desa_foto, ['http://', 'https://'])) {
                                $fotoKades = $data->kepala_desa_foto;
                            } elseif (\Illuminate\Support\Str::startsWith($data->kepala_desa_foto, 'images/')) {
                                $fotoKades = asset($data->kepala_desa_foto);
                            } else {
                                // Backward-compat: dulu sempat disimpan di storage/public
                                $fotoKades = asset('storage/' . $data->kepala_desa_foto);
                            }
                        }
                    @endphp
                    <div class="rounded-3xl shadow-lg h-full overflow-hidden border border-slate-200 bg-white">
                        <div class="px-5 py-3 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-sm font-semibold text-center">
                            Profil Kepala Desa
                        </div>
                        <div class="p-7 text-center h-full flex flex-col">
                            <div class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-blue-50 border border-blue-100 text-blue-700 text-xs font-semibold mx-auto mb-5">
                                <span>🏛️</span>
                                <span>Pimpinan Desa</span>
                            </div>

                            <img src="{{ $fotoKades }}" alt="Kepala Desa"
                                  class="w-48 h-48 object-cover rounded-2xl mx-auto mb-5 shadow-lg border-4 border-white ring-2 ring-blue-100">

                            <h3 class="text-3xl font-bold leading-tight text-slate-800">{{ $data->nama_kepala_desa ?? 'Nama Kepala Desa' }}</h3>
                            <p class="text-blue-700 font-medium mt-2">{{ $data->kepala_desa_jabatan ?? 'Kepala Desa' }}</p>

                            @if(!empty($data->kepala_desa_periode))
                                <div class="mt-4 px-4 py-2 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-600">
                                    Periode: {{ $data->kepala_desa_periode }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aparatur Desa (Swiper Slider) -->
            <div class="mt-16">
                <style>
                    .aparatur-panel { border: 1px solid #e5e7eb; border-radius: 18px; overflow: hidden; background: #ffffff; box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06); }
                    .aparatur-head { background: linear-gradient(90deg, #1d4ed8 0%, #2563eb 55%, #3b82f6 100%); color: #fff; }
                    .aparatur-swiper { overflow: hidden; }
                    .aparatur-swiper .swiper-slide { height: auto; }
                    .aparatur-card { background: #f8fafc; border: 1px solid #dbeafe; border-radius: 14px; min-height: 240px; display: flex; overflow: hidden; }
                    .aparatur-photo-wrap { width: 42%; min-height: 240px; background: linear-gradient(180deg, #eff6ff, #dbeafe); flex-shrink: 0; }
                    .aparatur-photo-wrap img { width: 100%; height: 100%; object-fit: cover; display: block; }
                    .aparatur-info { width: 58%; padding: 18px; display: flex; flex-direction: column; justify-content: center; text-align: center; color: #0f172a; }
                    .aparatur-nav-btn { width: 30px; height: 30px; border-radius: 8px; background: rgba(255, 255, 255, 0.24); color: #fff; display: inline-flex; align-items: center; justify-content: center; border: 1px solid rgba(255,255,255,0.35); }
                    .aparatur-nav-btn:hover { background: rgba(255, 255, 255, 0.34); }
                    .aparatur-swiper .swiper-pagination-bullet { background: #93c5fd; opacity: 1; }
                    .aparatur-swiper .swiper-pagination-bullet-active { background: #2563eb; }
                    @media (max-width: 767px) {
                        .aparatur-card { flex-direction: column; min-height: 0; }
                        .aparatur-photo-wrap { width: 100%; min-height: 260px; }
                        .aparatur-info { width: 100%; }
                    }
                </style>

                @php
                    $aparatur = $aparatur ?? ($aparaturDesa ?? collect());
                @endphp

                @if(($aparatur ?? collect())->count() > 0)
                    <div class="aparatur-panel">
                        <div class="aparatur-head px-5 py-3 flex items-center justify-between">
                            <h3 class="text-xl font-bold tracking-wide">APARATUR DESA</h3>
                            <div class="flex items-center gap-2">
                                <button type="button" class="aparatur-nav-btn aparatur-prev" aria-label="Sebelumnya">‹</button>
                                <button type="button" class="aparatur-nav-btn aparatur-next" aria-label="Berikutnya">›</button>
                            </div>
                        </div>

                        <div class="p-3 md:p-4">
                            <div class="swiper aparatur-swiper">
                                <div class="swiper-wrapper">
                                    @foreach($aparatur as $item)
                                        @php
                                            $fotoAparatur = asset('images/logo.png');
                                            if (!empty($item->foto)) {
                                                if (\Illuminate\Support\Str::startsWith($item->foto, 'images/')) {
                                                    $fotoAparatur = asset($item->foto);
                                                } elseif (\Illuminate\Support\Str::startsWith($item->foto, ['http://', 'https://'])) {
                                                    $fotoAparatur = $item->foto;
                                                } else {
                                                    $fotoAparatur = asset('storage/' . $item->foto);
                                                }
                                            }
                                        @endphp
                                        <div class="swiper-slide">
                                            <article class="aparatur-card">
                                                <div class="aparatur-photo-wrap">
                                                    <img src="{{ $fotoAparatur }}" alt="{{ $item->nama }}">
                                                </div>
                                                <div class="aparatur-info">
                                                    <p class="text-base md:text-lg text-blue-700 font-medium leading-tight">{{ $item->jabatan }}</p>
                                                    <div class="my-3 border-t border-slate-200"></div>
                                                    <h4 class="text-lg md:text-xl font-bold text-slate-800 uppercase tracking-wide">{{ $item->nama }}</h4>
                                                </div>
                                            </article>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-pagination mt-4"></div>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-center text-gray-500">Belum ada data aparatur.</p>
                @endif
            </div>

             <!-- SEJARAH DESA -->
                <div class="mt-16 bg-white rounded-3xl shadow p-8 lg:p-10">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="text-4xl">📜</span>
                        <h3 class="text-2xl font-semibold text-gray-800">Sejarah Desa {{ $data->nama_desa ?? 'Maket Desa' }}</h3>
                    </div>

                    <div class="prose prose-gray max-w-none text-gray-700 leading-relaxed">
                        @if(!empty($data->sejarah_desa))
                            {!! nl2br(e($data->sejarah_desa)) !!}
                        @else
                            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-8 text-center">
                                <p class="text-amber-700">Sejarah desa belum diisi.</p>
                            </div>
                        @endif
                    </div>
                </div>

            <!-- ARTIKEL DESA MAKET -->
            <div class="mt-16">
                <h3 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-3">
                    📝 Artikel Desa Maket
                </h3>
                
                @if($artikelDesa->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                       @foreach($artikelDesa as $artikel)
                            <div class="bg-white rounded-3xl shadow overflow-hidden hover:shadow-xl transition group">
                                <!-- Bagian Header Gambar -->
                                <div class="h-48 bg-gradient-to-br from-orange-500 to-amber-500 flex items-center justify-center relative overflow-hidden">
                                    @php
                                        $artikelGambarSrc = null;
                                        if (!empty($artikel->gambar)) {
                                            if (\Illuminate\Support\Str::startsWith($artikel->gambar, 'artikel/')) {
                                                $artikelGambarSrc = file_exists(public_path($artikel->gambar)) ? asset($artikel->gambar) : null;
                                            } else {
                                                // Backward-compat: dulu sempat disimpan di storage/public
                                                $artikelGambarSrc = file_exists(public_path('storage/' . $artikel->gambar)) ? asset('storage/' . $artikel->gambar) : null;
                                            }
                                        }
                                    @endphp
                                    @if($artikelGambarSrc)
                                        <img src="{{ $artikelGambarSrc }}" 
                                            alt="{{ $artikel->judul }}" 
                                            class="w-full h-full object-cover">
                                    @else
                                        <div class="text-white text-7xl opacity-75">
                                            📰
                                        </div>
                                    @endif
                                </div>

                                <!-- Isi Card -->
                                <div class="p-6">
                                    <h4 class="font-semibold text-lg leading-tight line-clamp-2 group-hover:text-orange-600 transition">
                                        {{ $artikel->judul }}
                                    </h4>
                                    
                                    <p class="text-xs text-gray-500 mt-2">
                                        {{ $artikel->created_at->format('d M Y') }}
                                    </p>
                                    
                                    <p class="text-gray-600 text-sm mt-4 line-clamp-3">
                                        {{ Str::limit(strip_tags($artikel->isi), 130) }}
                                    </p>

                                    <a href="{{ route('artikel.show', $artikel->slug) }}" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-700 font-medium text-sm mt-5">
                                        Baca selengkapnya →
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-3xl shadow p-10 text-center">
                        <p class="text-gray-500">Belum ada artikel desa.</p>
                    </div>
                @endif
            </div>

        </div>

        <!-- ==================== SECTION TENTANG MAKET ==================== -->
        <div id="section-tentang" class="section hidden">
            <div class="mb-10">
                <h2 class="text-3xl font-semibold text-gray-800 flex items-center gap-3">
                    ℹ️ Tentang Maket
                </h2>
                <p class="text-gray-600 mt-2">
                    Selamat datang pada web MAKET Desa Buruan.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <div class="lg:col-span-8 bg-white rounded-3xl shadow p-8 lg:p-10">
                    <div class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700">
                        MAKET Desa Buruan
                    </div>
                    <h3 class="mt-5 text-3xl font-bold text-gray-900 leading-tight">
                        Selamat datang pada web MAKET Desa Buruan
                    </h3>
                    <div class="mt-6 prose prose-gray max-w-none text-gray-700 leading-relaxed">
                        <p>
                            MAKET Desa merupakan sebuah web untuk desa yang merupakan sebagai aksi desa memfasilitasi
                            peningkatan pelayanan kepada masyarakat dengan memanfaatkan teknologi digital.
                        </p>
                        <p>
                            MAKET Desa adalah sebuah sistem Manajemen Administrasi Kependudukan dan E-commerce Terpadu
                            berbasis website yang dikelola secara mandiri oleh desa.
                        </p>
                        <p>
                            Desa Buruan, Kecamatan Blahbatuh, Gianyar, Bali memiliki luas 4,21 km² terdiri dari tujuh
                            dusun yaitu Buruan, Bangunliman, Celuk, Getas Kawan, Getas Kangin, Kutri, dan Ketandan.
                        </p>
                    </div>
                </div>

                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-white rounded-3xl shadow p-6">
                        <h3 class="font-semibold text-lg text-gray-800">Informasi Wilayah</h3>
                        <div class="mt-5 space-y-4 text-sm">
                            <div class="flex items-center justify-between gap-4 border-b border-gray-100 pb-3">
                                <span class="text-gray-500">Kecamatan</span>
                                <span class="font-semibold text-gray-800 text-right">{{ $desaKecamatan ?: '-' }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-4 border-b border-gray-100 pb-3">
                                <span class="text-gray-500">Kabupaten</span>
                                <span class="font-semibold text-gray-800 text-right">{{ $desaKabupaten ?: '-' }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-4 border-b border-gray-100 pb-3">
                                <span class="text-gray-500">Provinsi</span>
                                <span class="font-semibold text-gray-800 text-right">{{ $desaProvinsi ?: '-' }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-gray-500">Luas Wilayah</span>
                                <span class="font-semibold text-gray-800 text-right">{{ $data->luas_wilayah ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-600 rounded-3xl shadow p-6 text-white">
                        <p class="text-sm text-blue-100">Penduduk Terdata</p>
                        <p class="mt-2 text-4xl font-bold">{{ number_format($totalPenduduk ?? 0) }}</p>
                        <p class="mt-3 text-sm text-blue-100">
                            Data penduduk yang tercatat dalam sistem informasi desa.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    <!-- ==================== SECTION PENDUDUK ==================== -->
     <div id="section-penduduk" class="section hidden">

    <div class="mb-10">
        <h2 class="text-3xl font-semibold text-gray-800 flex items-center gap-3">
            👥 Data Penduduk Desa Maket
        </h2>
        <p class="text-gray-600 mt-2">
            Data Kependudukan Terupdate • April 2026
        </p>
    </div>

    @php
        $totalPendudukSafe = (int) ($totalPenduduk ?? 0);
        $totalLakiSafe = (int) ($totalLaki ?? 0);
        $totalPerempuanSafe = (int) ($totalPerempuan ?? 0);
        $usiaProduktifSafe = (int) ($usiaProduktif ?? 0);
        $lansiaSafe = (int) ($lansia ?? 0);

        $pct = function (int $value) use ($totalPendudukSafe): int {
            if ($totalPendudukSafe <= 0) {
                return 0;
            }
            return (int) round(($value / $totalPendudukSafe) * 100);
        };

        $pctLaki = $pct($totalLakiSafe);
        $pctPerempuan = $pct($totalPerempuanSafe);
        $pctProduktif = $pct($usiaProduktifSafe);
        $pctLansia = $pct($lansiaSafe);
    @endphp

    <!-- Hero Statistik Penduduk -->
    <div class="relative overflow-hidden rounded-3xl shadow-xl mb-10">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-600"></div>
        <div class="absolute -top-24 -right-24 w-72 h-72 bg-white/10 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-white/10 rounded-full blur-2xl"></div>

        <div class="relative p-8 md:p-10 text-white">
            <div class="flex items-start justify-between gap-6 flex-wrap">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 text-white/90 text-xs font-medium">
                        <span class="w-2 h-2 rounded-full bg-emerald-300"></span>
                        Update terakhir: {{ now()->translatedFormat('d M Y') }}
                    </div>
                    <h3 class="mt-4 text-2xl md:text-3xl font-bold tracking-tight">Total Penduduk Terdata</h3>
                    <p class="mt-1 text-white/80 text-sm">Ringkasan cepat kependudukan Desa Maket.</p>
                </div>

                <div class="text-right">
                    <div class="text-5xl md:text-6xl font-extrabold leading-none">
                        {{ number_format($totalPendudukSafe) }}
                    </div>
                    <div class="mt-2 text-white/80 text-sm">jiwa</div>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white/10 rounded-2xl p-4 border border-white/10">
                    <div class="text-xs text-white/70">Laki-laki</div>
                    <div class="mt-1 text-xl font-bold">{{ number_format($totalLakiSafe) }}</div>
                    <div class="mt-2 h-2 bg-white/15 rounded-full overflow-hidden">
                        <div class="h-full bg-sky-300 rounded-full" style="width: {{ $pctLaki }}%"></div>
                    </div>
                    <div class="mt-1 text-[11px] text-white/70">{{ $pctLaki }}%</div>
                </div>

                <div class="bg-white/10 rounded-2xl p-4 border border-white/10">
                    <div class="text-xs text-white/70">Perempuan</div>
                    <div class="mt-1 text-xl font-bold">{{ number_format($totalPerempuanSafe) }}</div>
                    <div class="mt-2 h-2 bg-white/15 rounded-full overflow-hidden">
                        <div class="h-full bg-pink-300 rounded-full" style="width: {{ $pctPerempuan }}%"></div>
                    </div>
                    <div class="mt-1 text-[11px] text-white/70">{{ $pctPerempuan }}%</div>
                </div>

                <div class="bg-white/10 rounded-2xl p-4 border border-white/10">
                    <div class="text-xs text-white/70">Usia produktif</div>
                    <div class="mt-1 text-xl font-bold">{{ number_format($usiaProduktifSafe) }}</div>
                    <div class="mt-2 h-2 bg-white/15 rounded-full overflow-hidden">
                        <div class="h-full bg-emerald-300 rounded-full" style="width: {{ $pctProduktif }}%"></div>
                    </div>
                    <div class="mt-1 text-[11px] text-white/70">{{ $pctProduktif }}%</div>
                </div>

                <div class="bg-white/10 rounded-2xl p-4 border border-white/10">
                    <div class="text-xs text-white/70">Lansia</div>
                    <div class="mt-1 text-xl font-bold">{{ number_format($lansiaSafe) }}</div>
                    <div class="mt-2 h-2 bg-white/15 rounded-full overflow-hidden">
                        <div class="h-full bg-amber-300 rounded-full" style="width: {{ $pctLansia }}%"></div>
                    </div>
                    <div class="mt-1 text-[11px] text-white/70">{{ $pctLansia }}%</div>
                </div>
            </div>
        </div>
    </div>

    @if(false)
    <!-- Grid Statistik Penduduk -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Laki-laki -->
        <div class="bg-white rounded-3xl shadow p-8 text-center">
            <div class="text-5xl mb-4">👨</div>
            <div class="text-4xl font-bold text-blue-600">{{ number_format($totalLaki ?? 0) }}</div>
            <p class="text-sm text-gray-500 mt-3">Laki-laki</p>
        </div>

        <!-- Perempuan -->
        <div class="bg-white rounded-3xl shadow p-8 text-center">
            <div class="text-5xl mb-4">👩</div>
            <div class="text-4xl font-bold text-pink-600">{{ number_format($totalPerempuan ?? 0) }}</div>
            <p class="text-sm text-gray-500 mt-3">Perempuan</p>
        </div>

        <!-- Usia Produktif -->
        <div class="bg-white rounded-3xl shadow p-8 text-center">
            <div class="text-5xl mb-4">💼</div>
            <div class="text-4xl font-bold text-emerald-600">{{ number_format($usiaProduktif ?? 0) }}</div>
            <p class="text-sm text-gray-500 mt-3">Usia Produktif (15-64 th)</p>
        </div>

        <!-- Lansia -->
        <div class="bg-white rounded-3xl shadow p-8 text-center">
            <div class="text-5xl mb-4">🧓</div>
            <div class="text-4xl font-bold text-amber-600">{{ number_format($lansia ?? 0) }}</div>
            <p class="text-sm text-gray-500 mt-3">Lansia (>65 tahun)</p>
        </div>

    </div>
    @endif

    <!-- Insight cepat -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">
        <div class="bg-white rounded-3xl shadow p-8">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500">Jumlah Kepala Keluarga (KK)</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format((int) ($totalKK ?? 0)) }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center text-2xl">🏠</div>
            </div>
            <p class="mt-4 text-sm text-gray-600">Rata-rata anggota keluarga: <span class="font-semibold">{{ number_format((float) ($rataRataKK ?? 0), 1) }}</span> orang.</p>
        </div>

        <div class="bg-white rounded-3xl shadow p-8">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500">Komposisi Gender</p>
                    <p class="text-lg font-semibold text-gray-900 mt-1">L {{ $pctLaki }}% • P {{ $pctPerempuan }}%</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-pink-50 text-pink-700 flex items-center justify-center text-2xl">👥</div>
            </div>
            <div class="mt-4 h-3 bg-gray-100 rounded-full overflow-hidden flex">
                <div class="h-full bg-sky-500" style="width: {{ $pctLaki }}%"></div>
                <div class="h-full bg-pink-500" style="width: {{ $pctPerempuan }}%"></div>
            </div>
            <div class="mt-2 flex justify-between text-xs text-gray-500">
                <span>Laki-laki</span>
                <span>Perempuan</span>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow p-8">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500">Rentang Usia</p>
                    <p class="text-lg font-semibold text-gray-900 mt-1">Produktif {{ $pctProduktif }}% • Lansia {{ $pctLansia }}%</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-2xl">📈</div>
            </div>
            <div class="mt-4 space-y-3">
                <div>
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>Usia produktif (15–64)</span><span>{{ number_format($usiaProduktifSafe) }}</span>
                    </div>
                    <div class="mt-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $pctProduktif }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>Lansia (&gt; 65)</span><span>{{ number_format($lansiaSafe) }}</span>
                    </div>
                    <div class="mt-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-amber-500 rounded-full" style="width: {{ $pctLansia }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ringkasan detail -->
    <div class="mt-8 bg-white rounded-3xl shadow p-8">
        <h3 class="font-semibold text-xl mb-6">Ringkasan Detail</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div class="flex items-center justify-between rounded-2xl border border-gray-100 px-5 py-4">
                <span class="text-gray-600">Jumlah Kepala Keluarga (KK)</span>
                <span class="font-semibold text-gray-900">{{ number_format((int) ($totalKK ?? 0)) }}</span>
            </div>
            <div class="flex items-center justify-between rounded-2xl border border-gray-100 px-5 py-4">
                <span class="text-gray-600">Rata-rata anggota keluarga</span>
                <span class="font-semibold text-gray-900">{{ number_format((float) ($rataRataKK ?? 0), 1) }} orang</span>
            </div>
            <div class="flex items-center justify-between rounded-2xl border border-gray-100 px-5 py-4">
                <span class="text-gray-600">Usia produktif (15–64)</span>
                <span class="font-semibold text-gray-900">{{ number_format($usiaProduktifSafe) }} orang</span>
            </div>
            <div class="flex items-center justify-between rounded-2xl border border-gray-100 px-5 py-4">
                <span class="text-gray-600">Lansia (&gt; 65)</span>
                <span class="font-semibold text-gray-900">{{ number_format($lansiaSafe) }} orang</span>
            </div>
        </div>
    </div>

    <div class="mt-10 text-center text-xs text-gray-500">
        Data ini diambil dari Sistem Informasi Kependudukan Desa Maket • 
        Update terakhir: {{ now()->format('d F Y') }}
    </div>

    </div>

    <!-- ==================== SECTION KESEHATAN ==================== -->
    <div id="section-kesehatan" class="section hidden">
        <div class="mb-10">
            <h2 class="text-3xl font-semibold text-gray-800 flex items-center gap-3">
                🩺 Informasi Kesehatan Desa
            </h2>
            <p class="text-gray-600 mt-2">Ringkasan layanan dan informasi kesehatan untuk masyarakat desa.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-3xl shadow p-8">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-3xl">🏥</div>
                <h3 class="text-xl font-semibold text-gray-800 mt-5">Posyandu</h3>
                <p class="text-sm text-gray-600 mt-3 leading-relaxed">
                    Informasi pelayanan kesehatan ibu, bayi, balita, dan lansia di lingkungan desa.
                </p>
            </div>

            <div class="bg-white rounded-3xl shadow p-8">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center text-3xl">💉</div>
                <h3 class="text-xl font-semibold text-gray-800 mt-5">Imunisasi</h3>
                <p class="text-sm text-gray-600 mt-3 leading-relaxed">
                    Jadwal dan pengumuman imunisasi dapat dipublikasikan untuk memudahkan warga mengikuti layanan.
                </p>
            </div>

            <div class="bg-white rounded-3xl shadow p-8">
                <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-700 flex items-center justify-center text-3xl">📋</div>
                <h3 class="text-xl font-semibold text-gray-800 mt-5">Edukasi Kesehatan</h3>
                <p class="text-sm text-gray-600 mt-3 leading-relaxed">
                    Ruang informasi pencegahan penyakit, pola hidup sehat, dan program kesehatan desa.
                </p>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <h3 class="font-semibold text-lg text-gray-800">Layanan Kesehatan Desa</h3>
                    <a
                        href="#"
                        class="inline-flex items-center justify-center rounded-2xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700 transition"
                    >
                        Website Posyandu
                    </a>
                </div>
            </div>
            <div class="divide-y">
                @foreach([
                    ['title' => 'Pemeriksaan kesehatan dasar', 'desc' => 'Pemantauan kondisi kesehatan warga melalui kegiatan desa.'],
                    ['title' => 'Pendataan ibu hamil dan balita', 'desc' => 'Dukungan pendataan untuk pelayanan kesehatan keluarga.'],
                    ['title' => 'Pemantauan lansia', 'desc' => 'Informasi dan kegiatan kesehatan untuk warga lanjut usia.'],
                ] as $layanan)
                    <div class="px-6 py-5 flex items-start justify-between gap-4">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $layanan['title'] }}</p>
                            <p class="text-sm text-gray-600 mt-1">{{ $layanan['desc'] }}</p>
                        </div>
                        <span class="shrink-0 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold px-3 py-1">
                            Aktif
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- ==================== SECTION STATISTIK ==================== -->
    <div id="section-statistik" class="section hidden">
        <div class="mb-10">
            <h2 class="text-3xl font-semibold text-gray-800 flex items-center gap-3">
                📊 Statistik Singkat Desa
            </h2>
            <p class="text-gray-600 mt-2">Ringkasan data layanan desa untuk masyarakat.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-3xl shadow p-8 text-center">
                <div class="text-5xl mb-3">👥</div>
                <p class="text-sm text-gray-500">Penduduk Terdata</p>
                <p class="text-4xl font-bold text-gray-800 mt-2">{{ number_format($totalPenduduk ?? 0) }}</p>
            </div>
            <div class="bg-white rounded-3xl shadow p-8 text-center">
                <div class="text-5xl mb-3">📄</div>
                <p class="text-sm text-gray-500">Pengajuan Surat</p>
                <p class="text-4xl font-bold text-orange-600 mt-2">{{ number_format($totalPengajuanSurat ?? 0) }}</p>
            </div>
            <div class="bg-white rounded-3xl shadow p-8 text-center">
                <div class="text-5xl mb-3">📢</div>
                <p class="text-sm text-gray-500">Pengaduan Masuk</p>
                <p class="text-4xl font-bold text-red-600 mt-2">{{ number_format($totalPengaduan ?? 0) }}</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow p-8">
            <h3 class="font-semibold text-xl mb-5">Catatan Statistik Penduduk</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div class="flex justify-between border-b pb-3">
                    <span class="text-gray-600">Laki-laki</span>
                    <span class="font-medium">{{ number_format($totalLaki ?? 0) }} orang</span>
                </div>
                <div class="flex justify-between border-b pb-3">
                    <span class="text-gray-600">Perempuan</span>
                    <span class="font-medium">{{ number_format($totalPerempuan ?? 0) }} orang</span>
                </div>
                <div class="flex justify-between border-b pb-3">
                    <span class="text-gray-600">Usia Produktif</span>
                    <span class="font-medium">{{ number_format($usiaProduktif ?? 0) }} orang</span>
                </div>
                <div class="flex justify-between border-b pb-3">
                    <span class="text-gray-600">Lansia</span>
                    <span class="font-medium">{{ number_format($lansia ?? 0) }} orang</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
            <div class="bg-white rounded-3xl shadow p-6">
                <h3 class="font-semibold text-lg mb-4">Perbandingan Layanan Desa</h3>
                <div class="h-72">
                    <canvas id="statistikBarChart"></canvas>
                </div>
            </div>
            <div class="bg-white rounded-3xl shadow p-6">
                <h3 class="font-semibold text-lg mb-4">Komposisi Penduduk</h3>
                <div class="h-72">
                    <canvas id="statistikPieChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== SECTION KEUANGAN ==================== -->
    <div id="section-keuangan" class="section hidden">
        <div class="mb-10">
            <h2 class="text-3xl font-semibold text-gray-800 flex items-center gap-3">
                💰 Ringkasan Keuangan Desa
            </h2>
            <p class="text-gray-600 mt-2">Data singkat keuangan dari input admin desa.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-3xl shadow p-8">
                <p class="text-sm text-gray-500">Total Pendapatan</p>
                <p class="text-3xl font-bold text-emerald-600 mt-2">Rp {{ number_format((float) ($totalPendapatan ?? 0), 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-3xl shadow p-8">
                <p class="text-sm text-gray-500">Total Belanja</p>
                <p class="text-3xl font-bold text-rose-600 mt-2">Rp {{ number_format((float) ($totalBelanja ?? 0), 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-3xl shadow p-8">
                <p class="text-sm text-gray-500">Saldo Saat Ini</p>
                <p class="text-3xl font-bold mt-2 {{ ($saldoKeuangan ?? 0) >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                    Rp {{ number_format((float) ($saldoKeuangan ?? 0), 0, ',', '.') }}
                </p>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b flex items-center justify-between">
                <h3 class="font-semibold text-lg">Transaksi Terbaru</h3>
                <span class="text-sm text-gray-500">Maksimal 5 transaksi</span>
            </div>
            <div class="divide-y">
                @forelse(($transaksiKeuanganTerbaru ?? collect()) as $trx)
                    <div class="px-6 py-4 flex items-center justify-between gap-4">
                        <div class="min-w-0">
                            <p class="font-medium text-gray-800 truncate">{{ $trx->uraian }}</p>
                            <p class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($trx->tanggal)->format('d M Y') }} • {{ ucfirst($trx->jenis) }}
                            </p>
                        </div>
                        <p class="text-sm font-semibold shrink-0 {{ $trx->jenis === 'pendapatan' ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $trx->jenis === 'pendapatan' ? '+' : '-' }} Rp {{ number_format((float) $trx->jumlah, 0, ',', '.') }}
                        </p>
                    </div>
                @empty
                    <div class="px-6 py-8 text-sm text-gray-500 text-center">
                        Belum ada transaksi keuangan yang dipublikasikan.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- ==================== SECTION PROGRAM ==================== -->
    <div id="section-program" class="section hidden">
        <div class="mb-10">
            <h2 class="text-3xl font-semibold text-gray-800 flex items-center gap-3">
                📋 Program Desa
            </h2>
            <p class="text-gray-600 mt-2">Program prioritas desa yang dipublikasikan oleh admin.</p>
        </div>

        @if(($programDesa ?? collect())->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($programDesa as $program)
                    @php
                        $status = strtolower((string) $program->status);
                        $statusClass = match($status) {
                            'perencanaan' => 'bg-amber-100 text-amber-700',
                            'berjalan' => 'bg-blue-100 text-blue-700',
                            'selesai' => 'bg-emerald-100 text-emerald-700',
                            default => 'bg-gray-100 text-gray-700',
                        };

                        $kategori = strtolower((string) ($program->kategori ?? ''));
                        $kategoriIcon = '📌';
                        if (\Illuminate\Support\Str::contains($kategori, 'lingkungan')) $kategoriIcon = '🌱';
                        elseif (\Illuminate\Support\Str::contains($kategori, 'infrastruktur')) $kategoriIcon = '🏗️';
                        elseif (\Illuminate\Support\Str::contains($kategori, 'pendidikan')) $kategoriIcon = '🎓';
                        elseif (\Illuminate\Support\Str::contains($kategori, 'kesehatan')) $kategoriIcon = '🩺';
                        elseif (\Illuminate\Support\Str::contains($kategori, 'ekonomi')) $kategoriIcon = '💼';
                    @endphp

                    <article class="bg-white rounded-3xl shadow-md overflow-hidden transition-all duration-300 hover:-translate-y-1.5 hover:shadow-2xl">
                        @if(!empty($program->gambar))
                            <img src="{{ asset($program->gambar) }}" alt="{{ $program->judul }}" class="w-full h-52 object-cover">
                        @endif
                        <div class="p-7">
                        <div class="flex items-start justify-between gap-4">
                            <span class="text-xs px-3 py-1 rounded-full font-medium capitalize {{ $statusClass }}">
                                {{ $program->status }}
                            </span>
                            @if(!empty($program->tahun))
                                <span class="text-xs text-gray-500">{{ $program->tahun }}</span>
                            @endif
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mt-4">{{ $program->judul }}</h3>
                        @if(!empty($program->kategori))
                            <p class="text-sm text-gray-500 mt-1">{{ $kategoriIcon }} {{ $program->kategori }}</p>
                        @endif
                        <p class="text-sm text-gray-600 mt-3 leading-relaxed">
                            {{ \Illuminate\Support\Str::limit(strip_tags((string) $program->deskripsi), 140) }}
                        </p>
                        @if(!is_null($program->anggaran))
                            <p class="text-sm font-semibold text-emerald-700 mt-4">
                                Anggaran: Rp {{ number_format((float) $program->anggaran, 0, ',', '.') }}
                            </p>
                        @endif

                        <details class="mt-4">
                            <summary class="list-none inline-flex items-center px-3 py-2 rounded-xl bg-blue-50 text-blue-700 hover:bg-blue-100 text-sm font-medium cursor-pointer transition">
                                Lihat Detail
                            </summary>
                            <div class="mt-3 rounded-xl bg-gray-50 border border-gray-100 p-3 text-sm text-gray-700 leading-relaxed">
                                {{ $program->deskripsi ?: 'Deskripsi program belum diisi.' }}
                            </div>
                        </details>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-3xl shadow p-10 text-center text-gray-500">
                Program desa belum dipublikasikan.
            </div>
        @endif
    </div>

    <!-- ==================== SECTION WILAYAH (PETA) ==================== -->
    <div id="section-wilayah" class="section hidden">
        <div class="mb-8">
            <h2 class="text-3xl font-semibold text-gray-800 flex items-center gap-3">
                🗺️ Peta Wilayah & Kantor Desa
            </h2>
            <p class="text-gray-600 mt-1">
                Desa {{ $desaNama }} • {{ $lokasiLabel }}
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Peta Utama Leaflet -->
            <div class="lg:col-span-8">
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
                    <div id="map" style="height: 580px; width: 100%;"></div>
                </div>
            </div>

            <!-- Info + Google Embed -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Info Kantor Desa -->
                <div class="bg-white rounded-3xl shadow p-6">
                    <h3 class="font-bold text-xl mb-4 flex items-center gap-2">
                        🏛️ Kantor Desa
                    </h3>
                    <p class="text-gray-700">
                        <strong>Lokasi Kantor Desa {{ $desaNama }}</strong><br>
                        {{ $lokasiLabel }}
                    </p>
                    <div class="mt-4 text-sm text-gray-600">
                        Koordinat: <strong>-8.5436708, 115.3030258</strong>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow p-6">
                    <h3 class="font-bold text-xl mb-4 flex items-center gap-2">
                        🧭 Wilayah Banjar Dinas
                    </h3>
                    <div id="banjar-list" class="space-y-3 text-sm text-gray-600">
                        Memuat data banjar dinas...
                    </div>
                </div>

                <!-- Google Street View Embed -->
                <div class="bg-white rounded-3xl shadow overflow-hidden">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!3m2!1sid!2ssg!4v1777723510056!5m2!1sid!2ssg!6m8!1m7!1sy4JiMrPOS58R4ioueZ60vw!2m2!1d-8.54367081220857!2d115.3030257734422!3f284.1796851577553!4f-2.9509987508706814!5f0.7820865974627469" 
                        width="100%" 
                        height="280" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

            </div>
        </div>

        <div class="mt-8 text-center text-sm text-gray-500">
            Peta interaktif • Drag untuk melihat seluruh wilayah • Scroll untuk zoom
        </div>
    </div>

    <!-- ==================== SECTION BERITA ==================== -->
    <div id="section-berita" class="section hidden">
        <div class="mb-10">
            <h2 class="text-3xl font-semibold text-gray-800 flex items-center gap-3">
                📰 Berita Desa
            </h2>
            <p class="text-gray-600 mt-2">Kumpulan berita dan informasi terbaru dari desa.</p>
        </div>

        @if(($beritaDesa ?? collect())->isNotEmpty())
            <div class="bg-white rounded-3xl shadow p-5 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm text-gray-600 mb-2">Tanggal</label>
                        <select id="berita-filter-day" class="w-full border border-gray-300 rounded-xl px-3 py-2">
                            <option value="">Semua Tanggal</option>
                            @for($d = 1; $d <= 31; $d++)
                                <option value="{{ str_pad((string) $d, 2, '0', STR_PAD_LEFT) }}">{{ $d }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-2">Bulan</label>
                        <select id="berita-filter-month" class="w-full border border-gray-300 rounded-xl px-3 py-2">
                            <option value="">Semua Bulan</option>
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ str_pad((string) $m, 2, '0', STR_PAD_LEFT) }}">{{ $m }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-2">Tahun</label>
                        <select id="berita-filter-year" class="w-full border border-gray-300 rounded-xl px-3 py-2">
                            <option value="">Semua Tahun</option>
                            @foreach(($beritaDesa ?? collect())->map(fn($b) => optional($b->tanggal_publish ?? $b->created_at)->format('Y'))->filter()->unique()->sortDesc()->values() as $y)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="button" id="berita-filter-reset" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl px-4 py-2 font-medium">Reset Filter</button>
                    </div>
                </div>
            </div>

            <div id="berita-dashboard-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($beritaDesa as $berita)
                    @php
                        $beritaImage = null;
                        if (!empty($berita->gambar)) {
                            if (\Illuminate\Support\Str::startsWith($berita->gambar, 'berita/')) {
                                $beritaImage = file_exists(public_path($berita->gambar)) ? asset($berita->gambar) : null;
                            } else {
                                $beritaImage = file_exists(public_path('storage/' . $berita->gambar)) ? asset('storage/' . $berita->gambar) : null;
                            }
                        }
                        $publishDate = optional($berita->tanggal_publish ?? $berita->created_at)->format('Y-m-d');
                    @endphp
                    <article class="berita-dashboard-item bg-white rounded-3xl shadow overflow-hidden hover:shadow-xl transition"
                        data-publish="{{ $publishDate }}">
                        <div class="h-48 bg-gradient-to-br from-orange-500 to-amber-500 flex items-center justify-center overflow-hidden">
                            @if($beritaImage)
                                <img src="{{ $beritaImage }}" alt="{{ $berita->judul }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-white text-6xl opacity-75">📰</span>
                            @endif
                        </div>

                        <div class="p-6">
                            <p class="text-xs text-gray-500">{{ optional($berita->tanggal_publish ?? $berita->created_at)->format('d M Y') ?? '-' }}</p>
                            <h3 class="text-lg font-semibold text-gray-800 mt-2 line-clamp-2">{{ $berita->judul }}</h3>
                            <p class="text-sm text-gray-600 mt-3 line-clamp-3">
                                {{ \Illuminate\Support\Str::limit(strip_tags($berita->isi), 130) }}
                            </p>
                            <a href="{{ route('berita.show', $berita->slug) }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium text-sm mt-5">
                                Baca selengkapnya →
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
            <div id="berita-dashboard-empty" class="hidden bg-white rounded-3xl shadow p-10 text-center text-gray-500 mt-6">
                Tidak ada berita sesuai filter tanggal/bulan/tahun.
            </div>
        @else
            <div class="bg-white rounded-3xl shadow p-10 text-center text-gray-500">
                Belum ada berita yang dipublikasikan.
            </div>
        @endif

        <div class="mt-8 text-center">
            <a href="{{ route('berita.index') }}" class="inline-flex items-center px-5 py-3 rounded-2xl bg-blue-600 text-white hover:bg-blue-700 font-medium">
                Lihat Semua Berita
            </a>
        </div>
    </div>

    </main>
</div>

<!-- Swiper CSS -->
<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
/>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" 
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
function showSection(section) {
    document.querySelectorAll('.section').forEach(s => s.classList.add('hidden'));
    const el = document.getElementById(`section-${section}`);
    if (el) el.classList.remove('hidden');

    document.querySelectorAll('.menu-item').forEach(item => {
        item.classList.remove('active', 'border-white');
        if (item.getAttribute('onclick')?.includes(section)) {
            item.classList.add('active', 'border-white');
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    showSection('home');

    // YouTube autoplay + loop:
    // - Jika popup kebijakan aktif, mulai autoplay setelah popup ditutup
    // - Jika tidak ada popup, autoplay langsung saat dashboard dibuka
    const yt = document.getElementById('desaYoutubeIframe');
    const buildYoutubeSrc = (videoId, autoplay) => {
        const params = new URLSearchParams({
            rel: '0',
            playsinline: '1',
            mute: '1',
            autoplay: autoplay ? '1' : '0',
            loop: '1',
            playlist: videoId,
        });
        return `https://www.youtube.com/embed/${encodeURIComponent(videoId)}?${params.toString()}`;
    };

    const startYoutubeAutoplay = () => {
        if (!yt) return;
        const videoId = yt.getAttribute('data-video-id');
        if (!videoId) return;
        yt.setAttribute('src', buildYoutubeSrc(videoId, true));
    };

    if (yt) {
        const hasPopup = !!document.querySelector('[data-popup-kebijakan]');
        if (!hasPopup) {
            startYoutubeAutoplay();
        } else {
            window.addEventListener('popup-kebijakan:closed', startYoutubeAutoplay, { once: true });
        }
    }

    const initBeritaFilter = () => {
        const dayEl = document.getElementById('berita-filter-day');
        const monthEl = document.getElementById('berita-filter-month');
        const yearEl = document.getElementById('berita-filter-year');
        const resetEl = document.getElementById('berita-filter-reset');
        const cards = Array.from(document.querySelectorAll('.berita-dashboard-item'));
        const emptyEl = document.getElementById('berita-dashboard-empty');

        if (!dayEl || !monthEl || !yearEl || cards.length === 0) return;

        const applyFilter = () => {
            const day = dayEl.value;
            const month = monthEl.value;
            const year = yearEl.value;
            let visible = 0;

            cards.forEach((card) => {
                const publish = String(card.dataset.publish || '');
                const [y, m, d] = publish.split('-');
                const matchDay = !day || day === d;
                const matchMonth = !month || month === m;
                const matchYear = !year || year === y;
                const ok = matchDay && matchMonth && matchYear;
                card.classList.toggle('hidden', !ok);
                if (ok) visible++;
            });

            if (emptyEl) emptyEl.classList.toggle('hidden', visible > 0);
        };

        dayEl.addEventListener('change', applyFilter);
        monthEl.addEventListener('change', applyFilter);
        yearEl.addEventListener('change', applyFilter);
        if (resetEl) {
            resetEl.addEventListener('click', () => {
                dayEl.value = '';
                monthEl.value = '';
                yearEl.value = '';
                applyFilter();
            });
        }
    };

    initBeritaFilter();

    const barCanvas = document.getElementById('statistikBarChart');
    if (barCanvas) {
        new Chart(barCanvas, {
            type: 'bar',
            data: {
                labels: ['Penduduk', 'Pengajuan Surat', 'Pengaduan'],
                datasets: [{
                    label: 'Total',
                    data: [
                        {{ (int) ($totalPenduduk ?? 0) }},
                        {{ (int) ($totalPengajuanSurat ?? 0) }},
                        {{ (int) ($totalPengaduan ?? 0) }}
                    ],
                    backgroundColor: ['#2563eb', '#f97316', '#ef4444'],
                    borderRadius: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });
    }

    const pieCanvas = document.getElementById('statistikPieChart');
    if (pieCanvas) {
        new Chart(pieCanvas, {
            type: 'pie',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    data: [
                        {{ (int) ($totalLaki ?? 0) }},
                        {{ (int) ($totalPerempuan ?? 0) }}
                    ],
                    backgroundColor: ['#3b82f6', '#ec4899']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    const aparaturSwiperEl = document.querySelector('.aparatur-swiper');
    if (aparaturSwiperEl && typeof Swiper !== 'undefined') {
        new Swiper('.aparatur-swiper', {
            loop: true,
            speed: 700,
            spaceBetween: 20,
            autoplay: {
                delay: 2000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.aparatur-swiper .swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.aparatur-next',
                prevEl: '.aparatur-prev',
            },
            breakpoints: {
                0: { slidesPerView: 1 },
                768: { slidesPerView: 2 },
                1024: { slidesPerView: 3 },
            },
        });
    }
});
</script>

<script>
let wilayahMap = null;
let kantorMarker = null;
let banjarLayer = null;
let desaBoundaryLayer = null;
let banjarLayerById = {};
let banjarMarkerLayers = [];
let banjarLoaded = false;

function getBanjarStyle(isSelected = false) {
    return {
        color: isSelected ? '#ea580c' : '#1e40af',
        weight: isSelected ? 3 : 2,
        opacity: 0.9,
        fillColor: isSelected ? '#fb923c' : '#3b82f6',
        fillOpacity: isSelected ? 0.4 : 0.22
    };
}

function renderBanjarButtons(features) {
    const listEl = document.getElementById('banjar-list');
    if (!listEl) return;

    if (!features.length) {
        listEl.innerHTML = '<p class="text-sm text-amber-700">Data banjar dinas belum tersedia di database.</p>';
        return;
    }

    listEl.innerHTML = features.map((feature) => {
        const id = feature?.properties?.id ?? '';
        const nama = feature?.properties?.nama ?? 'Banjar';
        const total = Number(feature?.properties?.total_penduduk ?? 0);

        return `
            <div class="flex items-center justify-between gap-2 rounded-2xl border border-gray-100 p-3">
                <div>
                    <p class="font-semibold text-gray-800">${nama}</p>
                    <p class="text-xs text-gray-500">Penduduk: ${total.toLocaleString('id-ID')} jiwa</p>
                </div>
                <button
                    type="button"
                    class="shrink-0 rounded-xl bg-blue-600 px-3 py-2 text-xs font-medium text-white hover:bg-blue-700"
                    onclick="focusBanjarById('${id}')"
                >
                    Lihat Posisi
                </button>
            </div>
        `;
    }).join('');
}

function focusBanjarById(banjarId) {
    if (!wilayahMap || !banjarLayerById[banjarId]) return;

    Object.values(banjarLayerById).forEach((layer) => layer.setStyle(getBanjarStyle(false)));

    const targetLayer = banjarLayerById[banjarId];
    targetLayer.setStyle(getBanjarStyle(true));
    wilayahMap.fitBounds(targetLayer.getBounds(), { padding: [28, 28] });
    targetLayer.openPopup();
}

function getBalaiMarkerIcon(iconUrl = null) {
    return L.icon({
        iconUrl: iconUrl || '/image/marker-balai.png',
        iconSize: [34, 44],
        iconAnchor: [17, 42],
        popupAnchor: [0, -34]
    });
}

function renderBanjarMarkers(features) {
    banjarMarkerLayers.forEach((m) => wilayahMap.removeLayer(m));
    banjarMarkerLayers = [];

    features.forEach((feature) => {
        const banjarNama = feature?.properties?.nama ?? 'Banjar';
        const markers = Array.isArray(feature?.properties?.markers) ? feature.properties.markers : [];

        markers.forEach((item) => {
            const lat = Number(item?.lat);
            const lng = Number(item?.lng);
            if (!Number.isFinite(lat) || !Number.isFinite(lng)) return;

            const marker = L.marker([lat, lng], {
                icon: getBalaiMarkerIcon(item?.icon_url || null)
            }).addTo(wilayahMap);

            marker.bindPopup(`<b>${item?.nama ?? 'Balai Banjar'}</b><br>${banjarNama}${item?.alamat ? `<br>${item.alamat}` : ''}`);
            banjarMarkerLayers.push(marker);
        });
    });
}

async function loadBanjarDinas() {
    const response = await fetch('/api/wilayah-desa/banjar-dinas', {
        headers: { 'Accept': 'application/json' }
    });

    if (!response.ok) {
        throw new Error('Gagal memuat data banjar dinas');
    }

    return response.json();
}

async function initMap() {
    const markerKantor = [-8.543817207683, 115.3028445063262];
    const batasDesaBuruan = [
        [-8.535158, 115.303405],[-8.535113, 115.302385],[-8.535075, 115.302010],[-8.535186, 115.301521],
        [-8.535146, 115.301180],[-8.534847, 115.300921],[-8.534434, 115.300809],[-8.532862, 115.300740],
        [-8.532336, 115.300553],[-8.531925, 115.300293],[-8.531736, 115.299917],[-8.531657, 115.299541],
        [-8.531806, 115.299202],[-8.532179, 115.298861],[-8.532850, 115.298446],[-8.534382, 115.297762],
        [-8.535914, 115.297231],[-8.536328, 115.297151],[-8.536700, 115.297187],[-8.537076, 115.297336],
        [-8.537449, 115.297445],[-8.537860, 115.297408],[-8.538158, 115.297256],[-8.538498, 115.296756],
        [-8.540687, 115.291566],[-8.540678, 115.290574],[-8.540600, 115.289909],[-8.540933, 115.289870],
        [-8.541482, 115.289861],[-8.542015, 115.289714],[-8.542662, 115.289340],[-8.542853, 115.289328],
        [-8.543119, 115.289479],[-8.543295, 115.289770],[-8.543297, 115.290129],[-8.543623, 115.290664],
        [-8.544212, 115.291205],[-8.544707, 115.291133],[-8.545209, 115.290955],[-8.547116, 115.289946],
        [-8.547288, 115.289946],[-8.547477, 115.290007],[-8.547770, 115.290183],[-8.547904, 115.290427],
        [-8.547968, 115.290628],[-8.547995, 115.291198],[-8.548151, 115.291485],[-8.548327, 115.291586],
        [-8.549119, 115.291723],[-8.549344, 115.291795],[-8.549868, 115.291878],[-8.550235, 115.291994],
        [-8.551475, 115.292144],[-8.551702, 115.292140],[-8.551863, 115.292094],[-8.552047, 115.292003],
        [-8.551699, 115.293192],[-8.551038, 115.294947],[-8.550069, 115.296791],[-8.549854, 115.297410],
        [-8.549826, 115.298735],[-8.549999, 115.299355],[-8.550311, 115.300035],[-8.550718, 115.300624],
        [-8.551121, 115.300940],[-8.551355, 115.301284],[-8.551547, 115.301300],[-8.551742, 115.301400],
        [-8.551992, 115.301479],[-8.552404, 115.301569],[-8.553113, 115.301840],[-8.554660, 115.302323],
        [-8.554870, 115.302773],[-8.555052, 115.303621],[-8.555091, 115.304282],[-8.555095, 115.305192],
        [-8.555121, 115.305960],[-8.555195, 115.306428],[-8.555351, 115.306833],[-8.555890, 115.307553],
        [-8.556191, 115.307874],[-8.556412, 115.308187],[-8.556252, 115.308275],[-8.556111, 115.308440],
        [-8.555901, 115.308669],[-8.555895, 115.308671],[-8.555368, 115.308945],[-8.555231, 115.309101],
        [-8.555126, 115.309334],[-8.554984, 115.310112],[-8.554424, 115.310729],[-8.554361, 115.310819],
        [-8.553922, 115.311178],[-8.553627, 115.311315],[-8.553420, 115.311355],[-8.553261, 115.311398],
        [-8.552781, 115.311571],[-8.552559, 115.311716],[-8.552474, 115.311792],[-8.552393, 115.311921],
        [-8.552349, 115.312041],[-8.552411, 115.312103],[-8.552315, 115.312013],[-8.552140, 115.312174],
        [-8.551517, 115.312568],[-8.549348, 115.312525],[-8.546245, 115.312198],[-8.544571, 115.312121],
        [-8.544199, 115.312030],[-8.543644, 115.312044],[-8.543393, 115.312100],[-8.543114, 115.312236],
        [-8.542803, 115.312150],[-8.541745, 115.312115],[-8.541160, 115.311987],[-8.540228, 115.312046],
        [-8.539344, 115.311820],[-8.539305, 115.311132],[-8.539594, 115.309400],[-8.539632, 115.308725],
        [-8.539594, 115.308086],[-8.539317, 115.307144],[-8.538840, 115.306318],[-8.538389, 115.305650],
        [-8.535935, 115.303434],[-8.535683, 115.303401]
    ];

    if (!wilayahMap) {
        wilayahMap = L.map('map');
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(wilayahMap);
    }

    if (!kantorMarker) {
        kantorMarker = L.marker(markerKantor).addTo(wilayahMap)
            .bindPopup('<b>🏛️ Kantor Desa Buruan</b><br>Blahbatuh, Gianyar');
    }

    if (!desaBoundaryLayer) {
        desaBoundaryLayer = L.polygon(batasDesaBuruan, {
            color: '#0f172a',
            weight: 4,
            opacity: 0.95,
            fillOpacity: 0.03
        }).addTo(wilayahMap);
        desaBoundaryLayer.bindPopup('<b>Wilayah Desa Buruan</b><br>Batas utama desa');
    }

    if (banjarLoaded) {
        setTimeout(() => wilayahMap.invalidateSize(), 80);
        return;
    }

    const listEl = document.getElementById('banjar-list');
    if (listEl) listEl.textContent = 'Memuat data banjar dinas...';

    try {
        const geojson = await loadBanjarDinas();
        const features = Array.isArray(geojson?.features) ? geojson.features : [];

        banjarLayerById = {};

        if (banjarLayer) {
            wilayahMap.removeLayer(banjarLayer);
            banjarLayer = null;
        }

        banjarLayer = L.geoJSON(geojson, {
            style: () => getBanjarStyle(false),
            onEachFeature: (feature, layer) => {
                const id = String(feature?.properties?.id ?? '');
                const nama = feature?.properties?.nama ?? 'Banjar';
                const total = Number(feature?.properties?.total_penduduk ?? 0);

                banjarLayerById[id] = layer;
                layer.bindPopup(`<b>${nama}</b><br>Penduduk: ${total.toLocaleString('id-ID')} jiwa`);
                layer.on('click', () => {
                    Object.values(banjarLayerById).forEach((l) => l.setStyle(getBanjarStyle(false)));
                    layer.setStyle(getBanjarStyle(true));
                });
            }
        }).addTo(wilayahMap);

        renderBanjarMarkers(features);
        renderBanjarButtons(features);

        if (features.length) {
            wilayahMap.fitBounds(banjarLayer.getBounds(), { padding: [20, 20] });
        } else {
            wilayahMap.fitBounds(desaBoundaryLayer.getBounds(), { padding: [20, 20] });
        }

        banjarLoaded = true;
    } catch (error) {
        console.error(error);
        if (listEl) {
            listEl.innerHTML = '<p class="text-sm text-red-600">Gagal memuat data banjar dinas dari database.</p>';
        }
        if (desaBoundaryLayer) {
            wilayahMap.fitBounds(desaBoundaryLayer.getBounds(), { padding: [20, 20] });
        } else {
            wilayahMap.setView(markerKantor, 15);
        }
    } finally {
        setTimeout(() => wilayahMap.invalidateSize(), 120);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    window.showSection = function(section) {
        document.querySelectorAll('.section').forEach(s => s.classList.add('hidden'));
        const target = document.getElementById(`section-${section}`);
        if (target) target.classList.remove('hidden');

        document.querySelectorAll('.menu-item').forEach(item => {
            item.classList.remove('active', 'border-white');
            if (item.getAttribute('onclick')?.includes(section)) {
                item.classList.add('active', 'border-white');
            }
        });

        if (section === 'wilayah') {
            setTimeout(() => {
                initMap();
            }, 250);
        }
    };
});
</script>

</x-app-layout>
