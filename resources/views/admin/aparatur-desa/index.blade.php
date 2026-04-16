<x-app-layout>
    <x-slot name="title">Aparatur Desa</x-slot>

    <div class="min-h-screen bg-gray-100 flex">
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

        <div class="flex-1 p-8 lg:p-12 bg-gray-50">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-bold">🏛️ Aparatur Desa</h1>
                <a href="{{ route('admin.aparatur-desa.create') }}"
                   class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-3 rounded-2xl font-semibold">
                    + Tambah Aparatur
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-3xl shadow overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left">Foto</th>
                            <th class="px-6 py-4 text-left">Nama</th>
                            <th class="px-6 py-4 text-left">Jabatan</th>
                            <th class="px-6 py-4 text-left">Urutan</th>
                            <th class="px-6 py-4 text-left">Status</th>
                            <th class="px-6 py-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($aparaturs as $item)
                            <tr>
                                <td class="px-6 py-4">
                                    <img src="{{ $item->foto ? asset('storage/' . $item->foto) : 'https://via.placeholder.com/80x80?text=Foto' }}"
                                         class="w-16 h-16 rounded-xl object-cover border">
                                </td>
                                <td class="px-6 py-4 font-medium">{{ $item->nama }}</td>
                                <td class="px-6 py-4">{{ $item->jabatan }}</td>
                                <td class="px-6 py-4">{{ $item->urutan }}</td>
                                <td class="px-6 py-4">
                                    <span class="{{ $item->is_active ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.aparatur-desa.edit', $item->id) }}"
                                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.aparatur-desa.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus aparatur ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-sm">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    Belum ada data aparatur desa.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>