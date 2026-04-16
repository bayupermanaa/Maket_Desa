<x-app-layout>
    <x-slot name="title">Detail Pengajuan Surat</x-slot>

<div class="min-h-screen bg-gray-100 flex">

    <!-- CONTENT -->
    <main class="flex-1 p-10">

        <div class="max-w-4xl mx-auto">

            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-semibold text-gray-800">Detail Pengajuan Surat</h1>
                <p class="text-gray-500">Verifikasi pengajuan surat masyarakat</p>
            </div>

            <!-- Card -->
            <div class="bg-white rounded-3xl shadow p-8 space-y-6">

                <!-- STATUS -->
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold">Data Pemohon</h2>

                    <span class="px-4 py-2 rounded-full text-sm font-semibold
                        {{ $surat->status == 'Disetujui' ? 'bg-green-100 text-green-700' : 
                           ($surat->status == 'Ditolak' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                        {{ $surat->status }}
                    </span>
                </div>

                <hr>

                <!-- DATA -->
                <div class="grid grid-cols-2 gap-6">

                    <div>
                        <label class="text-sm text-gray-500">Nama</label>
                        <p class="font-semibold text-lg">{{ $surat->nama }}</p>
                    </div>

                    <div>
                        <label class="text-sm text-gray-500">NIK</label>
                        <p class="font-semibold text-lg">{{ $surat->nik }}</p>
                    </div>

                    <div>
                        <label class="text-sm text-gray-500">Jenis Surat</label>
                        <p class="font-semibold text-lg">{{ $surat->jenis_surat }}</p>
                    </div>

                    <div>
                        <label class="text-sm text-gray-500">No HP</label>
                        <p class="font-semibold text-lg">{{ $surat->no_hp }}</p>
                    </div>

                    <div class="col-span-2">
                        <label class="text-sm text-gray-500">Alamat</label>
                        <p class="font-semibold text-lg">{{ $surat->alamat }}</p>
                    </div>

                    <div class="col-span-2">
                        <label class="text-sm text-gray-500">Keperluan</label>
                        <p class="font-semibold text-lg">{{ $surat->keperluan }}</p>
                    </div>

                </div>

                <!-- LAMPIRAN -->
                @if($surat->file_lampiran)
                <div>
                    <label class="text-sm text-gray-500">File Lampiran</label>
                    <a href="{{ asset('storage/'.$surat->file_lampiran) }}" 
                       target="_blank"
                       class="block mt-2 text-blue-600 hover:underline">
                        Lihat File Lampiran
                    </a>
                </div>
                @endif

                <!-- FORM KETERANGAN PENOLAKAN -->
                @if($surat->status == 'Menunggu' || $surat->status == 'Diproses')
                <form action="{{ route('admin.pengajuan-surat.tolak', $surat->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <label class="text-sm text-gray-500">Keterangan (jika ditolak)</label>
                    <textarea name="keterangan" 
                              class="w-full mt-2 p-3 border rounded-xl"
                              placeholder="Masukkan alasan penolakan..."></textarea>

                    <div class="flex gap-4 mt-6">
                        <!-- SETUJUI -->
                        <form action="{{ route('admin.pengajuan-surat.setujui', $surat->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl">
                                ✔ Setujui
                            </button>
                        </form>

                        <!-- TOLAK -->
                        <button class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl">
                            ✖ Tolak
                        </button>

                        <a href="{{ route('admin.pengajuan-surat.index') }}"
                           class="px-6 py-3 bg-gray-300 rounded-xl">
                           Kembali
                        </a>
                    </div>
                </form>
                @endif

            </div>

        </div>

    </main>
</div>
</x-app-layout>