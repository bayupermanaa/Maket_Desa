<x-app-layout>
    <x-slot name="title">Detail Pengajuan Surat</x-slot>
    @php
        $routePrefix = request()->routeIs('kepala.*') ? 'kepala' : 'admin';
        $detailSurat = $surat->detail_surat ?? [];
        $jenisSuratBertemplate = ['Surat Keterangan Domisili', 'Surat Keterangan Usaha'];
        $statusBadgeSurat = [
            'Menunggu' => 'bg-amber-100 text-amber-700',
            'Diproses' => 'bg-blue-100 text-blue-700',
            'Diajukan ke Kepala Desa' => 'bg-indigo-100 text-indigo-700',
            'Disetujui Kepala Desa' => 'bg-emerald-100 text-emerald-700',
            'Ditolak Kepala Desa' => 'bg-orange-100 text-orange-700',
            'Disetujui' => 'bg-green-100 text-green-700',
            'Ditolak' => 'bg-red-100 text-red-700',
        ];
    @endphp

    <div class="min-h-screen bg-gray-100 flex">
        <main class="flex-1 p-10">
            <div class="max-w-4xl mx-auto">
                <div class="mb-8">
                    <h1 class="text-3xl font-semibold text-gray-800">Detail Pengajuan Surat</h1>
                    <p class="text-gray-500">Verifikasi pengajuan surat masyarakat</p>
                </div>

                @if (session('success'))
                    <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700">
                        <p class="font-medium">Data administrasi belum lengkap:</p>
                        <ul class="mt-1 list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-white rounded-3xl shadow p-8 space-y-6">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-semibold">Data Pemohon</h2>
                        <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $statusBadgeSurat[$surat->status] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ $surat->status }}
                        </span>
                    </div>

                    <hr>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm text-gray-500">Nama</label>
                            <p class="font-semibold text-lg">{{ $surat->nama }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Nomor KTP</label>
                            <p class="font-semibold text-lg">{{ $surat->nik }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Jenis Surat</label>
                            <p class="font-semibold text-lg">{{ $surat->jenis_surat }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">No HP</label>
                            <p class="font-semibold text-lg">{{ $surat->no_hp ?: '-' }}</p>
                        </div>

                        @foreach([
                            'tempat_lahir' => 'Tempat Lahir',
                            'tanggal_lahir' => 'Tanggal Lahir',
                            'kebangsaan' => 'Kebangsaan',
                            'agama' => 'Agama',
                            'jenis_kelamin' => 'Jenis Kelamin',
                            'pekerjaan' => 'Pekerjaan',
                        ] as $field => $label)
                            <div>
                                <label class="text-sm text-gray-500">{{ $label }}</label>
                                <p class="font-semibold text-lg">{{ $detailSurat[$field] ?? '-' }}</p>
                            </div>
                        @endforeach

                        <div class="md:col-span-2">
                            <label class="text-sm text-gray-500">Alamat Asal</label>
                            <p class="font-semibold text-lg">{{ $surat->alamat }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-sm text-gray-500">Maksud dan Tujuan</label>
                            <p class="font-semibold text-lg">{{ $surat->keperluan }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-sm text-gray-500">Keterangan Lain</label>
                                <p class="font-semibold text-lg">{{ $detailSurat['keterangan_lain'] ?? '-' }}</p>
                            </div>
                        @if($surat->keterangan)
                            <div class="md:col-span-2 rounded-2xl border border-rose-100 bg-rose-50 p-4">
                                <label class="text-sm text-rose-600">Keterangan Penolakan / Catatan</label>
                                <p class="font-semibold text-lg text-rose-800">{{ $surat->keterangan }}</p>
                            </div>
                        @endif
                    </div>

                    @if($surat->file_lampiran)
                        <div>
                            <label class="text-sm text-gray-500">File Lampiran</label>
                            <a href="{{ asset('storage/'.$surat->file_lampiran) }}" target="_blank" class="block mt-2 text-blue-600 hover:underline">
                                Lihat File Lampiran
                            </a>
                        </div>
                    @endif

                    @if(request()->routeIs('admin.*') && in_array($surat->jenis_surat, $jenisSuratBertemplate, true))
                        <form action="{{ route('admin.pengajuan-surat.administrasi', $surat->id) }}" method="POST" class="rounded-2xl border border-orange-100 bg-orange-50 p-6">
                            @csrf
                            @method('PATCH')

                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Data Administrasi Surat</h3>
                                    <p class="text-sm text-gray-600">Diisi oleh admin desa sebelum pengajuan dikirim ke kepala desa.</p>
                                </div>
                            </div>

                            <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="nomor_surat" class="block text-sm font-medium text-gray-700">Nomor Surat Desa</label>
                                    <input id="nomor_surat" name="detail_surat[nomor_surat]" type="text" required value="{{ old('detail_surat.nomor_surat', $detailSurat['nomor_surat'] ?? '') }}" class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm">
                                </div>
                                <div>
                                    <label for="tanggal_surat" class="block text-sm font-medium text-gray-700">Tanggal Surat Desa</label>
                                    <input id="tanggal_surat" name="detail_surat[tanggal_surat]" type="date" required value="{{ old('detail_surat.tanggal_surat', $detailSurat['tanggal_surat'] ?? now()->toDateString()) }}" class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm">
                                </div>
                                <div>
                                    <label for="nama_pejabat" class="block text-sm font-medium text-gray-700">Nama Pejabat yang Menerangkan</label>
                                    <input id="nama_pejabat" name="detail_surat[nama_pejabat]" type="text" required value="{{ old('detail_surat.nama_pejabat', $detailSurat['nama_pejabat'] ?? '') }}" class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm">
                                </div>
                                <div>
                                    <label for="jabatan_pejabat" class="block text-sm font-medium text-gray-700">Jabatan Pejabat</label>
                                    <input id="jabatan_pejabat" name="detail_surat[jabatan_pejabat]" type="text" required value="{{ old('detail_surat.jabatan_pejabat', $detailSurat['jabatan_pejabat'] ?? 'Perbekel Desa Buruan') }}" class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm">
                                </div>
                                <div>
                                    <label for="nama_banjar" class="block text-sm font-medium text-gray-700">Nama Banjar/Dusun</label>
                                    <input id="nama_banjar" name="detail_surat[nama_banjar]" type="text" required value="{{ old('detail_surat.nama_banjar', $detailSurat['nama_banjar'] ?? '') }}" class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm">
                                </div>
                                <div>
                                    <label for="nomor_surat_banjar" class="block text-sm font-medium text-gray-700">Nomor Surat Banjar/Dusun</label>
                                    <input id="nomor_surat_banjar" name="detail_surat[nomor_surat_banjar]" type="text" required value="{{ old('detail_surat.nomor_surat_banjar', $detailSurat['nomor_surat_banjar'] ?? '') }}" class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm">
                                </div>
                                <div>
                                    <label for="tanggal_surat_banjar" class="block text-sm font-medium text-gray-700">Tanggal Surat Banjar/Dusun</label>
                                    <input id="tanggal_surat_banjar" name="detail_surat[tanggal_surat_banjar]" type="date" required value="{{ old('detail_surat.tanggal_surat_banjar', $detailSurat['tanggal_surat_banjar'] ?? '') }}" class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm">
                                </div>
                                <div>
                                    <label for="jabatan_ttd" class="block text-sm font-medium text-gray-700">Jabatan Penanda Tangan</label>
                                    <input id="jabatan_ttd" name="detail_surat[jabatan_ttd]" type="text" required value="{{ old('detail_surat.jabatan_ttd', $detailSurat['jabatan_ttd'] ?? 'PERBEKEL DESA BURUAN') }}" class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm">
                                </div>
                                <div>
                                    <label for="nama_ttd" class="block text-sm font-medium text-gray-700">Nama Penanda Tangan</label>
                                    <input id="nama_ttd" name="detail_surat[nama_ttd]" type="text" required value="{{ old('detail_surat.nama_ttd', $detailSurat['nama_ttd'] ?? '') }}" class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm">
                                </div>
                            </div>

                            <div class="mt-5 flex justify-end">
                                <button class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-3 rounded-xl">
                                    Simpan Data Administrasi
                                </button>
                            </div>
                        </form>
                    @endif

                    <div class="flex flex-wrap gap-4 mt-6">
                        <a href="{{ route($routePrefix . '.pengajuan-surat.preview', $surat->id) }}" target="_blank" class="bg-orange-100 text-orange-700 px-6 py-3 rounded-xl">
                            Preview Surat
                        </a>

                        @if($surat->status == 'Disetujui')
                            <a href="{{ route($routePrefix . '.pengajuan-surat.download', $surat->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl">
                                Unduh Draft Word
                            </a>
                            <a href="{{ route($routePrefix . '.pengajuan-surat.pdf', $surat->id) }}" class="bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 rounded-xl">
                                Unduh PDF
                            </a>
                        @endif

                        @if($routePrefix === 'admin' && in_array($surat->status, ['Menunggu', 'Diproses', 'Ditolak Kepala Desa'], true))
                            <form action="{{ route($routePrefix . '.pengajuan-surat.setujui', $surat->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl">Ajukan ke Kepala Desa</button>
                            </form>

                            <form action="{{ route($routePrefix . '.pengajuan-surat.tolak', $surat->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <textarea name="keterangan" required rows="2" placeholder="Tuliskan alasan penolakan..." class="mb-3 w-full min-w-72 rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500 text-sm">{{ old('keterangan') }}</textarea>
                                <button class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl">Tolak</button>
                            </form>
                        @elseif($routePrefix === 'admin' && $surat->status === 'Disetujui Kepala Desa')
                            <form action="{{ route($routePrefix . '.pengajuan-surat.setujui', $surat->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl">Finalisasi Surat</button>
                            </form>
                        @elseif($routePrefix === 'kepala' && $surat->status === 'Diajukan ke Kepala Desa')
                            <form action="{{ route($routePrefix . '.pengajuan-surat.setujui', $surat->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl">Setujui Kepala Desa</button>
                            </form>

                            <form action="{{ route($routePrefix . '.pengajuan-surat.tolak', $surat->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <textarea name="keterangan" required rows="2" placeholder="Tuliskan alasan penolakan kepala desa..." class="mb-3 w-full min-w-72 rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500 text-sm">{{ old('keterangan') }}</textarea>
                                <button class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl">Tolak Kepala Desa</button>
                            </form>
                        @endif

                        <a href="{{ route($routePrefix . '.pengajuan-surat.index') }}" class="px-6 py-3 bg-gray-300 rounded-xl">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
