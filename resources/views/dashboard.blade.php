<x-app-layout>
<div class="min-h-screen bg-gray-50">

    <!-- Header & Logout -->
    <div class="max-w-7xl mx-auto px-6 py-3 flex justify-end">
        @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" onclick="return confirm('Yakin ingin keluar?')"
                    class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-2xl text-sm font-medium">
                    🚪 Logout
                </button>
            </form>
        @endauth
    </div>

         <!-- Main Header -->
    <header class="bg-gradient-to-r from-blue-700 to-blue-500 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 flex-wrap">

                <!-- Info Desa -->
                <div class="flex items-center gap-4 min-w-0">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center text-4xl font-bold text-blue-600 border-4 border-white shadow-inner">
                        MD
                    </div>
                    <div class="min-w-0">
                        <h1 class="text-3xl lg:text-4xl font-bold truncate">
                            SELAMAT DATANG DI DESA <span class="text-yellow-300">{{ $data->nama_desa ?? 'Nama Desa' }}</span>
                        </h1>
                        <p class="mt-1 text-blue-100 text-lg truncate">
                            {{ $data->kecamatan ?? '-' }}, {{ $data->kabupaten ?? '-' }}, {{ $data->provinsi ?? '-' }}
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
                <ul id="menu-bar" class="flex items-center h-14 text-sm font-medium overflow-x-auto whitespace-nowrap flex-wrap">
                    @foreach(['home'=>'🏠 Home','penduduk'=>'👥 Penduduk','statistik'=>'📊 Statistik','wilayah'=>'🗺️ Wilayah','keuangan'=>'💰 Keuangan','program'=>'📋 Program','berita'=>'📰 Berita'] as $key=>$label)
                    <li>
                        <a href="#" onclick="showSection('{{ $key }}')"
                           class="menu-item flex items-center gap-2 px-6 h-full hover:bg-white/10 transition-colors truncate {{ $loop->first ? 'active border-white' : '' }}">
                           {!! $label !!}
                        </a>
                    </li>
                    @endforeach
                    <li class="ml-auto pl-4">
                        <a href="/login" class="flex items-center gap-2 bg-white text-black hover:bg-gray-100 px-6 py-2 rounded-2xl font-semibold transition-all shadow-sm hover:shadow truncate">
                            🔑 Masuk ke Sistem
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>


        <!-- Konten Dinamis -->
    <main class="max-w-7xl mx-auto px-6 py-4 space-y-16">

        <!-- HOME SECTION -->
        <div id="section-home" class="section">
            <h2 class="text-3xl font-semibold text-gray-800 mb-6">
                Selamat Datang di Dashboard Desa {{ $data->nama_desa ?? 'Desa' }}
            </h2>
            <p class="text-gray-600 mb-6">
                Sistem Informasi Desa {{ $data->nama_desa ?? '' }},
                Kecamatan {{ $data->kecamatan ?? '-' }},
                {{ $data->kabupaten ?? '-' }},
                {{ $data->provinsi ?? '-' }}
            </p>

                 <!-- Video Profil -->
                <div class="lg:col-span-8">
                    <div class="bg-white rounded-3xl shadow p-6">
                        <h2 class="text-xl font-bold mb-5">🎬 Video Profil Desa</h2>

                        @if(!empty($data->video_desa))
                            @php
                                $url = trim($data->video_desa);
                                $videoId = '';

                                if(str_contains($url,'youtu.be/')) $videoId = explode('youtu.be/',$url)[1];
                                elseif(str_contains($url,'watch?v=')) $videoId = explode('watch?v=',$url)[1];
                                elseif(str_contains($url,'/embed/')) $videoId = explode('/embed/',$url)[1];
                                else $videoId = $url;

                                $videoId = explode('?', $videoId)[0];
                                $videoId = explode('&', $videoId)[0];
                            @endphp

                            @if($videoId)
                                <div class="aspect-video bg-black rounded-2xl overflow-hidden">
                                    <iframe width="100%" height="100%" src="https://www.youtube.com/embed/{{ trim($videoId) }}"
                                        frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                </div>
                            @else
                                <div class="aspect-video bg-gray-100 rounded-2xl flex items-center justify-center">
                                    <p class="text-gray-500">Video tidak dapat ditampilkan</p>
                                </div>
                            @endif
                        @else
                            <div class="aspect-video bg-gray-100 rounded-2xl flex flex-col items-center justify-center py-16 border border-dashed">
                                <span class="text-6xl mb-4">🎬</span>
                                <p class="text-gray-500">Belum ada video profil desa</p>
                            </div>
                        @endif
                    </div>
                </div>

            <!-- Kepala Desa -->
            <div class="lg:col-span-4">
                @php
                    $fotoKades = optional($data)->kepala_desa_foto
                        ? asset('storage/' . optional($data)->kepala_desa_foto)
                        : asset('images/default-kepala-desa.png');
                @endphp
                <div class="bg-white rounded-3xl shadow p-8 text-center h-full flex flex-col">
                    <img src="{{ $fotoKades }}" alt="Kepala Desa"
                        class="w-52 h-52 object-cover rounded-2xl mx-auto mb-6 shadow-lg border-4 border-white">
                    
                    <h3 class="text-2xl font-bold">
                        {{ optional($data)->nama_kepala_desa ?? 'Nama Kepala Desa' }}
                    </h3>
                    <p class="text-blue-600 font-medium">
                        {{ optional($data)->kepala_desa_jabatan ?? 'Kepala Desa' }}
                    </p>
                    <p class="text-gray-500">
                        {{ optional($data)->kepala_desa_periode }}
                    </p>
                </div>
            </div>

                <!-- Statistik Ringkas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
    <!-- Jumlah Penduduk -->
    <div class="bg-white rounded-3xl shadow p-6 flex items-center gap-4 min-w-0 overflow-hidden">
        <div class="text-5xl">👥</div>
        <div>
            <div class="text-4xl font-bold text-gray-800">{{ $data->jumlah_penduduk ?? 0 }}</div>
            <div class="text-sm text-gray-500">Jumlah Penduduk Saat Ini</div>
        </div>
    </div>

    <!-- Jumlah Banjar / Dusun -->
    <div class="bg-white rounded-3xl shadow p-6 flex items-center gap-4 min-w-0 overflow-hidden">
        <div class="text-5xl">🏘️</div>
        <div>
            <div class="text-4xl font-bold text-gray-800">{{ $data->jumlah_banjar ?? 0 }}</div>
            <div class="text-sm text-gray-500">Banjar / Dusun</div>
        </div>
    </div>

    <!-- Penduduk Baru Tahun Ini -->
    <div class="bg-white rounded-3xl shadow p-6 flex items-center gap-4 min-w-0 overflow-hidden">
        <div class="text-5xl">📈</div>
        <div>
            <div class="text-4xl font-bold text-green-600">{{ $data->penduduk_baru_tahun_ini ?? 0 }}</div>
            <div class="text-sm text-gray-500">Penduduk Baru Tahun Ini</div>
        </div>
    </div>
</div>

                <!-- ==================== APARATUR DESA ==================== -->
                <div class="mt-16">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="text-4xl">🏛️</span>
                        <h3 class="text-2xl font-semibold text-gray-800">Aparatur Desa</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($aparaturDesa as $aparatur)
                            <div class="bg-white rounded-3xl shadow p-6 text-center hover:shadow-xl transition">
                                <img
                                    src="{{ $aparatur->foto ? asset('storage/' . $aparatur->foto) : 'https://via.placeholder.com/200x200/E5E7EB/6B7280?text=Aparatur' }}"
                                    alt="{{ $aparatur->nama }}"
                                    class="w-32 h-32 object-cover rounded-full mx-auto mb-4 border-4 border-blue-100 shadow"
                                >

                                <h4 class="text-lg font-bold text-gray-800">
                                    {{ $aparatur->nama }}
                                </h4>

                                <p class="text-blue-600 font-medium mt-1">
                                    {{ $aparatur->jabatan }}
                                </p>

                                @if(!empty($aparatur->deskripsi))
                                    <p class="text-sm text-gray-500 mt-3">
                                        {{ $aparatur->deskripsi }}
                                    </p>
                                @endif
                            </div>
                        @empty
                            <div class="col-span-full text-center text-gray-500 bg-white rounded-3xl shadow p-8">
                                Belum ada data aparatur desa.
                            </div>
                        @endforelse
                    </div>
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
                                    @if($artikel->gambar && file_exists(public_path('storage/' . $artikel->gambar)))
                                        <img src="{{ asset('storage/' . $artikel->gambar) }}" 
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

                                    <a href="#" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-700 font-medium text-sm mt-5">
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

            <!-- PENDUDUK -->
            <div id="section-penduduk" class="section hidden">
                <h2 class="text-3xl font-semibold mb-6">Data Penduduk</h2>
                <div class="bg-white rounded-2xl shadow overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-blue-50">
                            <tr>
                                <th class="py-4 px-6 text-left">Kategori</th>
                                <th class="py-4 px-6 text-right">Jumlah</th>
                                <th class="py-4 px-6 text-right">Persentase</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            <tr><td class="py-4 px-6">Laki-laki</td><td class="py-4 px-6 text-right">1.238</td><td class="py-4 px-6 text-right">50.57%</td></tr>
                            <tr><td class="py-4 px-6">Perempuan</td><td class="py-4 px-6 text-right">1.210</td><td class="py-4 px-6 text-right">49.43%</td></tr>
                            <tr><td class="py-4 px-6">Usia Produktif (15-64 th)</td><td class="py-4 px-6 text-right">1.652</td><td class="py-4 px-6 text-right">67.48%</td></tr>
                            <tr><td class="py-4 px-6">Lansia (&gt;65 th)</td><td class="py-4 px-6 text-right">312</td><td class="py-4 px-6 text-right">12.75%</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- STATISTIK -->
            <div id="section-statistik" class="section hidden">
                <h2 class="text-3xl font-semibold text-gray-800 mb-2">Statistik Desa Maket</h2>
                <p class="text-gray-600 mb-10">Data per 25 Maret 2026</p>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="bg-white rounded-3xl shadow p-8">
                        <h3 class="font-semibold text-xl mb-6 flex items-center gap-2">
                            👥 Komposisi Penduduk Berdasarkan Jenis Kelamin
                        </h3>
                        <div class="h-80">
                            <canvas id="pieChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl shadow p-8">
                        <h3 class="font-semibold text-xl mb-6 flex items-center gap-2">
                            🏘️ Jumlah Penduduk per Banjar
                        </h3>
                        <div class="h-80">
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl shadow p-8 lg:col-span-2">
                        <h3 class="font-semibold text-xl mb-6 flex items-center gap-2">
                            📈 Pertumbuhan Penduduk 5 Tahun Terakhir
                        </h3>
                        <div class="h-80">
                            <canvas id="lineChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl shadow p-8 lg:col-span-2">
                        <h3 class="font-semibold text-xl mb-6 flex items-center gap-2">
                            🎓 Tingkat Pendidikan Penduduk
                        </h3>
                        <div class="h-80 max-w-md mx-auto">
                            <canvas id="doughnutChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="mt-12 bg-white rounded-3xl shadow overflow-hidden">
                    <div class="px-8 py-5 border-b">
                        <h3 class="font-semibold text-xl">Ringkasan Statistik</h3>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 divide-x divide-y">
                        <div class="p-8 text-center">
                            <div class="text-4xl font-bold text-blue-600">2.448</div>
                            <div class="text-sm text-gray-500 mt-2">Total Penduduk</div>
                        </div>
                        <div class="p-8 text-center">
                            <div class="text-4xl font-bold text-blue-600">1.238</div>
                            <div class="text-sm text-gray-500 mt-2">Laki-laki</div>
                        </div>
                        <div class="p-8 text-center">
                            <div class="text-4xl font-bold text-pink-600">1.210</div>
                            <div class="text-sm text-gray-500 mt-2">Perempuan</div>
                        </div>
                        <div class="p-8 text-center">
                            <div class="text-4xl font-bold text-green-600">67.5%</div>
                            <div class="text-sm text-gray-500 mt-2">Usia Produktif</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- WILAYAH -->
            <div id="section-wilayah" class="section hidden">
                <h2 class="text-3xl font-semibold mb-6">Peta & Wilayah Desa</h2>
                <div class="bg-white rounded-2xl shadow p-8 text-center">
                    <p class="text-gray-500 mb-4">🗺️ Peta Desa Maket (dalam pengembangan)</p>
                    <div class="bg-blue-100 h-96 rounded-xl flex items-center justify-center text-6xl">
                        📍
                    </div>
                    <p class="mt-4 text-sm text-gray-600">Luas wilayah: 12 km² • 12 Banjar • Batas dengan Desa Belega & Desa Bedulu</p>
                </div>
            </div>

            <!-- KEUANGAN -->
            <div id="section-keuangan" class="section hidden">
                <h2 class="text-3xl font-semibold mb-6">Keuangan Desa</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-6 rounded-2xl shadow">
                        <h3 class="font-medium text-lg mb-4">Anggaran Tahun 2026</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between"><span>APBDes</span><span class="font-semibold">Rp 2.845.000.000</span></div>
                            <div class="flex justify-between"><span>Realisasi</span><span class="font-semibold text-green-600">Rp 1.920.000.000 (67%)</span></div>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow">
                        <h3 class="font-medium text-lg mb-4">Pendapatan Utama</h3>
                        <ul class="space-y-2 text-sm">
                            <li class="flex justify-between"><span>Dana Desa</span><span>Rp 1.200.000.000</span></li>
                            <li class="flex justify-between"><span>Alokasi Dana Desa</span><span>Rp 850.000.000</span></li>
                            <li class="flex justify-between"><span>Retribusi & Lain-lain</span><span>Rp 120.000.000</span></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- PROGRAM -->
            <div id="section-program" class="section hidden">
                <h2 class="text-3xl font-semibold mb-6">Program Unggulan Desa</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-2xl shadow">
                        <div class="text-4xl mb-3">🌾</div>
                        <h3 class="font-semibold">Program Pertanian Organik</h3>
                        <p class="text-sm text-gray-600 mt-2">Peningkatan produksi padi organik di 8 banjar</p>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow">
                        <div class="text-4xl mb-3">🏡</div>
                        <h3 class="font-semibold">Desa Wisata Homestay</h3>
                        <p class="text-sm text-gray-600 mt-2">Pengembangan 15 homestay berbasis budaya Bali</p>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow">
                        <div class="text-4xl mb-3">♻️</div>
                        <h3 class="font-semibold">Bank Sampah & Teba Modern</h3>
                        <p class="text-sm text-gray-600 mt-2">Pengelolaan sampah dari rumah tangga</p>
                    </div>
                </div>
            </div>

            <!-- BERITA -->
            <div id="section-berita" class="section hidden">
                <h2 class="text-3xl font-semibold mb-6">Berita Terbaru Desa Maket</h2>
                <div class="space-y-8">
                    <div class="bg-white rounded-2xl shadow p-6 flex gap-6">
                        <div class="w-32 h-24 bg-blue-200 rounded-xl flex-shrink-0"></div>
                        <div>
                            <h3 class="font-semibold text-xl">Peringatan Hari Raya Nyepi 2026 Sukses dan Aman</h3>
                            <p class="text-sm text-gray-500 mt-1">24 Maret 2026</p>
                            <p class="mt-3 text-gray-600">Desa Maket berhasil melaksanakan Nyepi tanpa insiden. Warga sangat antusias mengikuti tradisi Catur Brata Penyepian.</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow p-6 flex gap-6">
                        <div class="w-32 h-24 bg-blue-200 rounded-xl flex-shrink-0"></div>
                        <div>
                            <h3 class="font-semibold text-xl">Panen Raya Padi Organik di Banjar Dukuh</h3>
                            <p class="text-sm text-gray-500 mt-1">20 Maret 2026</p>
                            <p class="mt-3 text-gray-600">Produksi meningkat 18% dibanding tahun lalu berkat program pertanian organik desa.</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow p-6 flex gap-6">
                        <div class="w-32 h-24 bg-blue-200 rounded-xl flex-shrink-0"></div>
                        <div>
                            <h3 class="font-semibold text-xl">Pelatihan Digital Marketing untuk UMKM Desa</h3>
                            <p class="text-sm text-gray-500 mt-1">15 Maret 2026</p>
                            <p class="mt-3 text-gray-600">50 pelaku usaha mengikuti pelatihan yang difasilitasi oleh Dinas Pariwisata Gianyar.</p>
                        </div>
                    </div>
                </div>
            </div>

        <!-- POPUP KEBIJAKAN -->
    @if(!empty($data->popup_aktif))
    <div id="policyModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden px-4">
        <div class="bg-white rounded-2xl w-full max-w-2xl p-6 shadow-2xl relative max-h-[85vh] overflow-y-auto">
            <button id="closePolicy" class="absolute top-4 right-4 text-gray-600 hover:text-gray-900 font-bold text-xl">&times;</button>
            <h2 class="text-2xl font-bold mb-4 text-gray-800">{{ $data->popup_judul ?? 'Kebijakan' }}</h2>
            <div class="text-gray-700 whitespace-pre-line">{{ $data->popup_isi ?? 'Belum ada isi kebijakan.' }}</div>
            <div class="mt-6 text-right">
                <button id="acceptPolicy" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">Tutup</button>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
// Show/hide section & menu active
function showSection(section){
    document.querySelectorAll('.section').forEach(s=>s.classList.add('hidden'));
    document.getElementById(`section-${section}`).classList.remove('hidden');
    document.querySelectorAll('.menu-item').forEach(item=>{
        item.classList.remove('active','border-white');
        if(item.getAttribute('onclick')?.includes(section)) item.classList.add('active','border-white');
    });
}

// Popup kebijakan
document.addEventListener('DOMContentLoaded', function(){
    showSection('home');
    const modal=document.getElementById('policyModal');
    const closeBtn=document.getElementById('closePolicy');
    const acceptBtn=document.getElementById('acceptPolicy');
    if(modal) modal.classList.remove('hidden');
    if(closeBtn) closeBtn.addEventListener('click',()=>modal.classList.add('hidden'));
    if(acceptBtn) acceptBtn.addEventListener('click',()=>modal.classList.add('hidden'));
    if(modal) modal.addEventListener('click',e=>{ if(e.target===modal) modal.classList.add('hidden') });
});
</script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const pieChart = document.getElementById('pieChart');
            const barChart = document.getElementById('barChart');
            const lineChart = document.getElementById('lineChart');
            const doughnutChart = document.getElementById('doughnutChart');

            if (pieChart) {
                new Chart(pieChart, {
                    type: 'pie',
                    data: {
                        labels: ['Laki-laki', 'Perempuan'],
                        datasets: [{
                            data: [1238, 1210],
                            backgroundColor: ['#2563eb', '#ec4899'],
                            borderWidth: 3,
                            borderColor: '#fff'
                        }]
                    },
                    options: { responsive: true, maintainAspectRatio: false }
                });
            }

            if (barChart) {
                new Chart(barChart, {
                    type: 'bar',
                    data: {
                        labels: ['Dukuh', 'Pande', 'Kedewatan', 'Buruan', 'Apuan', 'Tengah', 'Anyar', 'Batu', 'Banyuning', 'Sari', 'Taman', 'Puri'],
                        datasets: [{
                            label: 'Jumlah Penduduk',
                            data: [245, 198, 312, 167, 289, 154, 203, 176, 221, 134, 187, 162],
                            backgroundColor: '#3b82f6',
                            borderRadius: 8,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: { y: { beginAtZero: true } }
                    }
                });
            }

            if (lineChart) {
                new Chart(lineChart, {
                    type: 'line',
                    data: {
                        labels: ['2022', '2023', '2024', '2025', '2026'],
                        datasets: [{
                            label: 'Jumlah Penduduk',
                            data: [2180, 2250, 2315, 2380, 2448],
                            borderColor: '#2563eb',
                            backgroundColor: 'rgba(37, 99, 235, 0.1)',
                            tension: 0.4,
                            borderWidth: 4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } }
                    }
                });
            }

            if (doughnutChart) {
                new Chart(doughnutChart, {
                    type: 'doughnut',
                    data: {
                        labels: ['SD/SMP', 'SMA/SMK', 'Diploma/S1', 'Tidak Sekolah'],
                        datasets: [{
                            data: [42, 38, 15, 5],
                            backgroundColor: ['#60a5fa', '#22c55e', '#2563eb', '#ef4444'],
                            borderWidth: 4
                        }]
                    },
                    options: { responsive: true, maintainAspectRatio: false }
                });
            }
        });
    </script>
</x-app-layout>