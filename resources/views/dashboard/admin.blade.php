<x-app-layout>
    <x-slot name="title">Dashboard Admin - Desa Maket</x-slot>

    <div class="min-h-screen bg-gray-100 flex">

        <!-- SIDEBAR -->
        <aside class="w-72 bg-gray-900 text-white min-h-screen p-6 flex-shrink-0">
             <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 mb-10">
                    <div class="w-16 h-16 rounded-2xl overflow-hidden flex-shrink-0 bg-white flex items-center justify-center">
                        <img src="{{ asset('storage/images/logo.png') }}" alt="Logo Desa" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h1 class="text-xl font-semibold">Desa Maket</h1>
                        <p class="text-xs text-gray-400">Admin Panel</p>
                    </div>
                </a>

            <nav class="space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl font-medium transition
                          {{ request()->routeIs('admin.dashboard') ? 'bg-orange-600 text-white' : 'hover:bg-gray-800' }}">
                    🏠 Dashboard
                </a>

                <!-- Data Penduduk -->
                <a href="/admin/data-penduduk" 
                    class="flex items-center gap-3 px-5 py-4 hover:bg-gray-800 text-gray-300 hover:text-white transition-all {{ request()->is('admin/data-penduduk*') ? 'bg-gray-800 text-white' : '' }}">
                    <span class="text-2xl">👥</span>
                    <span class="font-medium">Data Penduduk</span>
                </a>

                <!-- Pengajuan Surat -->
                <a href="{{ route('admin.pengajuan-surat.index') }}" 
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl font-medium transition
                          {{ request()->routeIs('admin.pengajuan-surat.*') ? 'bg-orange-600 text-white' : 'hover:bg-gray-800' }}">
                    📄 Pengajuan Surat
                </a>

                <!-- Pengaduan Masyarakat -->
                <a href="{{ route('admin.pengaduan') }}" 
                    class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.pengaduan') ? 'bg-orange-600 text-white' : 'hover:bg-gray-800' }}">
                    📢 Pengaduan Masyarakat
                </a>

                <!-- Laporan & Statistik -->
                <a href="#" 
                   class="flex items-center gap-3 px-5 py-4 hover:bg-gray-800 rounded-2xl transition">
                    📊 Laporan & Statistik
                </a>

                <!-- Keuangan Desa -->
                <a href="#" 
                   class="flex items-center gap-3 px-5 py-4 hover:bg-gray-800 rounded-2xl transition">
                    💰 Keuangan Desa
                </a>

                <!-- Artikel Desa -->
                <a href="{{ route('admin.artikel.index') }}"
                class="flex items-center gap-3 px-5 py-4 rounded-2xl font-medium transition
                        {{ request()->routeIs('admin.artikel.*') ? 'bg-orange-600 text-white' : 'hover:bg-gray-800' }}">
                    <span class="text-2xl">📰</span>
                    <span class="font-medium">Artikel Desa</span>
                </a>

                <a href="{{ route('admin.aparatur-desa.index') }}"
                    class="flex items-center gap-3 px-5 py-4 rounded-2xl font-medium transition {{ request()->routeIs('admin.aparatur-desa.*') ? 'bg-orange-600 text-white' : 'hover:bg-gray-800' }}">
                    🏛️ Aparatur Desa
                </a>

                <!-- Pengaturan -->
                <a href="{{ route('admin.settings-desa.edit') }}" 
                    class="flex items-center gap-3 px-5 py-4 hover:bg-gray-800 rounded-2xl transition">
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
                        <a href="{{ route('logout') }}" 
                           onclick="return confirm('Yakin ingin logout?')"
                           class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-2xl text-sm font-medium flex items-center gap-2 transition">
                            🚪 Logout
                        </a>
                    </div>
                </div>
            </header>

            <!-- Isi Dashboard (content asli kamu) -->
            <div class="p-8">

                <!-- STATISTIC CARDS -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white rounded-3xl p-7 shadow">
                        <p class="text-sm text-gray-500">Total Penduduk</p>
                        <p class="text-4xl font-bold mt-4">2,448</p>
                        <div class="mt-8 text-5xl">👥</div>
                    </div>
                    <div class="bg-white rounded-3xl p-7 shadow">
                        <p class="text-sm text-gray-500">Pengajuan Surat</p>
                        <p class="text-4xl font-bold mt-4 text-orange-600">27</p>
                        <div class="mt-8 text-5xl">📄</div>
                    </div>
                    <div class="bg-white rounded-3xl p-7 shadow">
                        <p class="text-sm text-gray-500">Pengaduan Aktif</p>
                        <p class="text-4xl font-bold mt-4 text-red-600">12</p>
                        <div class="mt-8 text-5xl">⚠️</div>
                    </div>
                    <div class="bg-white rounded-3xl p-7 shadow">
                        <p class="text-sm text-gray-500">Dana Desa</p>
                        <p class="text-4xl font-bold mt-4">Rp 124jt</p>
                        <div class="mt-8 text-5xl">💰</div>
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
                            <div class="flex gap-5">
                                <div class="w-10 h-10 bg-green-100 rounded-2xl flex items-center justify-center text-2xl">✅</div>
                                <div class="flex-1">
                                    <p class="font-medium">Surat Keterangan Usaha disetujui</p>
                                    <p class="text-sm text-gray-500">I Nyoman Sujana • 2 jam yang lalu</p>
                                </div>
                                <span class="bg-green-100 text-green-700 px-4 py-1 rounded-full text-xs">Selesai</span>
                            </div>
                            <div class="flex gap-5">
                                <div class="w-10 h-10 bg-yellow-100 rounded-2xl flex items-center justify-center text-2xl">⏳</div>
                                <div class="flex-1">
                                    <p class="font-medium">Pengaduan jalan rusak sedang diproses</p>
                                    <p class="text-sm text-gray-500">I Wayan Sudarta • 5 jam yang lalu</p>
                                </div>
                                <span class="bg-yellow-100 text-yellow-700 px-4 py-1 rounded-full text-xs">Diproses</span>
                            </div>
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
                        <button class="py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-medium transition">
                            Tanggapi Pengaduan
                        </button>
                        <button class="py-4 bg-green-600 hover:bg-green-700 text-white rounded-2xl font-medium transition">
                            Update Data Penduduk
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Chart(document.getElementById('lineChart'), {
                type: 'line',
                data: {
                    labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                    datasets: [{
                        label: 'Pengajuan Surat',
                        data: [8, 12, 15, 9, 18, 14, 11],
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(245, 158, 11, 0.1)',
                        tension: 0.4,
                        borderWidth: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true } }
                }
            });
        });
    </script>
</x-app-layout>