<x-app-layout>
    <x-slot name="title">Tambah Berita</x-slot>
    <div class="min-h-screen bg-gray-100 flex">
        @include('admin.partials.sidebar')

        <main class="flex-1 p-8">
        <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Berita Desa</h1>

            @if($errors->any())
                <div class="mb-5 rounded-2xl bg-red-50 border border-red-200 px-4 py-3 text-red-700 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul</label>
                    <input type="text" name="judul" value="{{ old('judul') }}" class="w-full border border-gray-300 rounded-2xl px-4 py-3" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Isi Berita</label>
                    <textarea name="isi" rows="8" class="w-full border border-gray-300 rounded-2xl px-4 py-3" required>{{ old('isi') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Publish</label>
                    <input type="date" name="tanggal_publish" value="{{ old('tanggal_publish', now()->toDateString()) }}" class="w-full border border-gray-300 rounded-2xl px-4 py-3" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar</label>
                    <input type="file" name="gambar" accept=".jpg,.jpeg,.png,.webp" class="w-full border border-gray-300 rounded-2xl px-4 py-3">
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="px-6 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-medium">Simpan Berita</button>
                    <a href="{{ route('admin.berita.index') }}" class="px-6 py-3 rounded-2xl border border-gray-300 hover:bg-gray-50">Batal</a>
                </div>
            </form>
        </div>
        </main>
    </div>
</x-app-layout>
