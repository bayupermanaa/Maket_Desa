<x-app-layout>
    <div class="max-w-4xl mx-auto py-6 px-6">
        <h1 class="text-3xl font-bold mb-6">Edit Artikel</h1>

        <form action="{{ route('admin.artikel.update', $artikel) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-3xl shadow p-8 space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul Artikel</label>
                    <input type="text" name="judul" value="{{ old('judul', $artikel->judul) }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:border-blue-500"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</label>
                    @if($artikel->gambar)
                        <img src="{{ asset('storage/' . $artikel->gambar) }}" 
                             alt="" class="w-48 h-32 object-cover rounded-2xl mb-3">
                    @endif
                    <input type="file" name="gambar" accept="image/*"
                           class="w-full border border-gray-300 rounded-2xl p-3">
                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengganti gambar</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Isi Artikel</label>
                    <textarea name="isi" rows="15"
                              class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:border-blue-500"
                              required>{{ old('isi', $artikel->isi) }}</textarea>
                </div>

                <div class="flex gap-4">
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-2xl font-medium">
                        Update Artikel
                    </button>
                    <a href="{{ route('admin.artikel.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-8 py-3 rounded-2xl font-medium">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>