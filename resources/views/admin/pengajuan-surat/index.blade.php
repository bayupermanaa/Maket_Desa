<x-app-layout>
    <x-slot name="title">Verifikasi Pengajuan Surat - Desa Maket</x-slot>
    @php($routePrefix = request()->routeIs('kepala.*') ? 'kepala' : 'admin')

    <div class="min-h-screen bg-gray-100 flex">

        <!-- SIDEBAR -->
        @include('admin.partials.sidebar')

        <!-- MAIN CONTENT -->
        <main class="flex-1 p-10">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-semibold text-gray-800">Verifikasi Pengajuan Surat</h1>
                    <p class="text-gray-500">Admin hanya dapat memverifikasi pengajuan masyarakat</p>
                </div>
            </div>

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
                            <td class="px-6 py-4">
                                <span class="px-4 py-1 rounded-full text-xs font-medium
                                    {{ $item->status == 'Disetujui' ? 'bg-green-100 text-green-700' : 
                                       ($item->status == 'Ditolak' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                    {{ $item->status ?? 'Menunggu' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <a href="{{ route($routePrefix . '.pengajuan-surat.show', $item) }}" class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-sm hover:bg-blue-200">Detail</a>
                                
                                @if($item->status == 'Menunggu')
                                    <form action="{{ route($routePrefix . '.pengajuan-surat.setujui', $item->id) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <button class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm hover:bg-green-200">Setujui</button>
                                    </form>
                                    <form action="{{ route($routePrefix . '.pengajuan-surat.tolak', $item->id) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <button class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-sm hover:bg-red-200">Tolak</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-gray-500">Belum ada pengajuan surat</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</x-app-layout>


