<x-app-layout :show-footer="false">
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

    <style>
        body > div.min-h-screen:has(> main > .public-article-page) > footer {
            display: none !important;
        }

        .public-article-page {
            background: #f8fafc;
            min-height: 100%;
        }

        .public-article-shell {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            padding: 28px 24px 0;
        }

        .public-article-title {
            color: #0f172a;
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.22;
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
            padding: 30px;
        }

        .public-article-image {
            width: 100%;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        }

        .public-article-image img {
            width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
        }

        .public-article-body {
            margin-top: 24px;
            color: #334155;
            font-size: 16px;
            line-height: 1.75;
        }

        .public-article-body > * + * {
            margin-top: 22px;
        }

        .public-article-body p {
            margin: 0 0 22px;
        }

        .public-article-body p:last-child {
            margin-bottom: 0;
        }

        .public-article-body a {
            color: #2563eb;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .public-article-body blockquote {
            margin: 24px 0;
            padding-left: 18px;
            border-left: 3px solid #dbeafe;
            color: #475569;
        }

        .public-article-body ul,
        .public-article-body ol {
            margin: 0 0 22px 1.35rem;
            padding: 0;
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

        $articleFooterNav = [
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

        $footerNavIcons = [
            'Home' => '<svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 10.5L12 3l9 7.5"></path><path d="M5 9.5V21h14V9.5"></path><path d="M9 21v-6h6v6"></path></svg>',
            'Tentang Maket' => '<svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l8 4v10l-8 4-8-4V7l8-4z"></path><path d="M12 11v5"></path><path d="M12 8.5h.01"></path></svg>',
            'Penduduk' => '<svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M16 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"></path><circle cx="9.5" cy="7.5" r="3.5"></circle><path d="M20 21v-1.5a3.5 3.5 0 0 0-2.5-3.35"></path><path d="M16.5 4.5a3.5 3.5 0 0 1 0 7"></path></svg>',
            'Statistik' => '<svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 19V5"></path><path d="M4 19h16"></path><path d="M8 16v-5"></path><path d="M12 16V8"></path><path d="M16 16v-3"></path></svg>',
            'Kesehatan' => '<svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 8.5c0 6-8 11-8 11S4 14.5 4 8.5A4.5 4.5 0 0 1 12 6a4.5 4.5 0 0 1 8 2.5Z"></path><path d="M12 9v4"></path><path d="M10 11h4"></path></svg>',
            'Wilayah' => '<svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21s6-4.8 6-10a6 6 0 1 0-12 0c0 5.2 6 10 6 10z"></path><circle cx="12" cy="11" r="2.2"></circle></svg>',
            'Keuangan' => '<svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 2v20"></path><path d="M17 6.5a4 4 0 0 0-3.5-2.5H10a3.5 3.5 0 0 0 0 7h4a3.5 3.5 0 0 1 0 7H7"></path></svg>',
            'Program' => '<svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 6h16"></path><path d="M4 12h10"></path><path d="M4 18h16"></path><path d="M17 12l3 3-3 3"></path></svg>',
            'Berita' => '<svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 4h11l3 3v13H5z"></path><path d="M16 4v4h4"></path><path d="M8 11h6"></path><path d="M8 15h6"></path></svg>',
        ];

        $footerInfoIcons = [
            'Alamat' => '<svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21s6-4.8 6-10a6 6 0 1 0-12 0c0 5.2 6 10 6 10z"></path><circle cx="12" cy="11" r="2"></circle></svg>',
            'Email' => '<svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="M4 7l8 6 8-6"></path></svg>',
            'Telepon' => '<svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2c-3.3-.4-6.4-1.8-9.1-4.5S6.1 11.6 5.7 8.3A2 2 0 0 1 7.7 6h3a2 2 0 0 1 2 1.6l.5 2.2a2 2 0 0 1-.6 1.8l-1.3 1.3a14 14 0 0 0 5 5l1.3-1.3a2 2 0 0 1 1.8-.6l2.2.5A2 2 0 0 1 22 16.9z"></path></svg>',
            'Jam Pelayanan' => '<svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="8.5"></circle><path d="M12 8v4l3 2"></path></svg>',
            'Info' => '<svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"></circle><path d="M12 10.5v5"></path><path d="M12 7.5h.01"></path></svg>',
        ];
    @endphp

    <div class="public-article-page">
        <div class="public-article-shell">
            <div class="mb-4">
                <x-public-back-link href="{{ route('dashboard') }}" label="Kembali ke Dashboard" />
            </div>

            <div class="mb-6">
                <h1 class="public-article-title text-[32px] sm:text-[34px] lg:text-[38px]">
                    {{ $artikel->judul }}
                </h1>
                <p class="public-article-date mt-2">
                    {{ optional($artikel->created_at)->format('d M Y') }}
                </p>
            </div>

            <article class="public-article-card">
                <div class="public-article-card-inner">
                    @if($gambarSrc)
                        <div class="public-article-image">
                            <img src="{{ $gambarSrc }}" alt="{{ $artikel->judul }}">
                        </div>
                    @endif

                    <div class="public-article-body">
                        {!! $artikel->isi ?? '' !!}
                    </div>
                </div>
            </article>
        </div>

                <x-public-footer />
    </div>
</x-app-layout>



