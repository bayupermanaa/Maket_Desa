<x-app-layout>
     <x-slot name="title">Dashboard Admin - Desa Maket</x-slot>

    <div class="min-h-screen bg-gray-100 flex">

        <!-- SIDEBAR -->
        @include('admin.partials.sidebar')

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
                                    <img src="{{ \Illuminate\Support\Str::startsWith($artikel->gambar, 'artikel/') ? asset($artikel->gambar) : asset('storage/' . $artikel->gambar) }}" 
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



