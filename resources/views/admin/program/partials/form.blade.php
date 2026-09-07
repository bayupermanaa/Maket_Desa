@php($program = $program ?? null)

<div>
    <label class="block text-sm font-medium text-gray-700 mb-2">Judul Program</label>
    <input type="text" name="judul" value="{{ old('judul', $program->judul ?? '') }}" class="w-full border border-gray-300 rounded-2xl px-4 py-3" required>
    @error('judul') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Singkat</label>
    <textarea name="deskripsi" rows="4" class="w-full border border-gray-300 rounded-2xl px-4 py-3">{{ old('deskripsi', $program->deskripsi ?? '') }}</textarea>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
        <input type="text" name="kategori" value="{{ old('kategori', $program->kategori ?? '') }}" class="w-full border border-gray-300 rounded-2xl px-4 py-3" placeholder="Contoh: Infrastruktur">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
        <input type="number" name="tahun" value="{{ old('tahun', $program->tahun ?? '') }}" class="w-full border border-gray-300 rounded-2xl px-4 py-3" min="2000" max="2100">
    </div>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Program</label>
    <input type="file" name="gambar" accept=".jpg,.jpeg,.png,.webp" class="w-full border border-gray-300 rounded-2xl px-4 py-3 bg-white">
    <p class="text-xs text-gray-500 mt-2">Format: JPG/PNG/WEBP, maksimal 2 MB.</p>
    @if(!empty($program?->gambar))
        <div class="mt-3">
            <img src="{{ asset($program->gambar) }}" alt="Preview gambar program" class="w-40 h-28 object-cover rounded-xl border border-gray-200">
        </div>
    @endif
    @error('gambar') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Anggaran (Rp)</label>
        <input type="number" name="anggaran" value="{{ old('anggaran', $program->anggaran ?? '') }}" class="w-full border border-gray-300 rounded-2xl px-4 py-3" min="0">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
        <select name="status" class="w-full border border-gray-300 rounded-2xl px-4 py-3" required>
            @foreach(['perencanaan' => 'Perencanaan', 'berjalan' => 'Berjalan', 'selesai' => 'Selesai'] as $key => $label)
                <option value="{{ $key }}" {{ old('status', $program->status ?? 'perencanaan') === $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Urutan Tampil</label>
        <input type="number" name="urutan" value="{{ old('urutan', $program->urutan ?? 0) }}" class="w-full border border-gray-300 rounded-2xl px-4 py-3" min="0">
    </div>
</div>

<label class="inline-flex items-center gap-2 text-sm text-gray-700">
    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300" {{ old('is_active', $program->is_active ?? true) ? 'checked' : '' }}>
    Aktifkan untuk publik
</label>

<div class="pt-3">
    <button type="submit" class="px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-2xl font-medium">Simpan Program</button>
</div>
