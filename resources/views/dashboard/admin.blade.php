<x-app-layout>
    <x-slot name="title">Dashboard Admin - Desa Maket</x-slot>

    <div class="min-h-screen bg-gray-100 flex">

        <!-- SIDEBAR (sama seperti sebelumnya, saya biarkan) -->
        <aside class="w-72 bg-gray-900 text-white min-h-screen p-6 flex-shrink-0">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 mb-10">
                <div class="w-16 h-16 rounded-2xl overflow-hidden flex-shrink-0 bg-white flex items-center justify-center">
                    <img 
                        src="{{ asset('images/logo.png') }}" 
                        alt="Logo Desa Maket" 
                        class="w-full h-full object-contain"
                        onerror="this.src='https://via.placeholder.com/64?text=Logo'">
                </div>
                <div>
                    <h1 class="text-xl font-semibold">Desa Maket</h1>
                    <p class="text-xs text-gray-400">Admin Panel</p>
                </div>
            </a>

            <nav class="space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-orange-600 text-white' : 'hover:bg-gray-800' }}">
                    🏠 Dashboard
                </a>

                <a href="/admin/data-penduduk" 
                   class="flex items-center gap-3 px-5 py-4 hover:bg-gray-800 text-gray-300 hover:text-white transition-all {{ request()->is('admin/data-penduduk*') ? 'bg-gray-800 text-white' : '' }}">
                    <span class="text-2xl">👥</span>
                    <span class="font-medium">Data Penduduk</span>
                </a>

                <a href="{{ route('admin.pengajuan-surat.index') }}"
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl font-medium transition {{ request()->routeIs('admin.pengajuan-surat.*') ? 'bg-orange-600 text-white' : 'hover:bg-gray-800' }}">
                    📄 Pengajuan Surat
                </a>

                <a href="{{ route('admin.pengaduan') }}" 
                   class="flex items-center justify-between gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.pengaduan') ? 'bg-orange-600 text-white' : 'hover:bg-gray-800' }}">
                    <span class="flex items-center gap-3">
                        <span class="text-xl">📢</span>
                        <span>Pengaduan Masyarakat</span>
                    </span>
                    @if(($pengaduanBaru ?? 0) > 0)
                        <span class="min-w-6 h-6 px-2 rounded-full bg-red-500 text-white text-xs font-semibold flex items-center justify-center">
                            {{ $pengaduanBaru }}
                        </span>
                    @endif
                </a>

                <a href="{{ route('admin.laporan-statistik.index') }}" class="flex items-center gap-3 px-5 py-4 hover:bg-gray-800 rounded-2xl transition">
                    📊 Laporan & Statistik
                </a>

                <a href="{{ route('admin.keuangan') }}" 
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl font-medium transition 
                   {{ request()->routeIs('admin.keuangan') ? 'bg-orange-600 text-white' : 'hover:bg-gray-800' }}">
                    💰 Keuangan Desa
                </a>

                <a href="{{ route('admin.artikel.index') }}"
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl font-medium transition
                           {{ request()->routeIs('admin.artikel.*') ? 'bg-orange-600 text-white' : 'hover:bg-gray-800' }}">
                    <span class="text-2xl">📰</span>
                    <span class="font-medium">Artikel Desa</span>
                </a>

                <a href="{{ route('admin.berita.index') }}"
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl font-medium transition {{ request()->routeIs('admin.berita.*') ? 'bg-orange-600 text-white' : 'hover:bg-gray-800' }}">
                    📰 Berita Desa
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
            </nav>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="flex-1">

            <!-- HEADER -->
            <header class="bg-white border-b shadow-sm px-8 py-5">
                <div class="flex items-center justify-between">
                    <h2 class="text-3xl font-semibold text-gray-800">Dashboard Administrasi</h2>
                    <div class="flex items-center gap-6">
                        <div class="text-right">
                            <p class="font-medium">{{ session('user_name', 'Admin Desa') }}</p>
                            <p class="text-xs text-gray-500">Petugas Administrasi</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Yakin ingin logout?')">
                            @csrf
                            <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-2xl text-sm font-medium flex items-center gap-2 transition">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Isi Dashboard -->
            <div class="p-8">

                <!-- STATISTIC CARDS  -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white rounded-3xl p-7 shadow">
                        <p class="text-sm text-gray-500">Total Penduduk</p>
                        <p class="text-4xl font-bold mt-4">{{ number_format($totalPenduduk ?? 0) }}</p>
                        <div class="mt-8 text-5xl">👥</div>
                    </div>

                    <div class="bg-white rounded-3xl p-7 shadow">
                        <p class="text-sm text-gray-500">Pengajuan Surat</p>
                        <p class="text-4xl font-bold mt-4 text-orange-600">{{ $totalPengajuanSurat ?? 0 }}</p>
                        <div class="mt-8 text-5xl">📄</div>
                    </div>

                    <div class="bg-white rounded-3xl p-7 shadow">
                        <p class="text-sm text-gray-500">Pengaduan Aktif</p>
                        <p class="text-4xl font-bold mt-4 text-red-600">{{ $pengaduanAktif ?? 0 }}</p>
                        <div class="mt-8 text-5xl">⚠️</div>
                    </div>

                    <div class="bg-white rounded-3xl p-7 shadow">
                        <p class="text-sm text-gray-500">Dana Desa</p>
                        <p class="text-4xl font-bold mt-4">Rp {{ number_format($danaDesa ?? 0, 0, ',', '.') }}</p>
                        <div class="mt-8 text-5xl">💰</div>
                    </div>
                </div>

                <div class="mt-8 bg-white rounded-3xl shadow p-6 border border-gray-100">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800">Ringkasan Laporan & Statistik</h3>
                            <p class="text-sm text-gray-500 mt-1">Data singkat dari modul laporan admin.</p>
                        </div>
                        <a href="{{ route('admin.laporan-statistik.index') }}" class="inline-flex items-center justify-center bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-xl text-sm font-medium">
                            Buka Laporan Lengkap
                        </a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-5">
                        <div class="bg-gray-50 rounded-2xl p-4">
                            <p class="text-xs text-gray-500">Total Penduduk</p>
                            <p class="text-2xl font-bold text-gray-800">{{ number_format($totalPenduduk ?? 0) }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-2xl p-4">
                            <p class="text-xs text-gray-500">Pengajuan Surat</p>
                            <p class="text-2xl font-bold text-orange-600">{{ number_format($totalPengajuanSurat ?? 0) }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-2xl p-4">
                            <p class="text-xs text-gray-500">Pengaduan Aktif</p>
                            <p class="text-2xl font-bold text-red-600">{{ number_format($pengaduanAktif ?? 0) }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 bg-white rounded-3xl shadow p-6 border border-gray-100">
                    <h3 class="text-xl font-semibold text-gray-800">Progres Pengaduan Bulan Ini</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-5">
                        <div class="bg-gray-50 rounded-2xl p-4">
                            <p class="text-xs text-gray-500">Total Pengaduan</p>
                            <p class="text-2xl font-bold text-gray-800">{{ number_format($totalPengaduanBulanIni ?? 0) }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-2xl p-4">
                            <p class="text-xs text-gray-500">Selesai</p>
                            <p class="text-2xl font-bold text-emerald-600">{{ number_format($pengaduanSelesaiBulanIni ?? 0) }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-2xl p-4">
                            <p class="text-xs text-gray-500">Persentase Selesai</p>
                            <p class="text-2xl font-bold text-blue-600">{{ $persentaseSelesaiBulanIni ?? 0 }}%</p>
                        </div>
                    </div>
                    <div class="mt-4 rounded-2xl border border-amber-200 bg-amber-50 p-4">
                        <p class="text-xs text-amber-700">Notifikasi Admin</p>
                        <p class="text-lg font-semibold text-amber-800 mt-1">
                            {{ number_format($pengaduanBelumDitindaklanjuti ?? 0) }} pengaduan belum ditindaklanjuti admin.
                        </p>
                    </div>
                </div>

                <!-- RINGKASAN KEUANGAN DESA -->
                <div class="mt-10">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center gap-3">
                        💰 Ringkasan Keuangan Desa
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="bg-white rounded-3xl p-7 shadow border border-emerald-100">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm text-gray-500">Saldo Kas Desa</p>
                                    <p class="text-3xl font-bold text-emerald-600 mt-3">
                                        Rp {{ number_format($saldo ?? 0, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div class="text-4xl opacity-80">💰</div>
                            </div>
                        </div>

                        <div class="bg-white rounded-3xl p-7 shadow border border-blue-100">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm text-gray-500">Total Pendapatan</p>
                                    <p class="text-3xl font-bold text-blue-600 mt-3">
                                        Rp {{ number_format($total_pendapatan ?? 0, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div class="text-4xl opacity-80">📥</div>
                            </div>
                        </div>

                        <div class="bg-white rounded-3xl p-7 shadow border border-orange-100">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm text-gray-500">Total Belanja</p>
                                    <p class="text-3xl font-bold text-orange-600 mt-3">
                                        Rp {{ number_format($total_belanja ?? 0, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div class="text-4xl opacity-80">📤</div>
                            </div>
                        </div>

                        <div class="bg-white rounded-3xl p-7 shadow border border-purple-100">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm text-gray-500">Saldo Akhir</p>
                                    <p class="text-3xl font-bold {{ ($saldo ?? 0) >= 0 ? 'text-emerald-600' : 'text-red-600' }} mt-3">
                                        Rp {{ number_format($saldo ?? 0, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div class="text-4xl opacity-80">📊</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- GRAFIK & AKTIVITAS -->
                <div class="mt-10 grid grid-cols-1 lg:grid-cols-7 gap-6">

                    <!-- Line Chart -->
                    <div class="lg:col-span-4 bg-white rounded-3xl shadow p-8">
                        <h3 class="font-semibold text-xl mb-6">Tren Pengajuan Surat 7 Hari Terakhir</h3>
                        <div class="h-80">
                            <canvas id="lineChart"></canvas>
                        </div>
                    </div>

                    <!-- Aktivitas Terbaru -->
                    <div class="lg:col-span-3 bg-white rounded-3xl shadow p-8">
                        <h3 class="font-semibold text-xl mb-6">Aktivitas Terbaru</h3>
                        <div class="space-y-6">
                            @forelse($aktivitasTerbaru ?? [] as $aktivitas)
                                <div class="flex gap-5">
                                    <div class="w-10 h-10 {{ ($aktivitas['status'] ?? '') == 'selesai' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }} rounded-2xl flex items-center justify-center text-2xl">
                                        {{ ($aktivitas['status'] ?? '') == 'selesai' ? '✅' : '⏳' }}
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-medium">{{ $aktivitas['judul'] ?? '-' }}</p>
                                        <p class="text-sm text-gray-500">{{ $aktivitas['nama'] ?? '-' }} • {{ $aktivitas['waktu'] ?? '-' }}</p>
                                    </div>
                                    <span class="px-4 py-1 rounded-full text-xs font-medium
                                        {{ ($aktivitas['status'] ?? '') == 'selesai' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        {{ ucfirst($aktivitas['status'] ?? '-') }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-8">Belum ada aktivitas terbaru.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Aksi Cepat -->
                <div class="mt-10 bg-white rounded-3xl shadow p-8">
                    <h3 class="font-semibold text-xl mb-6">Aksi Cepat</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('admin.pengajuan-surat.index') }}" 
                           class="py-4 bg-orange-600 hover:bg-orange-700 text-white rounded-2xl font-medium text-center transition">
                            Verifikasi Surat Baru
                        </a>
                        <a href="{{ route('admin.pengaduan') }}" 
                           class="py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-medium text-center transition">
                            Tanggapi Pengaduan
                        </a>
                        <a href="/admin/data-penduduk" 
                           class="py-4 bg-green-600 hover:bg-green-700 text-white rounded-2xl font-medium text-center transition">
                            Update Data Penduduk
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const canvas = document.getElementById('lineChart');
            if (!canvas) return;

            // Data aman dengan default
            const labels = @json($hariLabels) || ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
            const dataPoints = @json($dataPengajuan) || [0, 0, 0, 0, 0, 0, 0];

            new Chart(canvas, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Pengajuan Surat',
                        data: dataPoints,
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(245, 158, 11, 0.1)',
                        tension: 0.4,
                        borderWidth: 4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { display: false } 
                    },
                    scales: { 
                        y: { 
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        } 
                    }
                }
            });
        });
    </script>
</x-app-layout>







