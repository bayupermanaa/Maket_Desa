<x-app-layout>
    <x-slot name="title">Pengajuan Surat - Desa Makét</x-slot>

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

           <!-- CONTENT -->
        <main class="flex-1 p-10">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-semibold text-gray-800">Data Penduduk</h1>
                    <p class="text-gray-500">Kelola Data Penduduk Desa</p>
                </div>
                <div class="text-sm text-gray-500">
                    Total Data: <span class="font-semibold text-gray-700">{{ $penduduk->total() }}</span> orang
                </div>
            </div>

            <div class="p-6">
               
            <!-- Tombol Import -->
            <div class="flex gap-3 mb-6">
                <form action="{{ route('admin.penduduk.previewImport') }}" method="POST" enctype="multipart/form-data" class="flex gap-3">
                    @csrf
                    <input type="file" name="file" id="fileImport" class="hidden">
                    <button type="button" onclick="document.getElementById('fileImport').click()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        📥 Import Excel / CSV
                    </button>
                    <button type="submit" id="btnSubmitImport" class="hidden">Preview</button>
                </form>
            </div>

            <script>
                document.getElementById('fileImport').addEventListener('change', function(){
                    document.getElementById('btnSubmitImport').click();
                });
            </script>

                 <!-- Tabel Data Penduduk -->
            <div class="bg-white rounded-2xl shadow overflow-auto">
                <table class="min-w-full text-sm table-auto border border-gray-200">
                     <thead class="bg-gray-50 border-b border-gray-200 sticky top-0">
                        <tr>
                            <th class="px-3 py-2">No</th>
                            <th class="px-3 py-2">RW</th>
                            <th class="px-3 py-2">RT</th>
                            <th class="px-3 py-2">Dusun</th>
                            <th class="px-3 py-2">Alamat</th>
                            <th class="px-3 py-2">Kode Keluarga</th>
                            <th class="px-3 py-2">Nama Kepala</th>
                            <th class="px-3 py-2">No</th>
                            <th class="px-3 py-2">NIK</th>
                            <th class="px-3 py-2">Nama Anggota</th>
                            <th class="px-3 py-2">JK</th>
                            <th class="px-3 py-2">Hubungan</th>
                            <th class="px-3 py-2">Tempat Lahir</th>
                            <th class="px-3 py-2">Tanggal Lahir</th>
                            <th class="px-3 py-2">Usia</th>
                            <th class="px-3 py-2">Status</th>
                            <th class="px-3 py-2">Agama</th>
                            <th class="px-3 py-2">GDarah</th>
                            <th class="px-3 py-2">Kewarganegaraan</th>
                            <th class="px-3 py-2">Suku</th>
                            <th class="px-3 py-2">Pendidikan</th>
                            <th class="px-3 py-2">Pekerjaan</th>
                            <th class="px-3 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($penduduk as $key => $p)
                        <tr class="{{ $p->is_active ? '' : 'bg-gray-50 text-gray-400' }}">
                            <td class="px-3 py-2">{{ $penduduk->firstItem() + $key }}</td>
                            <td class="px-3 py-2">{{ $p->rw }}</td>
                            <td class="px-3 py-2">{{ $p->rt }}</td>
                            <td class="px-3 py-2">{{ $p->dusun }}</td>
                            <td class="px-3 py-2">{{ $p->alamat }}</td>
                            <td class="px-3 py-2">{{ $p->kode_keluarga }}</td>
                            <td class="px-3 py-2">{{ $p->nama_kepala_keluarga }}</td>
                            <td class="px-3 py-2">{{ $p->no }}</td>
                            <td class="px-3 py-2">{{ $p->nik }}</td>
                            <td class="px-3 py-2">{{ $p->nama }}</td>
                            <td class="px-3 py-2">{{ $p->jk }}</td>
                            <td class="px-3 py-2">{{ $p->hubungan }}</td>
                            <td class="px-3 py-2">{{ $p->tempat_lahir }}</td>
                            <td class="px-3 py-2">{{ $p->tgl_lahir }}</td>
                            <td class="px-3 py-2">{{ $p->usia }}</td>
                            <td class="px-3 py-2">{{ $p->status }}</td>
                            <td class="px-3 py-2">{{ $p->agama }}</td>
                            <td class="px-3 py-2">{{ $p->gol_darah }}</td>
                            <td class="px-3 py-2">{{ $p->kewarganegaraan }}</td>
                            <td class="px-3 py-2">{{ $p->suku }}</td>
                            <td class="px-3 py-2">{{ $p->pendidikan }}</td>
                            <td class="px-3 py-2">{{ $p->pekerjaan }}</td>
                            <td class="px-3 py-2 flex gap-2">
                                <form method="POST" action="{{ route('admin.penduduk.toggleStatus', $p->id) }}">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 rounded-lg text-white {{ $p->is_active ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }}">
                                        {{ $p->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $penduduk->links() }}
                </div>
            </div>
        </main>
    </div>

    <script>
        // Auto submit form import ketika file dipilih
        document.getElementById('fileImport').addEventListener('change', function(){
            document.getElementById('btnSubmitImport').click();
        });
    </script>
</x-app-layout>

