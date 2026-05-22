<x-app-layout>
    <x-slot name="title">Pengelolaan Pengaduan Masyarakat</x-slot>
    @php($routePrefix = request()->routeIs('kepala.*') ? 'kepala' : 'admin')

    <div class="min-h-screen bg-gray-100 flex">
        @include('admin.partials.sidebar')

        <main class="flex-1 p-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">Daftar Pengaduan Masyarakat</h3>
                    <p class="text-sm text-gray-500 mt-1">Kelola status, catatan tindak lanjut, dan pantau timeline proses.</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route($routePrefix . '.pengaduan.export.excel') }}" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-medium">
                        Export Excel
                    </a>
                    <a href="{{ route($routePrefix . '.pengaduan.export.pdf') }}" target="_blank" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-medium">
                        Export PDF
                    </a>
                    <button id="btn-refresh" type="button" class="px-5 py-2.5 bg-orange-500 hover:bg-orange-600 text-white rounded-xl text-sm font-medium">
                        Refresh Data
                    </button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-600 text-white px-5 py-2.5 rounded-xl hover:bg-red-700 text-sm font-medium">
                            Logout
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">
                <div class="flex flex-col md:flex-row gap-3 md:items-center md:justify-between">
                    <input
                        type="text"
                        id="searchInput"
                        placeholder="Cari nomor tiket, nama pelapor, atau judul..."
                        class="w-full md:w-[28rem] border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-orange-500 focus:ring-orange-500"
                    >
                    <select id="statusFilter" class="border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-orange-500 focus:ring-orange-500">
                        <option value="all">Semua Status</option>
                        <option value="baru">Baru</option>
                        <option value="diproses">Diproses</option>
                        <option value="selesai">Selesai</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold text-gray-600">Tanggal</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-600">No. Tiket</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-600">Nama Pelapor</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-600">Judul Pengaduan</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-600">Status</th>
                            <th class="px-6 py-4 text-right font-semibold text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="complaintTable" class="divide-y divide-gray-100"></tbody>
                </table>
            </div>

            <section id="detailPanel" class="hidden mt-8 bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-6">
                    <div>
                        <h4 id="detailTitle" class="text-2xl font-semibold text-gray-800">Detail Pengaduan</h4>
                        <p id="detailInfo" class="text-sm text-gray-500 mt-1"></p>
                    </div>
                    <button id="closeDetailButton" type="button" class="text-sm px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-50">
                        Tutup
                    </button>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <div class="rounded-xl border border-gray-100 p-4">
                        <p class="text-xs text-gray-500">Status Saat Ini</p>
                        <p id="detailStatusText" class="font-semibold text-gray-800 mt-1">-</p>
                    </div>
                    <div class="rounded-xl border border-gray-100 p-4">
                        <p class="text-xs text-gray-500">Tanggal Laporan</p>
                        <p id="detailTanggalText" class="font-semibold text-gray-800 mt-1">-</p>
                    </div>
                    <div class="rounded-xl border border-gray-100 p-4">
                        <p class="text-xs text-gray-500">Pelapor</p>
                        <p id="detailPelaporText" class="font-semibold text-gray-800 mt-1">-</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    <div class="lg:col-span-5 space-y-6">
                        <div>
                            <h5 class="font-medium text-gray-800 mb-2">Isi Pengaduan</h5>
                            <p id="detailDeskripsi" class="text-sm text-gray-700 leading-relaxed">-</p>
                        </div>
                        <div>
                            <h5 class="font-medium text-gray-800 mb-2">Foto Bukti</h5>
                            <div id="fotoBukti" class="grid grid-cols-2 gap-3"></div>
                        </div>
                    </div>
                    <div class="lg:col-span-3">
                        <h5 class="font-medium text-gray-800 mb-2">Timeline</h5>
                        <div id="timeline" class="space-y-3"></div>
                    </div>
                    <div class="lg:col-span-4">
                        <h5 class="font-medium text-gray-800 mb-2">Tindak Lanjut Admin</h5>
                        <div class="space-y-4">
                            <div>
                                <label for="statusSelect" class="block text-sm text-gray-600 mb-1">Status</label>
                                <select id="statusSelect" class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-orange-500 focus:ring-orange-500">
                                    <option value="baru">Baru</option>
                                    <option value="sedang_diproses">Sedang Diproses</option>
                                    <option value="selesai">Selesai</option>
                                    <option value="ditolak">Ditolak</option>
                                </select>
                            </div>
                            <div>
                                <label for="catatan" class="block text-sm text-gray-600 mb-1">Catatan Admin</label>
                                <textarea id="catatan" rows="8" class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-orange-500 focus:ring-orange-500" placeholder="Tulis tindak lanjut untuk warga..."></textarea>
                            </div>
                            <div>
                                <label for="fotoBuktiInput" class="block text-sm text-gray-600 mb-1">Foto Bukti Tindak Lanjut (Opsional)</label>
                                <input
                                    id="fotoBuktiInput"
                                    type="file"
                                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                    class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm"
                                >
                                <p class="text-xs text-gray-500 mt-1">Gunakan untuk bukti progres (mis. baru dikerjakan 3 meter) atau bukti selesai.</p>
                            </div>
                            <button id="saveChangesButton" type="button" class="w-full py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-xl text-sm font-medium">
                                Simpan Perubahan
                            </button>
                            <p id="saveFeedback" class="text-sm hidden"></p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dataUrl = "{{ route($routePrefix . '.pengaduan.data') }}";
            const showUrlTemplate = "{{ route($routePrefix . '.pengaduan.show', ['id' => '__ID__']) }}";
            const updateUrlTemplate = "{{ route($routePrefix . '.pengaduan.update', ['id' => '__ID__']) }}";
            const csrfToken = "{{ csrf_token() }}";

            const complaintTable = document.getElementById('complaintTable');
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const detailPanel = document.getElementById('detailPanel');
            const detailTitle = document.getElementById('detailTitle');
            const detailInfo = document.getElementById('detailInfo');
            const detailDeskripsi = document.getElementById('detailDeskripsi');
            const detailStatusText = document.getElementById('detailStatusText');
            const detailTanggalText = document.getElementById('detailTanggalText');
            const detailPelaporText = document.getElementById('detailPelaporText');
            const statusSelect = document.getElementById('statusSelect');
            const catatanInput = document.getElementById('catatan');
            const fotoBuktiInput = document.getElementById('fotoBuktiInput');
            const timeline = document.getElementById('timeline');
            const fotoBukti = document.getElementById('fotoBukti');
            const saveFeedback = document.getElementById('saveFeedback');

            let complaints = [];
            let currentId = null;

            const normalizeStatus = (status) => {
                if (status === 'sedang_diproses' || status === 'diproses') return 'diproses';
                return status;
            };

            const formatStatusLabel = (status) => {
                const labels = {
                    baru: 'Baru',
                    sedang_diproses: 'Sedang Diproses',
                    diproses: 'Sedang Diproses',
                    selesai: 'Selesai',
                    ditolak: 'Ditolak',
                };
                return labels[status] || status || '-';
            };

            const statusClass = (status) => {
                if (status === 'selesai') return 'bg-emerald-100 text-emerald-700';
                if (status === 'ditolak') return 'bg-rose-100 text-rose-700';
                if (status === 'sedang_diproses' || status === 'diproses') return 'bg-blue-100 text-blue-700';
                return 'bg-amber-100 text-amber-700';
            };

            const renderTable = () => {
                const q = (searchInput.value || '').trim().toLowerCase();
                const selectedStatus = statusFilter.value;

                const filtered = complaints.filter((item) => {
                    const hay = `${item.nomor} ${item.nama_pelapor} ${item.judul}`.toLowerCase();
                    const matchSearch = q === '' || hay.includes(q);
                    const matchStatus = selectedStatus === 'all' || normalizeStatus(item.status) === selectedStatus;
                    return matchSearch && matchStatus;
                });

                if (filtered.length === 0) {
                    complaintTable.innerHTML = '<tr><td colspan="6" class="px-6 py-10 text-center text-gray-500">Data tidak ditemukan.</td></tr>';
                    return;
                }

                complaintTable.innerHTML = filtered.map((item) => `
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">${item.tanggal}</td>
                        <td class="px-6 py-4 font-medium text-gray-700">${item.nomor}</td>
                        <td class="px-6 py-4">${item.nama_pelapor}</td>
                        <td class="px-6 py-4">${item.judul}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold ${statusClass(item.status)}">${formatStatusLabel(item.status)}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button type="button" class="detail-btn px-3 py-1.5 rounded-lg border border-orange-200 text-orange-700 hover:bg-orange-50 text-sm" data-id="${item.id}">
                                Detail
                            </button>
                        </td>
                    </tr>
                `).join('');

                complaintTable.querySelectorAll('.detail-btn').forEach((btn) => {
                    btn.addEventListener('click', () => showDetail(btn.dataset.id));
                });
            };

            const loadPengaduan = async () => {
                complaintTable.innerHTML = '<tr><td colspan="6" class="px-6 py-10 text-center text-gray-500">Memuat data...</td></tr>';
                try {
                    const res = await fetch(dataUrl);
                    complaints = await res.json();
                    renderTable();
                } catch (error) {
                    complaintTable.innerHTML = '<tr><td colspan="6" class="px-6 py-10 text-center text-rose-600">Gagal memuat data pengaduan.</td></tr>';
                }
            };

            const renderTimeline = (items) => {
                if (!Array.isArray(items) || items.length === 0) {
                    timeline.innerHTML = '<p class="text-sm text-gray-500">Belum ada timeline.</p>';
                    return;
                }

                timeline.innerHTML = items.map((item) => `
                    <div class="rounded-xl border border-gray-100 p-3">
                        <div class="flex items-center justify-between gap-2">
                            <p class="text-sm font-medium text-gray-800">${formatStatusLabel(item.status)}</p>
                            <p class="text-xs text-gray-500">${item.waktu || '-'}</p>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Oleh: ${item.dibuat_oleh || '-'}</p>
                        <p class="text-sm text-gray-700 mt-2">${item.catatan || '-'}</p>
                        ${item.foto_bukti_url ? `<a href="${item.foto_bukti_url}" target="_blank" rel="noopener noreferrer" class="inline-block mt-2"><img src="${item.foto_bukti_url}" alt="Bukti Tindak Lanjut" class="w-24 h-24 rounded-lg object-cover border border-gray-200"></a>` : ''}
                    </div>
                `).join('');
            };

            const renderFoto = (paths) => {
                if (!Array.isArray(paths) || paths.length === 0) {
                    fotoBukti.innerHTML = '<p class="text-sm text-gray-500">Tidak ada foto bukti.</p>';
                    return;
                }

                fotoBukti.innerHTML = paths.map((path) => {
                    const url = path.startsWith('http') ? path : `/storage/${path}`;
                    return `
                        <a href="${url}" target="_blank" rel="noopener noreferrer" class="block">
                            <img src="${url}" alt="Foto Bukti" class="w-full h-28 object-cover rounded-xl border border-gray-200">
                        </a>
                    `;
                }).join('');
            };

            const setFeedback = (message, isError = false) => {
                saveFeedback.textContent = message;
                saveFeedback.classList.remove('hidden', 'text-emerald-600', 'text-rose-600');
                saveFeedback.classList.add(isError ? 'text-rose-600' : 'text-emerald-600');
            };

            const clearFeedback = () => {
                saveFeedback.classList.add('hidden');
                saveFeedback.textContent = '';
            };

            const showDetail = async (id) => {
                currentId = id;
                clearFeedback();
                detailPanel.classList.remove('hidden');
                detailTitle.textContent = 'Memuat detail...';
                detailInfo.textContent = '';

                try {
                    const showUrl = showUrlTemplate.replace('__ID__', id);
                    const res = await fetch(showUrl);
                    if (!res.ok) throw new Error('Gagal memuat detail');
                    const data = await res.json();

                    detailTitle.textContent = `${data.nomor} - ${data.judul}`;
                    detailInfo.textContent = `${data.nama_pelapor} • ${data.tanggal}`;
                    detailDeskripsi.textContent = data.deskripsi || '-';
                    detailStatusText.textContent = formatStatusLabel(data.status);
                    detailTanggalText.textContent = data.tanggal || '-';
                    detailPelaporText.textContent = data.nama_pelapor || '-';

                    statusSelect.value = data.status === 'diproses' ? 'sedang_diproses' : data.status;
                    catatanInput.value = data.catatan_admin || '';
                    if (fotoBuktiInput) fotoBuktiInput.value = '';

                    renderTimeline(data.timeline);
                    renderFoto(data.foto_bukti);
                } catch (error) {
                    detailTitle.textContent = 'Gagal memuat detail pengaduan';
                    detailInfo.textContent = 'Silakan coba lagi.';
                }
            };

            const saveChanges = async () => {
                if (!currentId) return;
                clearFeedback();

                try {
                    const updateUrl = updateUrlTemplate.replace('__ID__', currentId);
                    const formData = new FormData();
                    formData.append('_method', 'PUT');
                    formData.append('status', statusSelect.value);
                    formData.append('catatan', catatanInput.value || '');
                    if (fotoBuktiInput && fotoBuktiInput.files && fotoBuktiInput.files[0]) {
                        formData.append('foto_bukti', fotoBuktiInput.files[0]);
                    }

                    const res = await fetch(updateUrl, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: formData,
                    });

                    if (!res.ok) {
                        throw new Error('Gagal menyimpan perubahan');
                    }

                    setFeedback('Perubahan berhasil disimpan.');
                    await Promise.all([loadPengaduan(), showDetail(currentId)]);
                } catch (error) {
                    setFeedback('Gagal menyimpan perubahan. Coba lagi.', true);
                }
            };

            document.getElementById('btn-refresh').addEventListener('click', loadPengaduan);
            document.getElementById('closeDetailButton').addEventListener('click', () => detailPanel.classList.add('hidden'));
            document.getElementById('saveChangesButton').addEventListener('click', saveChanges);
            searchInput.addEventListener('input', renderTable);
            statusFilter.addEventListener('change', renderTable);

            loadPengaduan();
        });
    </script>
</x-app-layout>
