<x-app-layout>
    <x-slot name="title">Aparatur Desa</x-slot>

    <div class="min-h-screen bg-gray-100 flex">
        @include('admin.partials.sidebar')

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
                            <th class="px-6 py-4 text-left">Deskripsi</th>
                            <th class="px-6 py-4 text-left">Urutan</th>
                            <th class="px-6 py-4 text-left">Status</th>
                            <th class="px-6 py-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($aparaturs as $item)
                            <tr>
                                <td class="px-6 py-4">
                                    <img src="{{ $item->foto && \Illuminate\Support\Str::startsWith($item->foto, 'images/') ? asset($item->foto) : asset('images/logo.png') }}"
                                         class="w-16 h-16 rounded-xl object-cover border">
                                </td>
                                <td class="px-6 py-4 font-medium">{{ $item->nama }}</td>
                                <td class="px-6 py-4">{{ $item->jabatan }}</td>
                                <td class="px-6 py-4 text-gray-600 max-w-xs">
                                    <div class="line-clamp-2">
                                        {{ $item->deskripsi ?? '-' }}
                                    </div>
                                </td>
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
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
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



