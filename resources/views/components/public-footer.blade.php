@props(['settings' => null])

@php
    $footerData = $settings ?? \App\Models\SettingsDesa::first();
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

    $footerNav = [
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

@once
    <style>
        .public-footer {
            width: 100%;
            margin-top: 48px;
            border-radius: 0;
            background: linear-gradient(135deg, #071d46 0%, #0b2f75 55%, #123e87 100%);
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            color: rgba(255, 255, 255, 0.72);
        }

        .public-footer-inner {
            max-width: 1240px;
            margin: 0 auto;
            padding: 48px 24px 24px;
        }

        .public-footer-logo {
            width: 66px;
            height: 66px;
            object-fit: contain;
            flex-shrink: 0;
            filter: drop-shadow(0 3px 8px rgba(0, 0, 0, 0.16));
        }

        .public-footer-brand {
            color: #ffffff;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .public-footer-brand-accent {
            color: #facc15;
        }

        .public-footer-location {
            color: rgba(255, 255, 255, 0.72);
            line-height: 1.6;
        }

        .public-footer-heading {
            position: relative;
            margin-bottom: 0.85rem;
            padding-bottom: 0.5rem;
            color: #ffffff;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: -0.01em;
        }

        .public-footer-heading::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            width: 44px;
            height: 2px;
            border-radius: 9999px;
            background: linear-gradient(90deg, #93c5fd, #facc15);
        }

        .public-footer-quick-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: rgba(255, 255, 255, 0.72);
            transition: color 200ms ease, transform 200ms ease;
        }

        .public-footer-link-icon,
        .public-footer-info-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: rgba(255, 255, 255, 0.82);
        }

        .public-footer-link-icon svg,
        .public-footer-info-icon svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
        }

        .public-footer-quick-link:hover .public-footer-link-icon,
        .public-footer-contact-item:hover .public-footer-info-icon {
            color: #ffffff;
        }

        .public-footer-quick-link:hover {
            color: #ffffff;
            transform: translateX(3px);
        }

        .public-footer-contact-item {
            display: flex;
            align-items: flex-start;
            gap: 0.625rem;
            color: rgba(255, 255, 255, 0.72);
        }

        .public-footer-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.10);
        }

        .public-footer-copyright {
            color: rgba(255, 255, 255, 0.60);
            font-size: 0.75rem;
        }

        @media (max-width: 767px) {
            .public-footer {
                margin-top: 32px;
            }

            .public-footer-inner {
                padding: 40px 16px 20px;
            }
        }
    </style>
@endonce

<footer class="public-footer">
    <div class="public-footer-inner">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 lg:gap-12">
            <div>
                <div class="flex items-start gap-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Desa" class="public-footer-logo">
                    <div class="min-w-0">
                        <h3 class="text-xl sm:text-2xl public-footer-brand">
                            MAKET DESA <span class="public-footer-brand-accent">Buruan</span>
                        </h3>
                        <p class="public-footer-location mt-2 text-sm">
                            Kecamatan {{ $footerKecamatan }}<br>
                            Kabupaten {{ $footerKabupaten }}<br>
                            Provinsi {{ $footerProvinsi }}
                        </p>
                    </div>
                </div>
                <p class="mt-5 max-w-md text-sm leading-7 text-white/72">
                    Portal informasi resmi Desa Buruan untuk pelayanan, data publik, berita, dan informasi desa yang lebih mudah diakses masyarakat.
                </p>
            </div>

            <div>
                <h4 class="public-footer-heading">Navigasi</h4>
                <ul class="space-y-2.5 text-sm">
                    @foreach($footerNav as $item)
                        <li>
                            <a href="{{ $item['href'] }}" class="public-footer-quick-link">
                                <span class="public-footer-link-icon" aria-hidden="true">{!! $footerNavIcons[$item['label']] ?? $footerNavIcons['Home'] !!}</span>
                                <span>{{ $item['label'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="public-footer-heading">Informasi Desa</h4>
                <div class="space-y-4 text-sm">
                    @if(!empty($footerContactItems))
                        @foreach($footerContactItems as $contact)
                            <div class="public-footer-contact-item">
                                <span class="public-footer-info-icon mt-0.5" aria-hidden="true">{!! $footerInfoIcons[$contact['label']] ?? $footerInfoIcons['Info'] !!}</span>
                                <div class="min-w-0">
                                    <p class="text-white font-medium">{{ $contact['label'] }}</p>
                                    <p class="mt-1 text-white/72 leading-6 break-words">{{ $contact['value'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="public-footer-contact-item">
                            <span class="public-footer-info-icon mt-0.5" aria-hidden="true">{!! $footerInfoIcons['Info'] !!}</span>
                            <p class="text-white/72 leading-7">
                                Informasi kontak desa belum tersedia pada data yang dipublikasikan.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="public-footer-divider mt-12 pt-6 flex flex-col md:flex-row md:items-center md:justify-between gap-3 text-center md:text-left">
            <p class="public-footer-copyright">
                © {{ now()->year }} MAKET DESA Buruan
            </p>
        </div>
    </div>
</footer>
