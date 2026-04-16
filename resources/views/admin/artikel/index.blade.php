<x-app-layout>
     <x-slot name="title">Dashboard Admin - Desa Maket</x-slot>

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

                <!-- Artikel Desa -->
                <a href="{{ route('admin.artikel.index') }}"
                class="flex items-center gap-3 px-5 py-4 rounded-2xl font-medium transition
                        {{ request()->routeIs('admin.artikel.*') ? 'bg-orange-600 text-white' : 'hover:bg-gray-800' }}">
                    <span class="text-2xl">📰</span>
                    <span class="font-medium">Artikel Desa</span>
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

     <!-- HEADER -->
    <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Manajemen Artikel</h1>
                <p class="text-gray-500 mt-1">Kelola berita dan artikel desa</p>
            </div>
            <a href="{{ route('admin.artikel.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-medium flex items-center gap-2 shadow-sm">
                <span class="text-xl">＋</span>
                Tambah Artikel Baru
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-5 py-4 rounded-2xl mb-6 flex items-center gap-3">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-5 py-4 rounded-2xl mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Gambar</th>
                        <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Judul Artikel</th>
                        <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Tanggal Publish</th>
                        <th class="px-6 py-4 text-center text-sm font-medium text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($artikels as $artikel)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                @if($artikel->gambar)
                                    <img src="{{ asset('storage/' . $artikel->gambar) }}" 
                                         alt="{{ $artikel->judul }}"
                                         class="w-16 h-16 object-cover rounded-xl shadow">
                                @else
                                    <div class="w-16 h-16 bg-gray-100 rounded-xl flex items-center justify-center text-3xl text-gray-400">
                                        🖼️
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-800">{{ $artikel->judul }}</div>
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-sm">
                                {{ $artikel->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-4">
                                    <a href="{{ route('admin.artikel.edit', $artikel) }}" 
                                       class="text-blue-600 hover:text-blue-700 font-medium">✏️ Edit</a>
                                    
                                    <form action="{{ route('admin.artikel.destroy', $artikel) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700 font-medium">🗑️ Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center">
                                <div class="text-gray-400 text-6xl mb-4">📰</div>
                                <p class="text-gray-500">Belum ada artikel yang dibuat.</p>
                                <p class="text-sm text-gray-400 mt-1">Klik tombol di atas untuk menambahkan artikel pertama.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-center">
            {{ $artikels->links() }}
        </div>
    </div>
</x-app-layout>