<x-app-layout>
    <x-slot name="title">Edit Berita</x-slot>
    <div class="min-h-screen bg-gray-100 flex">
        @include('admin.partials.sidebar')

        <main class="flex-1 p-8">
        <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Berita Desa</h1>
            <form action="{{ route('admin.berita.update', ['beritum' => $berita->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul</label>
                    <input type="text" name="judul" value="{{ old('judul', $berita->judul) }}" class="w-full border border-gray-300 rounded-2xl px-4 py-3" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Isi Berita</label>
                    <textarea name="isi" rows="8" class="w-full border border-gray-300 rounded-2xl px-4 py-3" required>{{ old('isi', $berita->isi) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Publish</label>
                    <input type="date" name="tanggal_publish" value="{{ old('tanggal_publish', optional($berita->tanggal_publish)->format('Y-m-d')) }}" class="w-full border border-gray-300 rounded-2xl px-4 py-3" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar</label>
                    <input type="file" name="gambar" accept=".jpg,.jpeg,.png,.webp" class="w-full border border-gray-300 rounded-2xl px-4 py-3">
                    @if($berita->gambar)
                        <img src="{{ \Illuminate\Support\Str::startsWith($berita->gambar, 'berita/') ? asset($berita->gambar) : asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="mt-3 w-40 h-28 object-cover rounded-xl border">
                    @endif
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="px-6 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-medium">Update Berita</button>
                    <a href="{{ route('admin.berita.index') }}" class="px-6 py-3 rounded-2xl border border-gray-300 hover:bg-gray-50">Batal</a>
                </div>
            </form>
        </div>
        </main>
    </div>
</x-app-layout>
