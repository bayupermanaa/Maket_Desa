<x-app-layout>
    <x-slot name="title">Manajemen Berita Desa</x-slot>

    <div class="min-h-screen bg-gray-100 flex">
        @include('admin.partials.sidebar')

        <main class="flex-1 p-8 md:p-10">
            <div class="max-w-7xl mx-auto space-y-6">
                <div class="flex flex-wrap items-start justify-between gap-4 mb-8">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Manajemen Berita</h1>
                        <p class="text-gray-500 mt-1">Kelola berita desa untuk ditampilkan pada dashboard publik.</p>
                    </div>
                    <a href="{{ route('admin.berita.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-medium shadow-sm">
                        + Tambah Berita Baru
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                        <p class="text-xs text-gray-500">Total Berita</p>
                        <p class="mt-2 text-2xl font-bold text-gray-800">{{ $beritas->total() }}</p>
                    </div>
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                        <p class="text-xs text-gray-500">Data Halaman Ini</p>
                        <p class="mt-2 text-2xl font-bold text-blue-700">{{ $beritas->count() }}</p>
                    </div>
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                        <p class="text-xs text-gray-500">Status</p>
                        <p class="mt-2 text-2xl font-bold text-emerald-700">Published</p>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow overflow-hidden">
                    <div class="px-6 py-4 border-b flex items-center justify-between">
                        <h3 class="font-semibold text-lg text-gray-800">Daftar Berita Desa</h3>
                        <span class="text-sm text-gray-500">Urut terbaru</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50 text-gray-600">
                                <tr>
                                    <th class="px-6 py-4 text-left font-medium">Gambar</th>
                                    <th class="px-6 py-4 text-left font-medium">Judul Berita</th>
                                    <th class="px-6 py-4 text-left font-medium">Tanggal</th>
                                    <th class="px-6 py-4 text-center font-medium">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($beritas as $berita)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">
                                            @if($berita->gambar)
                                                <img
                                                    src="{{ \Illuminate\Support\Str::startsWith($berita->gambar, 'berita/') ? asset($berita->gambar) : asset('storage/' . $berita->gambar) }}"
                                                    alt="{{ $berita->judul }}"
                                                    class="w-16 h-16 object-cover rounded-xl shadow">
                                            @else
                                                <div class="w-16 h-16 bg-gray-100 rounded-xl flex items-center justify-center text-2xl text-gray-400">🖼️</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-gray-800 line-clamp-2">{{ $berita->judul }}</div>
                                            <div class="text-xs text-gray-500 mt-1">Slug: {{ $berita->slug }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-gray-500">{{ $berita->created_at->format('d M Y') }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex justify-center gap-4">
                                                <a href="{{ route('admin.berita.edit', $berita) }}" class="text-blue-600 hover:text-blue-700 font-medium">Edit</a>
                                                <form action="{{ route('admin.berita.destroy', $berita) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-700 font-medium">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-20 text-center">
                                            <div class="mx-auto max-w-md">
                                                <div class="text-6xl mb-4">📰</div>
                                                <p class="text-gray-700 font-semibold text-lg">Belum ada berita.</p>
                                                <p class="text-sm text-gray-500 mt-2">Mulai publikasi informasi desa dengan menambahkan berita pertama.</p>
                                                <a href="{{ route('admin.berita.create') }}" class="inline-flex mt-5 px-5 py-2.5 rounded-xl bg-blue-600 text-white hover:bg-blue-700 text-sm font-medium">
                                                    + Tambah Berita Baru
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($beritas->count() === 0)
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                            <h4 class="font-semibold text-gray-800 mb-2">Aksi Cepat</h4>
                            <p class="text-sm text-gray-600 mb-4">Buat berita baru sekarang agar menu Berita publik langsung terisi.</p>
                            <a href="{{ route('admin.berita.create') }}" class="inline-flex px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium">
                                Tulis Berita
                            </a>
                        </div>
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                            <h4 class="font-semibold text-gray-800 mb-2">Tips Konten</h4>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• Gunakan judul singkat dan jelas.</li>
                                <li>• Tambahkan gambar agar lebih menarik.</li>
                                <li>• Isi berita fokus ke kegiatan desa terbaru.</li>
                            </ul>
                        </div>
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                            <h4 class="font-semibold text-gray-800 mb-2">Alur Publikasi</h4>
                            <ol class="text-sm text-gray-600 space-y-1">
                                <li>1. Klik “Tambah Berita Baru”.</li>
                                <li>2. Isi judul, isi, dan gambar.</li>
                                <li>3. Simpan dan cek di dashboard publik.</li>
                            </ol>
                        </div>
                    </div>
                @endif

                <div class="mt-6">{{ $beritas->onEachSide(1)->links() }}</div>
            </div>
        </main>
    </div>
</x-app-layout>
