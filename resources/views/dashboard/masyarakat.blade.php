<x-app-layout>
    <x-slot name="title">Dashboard Masyarakat - Desa Makét</x-slot>

    <div class="min-h-screen bg-gray-100">
        
        <!-- HEADER -->
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="https://via.placeholder.com/50" alt="Logo" class="h-10 w-10">
                    <div>
                        <h1 class="font-semibold text-lg">Sistem Informasi MAKET Desa Buruan</h1>
                        <p class="text-xs text-gray-500">Kecamatan Blahbatuh, Gianyar, Bali</p>
                    </div>
                </div>

                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-600">Selamat datang,</span>
                        <span class="font-medium">{{ auth()->user()->name ?? 'Bayu Permana' }}</span>
                    </div>
                    
                    <button onclick="logout()" 
                            class="flex items-center gap-2 text-red-600 hover:text-red-700 font-medium">
                        <span>Logout</span>
                    </button>
                </div>
            </div>
        </header>

        <div class="flex max-w-7xl mx-auto">
            
            <!-- SIDEBAR -->
            <div class="w-64 bg-white h-screen border-r p-6">
                <nav class="space-y-1">
                    <a href="#" class="flex items-center gap-3 px-4 py-3 bg-orange-50 text-orange-600 rounded-xl font-medium">
                        <span>🏠</span> Dashboard
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-100 rounded-xl">
                        <span>📄</span> Pengajuan Surat
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-100 rounded-xl">
                        <span>📋</span> Status Pengajuan Surat
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-100 rounded-xl">
                        <span>👤</span> Pengaduan Masyarakat
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-100 rounded-xl">
                        <span>⚠️</span> Status Pengaduan
                    </a>
                </nav>
            </div>

            <!-- KONTEN UTAMA -->
            <div class="flex-1 p-8">
                <h2 class="text-2xl font-semibold mb-8">Dashboard / Beranda</h2>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- Profil Pengguna -->
                    <div class="bg-white rounded-2xl shadow p-6">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-gray-200 rounded-full"></div>
                            <div>
                                <h3 class="font-semibold">Bayu Permana</h3>
                                <p class="text-sm text-gray-500">NIK: 123456789</p>
                                <p class="text-sm text-gray-500">Dusun: Buruan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Ringkasan Pengajuan -->
                    <div class="bg-white rounded-2xl shadow p-6">
                        <h4 class="font-medium mb-4">Ringkasan Pengajuan</h4>
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-3xl font-bold text-orange-600">12</p>
                                <p class="text-sm text-gray-500">Total Pengajuan</p>
                            </div>
                            <div>
                                <p class="text-3xl font-bold text-green-600">2</p>
                                <p class="text-sm text-gray-500">Sedang Diproses</p>
                            </div>
                        </div>
                    </div>

                    <!-- Notifikasi -->
                    <div class="bg-white rounded-2xl shadow p-6">
                        <h4 class="font-medium mb-4 flex items-center gap-2">
                            <span>🛎️</span> Notifikasi Terbaru
                        </h4>
                        <p class="text-sm text-gray-600">Pengajuan Surat Keterangan Usaha sudah disetujui</p>
                        <p class="text-xs text-gray-500 mt-2">2 jam yang lalu</p>
                    </div>
                </div>

                <!-- Status Terbaru -->
                <div class="mt-10">
                    <h3 class="font-semibold mb-4">Status Terbaru</h3>
                    <div class="bg-white rounded-2xl shadow overflow-hidden">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="py-4 px-6 text-left">No</th>
                                    <th class="py-4 px-6 text-left">Tanggal & Jam</th>
                                    <th class="py-4 px-6 text-left">Jenis & Nomor</th>
                                    <th class="py-4 px-6 text-left">Deskripsi Singkat</th>
                                    <th class="py-4 px-6 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                <!-- Isi data dummy -->
                                <tr>
                                    <td class="py-4 px-6">1</td>
                                    <td class="py-4 px-6 text-sm">07 Jan 2026, 10:15</td>
                                    <td class="py-4 px-6">Surat Keterangan Usaha #SKM-001</td>
                                    <td class="py-4 px-6 text-sm">Pengajuan Surat Keterangan Usaha</td>
                                    <td class="py-4 px-6 text-center"><span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">Selesai</span></td>
                                </tr>
                                <!-- Tambahkan baris lain sesuai kebutuhan -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>