<x-app-layout :show-footer="false">
    <style>
        body > div.min-h-screen > footer {
            display: none !important;
        }

        .public-news-page {
            background: #f8fafc;
            min-height: 100%;
        }

        .public-news-shell {
            max-width: 1240px;
            margin: 0 auto;
            padding: 28px 24px 0;
        }

        .public-filter-panel select:focus-visible,
        .public-filter-button:focus-visible,
        .public-reset-button:focus-visible,
        .news-readmore:focus-visible {
            outline: 2px solid rgba(59, 130, 246, 0.4);
            outline-offset: 3px;
            border-radius: 12px;
        }

        .public-news-title {
            color: #0f172a;
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.15;
        }

        .public-news-subtitle {
            color: #64748b;
            line-height: 1.6;
        }

        .public-filter-panel {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 20px;
            box-shadow:
                0 8px 22px rgba(15, 23, 42, 0.055),
                0 2px 6px rgba(15, 23, 42, 0.025);
            padding: 22px;
        }

        .public-filter-panel label {
            color: #64748b;
            font-weight: 500;
        }

        .public-filter-panel select {
            width: 100%;
            min-height: 44px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 0 0.85rem;
            background: #ffffff;
            color: #0f172a;
            transition: border-color 200ms ease, box-shadow 200ms ease;
        }

        .public-filter-panel select:focus {
            border-color: rgba(59, 130, 246, 0.6);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
            outline: none;
        }

        .public-filter-button,
        .public-reset-button {
            min-height: 44px;
            border-radius: 12px;
            font-weight: 600;
            transition: background-color 200ms ease, color 200ms ease, border-color 200ms ease, box-shadow 200ms ease;
        }

        .public-filter-button {
            background: #2563eb;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.14);
        }

        .public-filter-button:hover {
            background: #1d4ed8;
        }

        .public-reset-button {
            background: #f1f5f9;
            color: #334155;
            border: 1px solid #e2e8f0;
        }

        .public-reset-button:hover {
            background: #e2e8f0;
        }

        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
            align-items: stretch;
        }

        .news-card {
            display: flex;
            flex-direction: column;
            min-height: 100%;
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 20px;
            overflow: hidden;
            box-shadow:
                0 8px 22px rgba(15, 23, 42, 0.055),
                0 2px 6px rgba(15, 23, 42, 0.025);
            transition: transform 200ms ease, box-shadow 200ms ease, border-color 200ms ease;
        }

        .news-card:hover {
            transform: translateY(-3px);
            box-shadow:
                0 15px 32px rgba(15, 23, 42, 0.09),
                0 3px 8px rgba(15, 23, 42, 0.04);
            border-color: rgba(37, 99, 235, 0.16);
        }

        .news-image-wrap {
            aspect-ratio: 16 / 9;
            overflow: hidden;
            background: #e2e8f0;
        }

        .news-image-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
            transition: transform 300ms ease;
        }

        .news-card:hover .news-image-wrap img {
            transform: scale(1.02);
        }

        .news-body {
            display: flex;
            flex: 1;
            flex-direction: column;
            padding: 24px;
        }

        .news-meta {
            color: #64748b;
            font-size: 12.5px;
        }

        .news-title {
            margin-top: 0.5rem;
            color: #0f172a;
            font-weight: 700;
            line-height: 1.35;
        }

        .news-text {
            margin-top: 0.75rem;
            color: #64748b;
            font-size: 0.9375rem;
            line-height: 1.6;
        }

        .news-readmore {
            margin-top: auto;
            padding-top: 1.25rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #2563eb;
            font-size: 0.875rem;
            font-weight: 600;
            transition: color 200ms ease, transform 200ms ease;
        }

        .news-readmore svg {
            width: 16px;
            height: 16px;
            flex: 0 0 16px;
            display: block;
        }

        .news-readmore:hover {
            color: #1d4ed8;
            transform: translateX(2px);
        }

        .news-empty-state {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 20px;
            box-shadow:
                0 8px 22px rgba(15, 23, 42, 0.055),
                0 2px 6px rgba(15, 23, 42, 0.025);
            color: #64748b;
        }

    </style>

    <div class="public-news-page">
        <div class="public-news-shell">
            <div class="mb-4">
                <x-public-back-link href="{{ route('dashboard') }}#section-berita" label="Kembali ke Dashboard" />
            </div>

            <div class="mb-8 sm:mb-9">
                <h1 class="public-news-title text-3xl sm:text-[34px]">Berita Desa</h1>
                <p class="public-news-subtitle mt-2 max-w-2xl text-sm sm:text-base">
                    Informasi terbaru seputar kegiatan dan pengumuman desa.
                </p>
            </div>

            <form method="GET" action="{{ route('berita.index') }}" class="public-filter-panel mb-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm mb-2" for="berita-day">Tanggal</label>
                        <select id="berita-day" name="day">
                            <option value="">Semua Tanggal</option>
                            @for($d = 1; $d <= 31; $d++)
                                <option value="{{ $d }}" {{ (int)($day ?? 0) === $d ? 'selected' : '' }}>{{ $d }}</option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm mb-2" for="berita-month">Bulan</label>
                        <select id="berita-month" name="month">
                            <option value="">Semua Bulan</option>
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ (int)($month ?? 0) === $m ? 'selected' : '' }}>{{ $m }}</option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm mb-2" for="berita-year">Tahun</label>
                        <select id="berita-year" name="year">
                            <option value="">Semua Tahun</option>
                            @foreach(($availableYears ?? collect()) as $yr)
                                <option value="{{ $yr }}" {{ (int)($year ?? 0) === (int) $yr ? 'selected' : '' }}>{{ $yr }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end gap-2">
                        <button type="submit" class="public-filter-button w-full px-4 py-2">
                            Filter
                        </button>
                        <a href="{{ route('berita.index') }}" class="public-reset-button w-full text-center px-4 py-2">
                            Reset
                        </a>
                    </div>
                </div>
            </form>

            @if(($beritas ?? collect())->isNotEmpty())
                <div class="news-grid">
                    @forelse($beritas as $berita)
                        <article class="news-card">
                            <div class="news-image-wrap">
                                @if($berita->gambar)
                                    <img src="{{ \Illuminate\Support\Str::startsWith($berita->gambar, 'berita/') ? asset($berita->gambar) : asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}">
                                @endif
                            </div>

                            <div class="news-body">
                                <p class="news-meta">
                                    {{ optional($berita->tanggal_publish ?? $berita->created_at)->format('d M Y') ?? '-' }}
                                </p>
                                <h3 class="news-title text-lg line-clamp-2">{{ $berita->judul }}</h3>
                                <p class="news-text line-clamp-3">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($berita->isi), 130) }}
                                </p>
                                <a href="{{ route('berita.show', $berita->slug) }}" class="news-readmore">
                                    <span>Baca selengkapnya</span>
                                    <svg class="public-inline-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="m13 6 6 6-6 6"></path>
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @empty
                        <div class="news-empty-state col-span-full p-10 text-center">
                            Tidak ada berita ditemukan.<br>
                            <span class="mt-2 block text-sm">Coba ubah filter tanggal, bulan, atau tahun.</span>
                        </div>
                    @endforelse
                </div>
            @else
                <div class="news-empty-state p-10 text-center">
                    Tidak ada berita ditemukan.<br>
                    <span class="mt-2 block text-sm">Coba ubah filter tanggal, bulan, atau tahun.</span>
                </div>
            @endif

            <div class="mt-8">
                {{ $beritas->links() }}
            </div>
        </div>

        @php
            $newsFooterNav = [
                ['label' => 'Home', 'href' => route('dashboard')],
                ['label' => 'Tentang Maket', 'href' => route('dashboard') . '#section-tentang'],
                ['label' => 'Penduduk', 'href' => route('dashboard') . '#section-penduduk'],
                ['label' => 'Statistik', 'href' => route('dashboard') . '#section-statistik'],
                ['label' => 'Kesehatan', 'href' => route('dashboard') . '#section-kesehatan'],
                ['label' => 'Wilayah', 'href' => route('dashboard') . '#section-wilayah'],
                ['label' => 'Keuangan', 'href' => route('dashboard') . '#section-keuangan'],
                ['label' => 'Program', 'href' => route('dashboard') . '#section-program'],
                ['label' => 'Berita', 'href' => route('berita.index')],
            ];
        @endphp

                <x-public-footer />
    </div>
</x-app-layout>


