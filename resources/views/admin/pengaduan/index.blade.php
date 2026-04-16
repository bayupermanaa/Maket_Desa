<x-app-layout>
    <x-slot name="title">Pengelolaan Pengaduan Masyarakat</x-slot>

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

        <!-- KONTEN UTAMA -->
        <main class="flex-1 p-10">
                <!-- HEADER -->
                <div class="flex justify-between items-center mb-8">
                    <h3 class="text-2xl font-bold">Daftar Pengaduan Masyarakat</h3>
                    <div class="flex items-center gap-4">
                        <button onclick="loadPengaduan()" class="px-5 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-2xl flex items-center gap-2">↻ Refresh Data</button>
                        <div class="relative cursor-pointer">
                            <span class="text-2xl">🛎️</span>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs px-1.5 rounded-full">3</span>
                        </div>
                        <button onclick="logout()" class="bg-red-600 text-white px-5 py-2 rounded-lg hover:bg-red-700">Logout</button>
                    </div>
                </div>

                <!-- SEARCH BAR -->
                <input type="text" id="searchInput" placeholder="Cari nama pelapor atau judul pengaduan..."
                       class="w-full md:w-96 border border-gray-300 rounded-2xl px-5 py-3 mb-6 focus:outline-none focus:border-orange-500">

                <!-- TABLE -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left">Tanggal</th>
                                <th class="px-6 py-4 text-left">Nomor</th>
                                <th class="px-6 py-4 text-left">Nama Pelapor</th>
                                <th class="px-6 py-4 text-left">Judul Pengaduan</th>
                                <th class="px-6 py-4 text-left">Status</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="complaintTable" class="divide-y divide-gray-200 odd:bg-gray-50"></tbody>
                    </table>
                </div>

                <!-- DETAIL PANEL -->
                <div id="detailPanel" class="hidden mt-8 bg-white rounded-3xl shadow-sm p-8">
                    <div class="flex justify-between mb-6">
                        <div>
                            <h3 class="text-2xl font-semibold" id="detailTitle"></h3>
                            <p class="text-gray-500" id="detailInfo"></p>
                        </div>
                        <button onclick="closeDetail()" class="text-3xl text-gray-400 hover:text-gray-600">✕</button>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                        <div class="lg:col-span-3">
                            <h4 class="font-medium mb-4">Timeline</h4>
                            <div id="timeline" class="space-y-6 border-l-2 border-orange-200 pl-6"></div>
                        </div>
                        <div class="lg:col-span-4">
                            <h4 class="font-medium mb-4">Foto Bukti</h4>
                            <div id="fotoBukti" class="grid grid-cols-2 gap-4"></div>
                        </div>
                        <div class="lg:col-span-5">
                            <h4 class="font-medium mb-4">Catatan & Tindak Lanjut</h4>
                            <textarea id="catatan" rows="6" class="w-full border rounded-2xl p-5"></textarea>

                            <div class="mt-6">
                                <label class="block text-sm font-medium mb-2">Upload Bukti Tindak Lanjut</label>
                                <input type="file" class="w-full">
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex gap-4">
                        <button onclick="updateStatus('sedang_diproses')" class="flex-1 py-4 bg-yellow-500 text-white rounded-2xl">Sedang Diproses</button>
                        <button onclick="updateStatus('selesai')" class="flex-1 py-4 bg-green-600 text-white rounded-2xl">Selesai</button>
                        <button onclick="saveChanges()" class="flex-1 py-4 bg-orange-600 text-white rounded-2xl">Simpan Perubahan</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    @push('scripts')
    <script>
        let currentId = null;

        async function loadPengaduan() {
            const tbody = document.getElementById('complaintTable');
            tbody.innerHTML = `<tr><td colspan="6" class="text-center py-10">Memuat data...</td></tr>`;

            try {
                const res = await fetch("{{ route('admin.pengaduan.data') }}");
                const data = await res.json();

                let html = '';
                data.forEach(item => {
                    const statusClass = item.status === 'sedang_diproses' ? 'bg-yellow-100 text-yellow-700' : 
                                       item.status === 'selesai' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700';
                    
                    html += `
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-5">${item.tanggal}</td>
                            <td class="px-6 py-5 font-medium">${item.nomor}</td>
                            <td class="px-6 py-5">${item.nama_pelapor}</td>
                            <td class="px-6 py-5">${item.judul}</td>
                            <td class="px-6 py-5"><span class="px-4 py-1 rounded-full text-xs font-medium ${statusClass}">${item.status}</span></td>
                            <td class="px-6 py-5 text-center">
                                <button onclick="showDetail(${item.id})" class="text-orange-600 hover:underline">Detail →</button>
                            </td>
                        </tr>
                    `;
                });

                tbody.innerHTML = html || `<tr><td colspan="6" class="text-center py-10 text-gray-500">Belum ada pengaduan</td></tr>`;
            } catch(e) {
                tbody.innerHTML = `<tr><td colspan="6" class="text-center py-10 text-red-500">Gagal memuat data</td></tr>`;
            }
        }

        async function showDetail(id) {
            currentId = id;
            document.getElementById('detailPanel').classList.remove('hidden');
            // Tambahkan logika untuk load detail pengaduan
        }

        function closeDetail() {
            document.getElementById('detailPanel').classList.add('hidden');
        }

        function updateStatus(status) {
            alert(`Status diubah menjadi ${status}`);
        }

        async function saveChanges() {
            alert('Perubahan disimpan');
            loadPengaduan();
        }

        window.onload = loadPengaduan;
    </script>
    @endpush
</x-app-layout>