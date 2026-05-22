<x-app-layout>
    <x-slot name="title">Program Desa - Desa Maket</x-slot>

    <div class="min-h-screen bg-gray-100 flex">
        @include('admin.partials.sidebar')

        <main class="flex-1 p-10">
            <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-semibold text-gray-800">Program Desa</h1>
                    <p class="text-gray-500">Kelola program yang ditampilkan di dashboard publik.</p>
                </div>
                <a href="{{ route('admin.program.create') }}" class="px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-2xl font-medium">
                    + Tambah Program
                </a>
            </div>

            @if(session('success'))
                <div class="mb-6 rounded-2xl bg-green-50 border border-green-200 px-4 py-3 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-3xl shadow p-6 md:p-8">
                <div class="mb-6 flex items-center justify-between">
                    <h3 class="font-semibold text-xl text-gray-800">Daftar Program Desa</h3>
                    <span class="text-sm text-gray-500">Total {{ $programs->count() }} program</span>
                </div>

                @forelse($programs as $program)
                    @php
                        $status = strtolower((string) $program->status);
                        $statusClass = match($status) {
                            'perencanaan' => 'bg-amber-100 text-amber-700',
                            'berjalan' => 'bg-blue-100 text-blue-700',
                            'selesai' => 'bg-emerald-100 text-emerald-700',
                            default => 'bg-gray-100 text-gray-700',
                        };

                        $kategori = strtolower((string) ($program->kategori ?? ''));
                        $kategoriIcon = '📌';
                        if (\Illuminate\Support\Str::contains($kategori, 'lingkungan')) $kategoriIcon = '🌱';
                        elseif (\Illuminate\Support\Str::contains($kategori, 'infrastruktur')) $kategoriIcon = '🏗️';
                        elseif (\Illuminate\Support\Str::contains($kategori, 'pendidikan')) $kategoriIcon = '🎓';
                        elseif (\Illuminate\Support\Str::contains($kategori, 'kesehatan')) $kategoriIcon = '🩺';
                        elseif (\Illuminate\Support\Str::contains($kategori, 'ekonomi')) $kategoriIcon = '💼';
                    @endphp

                    @if($loop->first)
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @endif

                    <article class="rounded-3xl border border-gray-100 bg-white shadow-md overflow-hidden transition-all duration-300 hover:-translate-y-1.5 hover:shadow-2xl">
                        @if(!empty($program->gambar))
                            <img src="{{ asset($program->gambar) }}" alt="{{ $program->judul }}" class="w-full h-52 object-cover">
                        @else
                            <div class="w-full h-52 bg-gray-100 flex items-center justify-center text-gray-400">Tidak ada gambar</div>
                        @endif

                        <div class="p-6">
                            <div class="flex items-start justify-between gap-3">
                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold capitalize {{ $statusClass }}">
                                    {{ $program->status }}
                                </span>
                                <span class="text-xs text-gray-500">{{ $program->tahun ?? '-' }}</span>
                            </div>

                            <h4 class="mt-4 text-lg md:text-xl font-semibold text-gray-800 leading-snug">{{ $program->judul }}</h4>
                            <p class="mt-2 text-sm text-gray-500">{{ $kategoriIcon }} {{ $program->kategori ?? 'Kategori belum diisi' }}</p>
                            <p class="mt-3 text-sm text-gray-600 leading-relaxed">{{ \Illuminate\Support\Str::limit(strip_tags((string) $program->deskripsi), 120) }}</p>

                            @if(!is_null($program->anggaran))
                                <p class="mt-4 text-sm font-semibold text-emerald-700">
                                    Anggaran: Rp {{ number_format((float) $program->anggaran, 0, ',', '.') }}
                                </p>
                            @endif

                            <details class="mt-4 group">
                                <summary class="list-none inline-flex items-center px-3 py-2 rounded-xl bg-blue-50 text-blue-700 hover:bg-blue-100 text-sm font-medium cursor-pointer transition">
                                    Lihat Detail
                                </summary>
                                <div class="mt-3 rounded-xl bg-gray-50 border border-gray-100 p-3 text-sm text-gray-700 leading-relaxed">
                                    {{ $program->deskripsi ?: 'Deskripsi program belum diisi.' }}
                                </div>
                            </details>

                            <div class="mt-5 pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                                <a href="{{ route('admin.program.edit', $program) }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Edit</a>
                                <form method="POST" action="{{ route('admin.program.destroy', $program) }}" onsubmit="return confirm('Hapus program ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-600 hover:text-red-700 font-medium">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </article>

                    @if($loop->last)
                        </div>
                    @endif
                @empty
                    <div class="px-5 py-12 text-center text-gray-500 bg-gray-50 rounded-2xl">
                        Belum ada data program.
                    </div>
                @endforelse
            </div>
        </main>
    </div>
</x-app-layout>

