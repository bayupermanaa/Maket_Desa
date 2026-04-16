<x-app-layout>
    <x-slot name="title">Edit Aparatur Desa</x-slot>

    <div class="max-w-4xl mx-auto p-8">
        <h1 class="text-3xl font-bold mb-8">Edit Aparatur Desa</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.aparatur-desa.update', $aparatur->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-3xl shadow space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="font-medium">Nama</label>
                <input type="text" name="nama" value="{{ old('nama', $aparatur->nama) }}" class="w-full mt-2 border rounded-xl p-3">
            </div>

            <div>
                <label class="font-medium">Jabatan</label>
                <input type="text" name="jabatan" value="{{ old('jabatan', $aparatur->jabatan) }}" class="w-full mt-2 border rounded-xl p-3">
            </div>

            <div>
                <label class="font-medium">Deskripsi</label>
                <textarea name="deskripsi" rows="4" class="w-full mt-2 border rounded-xl p-3">{{ old('deskripsi', $aparatur->deskripsi) }}</textarea>
            </div>

            <div>
                <label class="font-medium">Urutan</label>
                <input type="number" name="urutan" value="{{ old('urutan', $aparatur->urutan) }}" class="w-full mt-2 border rounded-xl p-3">
            </div>

            <div>
                <label class="font-medium">Foto</label>
                <input type="file" name="foto" class="w-full mt-2 border rounded-xl p-3">
            </div>

            @if($aparatur->foto)
                <div>
                    <p class="text-sm text-gray-600 mb-2">Foto Saat Ini</p>
                    <img src="{{ asset('storage/' . $aparatur->foto) }}" class="w-28 h-28 rounded-xl object-cover border">
                </div>
            @endif

            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_active" value="1" {{ $aparatur->is_active ? 'checked' : '' }}>
                <label class="font-medium">Aktif</label>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-8 py-3 rounded-2xl font-semibold">
                    Update
                </button>
                <a href="{{ route('admin.aparatur-desa.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-8 py-3 rounded-2xl font-semibold">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</x-app-layout>