<x-app-layout>
    <div class="max-w-4xl mx-auto px-6 py-10">
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('berita.index') }}" class="text-sm text-blue-600 hover:text-blue-700">&larr; Kembali ke Berita</a>
        </div>

        <h1 class="text-3xl font-bold text-gray-800 mt-3">{{ $berita->judul }}</h1>
        <p class="text-sm text-gray-500 mt-2">{{ optional($berita->tanggal_publish ?? $berita->created_at)->format('d M Y') ?? '-' }}</p>

        @if($berita->gambar)
            <div class="mt-6 rounded-3xl overflow-hidden shadow">
                <img src="{{ \Illuminate\Support\Str::startsWith($berita->gambar, 'berita/') ? asset($berita->gambar) : asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="w-full h-auto object-cover">
            </div>
        @endif

        <div class="mt-8 prose prose-gray max-w-none">
            {!! nl2br(e($berita->isi)) !!}
        </div>

    </div>
</x-app-layout>


