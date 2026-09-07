<x-app-layout :show-footer="false">
    <style>
        body > div.min-h-screen:has(> main > .public-article-page) > footer {
            display: none !important;
        }

        .public-article-page {
            background: #f8fafc;
        }

        .public-article-shell {
            max-width: 1000px;
            margin: 0 auto;
            padding: 28px 24px 0;
        }

        .public-article-title {
            color: #0f172a;
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.15;
        }

        .public-article-date {
            color: #64748b;
            font-size: 0.875rem;
        }

        .public-article-card {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 20px;
            box-shadow:
                0 10px 30px rgba(15, 23, 42, 0.055),
                0 2px 8px rgba(15, 23, 42, 0.025);
            overflow: hidden;
        }

        .public-article-card-inner {
            padding: 28px;
        }

        .public-article-image {
            width: 100%;
            border-radius: 18px;
            overflow: hidden;
        }

        .public-article-image img {
            width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
        }

        .public-article-content {
            color: #334155;
            font-size: 0.98rem;
            line-height: 1.75;
            margin-top: 24px;
        }

        .public-article-content p {
            margin-bottom: 20px;
        }

        .public-article-content p:last-child {
            margin-bottom: 0;
        }

    </style>

    @php
        $footerData = \App\Models\SettingsDesa::first();
        $footerAlamat = trim((string) (data_get($footerData, 'alamat') ?? data_get($footerData, 'alamat_desa') ?? ''));
        $footerEmail = trim((string) (data_get($footerData, 'email') ?? data_get($footerData, 'email_desa') ?? ''));
        $footerTelepon = trim((string) (data_get($footerData, 'telepon') ?? data_get($footerData, 'no_telp') ?? data_get($footerData, 'nomor_telepon') ?? ''));
        $footerJam = trim((string) (data_get($footerData, 'jam_pelayanan') ?? data_get($footerData, 'jam_buka') ?? ''));
        $footerKecamatan = (string) (data_get($footerData, 'kecamatan') ?? 'Blahbatuh');
        $footerKabupaten = (string) (data_get($footerData, 'kabupaten') ?? 'Gianyar');
        $footerProvinsi = (string) (data_get($footerData, 'provinsi') ?? 'Bali');

        $footerContactItems = array_values(array_filter([
            $footerAlamat ? ['label' => 'Alamat', 'value' => $footerAlamat] : null,
            $footerEmail ? ['label' => 'Email', 'value' => $footerEmail] : null,
            $footerTelepon ? ['label' => 'Telepon', 'value' => $footerTelepon] : null,
            $footerJam ? ['label' => 'Jam Pelayanan', 'value' => $footerJam] : null,
        ]));

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

    <div class="public-article-page">
        <div class="public-article-shell">
            <div class="mb-4">
                <x-public-back-link href="{{ route('berita.index') }}" label="Kembali ke Berita" />
            </div>

            <div class="mb-6 sm:mb-7">
                <h1 class="public-article-title text-[32px] sm:text-[36px] lg:text-[40px]">
                    {{ $berita->judul }}
                </h1>
                <p class="public-article-date mt-2">
                    {{ optional($berita->tanggal_publish ?? $berita->created_at)->format('d M Y') ?? '-' }}
                </p>
            </div>

            <article class="public-article-card">
                <div class="public-article-card-inner">
                    @if($berita->gambar)
                        <div class="public-article-image">
                            <img
                                src="{{ \Illuminate\Support\Str::startsWith($berita->gambar, 'berita/') ? asset($berita->gambar) : asset('storage/' . $berita->gambar) }}"
                                alt="{{ $berita->judul }}"
                            >
                        </div>
                    @endif

                    <div class="public-article-content">
                        {!! nl2br(e($berita->isi)) !!}
                    </div>
                </div>
            </article>
        </div>

                <x-public-footer />
    </div>
</x-app-layout>


