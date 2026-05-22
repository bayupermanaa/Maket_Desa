<x-app-layout>
    <div class="max-w-7xl mx-auto px-6 py-10">
        <div class="flex items-center justify-between gap-4 flex-wrap">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">📰 Artikel Desa</h1>
                <p class="text-gray-600 mt-1">Berita, informasi, dan kegiatan terbaru.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-5 py-3 rounded-2xl font-semibold">
                ← Kembali ke Dashboard
            </a>
        </div>

        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($artikels as $artikel)
                @php
                    $gambarSrc = null;
                    if (!empty($artikel->gambar)) {
                        if (\Illuminate\Support\Str::startsWith($artikel->gambar, 'artikel/')) {
                            $gambarSrc = file_exists(public_path($artikel->gambar)) ? asset($artikel->gambar) : null;
                        } else {
                            $gambarSrc = file_exists(public_path('storage/' . $artikel->gambar)) ? asset('storage/' . $artikel->gambar) : null;
                        }
                    }
                @endphp

                <a href="{{ route('artikel.show', $artikel->slug) }}" class="bg-white rounded-3xl shadow overflow-hidden hover:shadow-xl transition group">
                    <div class="h-48 bg-gradient-to-br from-orange-500 to-amber-500 flex items-center justify-center overflow-hidden">
                        @if($gambarSrc)
                            <img src="{{ $gambarSrc }}" alt="{{ $artikel->judul }}" class="w-full h-full object-cover">
                        @else
                            <div class="text-white text-7xl opacity-75">📰</div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h2 class="font-semibold text-lg leading-tight line-clamp-2 group-hover:text-orange-600 transition">
                            {{ $artikel->judul }}
                        </h2>
                        <p class="text-xs text-gray-500 mt-2">{{ $artikel->created_at->format('d M Y') }}</p>
                        <p class="text-gray-600 text-sm mt-4 line-clamp-3">
                            {{ \Illuminate\Support\Str::limit(strip_tags($artikel->isi ?? ''), 140) }}
                        </p>
                        <div class="mt-5 text-blue-600 font-medium text-sm">Baca selengkapnya →</div>
                    </div>
                </a>
            @empty
                <div class="col-span-full bg-white rounded-3xl shadow p-10 text-center">
                    <p class="text-gray-500">Belum ada artikel.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-10 flex justify-center">
            {{ $artikels->links() }}
        </div>
    </div>
</x-app-layout>

