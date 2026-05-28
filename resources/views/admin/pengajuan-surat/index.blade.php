<x-app-layout>
    <x-slot name="title">Verifikasi Pengajuan Surat - Desa Maket</x-slot>
    @php
        $routePrefix = request()->routeIs('kepala.*') ? 'kepala' : 'admin';
        $statusBadgeSurat = [
            'Menunggu' => 'bg-amber-100 text-amber-700',
            'Diproses' => 'bg-blue-100 text-blue-700',
            'Diajukan ke Kepala Desa' => 'bg-indigo-100 text-indigo-700',
            'Disetujui Kepala Desa' => 'bg-emerald-100 text-emerald-700',
            'Ditolak Kepala Desa' => 'bg-orange-100 text-orange-700',
            'Disetujui' => 'bg-green-100 text-green-700',
            'Ditolak' => 'bg-red-100 text-red-700',
        ];
        $filters = $filters ?? [];
        $statusOptions = $statusOptions ?? array_keys($statusBadgeSurat);
    @endphp

    <div class="min-h-screen bg-gray-100 flex">

        <!-- SIDEBAR -->
        @include('admin.partials.sidebar')

        <!-- MAIN CONTENT -->
        <main class="flex-1 p-10">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-semibold text-gray-800">Verifikasi Pengajuan Surat</h1>
                    <p class="text-gray-500">{{ $routePrefix === 'kepala' ? 'Validasi pengajuan yang sudah diajukan admin' : 'Lengkapi administrasi lalu ajukan pengajuan masyarakat ke kepala desa' }}</p>
                </div>
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

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                @if($routePrefix === 'kepala')
                    <a href="{{ route($routePrefix . '.pengajuan-surat.index', ['status' => 'Diajukan ke Kepala Desa']) }}" class="bg-white rounded-2xl border border-indigo-100 p-5 shadow-sm hover:border-indigo-200 transition">
                        <p class="text-sm text-gray-500">Menunggu Validasi</p>
                        <p class="mt-2 text-3xl font-bold text-indigo-600">{{ number_format($suratMenungguKepalaCount ?? 0) }}</p>
                    </a>
                    <a href="{{ route($routePrefix . '.pengajuan-surat.index', ['status' => 'Disetujui Kepala Desa']) }}" class="bg-white rounded-2xl border border-emerald-100 p-5 shadow-sm hover:border-emerald-200 transition">
                        <p class="text-sm text-gray-500">Sudah Disetujui</p>
                        <p class="mt-2 text-3xl font-bold text-emerald-600">{{ number_format($suratPerluFinalisasiCount ?? 0) }}</p>
                    </a>
                    <a href="{{ route($routePrefix . '.pengajuan-surat.index', ['status' => 'Ditolak Kepala Desa']) }}" class="bg-white rounded-2xl border border-orange-100 p-5 shadow-sm hover:border-orange-200 transition">
                        <p class="text-sm text-gray-500">Ditolak Kepala Desa</p>
                        <p class="mt-2 text-3xl font-bold text-orange-600">{{ number_format($suratDitolakKepalaCount ?? 0) }}</p>
                    </a>
                @else
                    <a href="{{ route($routePrefix . '.pengajuan-surat.index', ['status' => 'Menunggu']) }}" class="bg-white rounded-2xl border border-amber-100 p-5 shadow-sm hover:border-amber-200 transition">
                        <p class="text-sm text-gray-500">Surat Baru</p>
                        <p class="mt-2 text-3xl font-bold text-amber-600">{{ number_format($suratBaruCount ?? 0) }}</p>
                    </a>
                    <a href="{{ route($routePrefix . '.pengajuan-surat.index', ['status' => 'Diajukan ke Kepala Desa']) }}" class="bg-white rounded-2xl border border-indigo-100 p-5 shadow-sm hover:border-indigo-200 transition">
                        <p class="text-sm text-gray-500">Menunggu Kepala Desa</p>
                        <p class="mt-2 text-3xl font-bold text-indigo-600">{{ number_format($suratMenungguKepalaCount ?? 0) }}</p>
                    </a>
                    <a href="{{ route($routePrefix . '.pengajuan-surat.index', ['status' => 'Disetujui Kepala Desa']) }}" class="bg-white rounded-2xl border border-emerald-100 p-5 shadow-sm hover:border-emerald-200 transition">
                        <p class="text-sm text-gray-500">Perlu Finalisasi</p>
                        <p class="mt-2 text-3xl font-bold text-emerald-600">{{ number_format($suratPerluFinalisasiCount ?? 0) }}</p>
                    </a>
                @endif
            </div>

            @if(($notifikasiSuratCount ?? 0) > 0)
                <div class="mb-6 rounded-2xl border border-orange-200 bg-orange-50 px-5 py-4 text-sm text-orange-800 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <p>
                        {{ $routePrefix === 'kepala' ? 'Ada pengajuan surat yang menunggu validasi kepala desa.' : 'Ada surat baru dari masyarakat yang perlu diproses admin.' }}
                    </p>
                    <a href="{{ route($routePrefix . '.pengajuan-surat.index', ['status' => $routePrefix === 'kepala' ? 'Diajukan ke Kepala Desa' : 'Menunggu']) }}" class="font-semibold text-orange-700 hover:text-orange-900">
                        Lihat sekarang
                    </a>
                </div>
            @endif

            <form method="GET" action="{{ route($routePrefix . '.pengajuan-surat.index') }}" class="mb-6 bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div class="md:col-span-2">
                        <label for="q" class="block text-sm font-medium text-gray-700">Cari</label>
                        <input id="q" name="q" type="text" value="{{ $filters['q'] ?? '' }}" placeholder="Nama, NIK, atau jenis surat" class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm">
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="status" name="status" class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm">
                            <option value="">Semua status</option>
                            @foreach($statusOptions as $status)
                                <option value="{{ $status }}" {{ ($filters['status'] ?? '') === $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="date_from" class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                        <input id="date_from" name="date_from" type="date" value="{{ $filters['date_from'] ?? '' }}" class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm">
                    </div>
                    <div>
                        <label for="date_to" class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                        <input id="date_to" name="date_to" type="date" value="{{ $filters['date_to'] ?? '' }}" class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm">
                    </div>
                </div>
                <div class="mt-4 flex flex-wrap justify-end gap-3">
                    <a href="{{ route($routePrefix . '.pengajuan-surat.index') }}" class="px-5 py-2.5 rounded-xl bg-gray-100 text-gray-700 text-sm font-medium hover:bg-gray-200">Reset</a>
                    <button class="px-5 py-2.5 rounded-xl bg-orange-600 text-white text-sm font-medium hover:bg-orange-700">Terapkan Filter</button>
                </div>
            </form>

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
                            <td class="px-6 py-4">{{ $pengajuan->firstItem() + $loop->index }}</td>
                            <td class="px-6 py-4 font-medium">{{ $item->nama }}</td>
                            <td class="px-6 py-4">{{ $item->jenis_surat }}</td>
                            <td class="px-6 py-4">{{ $item->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-4 py-1 rounded-full text-xs font-medium {{ $statusBadgeSurat[$item->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ $item->status ?? 'Menunggu' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <a href="{{ route($routePrefix . '.pengajuan-surat.show', $item) }}" class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-sm hover:bg-blue-200">Detail</a>

                                @if($routePrefix === 'admin' && in_array($item->status, ['Menunggu', 'Diproses', 'Ditolak Kepala Desa'], true))
                                    <form action="{{ route($routePrefix . '.pengajuan-surat.setujui', $item->id) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <button class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-lg text-sm hover:bg-indigo-200">Ajukan ke Kepala</button>
                                    </form>
                                    <a href="{{ route($routePrefix . '.pengajuan-surat.show', $item) }}" class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-sm hover:bg-red-200">Tolak</a>
                                @elseif($routePrefix === 'admin' && $item->status === 'Disetujui Kepala Desa')
                                    <form action="{{ route($routePrefix . '.pengajuan-surat.setujui', $item->id) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <button class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm hover:bg-green-200">Finalisasi</button>
                                    </form>
                                @elseif($routePrefix === 'kepala' && $item->status === 'Diajukan ke Kepala Desa')
                                    <form action="{{ route($routePrefix . '.pengajuan-surat.setujui', $item->id) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <button class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm hover:bg-green-200">Setujui</button>
                                    </form>
                                    <a href="{{ route($routePrefix . '.pengajuan-surat.show', $item) }}" class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-sm hover:bg-red-200">Tolak</a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-gray-500">Belum ada pengajuan surat sesuai filter.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $pengajuan->links() }}
            </div>
        </main>
    </div>
</x-app-layout>
