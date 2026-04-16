<x-app-layout>
    <div class="max-w-4xl mx-auto py-6 px-6">
        <h1 class="text-3xl font-bold mb-6">Tambah Artikel Baru</h1>

        

        <form action="{{ route('admin.artikel.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="bg-white rounded-3xl shadow p-8 space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul Artikel</label>
                    <input type="text" name="judul" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:border-blue-500"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar (Opsional)</label>
                    <input type="file" name="gambar" accept="image/*"
                           class="w-full border border-gray-300 rounded-2xl p-3">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Isi Artikel</label>
                    <textarea name="isi" rows="15"
                              class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:border-blue-500"
                              required></textarea>
                </div>

                <div class="flex gap-4">
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-2xl font-medium">
                        Simpan Artikel
                    </button>
                    <a href="{{ route('admin.artikel.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-8 py-3 rounded-2xl font-medium">
                        Batal
                    </a>
                    <a href="{{ route('admin.artikel.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-8 py-3 rounded-2xl font-semibold">
                    Kembali
                </a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>