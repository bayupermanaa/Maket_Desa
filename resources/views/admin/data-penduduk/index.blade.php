<x-app-layout>
    <x-slot name="title">Data Penduduk - Desa Maket</x-slot>

    <div class="min-h-screen bg-gray-100 flex">
        @include('admin.partials.sidebar')

        <div class="p-6 md:p-8 w-full">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5 md:p-6">
                <h1 class="text-3xl font-semibold text-gray-900 mb-1">Data Penduduk</h1>
                <p class="text-sm text-gray-600 mb-4">Total Data: {{ $penduduk->total() }}</p>

                <form method="GET" action="{{ route('admin.data-penduduk.index') }}" class="mb-4 flex flex-wrap items-center gap-2">
                    <select name="status_filter" class="border border-gray-300 px-3 py-2 rounded-lg text-sm bg-white">
                        <option value="">Semua</option>
                        <option value="1" {{ request('status_filter') == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ request('status_filter') == '0' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">Filter</button>
                </form>

                <form action="{{ route('admin.penduduk.confirm-import') }}" method="POST" enctype="multipart/form-data" class="mb-4">
                    @csrf
                    <input type="file" name="file" id="fileImport" class="hidden" accept=".xlsx,.xls">
                    <button type="button" onclick="document.getElementById('fileImport').click()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">
                        Import dari Excel
                    </button>
                    <button type="submit" id="btnSubmitImport" class="hidden">Submit</button>
                </form>

                <script>
                    document.getElementById('fileImport').addEventListener('change', function() {
                        document.getElementById('btnSubmitImport').click();
                    });

                    function confirmToggle(form) {
                        let actionText = form.querySelector('button').innerText;
                        if (actionText.trim().toLowerCase() === 'nonaktifkan') {
                            const reason = prompt('Masukkan keterangan kenapa penduduk ini tidak aktif:');

                            if (reason === null) {
                                return false;
                            }

                            const trimmed = reason.trim();
                            if (trimmed === '') {
                                alert('Keterangan nonaktif wajib diisi.');
                                return false;
                            }

                            form.querySelector('input[name="keterangan_nonaktif"]').value = trimmed;
                        }

                        return confirm(`Apakah Anda yakin ingin ${actionText.toLowerCase()} penduduk ini?`);
                    }
                </script>

                <div class="overflow-x-auto mt-6 border border-gray-300 rounded-xl">
                    <table class="min-w-full border-collapse text-sm text-gray-800">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border border-gray-300 px-3 py-2 text-left font-semibold">RW</th>
                                <th class="border border-gray-300 px-3 py-2 text-left font-semibold">RT</th>
                                <th class="border border-gray-300 px-3 py-2 text-left font-semibold">Dusun</th>
                                <th class="border border-gray-300 px-3 py-2 text-left font-semibold">Alamat</th>
                                <th class="border border-gray-300 px-3 py-2 text-left font-semibold">Kode Keluarga</th>
                                <th class="border border-gray-300 px-3 py-2 text-left font-semibold">Nama Kepala Keluarga</th>
                                <th class="border border-gray-300 px-3 py-2 text-left font-semibold">No</th>
                                <th class="border border-gray-300 px-3 py-2 text-left font-semibold">NIK</th>
                                <th class="border border-gray-300 px-3 py-2 text-left font-semibold">Nama Anggota</th>
                                <th class="border border-gray-300 px-3 py-2 text-left font-semibold">Jenis Kelamin</th>
                                <th class="border border-gray-300 px-3 py-2 text-left font-semibold">Hubungan</th>
                                <th class="border border-gray-300 px-3 py-2 text-left font-semibold">Tempat Lahir</th>
                                <th class="border border-gray-300 px-3 py-2 text-left font-semibold">Tanggal Lahir</th>
                                <th class="border border-gray-300 px-3 py-2 text-left font-semibold">Usia</th>
                                <th class="border border-gray-300 px-3 py-2 text-left font-semibold">Status</th>
                                <th class="border border-gray-300 px-3 py-2 text-left font-semibold">Agama</th>
                                <th class="border border-gray-300 px-3 py-2 text-left font-semibold">Gol Darah</th>
                                <th class="border border-gray-300 px-3 py-2 text-left font-semibold">Kewarganegaraan</th>
                                <th class="border border-gray-300 px-3 py-2 text-left font-semibold">Suku</th>
                                <th class="border border-gray-300 px-3 py-2 text-left font-semibold">Pendidikan</th>
                                <th class="border border-gray-300 px-3 py-2 text-left font-semibold">Pekerjaan</th>
                                <th class="border border-gray-300 px-3 py-2 text-left font-semibold">Keterangan Nonaktif</th>
                                <th class="border border-gray-300 px-3 py-2 text-left font-semibold">Aktif</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penduduk as $p)
                            <tr class="{{ $p->is_active ? 'odd:bg-white even:bg-gray-50 hover:bg-blue-50' : 'bg-gray-50 text-gray-400' }}">
                                <td class="border border-gray-300 px-3 py-2 align-top">{{ $p->rw ?? '-' }}</td>
                                <td class="border border-gray-300 px-3 py-2 align-top">{{ $p->rt ?? '-' }}</td>
                                <td class="border border-gray-300 px-3 py-2 align-top">{{ $p->dusun ?? '-' }}</td>
                                <td class="border border-gray-300 px-3 py-2 align-top">{{ $p->alamat ?? '-' }}</td>
                                <td class="border border-gray-300 px-3 py-2 align-top whitespace-nowrap">{{ $p->kode_keluarga ?? '-' }}</td>
                                <td class="border border-gray-300 px-3 py-2 align-top">{{ $p->nama_kepala_keluarga ?? '-' }}</td>
                                <td class="border border-gray-300 px-3 py-2 align-top">{{ $p->no ?? '-' }}</td>
                                <td class="border border-gray-300 px-3 py-2 align-top whitespace-nowrap">{{ $p->nik ?? '-' }}</td>
                                <td class="border border-gray-300 px-3 py-2 align-top">{{ $p->nama_anggota ?? '-' }}</td>
                                <td class="border border-gray-300 px-3 py-2 align-top whitespace-nowrap">{{ $p->jenis_kelamin ?? '-' }}</td>
                                <td class="border border-gray-300 px-3 py-2 align-top">{{ $p->hubungan ?? '-' }}</td>
                                <td class="border border-gray-300 px-3 py-2 align-top">{{ $p->tempat_lahir ?? '-' }}</td>
                                <td class="border border-gray-300 px-3 py-2 align-top whitespace-nowrap">{{ $p->tgl_lahir ?? '-' }}</td>
                                <td class="border border-gray-300 px-3 py-2 align-top">{{ $p->usia ?? '-' }}</td>
                                <td class="border border-gray-300 px-3 py-2 align-top">{{ $p->status ?? '-' }}</td>
                                <td class="border border-gray-300 px-3 py-2 align-top">{{ $p->agama ?? '-' }}</td>
                                <td class="border border-gray-300 px-3 py-2 align-top">{{ $p->gol_darah ?? '-' }}</td>
                                <td class="border border-gray-300 px-3 py-2 align-top">{{ $p->kewarganegaraan ?? '-' }}</td>
                                <td class="border border-gray-300 px-3 py-2 align-top">{{ $p->suku ?? '-' }}</td>
                                <td class="border border-gray-300 px-3 py-2 align-top">{{ $p->pendidikan ?? '-' }}</td>
                                <td class="border border-gray-300 px-3 py-2 align-top">{{ $p->pekerjaan ?? '-' }}</td>
                                <td class="border border-gray-300 px-3 py-2 align-top min-w-48">
                                    @if($p->is_active)
                                        <span class="text-gray-400">-</span>
                                    @else
                                        <span class="text-rose-700">{{ $p->keterangan_nonaktif ?: 'Tidak ada keterangan.' }}</span>
                                    @endif
                                </td>
                                <td class="border border-gray-300 px-3 py-2 align-top">
                                    <form action="{{ route('admin.penduduk.toggle-status', $p->id) }}" method="POST" onsubmit="return confirmToggle(this)">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="keterangan_nonaktif" value="">
                                        <button type="submit" class="px-3 py-1.5 rounded text-xs font-medium whitespace-nowrap {{ $p->is_active ? 'bg-red-600 text-white hover:bg-red-700' : 'bg-green-600 text-white hover:bg-green-700' }}">
                                            {{ $p->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $penduduk->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


