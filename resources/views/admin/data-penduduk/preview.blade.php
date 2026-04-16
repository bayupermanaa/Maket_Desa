<x-app-layout>
    <x-slot name="title">Preview Import Data Penduduk</x-slot>

    <div class="p-10">
        <h1 class="text-2xl font-bold mb-6">Preview Data Import</h1>
        
        <form action="{{ route('admin.penduduk.confirmImport') }}" method="POST">
            @csrf
            
            <!-- INPUT HIDDEN YANG SUDAH DIPERBAIKI -->
            <input type="hidden" name="rows" value="{{ json_encode($previewData) }}">

            <div class="overflow-auto bg-white rounded-2xl shadow mb-6">
                <table class="w-full table-auto text-sm border-collapse">
                    <thead class="bg-gray-50 border-b sticky top-0">
                        <tr>
                            <th class="px-2 py-3 text-left">RW</th>
                            <th class="px-2 py-3 text-left">RT</th>
                            <th class="px-2 py-3 text-left">Dusun</th>
                            <th class="px-2 py-3 text-left">Alamat</th>
                            <th class="px-2 py-3 text-left">Kode Keluarga</th>
                            <th class="px-2 py-3 text-left">Nama Kepala</th>
                            <th class="px-2 py-3 text-left">No</th>
                            <th class="px-2 py-3 text-left">NIK</th>
                            <th class="px-2 py-3 text-left">Nama Anggota</th>
                            <th class="px-2 py-3 text-left">JK</th>
                            <th class="px-2 py-3 text-left">Hubungan</th>
                            <th class="px-2 py-3 text-left">Tempat Lahir</th>
                            <th class="px-2 py-3 text-left">Tgl Lahir</th>
                            <th class="px-2 py-3 text-left">Usia</th>
                            <th class="px-2 py-3 text-left">Status</th>
                            <th class="px-2 py-3 text-left">Agama</th>
                            <th class="px-2 py-3 text-left">GDarah</th>
                            <th class="px-2 py-3 text-left">Kewarganegaraan</th>
                            <th class="px-2 py-3 text-left">Suku</th>
                            <th class="px-2 py-3 text-left">Pendidikan</th>
                            <th class="px-2 py-3 text-left">Pekerjaan</th>
                            <th class="px-2 py-3 text-center">Valid</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($previewData as $row)
                        <tr class="{{ $row['valid'] ? 'bg-green-50' : 'bg-red-100 text-red-700' }}">
                            <td class="px-2 py-2">{{ $row['rw'] ?? '-' }}</td>
                            <td class="px-2 py-2">{{ $row['rt'] ?? '-' }}</td>
                            <td class="px-2 py-2">{{ $row['dusun'] ?? '-' }}</td>
                            <td class="px-2 py-2">{{ $row['alamat'] ?? '-' }}</td>
                            <td class="px-2 py-2">{{ $row['kode_keluarga'] ?? '-' }}</td>
                            <td class="px-2 py-2">{{ $row['nama_kepala_keluarga'] ?? '-' }}</td>
                            <td class="px-2 py-2">{{ $row['no'] ?? '-' }}</td>
                            <td class="px-2 py-2">{{ $row['nik'] ?? '-' }}</td>
                            <td class="px-2 py-2">{{ $row['nama'] ?? '-' }}</td>
                            <td class="px-2 py-2">{{ $row['jk'] ?? '-' }}</td>
                            <td class="px-2 py-2">{{ $row['hubungan'] ?? '-' }}</td>
                            <td class="px-2 py-2">{{ $row['tempat_lahir'] ?? '-' }}</td>
                            <td class="px-2 py-2">{{ $row['tgl_lahir'] ?? '-' }}</td>
                            <td class="px-2 py-2">{{ $row['usia'] ?? '-' }}</td>
                            <td class="px-2 py-2">{{ $row['status'] ?? '-' }}</td>
                            <td class="px-2 py-2">{{ $row['agama'] ?? '-' }}</td>
                            <td class="px-2 py-2">{{ $row['gol_darah'] ?? '-' }}</td>
                            <td class="px-2 py-2">{{ $row['kewarganegaraan'] ?? '-' }}</td>
                            <td class="px-2 py-2">{{ $row['suku'] ?? '-' }}</td>
                            <td class="px-2 py-2">{{ $row['pendidikan'] ?? '-' }}</td>
                            <td class="px-2 py-2">{{ $row['pekerjaan'] ?? '-' }}</td>
                            <td class="px-2 py-2 text-center font-medium">
                                @if($row['valid'])
                                    <span class="text-green-600">✅ Valid</span>
                                @else
                                    <span class="text-red-600">❌ Tidak Valid</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex gap-4">
                <button type="submit"
                    class="px-8 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition font-medium">
                    ✅ Konfirmasi & Import ke Database
                </button>
                
                <a href="{{ route('admin.penduduk.index') }}" 
                   class="px-8 py-3 bg-gray-500 text-white rounded-xl hover:bg-gray-600 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>