<x-app-layout>
    <x-slot name="title">Pengajuan Surat - Desa Maket</x-slot>

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

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-semibold text-gray-800">Verifikasi Pengajuan Surat</h1>
                <p class="text-gray-500">Admin hanya dapat memverifikasi pengajuan masyarakat</p>
            </div>

            <span class="bg-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm">
                Mode Verifikasi Admin
            </span>
        </div>

        <!-- TABLE -->
        <div class="bg-white rounded-3xl shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left">No</th>
                        <th class="px-6 py-4 text-left">Nama Pemohon</th>
                        <th class="px-6 py-4 text-left">Jenis Surat</th>
                        <th class="px-6 py-4 text-left">Tanggal</th>
                        <th class="px-6 py-4 text-left">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse ($pengajuan as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 font-medium">{{ $item->nama }}</td>
                        <td class="px-6 py-4">{{ $item->jenis_surat }}</td>
                        <td class="px-6 py-4">{{ $item->created_at->format('d M Y') }}</td>

                        <!-- STATUS -->
                        <td class="px-6 py-4">
                            <span class="px-4 py-1 rounded-full text-xs font-medium
                                {{ $item->status == 'Disetujui' ? 'bg-green-100 text-green-700' : 
                                   ($item->status == 'Ditolak' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                {{ $item->status ?? 'Menunggu' }}
                            </span>
                        </td>

                        <!-- AKSI -->
                        <td class="px-6 py-4 text-center space-x-2">

                            <!-- DETAIL -->
                            <a href="{{ route('admin.pengajuan-surat.show', $item) }}" 
                               class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-sm hover:bg-blue-200">
                                Detail
                            </a>

                            @if($item->status == 'Menunggu')

                                <!-- SETUJUI -->
                                <form action="{{ route('admin.pengajuan-surat.setujui', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm hover:bg-green-200">
                                        Setujui
                                    </button>
                                </form>

                                <!-- TOLAK -->
                                <form action="{{ route('admin.pengajuan-surat.tolak', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-sm hover:bg-red-200">
                                        Tolak
                                    </button>
                                </form>

                            @endif

                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center text-gray-500">
                            Belum ada pengajuan surat
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </main>
</div>
</x-app-layout>