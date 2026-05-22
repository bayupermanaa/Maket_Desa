<x-app-layout>
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

    <div class="max-w-4xl mx-auto px-6 py-10">
        <div class="flex items-center justify-end">
            <a href="{{ route('dashboard') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-5 py-3 rounded-2xl font-semibold">
                ← Kembali ke Dashboard
            </a>
        </div>

        <h1 class="mt-4 text-3xl sm:text-4xl font-bold text-gray-900">{{ $artikel->judul }}</h1>
        <p class="mt-2 text-sm text-gray-500">{{ $artikel->created_at->format('d M Y') }}</p>

        @if($gambarSrc)
            <div class="mt-6 rounded-3xl overflow-hidden shadow">
                <img src="{{ $gambarSrc }}" alt="{{ $artikel->judul }}" class="w-full h-72 sm:h-96 object-cover">
            </div>
        @endif

        <article class="mt-8 bg-white rounded-3xl shadow p-6 sm:p-8">
            <div class="prose prose-gray max-w-none">
                {!! nl2br(e($artikel->isi ?? '')) !!}
            </div>
        </article>
    </div>
</x-app-layout>
