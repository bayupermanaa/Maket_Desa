<x-app-layout>
    <div class="max-w-7xl mx-auto px-6 py-10">
        <div class="flex items-center justify-between gap-4 flex-wrap">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Artikel Desa</h1>
                <p class="text-gray-600 mt-1">Berita, informasi, dan kegiatan terbaru.</p>
            </div>
            <x-public-back-link href="{{ route('dashboard') }}" label="Kembali ke Dashboard" />
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
                            <svg class="h-16 w-16 text-white opacity-75" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M5 4h11l3 3v13H5z"></path>
                                <path d="M16 4v4h4"></path>
                                <path d="M8 11h6"></path>
                                <path d="M8 15h6"></path>
                            </svg>
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
                        <div class="mt-5 inline-flex items-center gap-[6px] text-blue-600 font-medium text-sm">
                            <span>Baca selengkapnya</span>
                            <svg class="public-inline-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m13 6 6 6-6 6"></path>
                            </svg>
                        </div>
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
