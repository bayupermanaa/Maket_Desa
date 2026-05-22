<x-app-layout>
    <x-slot name="title">Dashboard Masyarakat - Desa Maket</x-slot>

    @php
        $namaMasyarakat = session('user_name', 'Warga Desa');
        $statusBadgeSurat = [
            'Menunggu' => 'bg-amber-100 text-amber-700',
            'Diproses' => 'bg-blue-100 text-blue-700',
            'Disetujui' => 'bg-emerald-100 text-emerald-700',
            'Ditolak' => 'bg-rose-100 text-rose-700',
        ];
        $statusBadgePengaduan = [
            'baru' => 'bg-amber-100 text-amber-700',
            'sedang_diproses' => 'bg-blue-100 text-blue-700',
            'diproses' => 'bg-blue-100 text-blue-700',
            'selesai' => 'bg-emerald-100 text-emerald-700',
            'ditolak' => 'bg-rose-100 text-rose-700',
        ];
    @endphp

    <div class="min-h-screen bg-gray-100 flex">
        <aside class="w-72 bg-gray-900 text-white min-h-screen p-6 flex-shrink-0">
            <a href="{{ route('dashboard.masyarakat') }}" class="flex items-center gap-3 mb-10">
                <div class="w-16 h-16 rounded-2xl overflow-hidden flex-shrink-0 bg-white flex items-center justify-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Desa" class="w-full h-full object-contain">
                </div>
                <div>
                    <h1 class="text-xl font-semibold">Desa Maket</h1>
                    <p class="text-xs text-gray-400">Portal Masyarakat</p>
                </div>
            </a>

            <nav class="space-y-1" id="menu-masyarakat-side">
                <button type="button" data-target="beranda" class="menu-side-item w-full text-left flex items-center gap-3 px-5 py-4 rounded-2xl font-medium transition bg-orange-600 text-white">
                   🏠 Dashboard
                </button>
                <button type="button" data-target="pengajuan" class="menu-side-item w-full text-left flex items-center gap-3 px-5 py-4 rounded-2xl font-medium transition hover:bg-gray-800">
                    📄 Pengajuan Surat
                </button>
                <button type="button" data-target="status-surat" class="menu-side-item w-full text-left flex items-center gap-3 px-5 py-4 rounded-2xl font-medium transition hover:bg-gray-800">
                    ✅ Status Pengajuan Surat
                </button>
                <button type="button" data-target="pengaduan" class="menu-side-item w-full text-left flex items-center gap-3 px-5 py-4 rounded-2xl font-medium transition hover:bg-gray-800">
                    💬 Pengaduan Masyarakat
                </button>
                <button type="button" data-target="status-pengaduan" class="menu-side-item w-full text-left flex items-center justify-between gap-3 px-5 py-4 rounded-2xl font-medium transition hover:bg-gray-800">
                    <span>✅Status Pengaduan</span>
                    @if(($pengaduanBelumDibaca ?? 0) > 0)
                        <span class="min-w-6 h-6 px-2 rounded-full bg-red-500 text-white text-xs font-semibold flex items-center justify-center">
                            {{ $pengaduanBelumDibaca }}
                        </span>
                    @endif
                </button>
            </nav>
        </aside>

        <div class="flex-1">
            <header class="bg-white border-b shadow-sm px-8 py-5">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-3xl font-semibold text-gray-800">Dashboard Masyarakat</h2>
                        <p class="text-sm text-gray-500 mt-1">Layanan administrasi dan pengaduan warga desa</p>
                    </div>

                    <div class="flex items-center gap-6">
                        <div class="text-right">
                            <p class="font-medium">{{ $namaMasyarakat }}</p>
                            <p class="text-xs text-gray-500">Role: Masyarakat</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-2xl text-sm font-medium transition">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <div class="p-8">
                @if(($pengaduanBelumDibaca ?? 0) > 0)
                    <div id="toast-update-pengaduan" class="mb-6 rounded-2xl border border-blue-200 bg-blue-50 px-5 py-4 text-sm text-blue-800 flex items-start justify-between gap-4">
                        <p>
                            Ada <span class="font-semibold">{{ $pengaduanBelumDibaca }}</span> update baru dari admin pada pengaduan Anda.
                        </p>
                        <button type="button" id="toast-update-close" class="text-blue-700 hover:text-blue-900 font-semibold">Tutup</button>
                    </div>
                @endif

                <section id="section-beranda" class="masyarakat-section">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="bg-white rounded-3xl p-7 shadow">
                            <p class="text-sm text-gray-500">Total Pengajuan Surat</p>
                            <p class="text-4xl font-bold mt-4 text-orange-600">{{ $totalPengajuanSurat ?? 0 }}</p>
                        </div>
                        <div class="bg-white rounded-3xl p-7 shadow">
                            <p class="text-sm text-gray-500">Surat Diproses</p>
                            <p class="text-4xl font-bold mt-4 text-blue-600">{{ $suratDiproses ?? 0 }}</p>
                        </div>
                        <div class="bg-white rounded-3xl p-7 shadow">
                            <p class="text-sm text-gray-500">Total Pengaduan</p>
                            <p class="text-4xl font-bold mt-4 text-emerald-600">{{ $totalPengaduan ?? 0 }}</p>
                        </div>
                        <div class="bg-white rounded-3xl p-7 shadow">
                            <p class="text-sm text-gray-500">Pengaduan Selesai</p>
                            <p class="text-4xl font-bold mt-4 text-purple-600">{{ $pengaduanSelesai ?? 0 }}</p>
                        </div>
                    </div>

                    <div class="mt-8 bg-white rounded-3xl shadow p-6 border border-gray-100">
                        <h3 class="text-xl font-semibold text-gray-800">Informasi Akun</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4 text-sm">
                            <p><span class="font-medium text-gray-800">Nama:</span> {{ $namaMasyarakat }}</p>
                            <p><span class="font-medium text-gray-800">Role:</span> Masyarakat</p>
                            <p><span class="font-medium text-gray-800">Akses:</span> Layanan Publik Desa</p>
                        </div>
                    </div>

                    <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="bg-white rounded-3xl shadow p-6 border border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-800">Pengajuan Surat Terbaru</h3>
                            <div class="mt-4 space-y-3">
                                @forelse(($riwayatPengajuanSurat ?? collect())->take(3) as $item)
                                    <div class="rounded-2xl border border-gray-100 p-4">
                                        <div class="flex items-center justify-between gap-3">
                                            <p class="font-medium text-gray-800">{{ $item->jenis_surat }}</p>
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusBadgeSurat[$item->status] ?? 'bg-gray-100 text-gray-700' }}">
                                                {{ $item->status }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2">{{ optional($item->created_at)->format('d M Y H:i') ?? '-' }}</p>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500">Belum ada pengajuan surat.</p>
                                @endforelse
                            </div>
                        </div>
                        <div class="bg-white rounded-3xl shadow p-6 border border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-800">Pengaduan Terbaru</h3>
                            <div class="mt-4 space-y-3">
                                @forelse(($riwayatPengaduan ?? collect())->take(3) as $item)
                                    <div class="rounded-2xl border border-gray-100 p-4">
                                        <div class="flex items-center justify-between gap-3">
                                            <p class="font-medium text-gray-800">{{ $item->judul }}</p>
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusBadgePengaduan[$item->status] ?? 'bg-gray-100 text-gray-700' }}">
                                                {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2">{{ optional($item->tanggal_pengaduan)->format('d M Y') ?? optional($item->created_at)->format('d M Y H:i') ?? '-' }}</p>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500">Belum ada pengaduan.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </section>

                <section id="section-pengajuan" class="masyarakat-section hidden">
                    <div class="bg-white rounded-3xl shadow p-6 border border-gray-100">
                        <h3 class="text-xl font-semibold text-gray-800">Pengajuan Surat</h3>
                        <p class="text-sm text-gray-500 mt-1">Isi form berikut untuk mengajukan surat ke admin desa.</p>

                        @if (session('success'))
                            <div class="mt-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="mt-4 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                                <p class="font-medium">Data pengajuan belum lengkap:</p>
                                <ul class="mt-1 list-disc pl-5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('masyarakat.pengajuan-surat.store', ['tab' => 'pengajuan']) }}" class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                            @csrf

                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <input
                                    id="nama"
                                    name="nama"
                                    type="text"
                                    required
                                    value="{{ old('nama', auth()->user()->name ?? '') }}"
                                    class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm"
                                >
                            </div>

                            <div>
                                <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                                <input
                                    id="nik"
                                    name="nik"
                                    type="text"
                                    required
                                    maxlength="20"
                                    value="{{ old('nik', auth()->user()->nik ?? '') }}"
                                    class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm"
                                >
                            </div>

                            <div>
                                <label for="jenis_surat" class="block text-sm font-medium text-gray-700">Jenis Surat</label>
                                <select
                                    id="jenis_surat"
                                    name="jenis_surat"
                                    required
                                    class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm"
                                >
                                    <option value="">Pilih jenis surat</option>
                                    @foreach (['Surat Keterangan Domisili', 'Surat Keterangan Usaha', 'Surat Keterangan Tidak Mampu', 'Surat Pengantar SKCK', 'Surat Keterangan Belum Menikah'] as $jenisSurat)
                                        <option value="{{ $jenisSurat }}" {{ old('jenis_surat') === $jenisSurat ? 'selected' : '' }}>{{ $jenisSurat }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="no_hp" class="block text-sm font-medium text-gray-700">No. HP</label>
                                <input
                                    id="no_hp"
                                    name="no_hp"
                                    type="text"
                                    maxlength="20"
                                    value="{{ old('no_hp') }}"
                                    class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm"
                                >
                            </div>

                            <div class="md:col-span-2">
                                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                                <textarea
                                    id="alamat"
                                    name="alamat"
                                    rows="2"
                                    class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm"
                                >{{ old('alamat') }}</textarea>
                            </div>

                            <div class="md:col-span-2">
                                <label for="keperluan" class="block text-sm font-medium text-gray-700">Keperluan</label>
                                <textarea
                                    id="keperluan"
                                    name="keperluan"
                                    required
                                    rows="3"
                                    class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm"
                                >{{ old('keperluan') }}</textarea>
                            </div>

                            <div class="md:col-span-2">
                                <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan Tambahan (Opsional)</label>
                                <textarea
                                    id="keterangan"
                                    name="keterangan"
                                    rows="2"
                                    class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm"
                                >{{ old('keterangan') }}</textarea>
                            </div>

                            <div class="md:col-span-2 flex justify-end">
                                <button type="submit" class="px-6 py-3 rounded-2xl bg-orange-600 text-white text-sm font-medium hover:bg-orange-700 transition">
                                    Kirim Pengajuan Surat
                                </button>
                            </div>
                        </form>
                    </div>
                </section>

                <section id="section-status-surat" class="masyarakat-section hidden">
                    <div class="bg-white rounded-3xl shadow p-6 border border-gray-100 overflow-x-auto">
                        <h3 class="text-xl font-semibold text-gray-800">Status Pengajuan Surat</h3>
                        <table class="w-full mt-4 text-sm">
                            <thead>
                                <tr class="text-left border-b text-gray-500">
                                    <th class="py-3 pr-4">Tanggal</th>
                                    <th class="py-3 pr-4">Jenis Surat</th>
                                    <th class="py-3 pr-4">Status</th>
                                    <th class="py-3">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(($riwayatPengajuanSurat ?? collect()) as $item)
                                    <tr class="border-b border-gray-100 last:border-0">
                                        <td class="py-3 pr-4">{{ optional($item->created_at)->format('d M Y H:i') ?? '-' }}</td>
                                        <td class="py-3 pr-4">{{ $item->jenis_surat }}</td>
                                        <td class="py-3 pr-4">
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusBadgeSurat[$item->status] ?? 'bg-gray-100 text-gray-700' }}">
                                                {{ $item->status }}
                                            </span>
                                        </td>
                                        <td class="py-3">{{ $item->keterangan ?: '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-6 text-center text-gray-500">Belum ada data pengajuan surat.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                <section id="section-pengaduan" class="masyarakat-section hidden">
                    <div class="bg-white rounded-3xl shadow p-6 border border-gray-100">
                        <h3 class="text-xl font-semibold text-gray-800">Pengaduan Masyarakat</h3>
                        <p class="text-sm text-gray-500 mt-1">Sampaikan laporan atau keluhan Anda melalui form berikut.</p>

                        @if (session('success_pengaduan'))
                            <div class="mt-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                                {{ session('success_pengaduan') }}
                            </div>
                        @endif

                        @if ($errors->pengaduan->any())
                            <div class="mt-4 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                                <p class="font-medium">Data pengaduan belum lengkap:</p>
                                <ul class="mt-1 list-disc pl-5">
                                    @foreach ($errors->pengaduan->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('masyarakat.pengaduan.store', ['tab' => 'pengaduan']) }}" enctype="multipart/form-data" class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                            @csrf

                            <div>
                                <label for="nama_pelapor" class="block text-sm font-medium text-gray-700">Nama Pelapor</label>
                                <input
                                    id="nama_pelapor"
                                    name="nama_pelapor"
                                    type="text"
                                    required
                                    value="{{ old('nama_pelapor', auth()->user()->name ?? '') }}"
                                    class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm"
                                >
                            </div>

                            <div>
                                <label for="nik_pengaduan" class="block text-sm font-medium text-gray-700">NIK</label>
                                <input
                                    id="nik_pengaduan"
                                    name="nik"
                                    type="text"
                                    required
                                    maxlength="20"
                                    value="{{ old('nik', auth()->user()->nik ?? '') }}"
                                    class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm"
                                >
                            </div>

                            <div>
                                <label for="no_hp_pengaduan" class="block text-sm font-medium text-gray-700">No. HP</label>
                                <input
                                    id="no_hp_pengaduan"
                                    name="no_hp"
                                    type="text"
                                    maxlength="20"
                                    value="{{ old('no_hp') }}"
                                    class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm"
                                >
                            </div>

                            <div>
                                <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori Pengaduan</label>
                                <select
                                    id="kategori"
                                    name="kategori"
                                    class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm"
                                >
                                    <option value="">Pilih kategori (opsional)</option>
                                    @foreach (['Infrastruktur', 'Lingkungan', 'Keamanan', 'Pelayanan Publik', 'Sosial'] as $kategori)
                                        <option value="{{ $kategori }}" {{ old('kategori') === $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label for="judul" class="block text-sm font-medium text-gray-700">Judul Pengaduan</label>
                                <input
                                    id="judul"
                                    name="judul"
                                    type="text"
                                    required
                                    value="{{ old('judul') }}"
                                    class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm"
                                >
                            </div>

                            <div class="md:col-span-2">
                                <label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi Kejadian</label>
                                <input
                                    id="lokasi"
                                    name="lokasi"
                                    type="text"
                                    value="{{ old('lokasi') }}"
                                    class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm"
                                >
                            </div>

                            <div class="md:col-span-2">
                                <label for="isi" class="block text-sm font-medium text-gray-700">Isi Pengaduan</label>
                                <textarea
                                    id="isi"
                                    name="isi"
                                    required
                                    rows="4"
                                    class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm"
                                >{{ old('isi') }}</textarea>
                            </div>

                            <div class="md:col-span-2">
                                <label for="foto" class="block text-sm font-medium text-gray-700">Foto Bukti (Opsional)</label>
                                <input
                                    id="foto"
                                    name="foto"
                                    type="file"
                                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                    class="mt-2 block w-full text-sm text-gray-700 file:mr-4 file:rounded-xl file:border-0 file:bg-orange-100 file:px-4 file:py-2 file:font-medium file:text-orange-700 hover:file:bg-orange-200"
                                >
                                <p class="mt-1 text-xs text-gray-500">Format: JPG, JPEG, PNG, WEBP. Maksimal 2MB.</p>
                            </div>

                            <div class="md:col-span-2 flex justify-end">
                                <button type="submit" class="px-6 py-3 rounded-2xl bg-orange-600 text-white text-sm font-medium hover:bg-orange-700 transition">
                                    Kirim Pengaduan
                                </button>
                            </div>
                        </form>
                    </div>
                </section>

                <section id="section-status-pengaduan" class="masyarakat-section hidden">
                    <div class="bg-white rounded-3xl shadow p-6 border border-gray-100 overflow-x-auto">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                            <h3 class="text-xl font-semibold text-gray-800">Status Pengaduan</h3>
                            <div class="flex items-center gap-2">
                                <label for="filter-status-pengaduan" class="text-sm text-gray-600">Filter Status</label>
                                <select id="filter-status-pengaduan" class="rounded-xl border-gray-300 text-sm focus:border-orange-500 focus:ring-orange-500">
                                    <option value="all">Semua</option>
                                    <option value="baru">Baru</option>
                                    <option value="diproses">Diproses</option>
                                    <option value="selesai">Selesai</option>
                                    <option value="ditolak">Ditolak</option>
                                    <option value="unread">Belum Dibaca</option>
                                </select>
                            </div>
                        </div>
                        <table class="w-full mt-4 text-sm">
                            <thead>
                                <tr class="text-left border-b text-gray-500">
                                    <th class="py-3 pr-4">Tanggal</th>
                                    <th class="py-3 pr-4">No. Tiket</th>
                                    <th class="py-3 pr-4">Judul</th>
                                    <th class="py-3 pr-4">Foto</th>
                                    <th class="py-3 pr-4">Status</th>
                                    <th class="py-3">Catatan</th>
                                    <th class="py-3 pl-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="status-pengaduan-body">
                                @forelse(($riwayatPengaduan ?? collect()) as $item)
                                    @php
                                        $hasUnreadUpdate = ($item->logs ?? collect())->contains(function ($log) use ($item) {
                                            if (($log->dibuat_oleh ?? '') !== 'Admin') {
                                                return false;
                                            }

                                            $lastSeen = $item->warga_last_seen_log_at;
                                            if (is_null($lastSeen)) {
                                                return true;
                                            }

                                            return optional($log->created_at)?->gt($lastSeen);
                                        });
                                    @endphp
                                    <tr class="border-b border-gray-100 last:border-0 status-pengaduan-row" data-status="{{ strtolower((string) $item->status) }}" data-unread="{{ $hasUnreadUpdate ? '1' : '0' }}">
                                        <td class="py-3 pr-4">{{ optional($item->tanggal_pengaduan)->format('d M Y') ?? optional($item->created_at)->format('d M Y H:i') ?? '-' }}</td>
                                        <td class="py-3 pr-4 font-medium text-gray-700">{{ $item->nomor_tiket ?: ('PGD-' . str_pad((string) $item->id, 5, '0', STR_PAD_LEFT)) }}</td>
                                        <td class="py-3 pr-4">{{ $item->judul }}</td>
                                        <td class="py-3 pr-4">
                                            @if (!empty($item->foto))
                                                <a href="{{ asset('storage/' . $item->foto) }}" target="_blank" rel="noopener noreferrer" class="inline-block">
                                                    <img
                                                        src="{{ asset('storage/' . $item->foto) }}"
                                                        alt="Foto Bukti Pengaduan"
                                                        class="w-14 h-14 rounded-lg object-cover border border-gray-200 hover:opacity-90 transition"
                                                    >
                                                </a>
                                            @else
                                                <span class="text-xs text-gray-400">Tidak ada</span>
                                            @endif
                                        </td>
                                        <td class="py-3 pr-4">
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusBadgePengaduan[$item->status] ?? 'bg-gray-100 text-gray-700' }}">
                                                {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                            </span>
                                        </td>
                                        <td class="py-3">{{ \Illuminate\Support\Str::limit(strip_tags($item->catatan_admin ?: '-'), 80) }}</td>
                                        <td class="py-3 pl-4 text-right">
                                            <button
                                                type="button"
                                                class="btn-detail-pengaduan text-sm px-3 py-1.5 rounded-lg border border-orange-200 text-orange-700 hover:bg-orange-50"
                                                data-id="{{ $item->id }}"
                                            >
                                                Detail
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr id="status-pengaduan-empty-default">
                                        <td colspan="7" class="py-6 text-center text-gray-500">Belum ada data pengaduan.</td>
                                    </tr>
                                @endforelse
                                <tr id="status-pengaduan-empty-filter" class="hidden">
                                    <td colspan="7" class="py-6 text-center text-gray-500">Tidak ada data dengan status yang dipilih.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <div id="modal-detail-pengaduan" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/40" data-close-detail-pengaduan></div>
        <div class="relative mx-auto mt-10 w-[95%] max-w-3xl bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h4 class="text-lg font-semibold text-gray-800">Detail Pengaduan</h4>
                <button type="button" class="text-gray-500 hover:text-gray-700" data-close-detail-pengaduan>✕</button>
            </div>
            <div class="p-6 space-y-5 max-h-[75vh] overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <p><span class="font-medium text-gray-700">No. Tiket:</span> <span id="detail-pengaduan-nomor">-</span></p>
                    <p><span class="font-medium text-gray-700">Tanggal:</span> <span id="detail-pengaduan-tanggal">-</span></p>
                    <p><span class="font-medium text-gray-700">Kategori:</span> <span id="detail-pengaduan-kategori">-</span></p>
                    <p><span class="font-medium text-gray-700">Status:</span> <span id="detail-pengaduan-status">-</span></p>
                    <p class="md:col-span-2"><span class="font-medium text-gray-700">Judul:</span> <span id="detail-pengaduan-judul">-</span></p>
                    <p class="md:col-span-2"><span class="font-medium text-gray-700">Lokasi:</span> <span id="detail-pengaduan-lokasi">-</span></p>
                </div>

                <div>
                    <h5 class="font-medium text-gray-800 mb-2">Isi Pengaduan</h5>
                    <p id="detail-pengaduan-isi" class="text-sm text-gray-700 leading-relaxed">-</p>
                </div>

                <div>
                    <h5 class="font-medium text-gray-800 mb-2">Catatan Admin</h5>
                    <p id="detail-pengaduan-catatan" class="text-sm text-gray-700 leading-relaxed">-</p>
                </div>

                <div>
                    <h5 class="font-medium text-gray-800 mb-2">Foto Bukti</h5>
                    <a id="detail-pengaduan-foto-link" href="#" target="_blank" rel="noopener noreferrer" class="hidden">
                        <img id="detail-pengaduan-foto" src="" alt="Foto Pengaduan" class="w-36 h-36 rounded-xl object-cover border border-gray-200">
                    </a>
                    <p id="detail-pengaduan-foto-empty" class="text-sm text-gray-500">Tidak ada foto bukti.</p>
                </div>

                <div>
                    <h5 class="font-medium text-gray-800 mb-2">Timeline Proses</h5>
                    <div id="detail-pengaduan-timeline" class="space-y-3"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuItems = document.querySelectorAll('.menu-side-item');
            const sections = document.querySelectorAll('.masyarakat-section');

            const showSection = (targetId) => {
                sections.forEach((section) => section.classList.add('hidden'));
                const target = document.getElementById(`section-${targetId}`);
                if (target) target.classList.remove('hidden');

                menuItems.forEach((item) => {
                    const isActive = item.dataset.target === targetId;
                    item.classList.toggle('bg-orange-600', isActive);
                    item.classList.toggle('text-white', isActive);
                    item.classList.toggle('hover:bg-gray-800', !isActive);
                });
            };

            menuItems.forEach((item) => {
                item.addEventListener('click', () => showSection(item.dataset.target));
            });

            const filterStatusPengaduanEl = document.getElementById('filter-status-pengaduan');
            const rowsStatusPengaduan = Array.from(document.querySelectorAll('.status-pengaduan-row'));
            const emptyFilterRow = document.getElementById('status-pengaduan-empty-filter');
            const emptyDefaultRow = document.getElementById('status-pengaduan-empty-default');

            const mapStatusForFilter = (status) => {
                if (status === 'sedang_diproses' || status === 'diproses') return 'diproses';
                return status;
            };

            const applyFilterStatusPengaduan = () => {
                if (!filterStatusPengaduanEl) return;

                const selected = filterStatusPengaduanEl.value;
                let visibleCount = 0;

                rowsStatusPengaduan.forEach((row) => {
                    const rawStatus = String(row.dataset.status || '').toLowerCase();
                    const normalizedStatus = mapStatusForFilter(rawStatus);
                    const isUnread = String(row.dataset.unread || '0') === '1';
                    const isVisible = selected === 'all'
                        || normalizedStatus === selected
                        || (selected === 'unread' && isUnread);
                    row.classList.toggle('hidden', !isVisible);
                    if (isVisible) visibleCount += 1;
                });

                if (emptyFilterRow) {
                    const shouldShowEmptyFilter = rowsStatusPengaduan.length > 0 && visibleCount === 0;
                    emptyFilterRow.classList.toggle('hidden', !shouldShowEmptyFilter);
                }

                if (emptyDefaultRow) {
                    emptyDefaultRow.classList.toggle('hidden', selected !== 'all');
                }
            };

            if (filterStatusPengaduanEl) {
                filterStatusPengaduanEl.addEventListener('change', applyFilterStatusPengaduan);
                applyFilterStatusPengaduan();
            }

            const toastCloseButton = document.getElementById('toast-update-close');
            const toastUpdatePengaduan = document.getElementById('toast-update-pengaduan');
            if (toastCloseButton && toastUpdatePengaduan) {
                toastCloseButton.addEventListener('click', () => {
                    toastUpdatePengaduan.classList.add('hidden');
                });
            }

            const modalDetail = document.getElementById('modal-detail-pengaduan');
            const closeModalButtons = document.querySelectorAll('[data-close-detail-pengaduan]');

            const formatStatus = (status) => {
                const raw = String(status || '').replaceAll('_', ' ');
                return raw.charAt(0).toUpperCase() + raw.slice(1);
            };

            const renderTimeline = (items) => {
                const container = document.getElementById('detail-pengaduan-timeline');
                if (!container) return;

                if (!Array.isArray(items) || items.length === 0) {
                    container.innerHTML = '<p class="text-sm text-gray-500">Belum ada timeline proses.</p>';
                    return;
                }

                container.innerHTML = items.map((item) => `
                    <div class="rounded-xl border border-gray-100 p-3">
                        <div class="flex items-center justify-between gap-3">
                            <p class="text-sm font-medium text-gray-800">${formatStatus(item.status)}</p>
                            <p class="text-xs text-gray-500">${item.waktu || '-'}</p>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Oleh: ${item.dibuat_oleh || '-'}</p>
                        <p class="text-sm text-gray-700 mt-2">${item.catatan || '-'}</p>
                        ${item.foto_bukti_url ? `<a href="${item.foto_bukti_url}" target="_blank" rel="noopener noreferrer" class="inline-block mt-2"><img src="${item.foto_bukti_url}" alt="Bukti Tindak Lanjut" class="w-24 h-24 rounded-lg object-cover border border-gray-200"></a>` : ''}
                    </div>
                `).join('');
            };

            const setModalValue = (id, value) => {
                const el = document.getElementById(id);
                if (el) el.textContent = value || '-';
            };

            const showModal = () => {
                if (modalDetail) modalDetail.classList.remove('hidden');
            };

            const hideModal = () => {
                if (modalDetail) modalDetail.classList.add('hidden');
            };

            closeModalButtons.forEach((btn) => {
                btn.addEventListener('click', hideModal);
            });

            document.querySelectorAll('.btn-detail-pengaduan').forEach((btn) => {
                btn.addEventListener('click', async () => {
                    const id = btn.dataset.id;
                    if (!id) return;

                    setModalValue('detail-pengaduan-judul', 'Memuat...');
                    showModal();

                    try {
                        const response = await fetch(`{{ url('/dashboard/masyarakat/pengaduan') }}/${id}`);
                        if (!response.ok) {
                            throw new Error('Gagal memuat detail pengaduan.');
                        }

                        const data = await response.json();
                        setModalValue('detail-pengaduan-nomor', data.nomor_tiket);
                        setModalValue('detail-pengaduan-tanggal', data.tanggal_pengaduan);
                        setModalValue('detail-pengaduan-kategori', data.kategori);
                        setModalValue('detail-pengaduan-status', formatStatus(data.status));
                        setModalValue('detail-pengaduan-judul', data.judul);
                        setModalValue('detail-pengaduan-lokasi', data.lokasi);
                        setModalValue('detail-pengaduan-isi', data.isi);
                        setModalValue('detail-pengaduan-catatan', data.catatan_admin);

                        const fotoLink = document.getElementById('detail-pengaduan-foto-link');
                        const foto = document.getElementById('detail-pengaduan-foto');
                        const fotoEmpty = document.getElementById('detail-pengaduan-foto-empty');
                        if (data.foto_url) {
                            if (fotoLink && foto && fotoEmpty) {
                                foto.src = data.foto_url;
                                fotoLink.href = data.foto_url;
                                fotoLink.classList.remove('hidden');
                                fotoEmpty.classList.add('hidden');
                            }
                        } else if (fotoLink && foto && fotoEmpty) {
                            foto.src = '';
                            fotoLink.href = '#';
                            fotoLink.classList.add('hidden');
                            fotoEmpty.classList.remove('hidden');
                        }

                        renderTimeline(data.timeline);
                    } catch (error) {
                        setModalValue('detail-pengaduan-judul', 'Gagal memuat detail');
                        setModalValue('detail-pengaduan-isi', 'Terjadi kesalahan saat mengambil data pengaduan.');
                        renderTimeline([]);
                    }
                });
            });

            const urlParams = new URLSearchParams(window.location.search);
            const requestedTab = urlParams.get('tab');
            const allowedTabs = ['beranda', 'pengajuan', 'status-surat', 'pengaduan', 'status-pengaduan'];
            const hasValidationErrors = {{ $errors->any() ? 'true' : 'false' }};
            const hasPengaduanErrors = {{ $errors->pengaduan->any() ? 'true' : 'false' }};

            if (hasPengaduanErrors) {
                showSection('pengaduan');
            } else if (hasValidationErrors) {
                showSection('pengajuan');
            } else if (requestedTab && allowedTabs.includes(requestedTab)) {
                showSection(requestedTab);
            } else {
                showSection('beranda');
            }
        });
    </script>
</x-app-layout>

