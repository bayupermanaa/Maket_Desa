<x-app-layout>
    <x-slot name="title">Dashboard Kepala Desa - Desa Maket</x-slot>

    <div class="min-h-screen bg-gray-100 flex">
        @include('admin.partials.sidebar')

        <main class="flex-1">
            <header class="bg-white border-b shadow-sm px-8 py-5">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-3xl font-semibold text-gray-800">Dashboard Kepala Desa</h2>
                        <p class="text-sm text-gray-500 mt-1">Pusat verifikasi surat dan pengaduan yang sudah diperiksa admin.</p>
                    </div>

                    <div class="flex items-center gap-6">
                        <div class="text-right">
                            <p class="font-medium">{{ session('user_name', 'Kepala Desa') }}</p>
                            <p class="text-xs text-gray-500">Verifikator Desa</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Yakin ingin logout?')">
                            @csrf
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-2xl text-sm font-medium transition">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <div class="p-8 space-y-8">
                @php
                    /** @var \Illuminate\Support\Collection<int, \App\Models\PengajuanSurat> $suratUntukDiverifikasi */
                    $suratUntukDiverifikasi = $suratUntukDiverifikasi ?? collect();

                    /** @var \Illuminate\Support\Collection<int, \App\Models\Pengaduan> $pengaduanUntukDiverifikasi */
                    $pengaduanUntukDiverifikasi = $pengaduanUntukDiverifikasi ?? collect();
                @endphp

                @if(($suratMenungguVerifikasi ?? 0) > 0 || ($pengaduanMenungguVerifikasi ?? 0) > 0)
                    <div class="rounded-2xl border border-orange-200 bg-orange-50 px-5 py-4 text-sm text-orange-800">
                        Ada {{ number_format(($suratMenungguVerifikasi ?? 0) + ($pengaduanMenungguVerifikasi ?? 0)) }} data yang menunggu validasi kepala desa.
                    </div>
                @endif

                <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                    <div class="bg-white rounded-3xl p-7 shadow border border-indigo-100">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Surat Menunggu Verifikasi</p>
                                <p class="text-4xl font-bold mt-4 text-indigo-600">{{ number_format($suratMenungguVerifikasi ?? 0) }}</p>
                            </div>
                            <div class="text-3xl font-bold text-indigo-200">SK</div>
                        </div>
                        <a href="{{ route('kepala.pengajuan-surat.index') }}" class="inline-block mt-6 text-sm font-medium text-indigo-700 hover:text-indigo-900">Buka daftar surat</a>
                    </div>

                    <div class="bg-white rounded-3xl p-7 shadow border border-emerald-100">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Surat Sudah Di-ACC</p>
                                <p class="text-4xl font-bold mt-4 text-emerald-600">{{ number_format($suratSudahAccKepala ?? 0) }}</p>
                            </div>
                            <div class="text-3xl font-bold text-emerald-200">OK</div>
                        </div>
                        <p class="text-xs text-gray-500 mt-6">Menunggu admin konfirmasi ke masyarakat.</p>
                    </div>

                    <div class="bg-white rounded-3xl p-7 shadow border border-blue-100">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Pengaduan Menunggu Verifikasi</p>
                                <p class="text-4xl font-bold mt-4 text-blue-600">{{ number_format($pengaduanMenungguVerifikasi ?? 0) }}</p>
                            </div>
                            <div class="text-3xl font-bold text-blue-200">PG</div>
                        </div>
                        <a href="{{ route('kepala.pengaduan') }}" class="inline-block mt-6 text-sm font-medium text-blue-700 hover:text-blue-900">Buka daftar pengaduan</a>
                    </div>

                    <div class="bg-white rounded-3xl p-7 shadow border border-emerald-100">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Pengaduan Sudah Di-ACC</p>
                                <p class="text-4xl font-bold mt-4 text-emerald-600">{{ number_format($pengaduanSudahAccKepala ?? 0) }}</p>
                            </div>
                            <div class="text-3xl font-bold text-emerald-200">OK</div>
                        </div>
                        <p class="text-xs text-gray-500 mt-6">Menunggu admin memberi kabar final.</p>
                    </div>
                </section>

                <section class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                    <div class="bg-white rounded-3xl shadow p-6">
                        <div class="flex items-center justify-between gap-4 mb-5">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800">Surat dari Admin</h3>
                                <p class="text-sm text-gray-500">Pengajuan yang siap di-ACC atau ditolak.</p>
                            </div>
                            <a href="{{ route('kepala.pengajuan-surat.index') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-medium">Lihat Semua</a>
                        </div>

                        <div class="space-y-3">
                            @forelse($suratUntukDiverifikasi as $surat)
                                @php
                                    /** @var \App\Models\PengajuanSurat $surat */
                                @endphp
                                <a href="{{ route('kepala.pengajuan-surat.show', $surat->id) }}" class="block rounded-2xl border border-gray-100 p-4 hover:bg-gray-50">
                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $surat->jenis_surat ?? 'Surat Keterangan' }}</p>
                                            <p class="text-sm text-gray-500 mt-1">{{ $surat->nama ?? 'Warga Desa' }} - {{ $surat->nik ?? '-' }}</p>
                                        </div>
                                        <span class="px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-semibold">{{ $surat->status ?? 'Menunggu Verifikasi' }}</span>
                                    </div>
                                </a>
                            @empty
                                <p class="text-center text-gray-500 py-10">Belum ada surat yang dikirim admin.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl shadow p-6">
                        <div class="flex items-center justify-between gap-4 mb-5">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800">Pengaduan dari Admin</h3>
                                <p class="text-sm text-gray-500">Pengaduan yang membutuhkan verifikasi kepala desa.</p>
                            </div>
                            <a href="{{ route('kepala.pengaduan') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-medium">Lihat Semua</a>
                        </div>

                        <div class="space-y-3">
                            @forelse($pengaduanUntukDiverifikasi as $pengaduan)
                                @php
                                    /** @var \App\Models\Pengaduan $pengaduan */
                                @endphp
                                <a href="{{ route('kepala.pengaduan') }}" class="block rounded-2xl border border-gray-100 p-4 hover:bg-gray-50">
                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $pengaduan->judul ?? 'Pengaduan Warga' }}</p>
                                            <p class="text-sm text-gray-500 mt-1">{{ $pengaduan->nama_pelapor ?? 'Warga Desa' }} - {{ $pengaduan->created_at?->format('d M Y') ?? '-' }}</p>
                                        </div>
                                        <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">Menunggu Verifikasi</span>
                                    </div>
                                </a>
                            @empty
                                <p class="text-center text-gray-500 py-10">Belum ada pengaduan yang dikirim admin.</p>
                            @endforelse
                        </div>
                    </div>
                </section>

                <section class="bg-white rounded-3xl shadow p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-5">Ringkasan Desa</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-gray-50 rounded-2xl p-4">
                            <p class="text-xs text-gray-500">Total Penduduk</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($totalPenduduk ?? 0) }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-2xl p-4">
                            <p class="text-xs text-gray-500">Total Pengajuan Surat</p>
                            <p class="text-2xl font-bold text-orange-600 mt-1">{{ number_format($totalPengajuanSurat ?? 0) }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-2xl p-4">
                            <p class="text-xs text-gray-500">Pengaduan Aktif</p>
                            <p class="text-2xl font-bold text-red-600 mt-1">{{ number_format($pengaduanAktif ?? 0) }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-2xl p-4">
                            <p class="text-xs text-gray-500">Saldo Kas Desa</p>
                            <p class="text-2xl font-bold text-emerald-600 mt-1">Rp {{ number_format($saldo ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>
</x-app-layout>
