<x-app-layout>
    <x-slot name="title">CMS Dashboard Desa</x-slot>
    
    <div class="min-h-screen bg-gray-100 flex">
        <aside class="w-72 bg-gray-900 text-white min-h-screen p-6 flex-shrink-0">
             <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 mb-10">
                    <div class="w-16 h-16 rounded-2xl overflow-hidden flex-shrink-0 bg-white flex items-center justify-center">
                        <img src="{{ asset('storage/images/logo.png') }}" alt="Logo Desa" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h1 class="text-xl font-semibold">Desa Maket</h1>
                        <p class="text-xs text-gray-400">Admin Panel</p>
                    </div>
                </a>

            <nav class="space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-orange-600 text-white' : 'hover:bg-gray-800' }}">
                    🏠 Dashboard
                </a>

                <a href="/admin/data-penduduk" 
                    class="flex items-center gap-3 px-5 py-4 hover:bg-gray-800 text-gray-300 hover:text-white transition-all {{ request()->is('admin/data-penduduk*') ? 'bg-gray-800 text-white' : '' }}">
                    <span class="text-2xl">👥</span>
                    <span class="font-medium">Data Penduduk</span>
                </a>

                <a href="{{ route('admin.pengajuan-surat.index') }}"
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl font-medium transition {{ request()->routeIs('admin.pengajuan-surat.*') ? 'bg-orange-600 text-white' : 'hover:bg-gray-800' }}">
                    📄 Pengajuan Surat
                </a>

                 <a href="{{ route('admin.pengaduan') }}" 
                    class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.pengaduan') ? 'bg-orange-600 text-white' : 'hover:bg-gray-800' }}">
                    📢 Pengaduan Masyarakat
                </a>

                <a href="#"
                   class="flex items-center gap-3 px-5 py-4 hover:bg-gray-800 rounded-2xl transition">
                    📊 Laporan & Statistik
                </a>

                <a href="#"
                   class="flex items-center gap-3 px-5 py-4 hover:bg-gray-800 rounded-2xl transition">
                    💰 Keuangan Desa
                </a>

                <a href="{{ route('admin.aparatur-desa.index') }}"
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl font-medium transition {{ request()->routeIs('admin.aparatur-desa.*') ? 'bg-orange-600 text-white' : 'hover:bg-gray-800' }}">
                    🏛️ Aparatur Desa
                </a>

                <a href="{{ route('admin.settings-desa.edit') }}"
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl font-medium transition {{ request()->routeIs('admin.settings-desa.*') ? 'bg-orange-600 text-white' : 'hover:bg-gray-800' }}">
                    ⚙️ CMS Dashboard Desa
                </a>
            </nav>
        </aside>

        <div class="flex-1 p-8 lg:p-12 bg-gray-50">
            <h1 class="text-3xl font-bold mb-8">⚙️ Pengaturan Desa</h1>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6">
                    <div class="font-semibold mb-2">Terjadi kesalahan:</div>
                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST"
                  action="{{ route('admin.settings-desa.update') }}"
                  enctype="multipart/form-data"
                  class="bg-white p-8 rounded-3xl shadow space-y-8">

                @csrf
                @method('PUT')

                <div>
                    <h2 class="text-xl font-bold mb-4">Profil Dasar Desa</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="font-medium">Nama Desa</label>
                            <input type="text" name="nama_desa" value="{{ old('nama_desa', $data->nama_desa ?? '') }}"
                                   class="w-full mt-2 border rounded-xl p-3">
                        </div>

                        <div>
                            <label class="font-medium">Kecamatan</label>
                            <input type="text" name="kecamatan" value="{{ old('kecamatan', $data->kecamatan ?? '') }}"
                                   class="w-full mt-2 border rounded-xl p-3">
                        </div>

                        <div>
                            <label class="font-medium">Kabupaten</label>
                            <input type="text" name="kabupaten" value="{{ old('kabupaten', $data->kabupaten ?? '') }}"
                                   class="w-full mt-2 border rounded-xl p-3">
                        </div>

                        <div>
                            <label class="font-medium">Provinsi</label>
                            <input type="text" name="provinsi" value="{{ old('provinsi', $data->provinsi ?? '') }}"
                                   class="w-full mt-2 border rounded-xl p-3">
                        </div>

                        <div>
                            <label class="font-medium">Luas Wilayah</label>
                            <input type="text" name="luas_wilayah" value="{{ old('luas_wilayah', $data->luas_wilayah ?? '') }}"
                                   placeholder="Contoh: 12 km²"
                                   class="w-full mt-2 border rounded-xl p-3">
                        </div>

                        <div>
                            <label class="font-medium">Kepadatan</label>
                            <input type="text" name="kepadatan" value="{{ old('kepadatan', $data->kepadatan ?? '') }}"
                                   placeholder="Contoh: 204 jiwa/km²"
                                   class="w-full mt-2 border rounded-xl p-3">
                        </div>

                        <div>
                            <label class="font-medium">Jumlah Penduduk</label>
                            <input type="number" name="jumlah_penduduk" value="{{ old('jumlah_penduduk', $data->jumlah_penduduk ?? '') }}"
                                   class="w-full mt-2 border rounded-xl p-3">
                        </div>

                        <div>
                            <label class="font-medium">Jumlah Banjar</label>
                            <input type="number" name="jumlah_banjar" value="{{ old('jumlah_banjar', $data->jumlah_banjar ?? '') }}"
                                   class="w-full mt-2 border rounded-xl p-3">
                        </div>

                        <div>
                            <label class="font-medium">Penduduk Baru Tahun Ini</label>
                            <input type="number" name="penduduk_baru_tahun_ini" value="{{ old('penduduk_baru_tahun_ini', $data->penduduk_baru_tahun_ini ?? '') }}"
                                   class="w-full mt-2 border rounded-xl p-3">
                        </div>
                    </div>
                </div>

                <div class="border-t pt-8">
                    <label class="font-semibold text-lg block mb-3">🎬 Video Profil Desa (YouTube)</label>

                    <div>
                        <label class="font-medium text-sm text-gray-600 block mb-2">Link YouTube</label>
                        <input type="text" id="youtube_input" name="video_desa"
                               value="{{ old('video_desa', $data->video_desa ?? '') }}"
                               placeholder="https://www.youtube.com/watch?v=raxZ7QMI4Eg"
                               class="w-full border border-gray-300 rounded-xl p-3 focus:outline-none focus:border-orange-500">
                    </div>

                    <p class="text-xs text-gray-500 mt-2 mb-5">
                        Masukkan link YouTube, preview akan muncul otomatis di bawah ini
                    </p>

                    <div id="video_preview" class="mt-6">
                        <p class="text-sm font-medium text-gray-700 mb-3">Preview Video:</p>
                        <div id="preview_container" class="aspect-video bg-black rounded-2xl overflow-hidden shadow hidden"></div>
                        <p id="no_preview" class="text-gray-400 text-center py-12 bg-gray-50 rounded-2xl">
                            Preview video akan muncul di sini setelah memasukkan link YouTube
                        </p>
                    </div>
                </div>

                <div class="border-t pt-8">
                    <h2 class="text-xl font-bold mb-4">Kepala Desa</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="font-medium">Nama Kepala Desa</label>
                            <input type="text" name="kepala_desa_nama" value="{{ old('kepala_desa_nama', $data->kepala_desa_nama ?? '') }}"
                                   class="w-full mt-2 border rounded-xl p-3">
                        </div>

                        <div>
                            <label class="font-medium">Jabatan Kepala Desa</label>
                            <input type="text" name="kepala_desa_jabatan" value="{{ old('kepala_desa_jabatan', $data->kepala_desa_jabatan ?? '') }}"
                                   class="w-full mt-2 border rounded-xl p-3">
                        </div>

                        <div>
                            <label class="font-medium">Periode Kepala Desa</label>
                            <input type="text" name="kepala_desa_periode" value="{{ old('kepala_desa_periode', $data->kepala_desa_periode ?? '') }}"
                                   placeholder="Contoh: 2016 - 2030"
                                   class="w-full mt-2 border rounded-xl p-3">
                        </div>

                        <div>
                            <label class="font-medium">Foto Kepala Desa</label>
                            <input type="file" name="kepala_desa_foto"
                                   class="w-full mt-2 border rounded-xl p-3">
                        </div>
                    </div>

                    @if(!empty($data->kepala_desa_foto))
                        <div class="mt-4">
                            <p class="text-sm text-gray-600 mb-2">Preview Foto Kepala Desa:</p>
                            <img src="{{ asset('storage/' . $data->kepala_desa_foto) }}"
                                 alt="Kepala Desa"
                                 class="w-32 h-32 object-cover rounded-2xl border shadow">
                        </div>
                    @endif
                </div>

                <div class="border-t pt-8">
                    <h2 class="text-xl font-bold mb-4">Sejarah Desa</h2>
                    <div>
                        <label class="font-medium">Isi Sejarah Desa</label>
                        <textarea name="sejarah_desa" rows="6"
                                  class="w-full mt-2 border rounded-xl p-3">{{ old('sejarah_desa', $data->sejarah_desa ?? '') }}</textarea>
                    </div>
                </div>

                <div class="border-t pt-8">
                    <h2 class="text-xl font-bold mb-4">Popup Kebijakan</h2>

                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="font-medium">Judul Popup</label>
                            <input type="text" name="popup_judul" value="{{ old('popup_judul', $data->popup_judul ?? '') }}"
                                   class="w-full mt-2 border rounded-xl p-3">
                        </div>

                        <div>
                            <label class="font-medium">Isi Popup</label>
                            <textarea name="popup_isi" rows="5"
                                      class="w-full mt-2 border rounded-xl p-3">{{ old('popup_isi', $data->popup_isi ?? '') }}</textarea>
                        </div>

                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="popup_aktif" value="1"
                                   {{ old('popup_aktif', $data->popup_aktif ?? false) ? 'checked' : '' }}>
                            <label class="font-medium">Tampilkan Popup</label>
                        </div>
                    </div>
                </div>

                <div class="border-t pt-8">
                    <button type="submit"
                            class="bg-orange-600 hover:bg-orange-700 text-white px-8 py-4 rounded-2xl font-semibold w-full md:w-auto">
                        💾 Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('youtube_input');
    const previewContainer = document.getElementById('preview_container');
    const noPreview = document.getElementById('no_preview');

    function cleanYouTubeUrl(url) {
        if (!url) return '';
        let videoId = '';

        if (url.includes('youtu.be/')) {
            videoId = url.split('youtu.be/')[1];
        } else if (url.includes('watch?v=')) {
            videoId = url.split('watch?v=')[1];
        } else if (url.includes('/embed/')) {
            videoId = url.split('/embed/')[1];
        } else if (/^[a-zA-Z0-9_-]{11}$/.test(url.trim())) {
            videoId = url.trim();
        }

        if (!videoId) return '';
        videoId = videoId.split('&')[0];
        return videoId;
    }

    function updatePreview() {
        const videoId = cleanYouTubeUrl(input.value);

        if (videoId && videoId.length >= 10) {
            previewContainer.innerHTML = `<iframe width="100%" height="100%" src="https://www.youtube.com/embed/${videoId}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>`;
            previewContainer.classList.remove('hidden');
            noPreview.classList.add('hidden');
        } else {
            previewContainer.classList.add('hidden');
            noPreview.classList.remove('hidden');
            previewContainer.innerHTML = '';
        }
    }

    updatePreview();
    input.addEventListener('input', updatePreview);
    input.addEventListener('paste', () => setTimeout(updatePreview, 50));
});
</script>