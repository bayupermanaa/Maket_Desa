<x-app-layout>
    <div class="max-w-7xl mx-auto px-6 py-10">
        <div class="mb-4">
            <a href="{{ route('dashboard') }}#section-berita" class="inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-700">
                &larr; Kembali ke Dashboard
            </a>
        </div>

        <h1 class="text-3xl font-bold text-gray-800 mb-2">Berita Desa</h1>
        <p class="text-gray-500 mb-8">Informasi terbaru seputar kegiatan dan pengumuman desa.</p>

        <form method="GET" action="{{ route('berita.index') }}" class="mb-8 bg-white rounded-3xl shadow p-5">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm text-gray-600 mb-2">Tanggal</label>
                    <select name="day" class="w-full border border-gray-300 rounded-xl px-3 py-2">
                        <option value="">Semua Tanggal</option>
                        @for($d = 1; $d <= 31; $d++)
                            <option value="{{ $d }}" {{ (int)($day ?? 0) === $d ? 'selected' : '' }}>{{ $d }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-2">Bulan</label>
                    <select name="month" class="w-full border border-gray-300 rounded-xl px-3 py-2">
                        <option value="">Semua Bulan</option>
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ (int)($month ?? 0) === $m ? 'selected' : '' }}>{{ $m }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-2">Tahun</label>
                    <select name="year" class="w-full border border-gray-300 rounded-xl px-3 py-2">
                        <option value="">Semua Tahun</option>
                        @foreach(($availableYears ?? collect()) as $yr)
                            <option value="{{ $yr }}" {{ (int)($year ?? 0) === (int)$yr ? 'selected' : '' }}>{{ $yr }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded-xl px-4 py-2 font-medium">Filter</button>
                    <a href="{{ route('berita.index') }}" class="w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl px-4 py-2 font-medium">Reset</a>
                </div>
            </div>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($beritas as $berita)
                <article class="bg-white rounded-3xl shadow overflow-hidden">
                    <div class="h-48 bg-gray-100">
                        @if($berita->gambar)
                            <img src="{{ \Illuminate\Support\Str::startsWith($berita->gambar, 'berita/') ? asset($berita->gambar) : asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div class="p-6">
                        <p class="text-xs text-gray-500">{{ optional($berita->tanggal_publish ?? $berita->created_at)->format('d M Y') ?? '-' }}</p>
                        <h3 class="text-lg font-semibold text-gray-800 mt-2 line-clamp-2">{{ $berita->judul }}</h3>
                        <p class="text-sm text-gray-600 mt-3 line-clamp-3">{{ \Illuminate\Support\Str::limit(strip_tags($berita->isi), 130) }}</p>
                        <a href="{{ route('berita.show', $berita->slug) }}" class="inline-block mt-4 text-blue-600 hover:text-blue-700 font-medium text-sm">Baca selengkapnya →</a>
                    </div>
                </article>
            @empty
                <div class="col-span-full bg-white rounded-3xl shadow p-10 text-center text-gray-500">Belum ada berita.</div>
            @endforelse
        </div>

        <div class="mt-8">{{ $beritas->links() }}</div>
    </div>
</x-app-layout>
