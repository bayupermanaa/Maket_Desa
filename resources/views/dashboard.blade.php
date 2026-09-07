<x-app-layout :show-footer="false">
<div class="public-dashboard-page min-h-screen bg-gray-50">

    <style>
        [x-cloak]{display:none !important;}
        html, body {
            margin: 0;
            padding: 0;
        }
        body > div.min-h-screen > nav {
            display: none !important;
        }
        body > div.min-h-screen > main {
            margin-top: 0 !important;
            padding-top: 26px !important;
        }
        body > div.min-h-screen:has(> main > .public-dashboard-page) > footer {
            display: none !important;
        }
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(14px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .scrollbar-samarkan {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        .scrollbar-samarkan::-webkit-scrollbar {
            display: none;
        }
        .public-navbar-wrapper {
            width: 100%;
            margin-top: 24px;
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.65);
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
        }
        .public-hero-header {
            position: relative;
            overflow: hidden;
            isolation: isolate;
            min-height: 292px !important;
            height: 292px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.16);
            box-shadow:
                0 16px 36px rgba(11, 63, 145, 0.18),
                0 4px 10px rgba(15, 23, 42, 0.08);
        }
        .public-hero-background,
        .public-hero-overlay,
        .public-hero-header::before {
            content: "";
            position: absolute;
            pointer-events: none;
        }
        .public-hero-background {
            inset: 0;
            z-index: 0;
            background-image: url('{{ asset('images/gapura-buruan.png') }}');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center 58%;
            opacity: 0.63;
            filter: grayscale(1) brightness(0.70) contrast(1.05);
        }
        .public-hero-overlay {
            inset: 0;
            z-index: 1;
            background:
                radial-gradient(circle at 65% 22%, rgba(80, 160, 255, 0.28), transparent 34%),
                linear-gradient(90deg, rgba(5, 28, 85, 0.98) 0%, rgba(10, 55, 160, 0.92) 38%, rgba(35, 105, 215, 0.64) 68%, rgba(150, 195, 245, 0.28) 100%);
        }
        .public-hero-header::before {
            z-index: 1;
            right: 12%;
            top: -38px;
            width: 280px;
            height: 280px;
            border-radius: 9999px;
            background: radial-gradient(circle, rgba(147, 197, 253, 0.18), rgba(96, 165, 250, 0.06) 44%, transparent 74%);
            filter: blur(4px);
            opacity: 0.30;
        }
        .public-hero-content {
            position: relative;
            z-index: 2;
            min-height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            opacity: 1 !important;
            filter: none !important;
            mix-blend-mode: normal !important;
        }
        .hero-top-row {
            position: relative;
            z-index: 2;
        }
        .public-hero-eyebrow {
            color: #ffffff !important;
            opacity: 1 !important;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.18);
            font-size: 17px;
            font-weight: 600;
            letter-spacing: 0.18em;
            line-height: 1;
        }
        .public-hero-title {
            color: #ffffff !important;
            opacity: 1 !important;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.18);
            font-size: clamp(2rem, 3vw, 2.45rem);
            font-weight: 800;
        }
        .public-hero-village-name {
            color: #ffffff !important;
            opacity: 1 !important;
        }
        .public-hero-village-accent {
            color: #FACC15 !important;
            opacity: 1 !important;
        }
        .public-header-location {
            color: rgba(255, 255, 255, 0.88) !important;
            opacity: 1 !important;
            font-size: 18px;
            line-height: 1.3;
        }
        .public-header-logo {
            width: 100px;
            height: 100px;
            max-width: 100px;
            max-height: 100px;
            object-fit: contain;
            flex-shrink: 0;
            opacity: 1 !important;
            filter: drop-shadow(0 4px 10px rgba(0,0,0,0.16));
        }
        .hero-login-button {
            background: #ffffff;
            color: #1d4ed8;
            border: 1px solid rgba(255, 255, 255, 0.72);
            box-shadow: 0 5px 12px rgba(15, 23, 42, 0.12);
            transform: translateY(0);
            transition: transform 160ms ease, box-shadow 160ms ease, background-color 160ms ease;
        }
        .hero-login-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 7px 14px rgba(15, 23, 42, 0.14);
        }
        .hero-stats-panel {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.30);
            border-radius: 18px;
            backdrop-filter: blur(16px);
            overflow: hidden;
            box-shadow:
                inset 0 1px 0 rgba(255,255,255,0.18),
                0 12px 28px rgba(8, 40, 100, 0.14);
        }
        .hero-stat-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 18px 20px;
            min-width: 0;
        }
        .hero-stat-item + .hero-stat-item {
            border-left: 1px solid rgba(255,255,255,0.20);
        }
        .hero-stat-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 14px;
            background: linear-gradient(135deg, #3B82F6, #2563EB);
            color: #ffffff;
            box-shadow: 0 8px 16px rgba(37, 99, 235, 0.22);
            flex-shrink: 0;
            transition: transform 160ms ease, box-shadow 160ms ease;
        }
        .hero-stat-item:hover .hero-stat-icon {
            transform: scale(1.03);
        }
        .hero-stats-panel .hero-stat-label,
        .hero-stats-panel .stat-label {
            color: rgba(255, 255, 255, 0.78) !important;
            opacity: 1 !important;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            line-height: 1;
        }
        .hero-stats-panel .hero-stat-value,
        .hero-stats-panel .stat-value {
            color: #ffffff !important;
            opacity: 1 !important;
            font-size: 1.1rem;
            font-weight: 800;
            line-height: 1.15;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.12);
        }
        .dashboard-stat-card.bg-white.rounded-3xl.shadow {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.75);
            border-radius: 20px;
            box-shadow:
                0 10px 30px rgba(15,23,42,0.055),
                0 2px 8px rgba(15,23,42,0.025);
            transition: transform 220ms ease, box-shadow 220ms ease, border-color 220ms ease;
            animation: fadeUp .45s ease both;
            will-change: transform, box-shadow;
        }
        .dashboard-stat-card.bg-white.rounded-3xl.shadow:hover {
            transform: translateY(-3px);
            box-shadow:
                0 16px 36px rgba(37,99,235,0.09),
                0 4px 10px rgba(15,23,42,0.04);
            border-color: rgba(37, 99, 235, 0.16);
        }
        .dashboard-stat-card .dashboard-stat-icon.stat-icon.text-6xl {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            margin-inline: auto;
            border-radius: 13px;
            background: #F8FAFC;
            color: inherit;
            box-shadow: 0 4px 12px rgba(15,23,42,0.05);
            transform: none;
            font-size: 1.7rem !important;
            line-height: 1;
            transition: transform 220ms ease, box-shadow 220ms ease;
        }
        .dashboard-stat-card:hover .dashboard-stat-icon.stat-icon.text-6xl {
            transform: scale(1.03);
        }
        .dashboard-stat-value {
            color: #0f172a;
            font-weight: 700;
            line-height: 1;
        }
        .dashboard-stat-label {
            color: #64748b;
            font-weight: 500;
        }
        .section-home-title {
            color: #0f172a;
            font-weight: 700;
            letter-spacing: -0.02em;
        }
        .public-header-stat {
            opacity: 1 !important;
        }
        .public-header-stat-icon {
            background: rgba(255, 255, 255, 0.18);
        }
        .mobile-menu-toggle {
            display: none !important;
        }
        .desktop-public-nav {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 6px;
            min-height: 52px;
        }
        .desktop-public-nav button,
        .desktop-public-nav a {
            width: auto;
            padding: 9px 14px;
        }
        .desktop-public-nav .menu-item {
            transition: all 160ms ease;
        }
        .desktop-public-nav .menu-item:hover {
            background: #F8FAFC;
        }
        .desktop-public-nav .menu-item.active {
            background: #EFF6FF;
            border-radius: 9999px;
        }
        .video-profile-card.bg-white.rounded-3xl.shadow,
        .profile-card.rounded-3xl.shadow-lg {
            background: #ffffff;
            border: 1px solid rgba(226,232,240,0.75);
            border-radius: 20px;
            box-shadow:
                0 10px 30px rgba(15,23,42,0.055),
                0 2px 8px rgba(15,23,42,0.025);
            transition: transform 220ms ease, box-shadow 220ms ease, border-color 220ms ease;
            animation: fadeUp .45s ease both;
            will-change: transform, box-shadow;
        }
        .video-profile-card.bg-white.rounded-3xl.shadow:hover,
        .profile-card.rounded-3xl.shadow-lg:hover {
            transform: translateY(-2px);
            box-shadow:
                0 14px 32px rgba(15,23,42,0.075),
                0 4px 10px rgba(15,23,42,0.04);
            border-color: rgba(37, 99, 235, 0.14);
        }
        .premium-card .premium-card-inner,
        .premium-card > * {
            border-radius: inherit;
        }
        .premium-badge {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            border-radius: 9999px;
            background: #F8FAFC;
            color: #1D4ED8;
            border: 1px solid rgba(29, 78, 216, 0.10);
            padding: .55rem .9rem;
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .04em;
        }
        .premium-card-title {
            color: #0f172a;
            font-weight: 700;
        }
        .premium-muted {
            color: #6B7280;
        }
        main .bg-white.rounded-3xl.shadow,
        main .bg-white.rounded-3xl.shadow-lg,
        main .bg-white.rounded-3xl.shadow-xl,
        main .bg-white.rounded-3xl.shadow-md {
            border-radius: 20px;
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            box-shadow:
                0 8px 20px rgba(15, 23, 42, 0.06),
                0 2px 6px rgba(15, 23, 42, 0.03);
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
            animation: fadeUp .45s ease both;
            will-change: transform, box-shadow;
        }
        main .bg-white.rounded-3xl.shadow:hover,
        main .bg-white.rounded-3xl.shadow-lg:hover,
        main .bg-white.rounded-3xl.shadow-xl:hover,
        main .bg-white.rounded-3xl.shadow-md:hover {
            transform: translateY(-3px);
            box-shadow:
                0 14px 26px rgba(15, 23, 42, 0.09),
                0 3px 8px rgba(15, 23, 42, 0.04);
            border-color: rgba(37, 99, 235, 0.16);
        }
        main .bg-white.rounded-3xl.shadow .text-4xl,
        main .bg-white.rounded-3xl.shadow .text-6xl,
        main .bg-white.rounded-3xl.shadow-lg .text-4xl,
        main .bg-white.rounded-3xl.shadow-lg .text-6xl,
        main .bg-white.rounded-3xl.shadow-xl .text-4xl,
        main .bg-white.rounded-3xl.shadow-xl .text-6xl,
        main .bg-white.rounded-3xl.shadow-md .text-4xl,
        main .bg-white.rounded-3xl.shadow-md .text-6xl {
            transition: transform 160ms ease;
        }
        main .bg-white.rounded-3xl.shadow:hover .text-4xl,
        main .bg-white.rounded-3xl.shadow:hover .text-6xl,
        main .bg-white.rounded-3xl.shadow-lg:hover .text-4xl,
        main .bg-white.rounded-3xl.shadow-lg:hover .text-6xl,
        main .bg-white.rounded-3xl.shadow-xl:hover .text-4xl,
        main .bg-white.rounded-3xl.shadow-xl:hover .text-6xl,
        main .bg-white.rounded-3xl.shadow-md:hover .text-4xl,
        main .bg-white.rounded-3xl.shadow-md:hover .text-6xl {
            transform: scale(1.03);
        }
        .kades-photo-frame {
            overflow: hidden;
            border: 3px solid #ffffff;
            border-radius: 14px;
            box-shadow: 0 8px 24px rgba(15,23,42,0.10);
            background: #ffffff;
            transition: transform 160ms ease, box-shadow 160ms ease;
        }
        .kades-photo-frame:hover {
            transform: scale(1.03);
            box-shadow: 0 10px 28px rgba(15, 23, 42, 0.14);
        }
        .kades-photo {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 1;
            filter: none;
            mix-blend-mode: normal;
            position: relative;
            z-index: 1;
        }
        .kades-name {
            position: relative;
            z-index: 2;
            display: inline-block;
            text-align: center;
            background: transparent;
            font-weight: 700;
            color: #0f172a;
        }
        .kades-jabatan {
            color: #2563eb;
            font-weight: 600;
            letter-spacing: 0.03em;
        }
        .kades-periode {
            display: inline-flex;
            align-items: center;
            border-radius: 9999px;
            background: #f8fafc;
            color: #6B7280;
            padding: .55rem .9rem;
            border: 1px solid rgba(15, 23, 42, 0.08);
        }
        .profile-card .bg-gradient-to-r {
            background: linear-gradient(90deg, #1d4ed8 0%, #3b82f6 100%);
            color: #ffffff;
            border-bottom: 1px solid rgba(226, 232, 240, 0.75);
        }
        .video-premium {
            padding: 18px;
            border-radius: 20px;
        }
        .video-frame {
            overflow: hidden;
            border-radius: 15px;
            box-shadow: none;
        }
        .aparatur-panel {
            border: 1px solid rgba(226,232,240,0.80);
            border-radius: 20px;
            overflow: hidden;
            background: #ffffff;
            box-shadow:
                0 8px 22px rgba(15,23,42,0.055),
                0 2px 6px rgba(15,23,42,0.025);
        }
        .aparatur-card {
            background: #ffffff;
            border: 1px solid rgba(226,232,240,0.80);
            border-radius: 20px;
            min-height: 240px;
            display: flex;
            overflow: hidden;
            transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
            animation: fadeUp .45s ease both;
        }
        .aparatur-card:hover {
            transform: translateY(-3px);
            box-shadow:
                0 15px 32px rgba(15,23,42,0.09),
                0 3px 8px rgba(15,23,42,0.04);
            border-color: rgba(37,99,235,0.16);
        }
        .aparatur-photo-wrap {
            width: 42%;
            height: 240px;
            min-height: 240px;
            background: #eff6ff;
            flex-shrink: 0;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.30);
            overflow: hidden;
        }
        .aparatur-photo-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center top;
            display: block;
            opacity: 1;
            filter: none;
            transition: transform 300ms ease;
        }
        .aparatur-card:hover .aparatur-photo-wrap img {
            transform: scale(1.025);
        }
        .aparatur-info {
            width: 58%;
            padding: 18px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            color: #0f172a;
        }
        .aparatur-info .text-base,
        .aparatur-info .text-lg {
            color: #2563eb;
            font-weight: 600;
            letter-spacing: 0.01em;
        }
        .aparatur-info h4 {
            font-weight: 700;
            color: #0f172a;
            line-height: 1.25;
        }
        .aparatur-nav-btn {
            width: 40px;
            height: 40px;
            border-radius: 9999px;
            background: #ffffff;
            color: #2563eb;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 12px rgba(15,23,42,0.05);
            transition: transform 220ms ease, background-color 220ms ease, box-shadow 220ms ease, border-color 220ms ease;
        }
        .aparatur-nav-btn:hover {
            transform: translateY(-1px);
            background: #eff6ff;
            border-color: #dbeafe;
            box-shadow: 0 6px 16px rgba(15,23,42,0.06);
        }
        .aparatur-swiper .swiper-pagination-bullet {
            background: #cbd5e1;
            opacity: 1;
            width: 7px;
            height: 7px;
        }
        .aparatur-swiper .swiper-pagination-bullet-active {
            background: #2563eb;
            width: 18px;
            border-radius: 9999px;
        }
        .premium-card .text-4xl,
        .premium-card .text-6xl,
        .video-profile-card .text-4xl,
        .video-profile-card .text-6xl {
            transition: transform 160ms ease;
        }
        .premium-card:hover .text-4xl,
        .premium-card:hover .text-6xl,
        .video-profile-card:hover .text-4xl,
        .video-profile-card:hover .text-6xl,
        .premium-card:hover .hero-stat-icon,
        .video-profile-card:hover .hero-stat-icon {
            transform: scale(1.03);
        }
        .program-section-title,
        .news-section-title {
            color: #0f172a;
            font-weight: 700;
            letter-spacing: -0.02em;
        }
        .program-section-subtitle,
        .news-section-subtitle {
            color: #64748b;
            line-height: 1.6;
        }
        .program-card,
        .news-card {
            background: #ffffff;
            border: 1px solid rgba(226,232,240,0.80);
            border-radius: 20px;
            overflow: hidden;
            box-shadow:
                0 8px 22px rgba(15,23,42,0.055),
                0 2px 6px rgba(15,23,42,0.025);
            transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
        }
        .program-card:hover,
        .news-card:hover {
            transform: translateY(-3px);
            box-shadow:
                0 15px 32px rgba(15,23,42,0.09),
                0 3px 8px rgba(15,23,42,0.04);
            border-color: rgba(37,99,235,0.16);
        }
        .program-image-wrap,
        .news-image-wrap {
            height: 210px;
            overflow: hidden;
        }
        .program-image-wrap img,
        .news-image-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
            transition: transform 300ms ease;
        }
        .program-card:hover .program-image-wrap img,
        .news-card:hover .news-image-wrap img {
            transform: scale(1.025);
        }
        .program-title,
        .news-title {
            color: #0f172a;
            font-weight: 700;
            line-height: 1.35;
        }
        .program-text,
        .news-text {
            color: #64748b;
            line-height: 1.6;
        }
        .program-meta,
        .news-meta {
            color: #94a3b8;
            font-size: 0.75rem;
        }
        .program-detail-btn,
        .news-readmore {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #2563eb;
            font-weight: 600;
            transition: color 220ms ease, transform 220ms ease;
        }

        .program-detail-btn svg,
        .news-readmore svg {
            width: 16px;
            height: 16px;
            flex: 0 0 16px;
            display: block;
        }
        .program-detail-btn:hover,
        .news-readmore:hover {
            color: #1d4ed8;
            transform: translateX(2px);
        }
        .program-detail-btn summary {
            list-style: none;
        }
        .program-detail-btn summary::-webkit-details-marker {
            display: none;
        }
        .program-detail-btn summary {
            background: #eff6ff;
            border: 1px solid #dbeafe;
            border-radius: 12px;
            padding: .55rem .85rem;
        }
        .program-detail-btn[open] summary {
            background: #dbeafe;
        }
        .program-empty-state,
        .news-empty-state {
            background: #ffffff;
            border: 1px solid rgba(226,232,240,0.80);
            border-radius: 20px;
            box-shadow:
                0 8px 22px rgba(15,23,42,0.055),
                0 2px 6px rgba(15,23,42,0.025);
            color: #64748b;
        }
        @media (max-width: 767px) {
            .mobile-menu-toggle {
                display: inline-flex !important;
            }
            .public-hero-header {
                min-height: auto !important;
                height: auto;
            }
            .desktop-public-nav {
                display: none !important;
            }
            .public-header-logo {
                width: 54px;
                height: 54px;
                max-width: 54px;
                max-height: 54px;
            }
            .public-hero-eyebrow {
                font-size: 12px;
            }
            .public-hero-title {
                font-size: 1.35rem;
            }
            .public-header-location {
                font-size: 0.8rem;
            }
            .hero-stats-panel {
                grid-template-columns: 1fr;
            }
            .hero-stat-item + .hero-stat-item {
                border-left: 0;
                border-top: 1px solid rgba(255, 255, 255, 0.20);
            }
            .public-hero-background,
            .public-hero-overlay {
                display: none !important;
            }
            .public-hero-header::before {
                right: -12px;
                top: -6px;
                width: 120px;
                height: 120px;
                opacity: 0.35;
            }
        }
        @media (min-width: 768px) and (max-width: 1023px) {
            .public-hero-header {
                min-height: 258px !important;
                height: 258px;
            }
            .public-header-logo {
                width: 82px;
                height: 82px;
                max-width: 82px;
                max-height: 82px;
            }
            .public-hero-eyebrow {
                font-size: 15px;
            }
            .public-hero-title {
                font-size: 2rem;
            }
            .public-header-location {
                font-size: 15px;
            }
        }
    </style>

    @php
        $popupAktif = (bool) (data_get($data ?? null, 'popup_aktif') ?? false);
        $popupJudul = (string) (data_get($data ?? null, 'popup_judul') ?? '');
        $popupIsi = (string) (data_get($data ?? null, 'popup_isi') ?? '');
        $desaNama = (string) ($data->nama_desa ?? 'MAKET DESA');
        $desaKecamatan = (string) ($data->kecamatan ?? 'Blahbatuh');
        $desaKabupaten = (string) ($data->kabupaten ?? 'Gianyar');
        $desaProvinsi = (string) ($data->provinsi ?? 'Bali');
        $lokasiLabel = trim($desaKecamatan . ', ' . $desaKabupaten . ', ' . $desaProvinsi, ', ');
        $headerStats = [
            ['label' => 'Luas Wilayah', 'icon' => '📐', 'value' => $data->luas_wilayah ?? '-'],
            ['label' => 'Kepadatan', 'icon' => '👥', 'value' => $data->kepadatan ?? '-'],
            ['label' => 'Jumlah Penduduk', 'icon' => '📊', 'value' => number_format($data->jumlah_penduduk ?? 0)],
        ];
        $navItems = [
            ['key' => 'home', 'icon' => '🏠', 'label' => 'Home'],
            ['key' => 'tentang', 'icon' => 'ℹ️', 'label' => 'Tentang Maket'],
            ['key' => 'penduduk', 'icon' => '👥', 'label' => 'Penduduk'],
            ['key' => 'statistik', 'icon' => '📊', 'label' => 'Statistik'],
            ['key' => 'kesehatan', 'icon' => '🩺', 'label' => 'Kesehatan'],
            ['key' => 'wilayah', 'icon' => '🗺️', 'label' => 'Wilayah'],
            ['key' => 'keuangan', 'icon' => '💰', 'label' => 'Keuangan'],
            ['key' => 'program', 'icon' => '📋', 'label' => 'Program'],
            ['key' => 'berita', 'icon' => '📰', 'label' => 'Berita'],
        ];
    @endphp

    @if(false && $popupAktif && (trim($popupJudul) !== '' || trim($popupIsi) !== ''))
        <div
            x-data="{ open: true }"
            x-show="open"
            x-cloak
            x-teleport="body"
            class="fixed inset-0 z-[2147483647] flex items-center justify-center px-4 py-8"
            aria-labelledby="popup-title"
            role="dialog"
            aria-modal="true"
        >
            <div class="absolute inset-0 bg-black/60" x-on:click="open = false"></div>

            <div class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl overflow-hidden">
                <div class="p-6 sm:p-8 border-b">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <h2 id="popup-title" class="text-xl sm:text-2xl font-bold text-gray-900 truncate">
                                {{ $popupJudul !== '' ? $popupJudul : 'Informasi' }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-500">Ditampilkan otomatis saat membuka dashboard.</p>
                        </div>
                        <button
                            type="button"
                            class="shrink-0 inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-700"
                            aria-label="Tutup popup"
                            x-on:click="open = false"
                        >
                            ✕
                        </button>
                    </div>
                </div>

                <div class="p-6 sm:p-8">
                    <div class="prose prose-gray max-w-none">
                        @if(trim($popupIsi) !== '')
                            {!! nl2br(e($popupIsi)) !!}
                        @else
                            <p class="text-gray-600">Konten popup belum diisi.</p>
                        @endif
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button
                            type="button"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-semibold"
                            x-on:click="open = false"
                        >
                            Saya Mengerti
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Header -->
    <header class="public-hero-header text-white">
        <div class="public-hero-background"></div>
        <div class="public-hero-overlay"></div>
        <div class="public-hero-content max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-7">
            <div class="flex h-full flex-col justify-center gap-4">
                <div class="hero-top-row flex items-start justify-between gap-4">
                    <div class="hero-identity flex items-center gap-4 min-w-0">
                        <img
                            src="{{ asset('images/LOGO DESA.png') }}"
                            alt="Logo Desa"
                            class="public-header-logo hero-logo drop-shadow-[0_10px_18px_rgba(0,0,0,0.22)]"
                            onerror="this.style.display='none';"
                        >
                        <div class="hero-text min-w-0">
                            <p class="public-hero-eyebrow hero-eyebrow text-[10px] sm:text-[11px] font-semibold tracking-[0.22em] uppercase leading-none">
                                SELAMAT DATANG DI
                            </p>
                            <h1 class="public-hero-title public-hero-village-name mt-1 text-lg sm:text-2xl lg:text-[2.1rem] font-bold leading-tight">
                                MAKET DESA <span class="public-hero-village-accent">{{ $data->nama_desa ?? 'Buruan' }}</span>
                            </h1>
                            <p class="public-header-location mt-1 text-xs sm:text-sm lg:text-[1rem] truncate">
                                {{ $lokasiLabel }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 sm:gap-3 shrink-0 z-[2]">
                        @auth
                            @php
                                $dashboardRoute = 'dashboard';
                                if (auth()->user()->role === 'admin_desa') {
                                    $dashboardRoute = 'admin.dashboard';
                                } elseif (auth()->user()->role === 'masyarakat') {
                                    $dashboardRoute = 'dashboard.masyarakat';
                                }
                            @endphp
                            <a href="{{ route($dashboardRoute) }}"
                               class="hero-login-button inline-flex items-center gap-2 px-4 sm:px-5 py-2 rounded-full font-semibold whitespace-nowrap">
                                <span>🧭</span>
                                <span class="hidden sm:inline">Dashboard Saya</span>
                                <span class="sm:hidden">Dashboard</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="hero-login-button inline-flex items-center gap-2 px-4 sm:px-5 py-2 rounded-full font-semibold whitespace-nowrap">
                                <span class="text-sm">🔑</span>
                                <span>Masuk / Login</span>
                            </a>
                        @endauth

                        <button
                            type="button"
                            id="mobile-menu-toggle"
                            class="mobile-menu-toggle md:hidden inline-flex items-center justify-center w-11 h-11 rounded-2xl bg-white/10 border border-white/20 text-white shadow-sm hover:bg-white/15 transition"
                            aria-label="Buka navigasi"
                        >
                            ☰
                        </button>
                    </div>
                </div>

                <div class="hero-stats-panel">
                    @foreach($headerStats as $stat)
                        <div class="hero-stat-item">
                            <div class="hero-stat-icon public-header-stat-icon shrink-0 text-sm sm:text-base">
                                {{ $stat['icon'] }}
                            </div>
                            <div class="min-w-0">
                                <p class="hero-stat-label stat-label text-[10px] sm:text-[11px] font-medium uppercase tracking-[0.14em] truncate leading-none">
                                    {{ $stat['label'] }}
                                </p>
                                <p class="hero-stat-value stat-value mt-1 text-sm sm:text-base lg:text-lg leading-tight truncate">
                                    {{ $stat['value'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </header>

    <div class="public-navbar-wrapper">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="desktop-public-nav">
                @foreach($navItems as $item)
                    <a href="https://posyandu.maketdesaburuan.id/"
                        target="_blank"
                        rel="noopener noreferrer"
                       data-section="{{ $item['key'] }}"
                       onclick="showSection('{{ $item['key'] }}'); return false;"
                       class="menu-item inline-flex items-center gap-2 rounded-full border border-transparent text-[14px] font-semibold text-slate-700 transition-all hover:bg-slate-50 hover:border-slate-200 {{ $loop->first ? 'active bg-[#EFF6FF] border-blue-200 text-blue-700 shadow-sm' : '' }}">
                        <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-blue-50 text-xs shrink-0">{{ $item['icon'] }}</span>
                        <span class="whitespace-nowrap">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>
        </div>
    </div>

    <div class="md:hidden border-b border-slate-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2.5">
            <div id="mobile-menu-panel" class="hidden">
                <div class="rounded-2xl border border-slate-200 bg-white p-2.5 shadow-sm">
                    <div class="grid grid-cols-2 gap-2">
                        @foreach($navItems as $item)
                            <a href="https://posyandu.maketdesaburuan.id/"
                        target="_blank"
                        rel="noopener noreferrer"
                               data-section="{{ $item['key'] }}"
                               onclick="showSection('{{ $item['key'] }}'); toggleMobileMenu(false); return false;"
                               class="menu-item inline-flex items-center gap-2 rounded-2xl px-3 py-2.5 text-sm font-medium transition-colors text-slate-700 hover:bg-slate-50 {{ $loop->first ? 'active bg-[#EFF6FF] border-blue-200 text-blue-700 shadow-sm' : 'bg-slate-50/60' }}">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-xl bg-blue-50 text-sm shrink-0">{{ $item['icon'] }}</span>
                                    <span class="min-w-0 truncate">{{ $item['label'] }}</span>
                                </a>
                            @endforeach
                        </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Konten Dinamis -->
    <main class="max-w-7xl mx-auto px-6 pt-6 pb-10">

        <!-- HOME SECTION -->
        <div id="section-home" class="section">
            <!-- Statistik 3 Card Real -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="dashboard-stat-card stat-card bg-white rounded-3xl shadow p-8 text-center">
                    <div class="dashboard-stat-icon stat-icon text-6xl mb-4">👥</div>
                    <h3 class="dashboard-stat-value text-4xl font-bold">{{ number_format($totalPenduduk ?? 0) }}</h3>
                    <p class="dashboard-stat-label mt-2">Jumlah Penduduk</p>
                </div>
                <div class="dashboard-stat-card stat-card bg-white rounded-3xl shadow p-8 text-center">
                    <div class="dashboard-stat-icon stat-icon text-6xl mb-4">📄</div>
                    <h3 class="dashboard-stat-value text-4xl font-bold">{{ number_format($totalPengajuanSurat ?? 0) }}</h3>
                    <p class="dashboard-stat-label mt-2">Pengajuan Surat</p>
                </div>
                <div class="dashboard-stat-card stat-card bg-white rounded-3xl shadow p-8 text-center">
                    <div class="dashboard-stat-icon stat-icon text-6xl mb-4">📢</div>
                    <h3 class="dashboard-stat-value text-4xl font-bold">{{ number_format($totalPengaduan ?? 0) }}</h3>
                    <p class="dashboard-stat-label mt-2">Pengaduan Masyarakat</p>
                </div>
            </div>

            <h2 class="section-home-title text-3xl font-semibold mb-6">
                Selamat Datang di Desa {{ $data->nama_desa ?? 'MAKET DESA' }}
            </h2>

            <!-- Video + Kepala Desa -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-16">
                <!-- Video Profil -->
                <div class="lg:col-span-8">
                    <div class="premium-card video-profile-card video-premium bg-white rounded-3xl shadow p-6">
                        <h2 class="text-xl font-bold mb-5 premium-card-title">🎬 Video Profil Desa</h2>
                        @if(!empty($data->video_desa))
                            @php
                                $url = trim($data->video_desa);
                                $videoId = '';
                                if(str_contains($url,'youtu.be/')) $videoId = explode('youtu.be/',$url)[1] ?? '';
                                elseif(str_contains($url,'watch?v=')) $videoId = explode('watch?v=',$url)[1] ?? '';
                                elseif(str_contains($url,'/embed/')) $videoId = explode('/embed/',$url)[1] ?? '';
                                $videoId = explode('?', $videoId)[0];
                            @endphp
                            @if($videoId)
                                <div class="video-frame aspect-video bg-black rounded-2xl overflow-hidden">
                                    <iframe
                                        id="desaYoutubeIframe"
                                        class="w-full h-full"
                                        data-video-id="{{ trim($videoId) }}"
                                        src="https://www.youtube.com/embed/{{ trim($videoId) }}?rel=0&playsinline=1&mute=1&autoplay=0&loop=1&playlist={{ trim($videoId) }}"
                                        frameborder="0"
                                        allow="autoplay; encrypted-media; picture-in-picture"
                                        allowfullscreen
                                    ></iframe>
                                </div>
                            @endif
                        @else
                            <div class="aspect-video bg-gray-100 rounded-2xl flex items-center justify-center py-16">
                                <span class="text-6xl">🎬</span>
                                <p class="text-gray-500">Belum ada video profil desa</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Kepala Desa -->
                <div class="lg:col-span-4">
                    @php
                        $fotoKades = asset('images/logo.png');
                        if (!empty($data->kepala_desa_foto)) {
                            if (\Illuminate\Support\Str::startsWith($data->kepala_desa_foto, ['http://', 'https://'])) {
                                $fotoKades = $data->kepala_desa_foto;
                            } elseif (\Illuminate\Support\Str::startsWith($data->kepala_desa_foto, 'images/')) {
                                $fotoKades = asset($data->kepala_desa_foto);
                            } else {
                                // Backward-compat: dulu sempat disimpan di storage/public
                                $fotoKades = asset('storage/' . $data->kepala_desa_foto);
                            }
                        }
                    @endphp
                    <div class="premium-card profile-card rounded-3xl shadow-lg h-full overflow-hidden border border-slate-200 bg-white">
                        <div class="px-5 py-3 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-sm font-semibold text-center">
                            Profil Kepala Desa
                        </div>
                        <div class="p-7 text-center h-full flex flex-col">
                            <div class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-blue-50 border border-blue-100 text-blue-700 text-xs font-semibold mx-auto mb-5">
                                <span>🏛️</span>
                                <span>Pimpinan Desa</span>
                            </div>

                            <div class="kades-photo-frame w-52 h-52 mx-auto mb-5">
                                <img src="{{ $fotoKades }}" alt="Kepala Desa" class="kades-photo">
                            </div>

                            <h3 class="kades-name text-3xl font-bold leading-tight text-slate-800">{{ $data->nama_kepala_desa ?? 'Nama Kepala Desa' }}</h3>
                            <p class="kades-jabatan text-blue-700 font-medium mt-2">{{ $data->kepala_desa_jabatan ?? 'Kepala Desa' }}</p>

                            @if(!empty($data->kepala_desa_periode))
                                <div class="kades-periode mt-4 px-4 py-2 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-600">
                                    Periode: {{ $data->kepala_desa_periode }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aparatur Desa (Swiper Slider) -->
            <div class="mt-16">
                <style>
                    .aparatur-panel { border: 1px solid rgba(226,232,240,0.80); border-radius: 20px; overflow: hidden; background: #ffffff; box-shadow: 0 8px 22px rgba(15,23,42,0.055), 0 2px 6px rgba(15,23,42,0.025); }
                    .aparatur-head { background: linear-gradient(90deg, #0B2F75 0%, #1D4ED8 55%, #3B82F6 100%); color: #fff; }
                    .aparatur-swiper { overflow: hidden; }
                    .aparatur-swiper .swiper-slide { height: auto; }
                    .aparatur-card { background: #ffffff; border: 1px solid rgba(226,232,240,0.80); border-radius: 20px; min-height: 240px; display: flex; overflow: hidden; transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease; animation: fadeUp .45s ease both; }
                    .aparatur-card:hover { transform: translateY(-3px); box-shadow: 0 15px 32px rgba(15,23,42,0.09), 0 3px 8px rgba(15,23,42,0.04); border-color: rgba(37,99,235,0.16); }
                    .aparatur-photo-wrap { width: 42%; height: 240px; min-height: 240px; background: #eff6ff; flex-shrink: 0; box-shadow: inset 0 1px 0 rgba(255,255,255,0.30); overflow: hidden; }
                    .aparatur-photo-wrap img { width: 100%; height: 100%; object-fit: cover; object-position: center top; display: block; opacity: 1; filter: none; transition: transform 300ms ease; }
                    .aparatur-card:hover .aparatur-photo-wrap img { transform: scale(1.025); }
                    .aparatur-info { width: 58%; padding: 18px; display: flex; flex-direction: column; justify-content: center; text-align: center; color: #0f172a; }
                    .aparatur-info .text-base, .aparatur-info .text-lg { color: #2563eb; font-weight: 600; letter-spacing: 0.01em; }
                    .aparatur-info h4 { font-weight: 700; color: #0f172a; line-height: 1.25; }
                    .aparatur-nav-btn { width: 40px; height: 40px; border-radius: 9999px; background: #ffffff; color: #2563eb; display: inline-flex; align-items: center; justify-content: center; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(15,23,42,0.05); transition: transform 220ms ease, background-color 220ms ease, box-shadow 220ms ease, border-color 220ms ease; }
                    .aparatur-nav-btn:hover { transform: translateY(-1px); background: #eff6ff; border-color: #dbeafe; box-shadow: 0 6px 16px rgba(15,23,42,0.06); }
                    .aparatur-swiper .swiper-pagination-bullet { background: #cbd5e1; opacity: 1; width: 7px; height: 7px; }
                    .aparatur-swiper .swiper-pagination-bullet-active { background: #2563eb; width: 18px; border-radius: 9999px; }
                    @media (max-width: 767px) {
                        .aparatur-card { flex-direction: column; min-height: 0; }
                        .aparatur-photo-wrap { width: 100%; height: 260px; min-height: 260px; }
                        .aparatur-info { width: 100%; }
                    }
                </style>

                @php
                    $aparatur = $aparatur ?? ($aparaturDesa ?? collect());
                @endphp

                @if(($aparatur ?? collect())->count() > 0)
                    <div class="aparatur-panel">
                        <div class="aparatur-head px-5 py-3 flex items-center justify-between">
                            <h3 class="text-xl font-bold tracking-[-0.02em]">Aparatur Desa</h3>
                            <div class="flex items-center gap-2">
                                <button type="button" class="aparatur-nav-btn aparatur-prev" aria-label="Sebelumnya">‹</button>
                                <button type="button" class="aparatur-nav-btn aparatur-next" aria-label="Berikutnya">›</button>
                            </div>
                        </div>

                        <div class="p-3 md:p-4">
                            <div class="swiper aparatur-swiper">
                                <div class="swiper-wrapper">
                                    @foreach($aparatur as $item)
                                        @php
                                            $fotoAparatur = asset('images/logo.png');
                                            if (!empty($item->foto)) {
                                                if (\Illuminate\Support\Str::startsWith($item->foto, 'images/')) {
                                                    $fotoAparatur = asset($item->foto);
                                                } elseif (\Illuminate\Support\Str::startsWith($item->foto, ['http://', 'https://'])) {
                                                    $fotoAparatur = $item->foto;
                                                } else {
                                                    $fotoAparatur = asset('storage/' . $item->foto);
                                                }
                                            }
                                        @endphp
                                        <div class="swiper-slide">
                                            <article class="aparatur-card">
                                                <div class="aparatur-photo-wrap">
                                                    <img src="{{ $fotoAparatur }}" alt="{{ $item->nama }}">
                                                </div>
                                                <div class="aparatur-info">
                                                    <p class="text-base md:text-lg leading-tight">{{ $item->jabatan }}</p>
                                                    <div class="my-3 border-t border-slate-200"></div>
                                                    <h4 class="text-lg md:text-xl uppercase tracking-wide">{{ $item->nama }}</h4>
                                                </div>
                                            </article>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-pagination mt-4"></div>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-center text-gray-500">Belum ada data aparatur.</p>
                @endif
            </div>

             <!-- SEJARAH DESA -->
                <div class="mt-16 bg-white rounded-3xl shadow p-8 lg:p-10">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="text-4xl">📜</span>
                        <h3 class="text-2xl font-semibold text-gray-800">Sejarah Desa {{ $data->nama_desa ?? 'MAKET DESA' }}</h3>
                    </div>

                    <div class="prose prose-gray max-w-none text-gray-700 leading-relaxed">
                        @if(!empty($data->sejarah_desa))
                            {!! nl2br(e($data->sejarah_desa)) !!}
                        @else
                            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-8 text-center">
                                <p class="text-amber-700">Sejarah desa belum diisi.</p>
                            </div>
                        @endif
                    </div>
                </div>

            <!-- ARTIKEL MAKET DESA -->
            <div class="mt-16">
                <h3 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-3">
                    📝 Artikel MAKET DESA
                </h3>
                
                @if($artikelDesa->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                       @foreach($artikelDesa as $artikel)
                            <div class="bg-white rounded-3xl shadow overflow-hidden hover:shadow-xl transition group">
                                <!-- Bagian Header Gambar -->
                                <div class="h-48 bg-gradient-to-br from-orange-500 to-amber-500 flex items-center justify-center relative overflow-hidden">
                                    @php
                                        $artikelGambarSrc = null;
                                        if (!empty($artikel->gambar)) {
                                            if (\Illuminate\Support\Str::startsWith($artikel->gambar, 'artikel/')) {
                                                $artikelGambarSrc = file_exists(public_path($artikel->gambar)) ? asset($artikel->gambar) : null;
                                            } else {
                                                // Backward-compat: dulu sempat disimpan di storage/public
                                                $artikelGambarSrc = file_exists(public_path('storage/' . $artikel->gambar)) ? asset('storage/' . $artikel->gambar) : null;
                                            }
                                        }
                                    @endphp
                                    @if($artikelGambarSrc)
                                        <img src="{{ $artikelGambarSrc }}" 
                                            alt="{{ $artikel->judul }}" 
                                            class="w-full h-full object-cover">
                                    @else
                                        <div class="text-white text-7xl opacity-75">
                                            <svg class="h-16 w-16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M5 4h11l3 3v13H5z"></path>
                                                <path d="M16 4v4h4"></path>
                                                <path d="M8 11h6"></path>
                                                <path d="M8 15h6"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Isi Card -->
                                <div class="p-6">
                                    <h4 class="font-semibold text-lg leading-tight line-clamp-2 group-hover:text-orange-600 transition">
                                        {{ $artikel->judul }}
                                    </h4>
                                    
                                    <p class="text-xs text-gray-500 mt-2">
                                        {{ $artikel->created_at->format('d M Y') }}
                                    </p>
                                    
                                    <p class="text-gray-600 text-sm mt-4 line-clamp-3">
                                        {{ Str::limit(strip_tags($artikel->isi), 130) }}
                                    </p>

                                    <a href="{{ route('artikel.show', $artikel->slug) }}" class="inline-flex items-center gap-[6px] text-blue-600 hover:text-blue-700 font-medium text-sm mt-5">
                                        <span>Baca selengkapnya</span>
                                        <svg class="public-inline-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M5 12h14"></path>
                                            <path d="m13 6 6 6-6 6"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-3xl shadow p-10 text-center">
                        <p class="text-gray-500">Belum ada artikel desa.</p>
                    </div>
                @endif
            </div>

        </div>

        <!-- ==================== SECTION TENTANG MAKET ==================== -->
        <div id="section-tentang" class="section hidden">
            <div class="mb-10">
                <h2 class="text-3xl font-semibold text-gray-800 flex items-center gap-3">
                    Tentang Maket
                </h2>
                <p class="text-gray-600 mt-2">
                    Selamat datang pada web MAKET DESA Buruan.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <div class="lg:col-span-8 bg-white rounded-3xl shadow p-8 lg:p-10">
                    <div class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700">
                        MAKET DESA Buruan
                    </div>
                    <h3 class="mt-5 text-3xl font-bold text-gray-900 leading-tight">
                        Selamat datang pada web MAKET DESA Buruan
                    </h3>
                    <div class="mt-6 prose prose-gray max-w-none text-gray-700 leading-relaxed">
                        <p>
                            MAKET DESA merupakan sebuah web untuk desa yang merupakan sebagai aksi desa memfasilitasi
                            peningkatan pelayanan kepada masyarakat dengan memanfaatkan teknologi digital.
                        </p>
                        <p>
                            MAKET DESA adalah sebuah sistem Manajemen Administrasi Kependudukan dan E-commerce Terpadu
                            berbasis website yang dikelola secara mandiri oleh desa.
                        </p>
                        <p>
                            Desa Buruan, Kecamatan Blahbatuh, Gianyar, Bali memiliki luas 4,21 km² terdiri dari tujuh
                            dusun yaitu Buruan, Bangunliman, Celuk, Getas Kawan, Getas Kangin, Kutri, dan Ketandan.
                        </p>
                    </div>
                </div>

                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-white rounded-3xl shadow p-6">
                        <h3 class="font-semibold text-lg text-gray-800">Informasi Wilayah</h3>
                        <div class="mt-5 space-y-4 text-sm">
                            <div class="flex items-center justify-between gap-4 border-b border-gray-100 pb-3">
                                <span class="text-gray-500">Kecamatan</span>
                                <span class="font-semibold text-gray-800 text-right">{{ $desaKecamatan ?: '-' }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-4 border-b border-gray-100 pb-3">
                                <span class="text-gray-500">Kabupaten</span>
                                <span class="font-semibold text-gray-800 text-right">{{ $desaKabupaten ?: '-' }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-4 border-b border-gray-100 pb-3">
                                <span class="text-gray-500">Provinsi</span>
                                <span class="font-semibold text-gray-800 text-right">{{ $desaProvinsi ?: '-' }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-gray-500">Luas Wilayah</span>
                                <span class="font-semibold text-gray-800 text-right">{{ $data->luas_wilayah ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-600 rounded-3xl shadow p-6 text-white">
                        <p class="text-sm text-blue-100">Penduduk Terdata</p>
                        <p class="mt-2 text-4xl font-bold">{{ number_format($totalPenduduk ?? 0) }}</p>
                        <p class="mt-3 text-sm text-blue-100">
                            Data penduduk yang tercatat dalam sistem informasi desa.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    <!-- ==================== SECTION PENDUDUK ==================== -->
     <div id="section-penduduk" class="section hidden">

    <div class="mb-10">
        <h2 class="text-3xl font-semibold text-gray-800 flex items-center gap-3">
            👥 Data Penduduk MAKET DESA
        </h2>
        <p class="text-gray-600 mt-2">
            Data Kependudukan Terupdate • April 2026
        </p>
    </div>

    @php
        $totalPendudukSafe = (int) ($totalPenduduk ?? 0);
        $totalLakiSafe = (int) ($totalLaki ?? 0);
        $totalPerempuanSafe = (int) ($totalPerempuan ?? 0);
        $usiaProduktifSafe = (int) ($usiaProduktif ?? 0);
        $lansiaSafe = (int) ($lansia ?? 0);

        $pct = function (int $value) use ($totalPendudukSafe): int {
            if ($totalPendudukSafe <= 0) {
                return 0;
            }
            return (int) round(($value / $totalPendudukSafe) * 100);
        };

        $pctLaki = $pct($totalLakiSafe);
        $pctPerempuan = $pct($totalPerempuanSafe);
        $pctProduktif = $pct($usiaProduktifSafe);
        $pctLansia = $pct($lansiaSafe);
    @endphp

    <!-- Hero Statistik Penduduk -->
    <div class="relative overflow-hidden rounded-3xl shadow-xl mb-10">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-600"></div>
        <div class="absolute -top-24 -right-24 w-72 h-72 bg-white/10 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-white/10 rounded-full blur-2xl"></div>

        <div class="relative p-8 md:p-10 text-white">
            <div class="flex items-start justify-between gap-6 flex-wrap">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 text-white/90 text-xs font-medium">
                        <span class="w-2 h-2 rounded-full bg-emerald-300"></span>
                        Update terakhir: {{ now()->translatedFormat('d M Y') }}
                    </div>
                    <h3 class="mt-4 text-2xl md:text-3xl font-bold tracking-tight">Total Penduduk Terdata</h3>
                    <p class="mt-1 text-white/80 text-sm">Ringkasan cepat kependudukan MAKET DESA.</p>
                </div>

                <div class="text-right">
                    <div class="text-5xl md:text-6xl font-extrabold leading-none">
                        {{ number_format($totalPendudukSafe) }}
                    </div>
                    <div class="mt-2 text-white/80 text-sm">jiwa</div>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white/10 rounded-2xl p-4 border border-white/10">
                    <div class="text-xs text-white/70">Laki-laki</div>
                    <div class="mt-1 text-xl font-bold">{{ number_format($totalLakiSafe) }}</div>
                    <div class="mt-2 h-2 bg-white/15 rounded-full overflow-hidden">
                        <div class="h-full bg-sky-300 rounded-full" style="width: {{ $pctLaki }}%"></div>
                    </div>
                    <div class="mt-1 text-[11px] text-white/70">{{ $pctLaki }}%</div>
                </div>

                <div class="bg-white/10 rounded-2xl p-4 border border-white/10">
                    <div class="text-xs text-white/70">Perempuan</div>
                    <div class="mt-1 text-xl font-bold">{{ number_format($totalPerempuanSafe) }}</div>
                    <div class="mt-2 h-2 bg-white/15 rounded-full overflow-hidden">
                        <div class="h-full bg-pink-300 rounded-full" style="width: {{ $pctPerempuan }}%"></div>
                    </div>
                    <div class="mt-1 text-[11px] text-white/70">{{ $pctPerempuan }}%</div>
                </div>

                <div class="bg-white/10 rounded-2xl p-4 border border-white/10">
                    <div class="text-xs text-white/70">Usia produktif</div>
                    <div class="mt-1 text-xl font-bold">{{ number_format($usiaProduktifSafe) }}</div>
                    <div class="mt-2 h-2 bg-white/15 rounded-full overflow-hidden">
                        <div class="h-full bg-emerald-300 rounded-full" style="width: {{ $pctProduktif }}%"></div>
                    </div>
                    <div class="mt-1 text-[11px] text-white/70">{{ $pctProduktif }}%</div>
                </div>

                <div class="bg-white/10 rounded-2xl p-4 border border-white/10">
                    <div class="text-xs text-white/70">Lansia</div>
                    <div class="mt-1 text-xl font-bold">{{ number_format($lansiaSafe) }}</div>
                    <div class="mt-2 h-2 bg-white/15 rounded-full overflow-hidden">
                        <div class="h-full bg-amber-300 rounded-full" style="width: {{ $pctLansia }}%"></div>
                    </div>
                    <div class="mt-1 text-[11px] text-white/70">{{ $pctLansia }}%</div>
                </div>
            </div>
        </div>
    </div>

    @if(false)
    <!-- Grid Statistik Penduduk -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Laki-laki -->
        <div class="bg-white rounded-3xl shadow p-8 text-center">
            <div class="text-5xl mb-4">👨</div>
            <div class="text-4xl font-bold text-blue-600">{{ number_format($totalLaki ?? 0) }}</div>
            <p class="text-sm text-gray-500 mt-3">Laki-laki</p>
        </div>

        <!-- Perempuan -->
        <div class="bg-white rounded-3xl shadow p-8 text-center">
            <div class="text-5xl mb-4">👩</div>
            <div class="text-4xl font-bold text-pink-600">{{ number_format($totalPerempuan ?? 0) }}</div>
            <p class="text-sm text-gray-500 mt-3">Perempuan</p>
        </div>

        <!-- Usia Produktif -->
        <div class="bg-white rounded-3xl shadow p-8 text-center">
            <div class="text-5xl mb-4">💼</div>
            <div class="text-4xl font-bold text-emerald-600">{{ number_format($usiaProduktif ?? 0) }}</div>
            <p class="text-sm text-gray-500 mt-3">Usia Produktif (15-64 th)</p>
        </div>

        <!-- Lansia -->
        <div class="bg-white rounded-3xl shadow p-8 text-center">
            <div class="text-5xl mb-4">🧓</div>
            <div class="text-4xl font-bold text-amber-600">{{ number_format($lansia ?? 0) }}</div>
            <p class="text-sm text-gray-500 mt-3">Lansia (>65 tahun)</p>
        </div>

    </div>
    @endif

    <!-- Insight cepat -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">
        <div class="bg-white rounded-3xl shadow p-8">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500">Jumlah Kepala Keluarga (KK)</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format((int) ($totalKK ?? 0)) }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center text-2xl">🏠</div>
            </div>
            <p class="mt-4 text-sm text-gray-600">Rata-rata anggota keluarga: <span class="font-semibold">{{ number_format((float) ($rataRataKK ?? 0), 1) }}</span> orang.</p>
        </div>

        <div class="bg-white rounded-3xl shadow p-8">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500">Komposisi Gender</p>
                    <p class="text-lg font-semibold text-gray-900 mt-1">L {{ $pctLaki }}% • P {{ $pctPerempuan }}%</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-pink-50 text-pink-700 flex items-center justify-center text-2xl">👥</div>
            </div>
            <div class="mt-4 h-3 bg-gray-100 rounded-full overflow-hidden flex">
                <div class="h-full bg-sky-500" style="width: {{ $pctLaki }}%"></div>
                <div class="h-full bg-pink-500" style="width: {{ $pctPerempuan }}%"></div>
            </div>
            <div class="mt-2 flex justify-between text-xs text-gray-500">
                <span>Laki-laki</span>
                <span>Perempuan</span>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow p-8">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500">Rentang Usia</p>
                    <p class="text-lg font-semibold text-gray-900 mt-1">Produktif {{ $pctProduktif }}% • Lansia {{ $pctLansia }}%</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-2xl">📈</div>
            </div>
            <div class="mt-4 space-y-3">
                <div>
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>Usia produktif (15–64)</span><span>{{ number_format($usiaProduktifSafe) }}</span>
                    </div>
                    <div class="mt-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $pctProduktif }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>Lansia (&gt; 65)</span><span>{{ number_format($lansiaSafe) }}</span>
                    </div>
                    <div class="mt-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-amber-500 rounded-full" style="width: {{ $pctLansia }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ringkasan detail -->
    <div class="mt-8 bg-white rounded-3xl shadow p-8">
        <h3 class="font-semibold text-xl mb-6">Ringkasan Detail</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div class="flex items-center justify-between rounded-2xl border border-gray-100 px-5 py-4">
                <span class="text-gray-600">Jumlah Kepala Keluarga (KK)</span>
                <span class="font-semibold text-gray-900">{{ number_format((int) ($totalKK ?? 0)) }}</span>
            </div>
            <div class="flex items-center justify-between rounded-2xl border border-gray-100 px-5 py-4">
                <span class="text-gray-600">Rata-rata anggota keluarga</span>
                <span class="font-semibold text-gray-900">{{ number_format((float) ($rataRataKK ?? 0), 1) }} orang</span>
            </div>
            <div class="flex items-center justify-between rounded-2xl border border-gray-100 px-5 py-4">
                <span class="text-gray-600">Usia produktif (15–64)</span>
                <span class="font-semibold text-gray-900">{{ number_format($usiaProduktifSafe) }} orang</span>
            </div>
            <div class="flex items-center justify-between rounded-2xl border border-gray-100 px-5 py-4">
                <span class="text-gray-600">Lansia (&gt; 65)</span>
                <span class="font-semibold text-gray-900">{{ number_format($lansiaSafe) }} orang</span>
            </div>
        </div>
    </div>

    <div class="mt-10 text-center text-xs text-gray-500">
        Data ini diambil dari Sistem Informasi Kependudukan MAKET DESA •
        Update terakhir: {{ now()->format('d F Y') }}
    </div>

    </div>

    <!-- ==================== SECTION KESEHATAN ==================== -->
    <div id="section-kesehatan" class="section hidden">
        <div class="mb-10">
            <h2 class="text-3xl font-semibold text-gray-800 flex items-center gap-3">
                🩺 Informasi Kesehatan Desa
            </h2>
            <p class="text-gray-600 mt-2">Ringkasan layanan dan informasi kesehatan untuk masyarakat desa.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-3xl shadow p-8">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-3xl">🏥</div>
                <h3 class="text-xl font-semibold text-gray-800 mt-5">Posyandu</h3>
                <p class="text-sm text-gray-600 mt-3 leading-relaxed">
                    Informasi pelayanan kesehatan ibu, bayi, balita, dan lansia di lingkungan desa.
                </p>
            </div>

            <div class="bg-white rounded-3xl shadow p-8">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center text-3xl">💉</div>
                <h3 class="text-xl font-semibold text-gray-800 mt-5">Imunisasi</h3>
                <p class="text-sm text-gray-600 mt-3 leading-relaxed">
                    Jadwal dan pengumuman imunisasi dapat dipublikasikan untuk memudahkan warga mengikuti layanan.
                </p>
            </div>

            <div class="bg-white rounded-3xl shadow p-8">
                <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-700 flex items-center justify-center text-3xl">📋</div>
                <h3 class="text-xl font-semibold text-gray-800 mt-5">Edukasi Kesehatan</h3>
                <p class="text-sm text-gray-600 mt-3 leading-relaxed">
                    Ruang informasi pencegahan penyakit, pola hidup sehat, dan program kesehatan desa.
                </p>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <h3 class="font-semibold text-lg text-gray-800">Layanan Kesehatan Desa</h3>
                    <a
                        href="https://posyandu.maketdesaburuan.id/"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center justify-center rounded-2xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700 transition"
                    >
                        Website Posyandu
                    </a>
                </div>
            </div>
            <div class="divide-y">
                @foreach([
                    ['title' => 'Pemeriksaan kesehatan dasar', 'desc' => 'Pemantauan kondisi kesehatan warga melalui kegiatan desa.'],
                    ['title' => 'Pendataan ibu hamil dan balita', 'desc' => 'Dukungan pendataan untuk pelayanan kesehatan keluarga.'],
                    ['title' => 'Pemantauan lansia', 'desc' => 'Informasi dan kegiatan kesehatan untuk warga lanjut usia.'],
                ] as $layanan)
                    <div class="px-6 py-5 flex items-start justify-between gap-4">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $layanan['title'] }}</p>
                            <p class="text-sm text-gray-600 mt-1">{{ $layanan['desc'] }}</p>
                        </div>
                        <span class="shrink-0 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold px-3 py-1">
                            Aktif
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- ==================== SECTION STATISTIK ==================== -->
    <div id="section-statistik" class="section hidden">
        <div class="mb-10">
            <h2 class="text-3xl font-semibold text-gray-800 flex items-center gap-3">
                📊 Statistik Singkat Desa
            </h2>
            <p class="text-gray-600 mt-2">Ringkasan data layanan desa untuk masyarakat.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-3xl shadow p-8 text-center">
                <div class="text-5xl mb-3">👥</div>
                <p class="text-sm text-gray-500">Penduduk Terdata</p>
                <p class="text-4xl font-bold text-gray-800 mt-2">{{ number_format($totalPenduduk ?? 0) }}</p>
            </div>
            <div class="bg-white rounded-3xl shadow p-8 text-center">
                <div class="text-5xl mb-3">📄</div>
                <p class="text-sm text-gray-500">Pengajuan Surat</p>
                <p class="text-4xl font-bold text-orange-600 mt-2">{{ number_format($totalPengajuanSurat ?? 0) }}</p>
            </div>
            <div class="bg-white rounded-3xl shadow p-8 text-center">
                <div class="text-5xl mb-3">📢</div>
                <p class="text-sm text-gray-500">Pengaduan Masuk</p>
                <p class="text-4xl font-bold text-red-600 mt-2">{{ number_format($totalPengaduan ?? 0) }}</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow p-8">
            <h3 class="font-semibold text-xl mb-5">Catatan Statistik Penduduk</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div class="flex justify-between border-b pb-3">
                    <span class="text-gray-600">Laki-laki</span>
                    <span class="font-medium">{{ number_format($totalLaki ?? 0) }} orang</span>
                </div>
                <div class="flex justify-between border-b pb-3">
                    <span class="text-gray-600">Perempuan</span>
                    <span class="font-medium">{{ number_format($totalPerempuan ?? 0) }} orang</span>
                </div>
                <div class="flex justify-between border-b pb-3">
                    <span class="text-gray-600">Usia Produktif</span>
                    <span class="font-medium">{{ number_format($usiaProduktif ?? 0) }} orang</span>
                </div>
                <div class="flex justify-between border-b pb-3">
                    <span class="text-gray-600">Lansia</span>
                    <span class="font-medium">{{ number_format($lansia ?? 0) }} orang</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
            <div class="bg-white rounded-3xl shadow p-6">
                <h3 class="font-semibold text-lg mb-4">Perbandingan Layanan Desa</h3>
                <div class="h-72">
                    <canvas id="statistikBarChart"></canvas>
                </div>
            </div>
            <div class="bg-white rounded-3xl shadow p-6">
                <h3 class="font-semibold text-lg mb-4">Komposisi Penduduk</h3>
                <div class="h-72">
                    <canvas id="statistikPieChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== SECTION KEUANGAN ==================== -->
    <div id="section-keuangan" class="section hidden">
        <div class="mb-10">
            <h2 class="text-3xl font-semibold text-gray-800 flex items-center gap-3">
                💰 Ringkasan Keuangan Desa
            </h2>
            <p class="text-gray-600 mt-2">Data singkat keuangan dari input admin desa.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-3xl shadow p-8">
                <p class="text-sm text-gray-500">Total Pendapatan</p>
                <p class="text-3xl font-bold text-emerald-600 mt-2">Rp {{ number_format((float) ($totalPendapatan ?? 0), 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-3xl shadow p-8">
                <p class="text-sm text-gray-500">Total Belanja</p>
                <p class="text-3xl font-bold text-rose-600 mt-2">Rp {{ number_format((float) ($totalBelanja ?? 0), 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-3xl shadow p-8">
                <p class="text-sm text-gray-500">Saldo Saat Ini</p>
                <p class="text-3xl font-bold mt-2 {{ ($saldoKeuangan ?? 0) >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                    Rp {{ number_format((float) ($saldoKeuangan ?? 0), 0, ',', '.') }}
                </p>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b flex items-center justify-between">
                <h3 class="font-semibold text-lg">Transaksi Terbaru</h3>
                <span class="text-sm text-gray-500">Maksimal 5 transaksi</span>
            </div>
            <div class="divide-y">
                @forelse(($transaksiKeuanganTerbaru ?? collect()) as $trx)
                    <div class="px-6 py-4 flex items-center justify-between gap-4">
                        <div class="min-w-0">
                            <p class="font-medium text-gray-800 truncate">{{ $trx->uraian }}</p>
                            <p class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($trx->tanggal)->format('d M Y') }} • {{ ucfirst($trx->jenis) }}
                            </p>
                        </div>
                        <p class="text-sm font-semibold shrink-0 {{ $trx->jenis === 'pendapatan' ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $trx->jenis === 'pendapatan' ? '+' : '-' }} Rp {{ number_format((float) $trx->jumlah, 0, ',', '.') }}
                        </p>
                    </div>
                @empty
                    <div class="px-6 py-8 text-sm text-gray-500 text-center">
                        Belum ada transaksi keuangan yang dipublikasikan.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- ==================== SECTION PROGRAM ==================== -->
    <div id="section-program" class="section hidden">
        <div class="mb-10">
            <h2 class="program-section-title text-3xl font-semibold flex items-center gap-3">
                📋 Program Desa
            </h2>
            <p class="program-section-subtitle mt-2">Program prioritas desa yang dipublikasikan oleh admin.</p>
        </div>

        @if(($programDesa ?? collect())->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($programDesa as $program)
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

                    <article class="program-card">
                        @if(!empty($program->gambar))
                            <div class="program-image-wrap">
                                <img src="{{ asset($program->gambar) }}" alt="{{ $program->judul }}">
                            </div>
                        @endif
                        <div class="p-7">
                        <div class="flex items-start justify-between gap-4">
                            <span class="text-xs px-3 py-1 rounded-full font-medium capitalize {{ $statusClass }}">
                                {{ $program->status }}
                            </span>
                            @if(!empty($program->tahun))
                                <span class="program-meta">{{ $program->tahun }}</span>
                            @endif
                        </div>
                        <h3 class="program-title text-xl mt-4">{{ $program->judul }}</h3>
                        @if(!empty($program->kategori))
                            <p class="program-meta mt-1">{{ $kategoriIcon }} {{ $program->kategori }}</p>
                        @endif
                        <p class="program-text text-sm mt-3">
                            {{ \Illuminate\Support\Str::limit(strip_tags((string) $program->deskripsi), 140) }}
                        </p>
                        @if(!is_null($program->anggaran))
                            <p class="text-sm font-semibold text-emerald-700 mt-4">
                                Anggaran: Rp {{ number_format((float) $program->anggaran, 0, ',', '.') }}
                            </p>
                        @endif

                        <details class="program-detail-btn mt-4">
                            <summary class="inline-flex items-center text-sm font-medium cursor-pointer transition">
                                <span>Lihat Detail</span>
                                <svg class="public-inline-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m13 6 6 6-6 6"></path>
                                </svg>
                            </summary>
                            <div class="mt-3 rounded-xl bg-gray-50 border border-gray-100 p-3 text-sm text-gray-700 leading-relaxed">
                                {{ $program->deskripsi ?: 'Deskripsi program belum diisi.' }}
                            </div>
                        </details>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="program-empty-state p-10 text-center">
                Program desa belum dipublikasikan.
            </div>
        @endif
    </div>

    <!-- ==================== SECTION WILAYAH (PETA) ==================== -->
    <div id="section-wilayah" class="section hidden">
        <div class="mb-8">
            <h2 class="text-3xl font-semibold text-gray-800 flex items-center gap-3">
                🗺️ Peta Wilayah & Kantor Desa
            </h2>
            <p class="text-gray-600 mt-1">
                Desa {{ $desaNama }} • {{ $lokasiLabel }}
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Peta Utama Leaflet -->
            <div class="lg:col-span-8">
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
                    <div id="map" style="height: 580px; width: 100%;"></div>
                </div>
            </div>

            <!-- Info + Google Embed -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Info Kantor Desa -->
                <div class="bg-white rounded-3xl shadow p-6">
                    <h3 class="font-bold text-xl mb-4 flex items-center gap-2">
                        🏛️ Kantor Desa
                    </h3>
                    <p class="text-gray-700">
                        <strong>Lokasi Kantor Desa {{ $desaNama }}</strong><br>
                        {{ $lokasiLabel }}
                    </p>
                    <div class="mt-4 text-sm text-gray-600">
                        Koordinat: <strong>-8.5436708, 115.3030258</strong>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow p-6">
                    <h3 class="font-bold text-xl mb-4 flex items-center gap-2">
                        🧭 Wilayah Banjar Dinas
                    </h3>
                    <div id="banjar-list" class="space-y-3 text-sm text-gray-600">
                        Memuat data banjar dinas...
                    </div>
                </div>

                <!-- Google Street View Embed -->
                <div class="bg-white rounded-3xl shadow overflow-hidden">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!3m2!1sid!2ssg!4v1777723510056!5m2!1sid!2ssg!6m8!1m7!1sy4JiMrPOS58R4ioueZ60vw!2m2!1d-8.54367081220857!2d115.3030257734422!3f284.1796851577553!4f-2.9509987508706814!5f0.7820865974627469" 
                        width="100%" 
                        height="280" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

            </div>
        </div>

        <div class="mt-8 text-center text-sm text-gray-500">
            Peta interaktif • Drag untuk melihat seluruh wilayah • Scroll untuk zoom
        </div>
    </div>

    <!-- ==================== SECTION BERITA ==================== -->
    <div id="section-berita" class="section hidden">
        <div class="mb-10">
            <h2 class="news-section-title text-3xl font-semibold flex items-center gap-3">
                Berita Desa
            </h2>
            <p class="news-section-subtitle mt-2">Kumpulan berita dan informasi terbaru dari desa.</p>
        </div>

        @if(($beritaDesa ?? collect())->isNotEmpty())
            <div class="program-empty-state p-5 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm text-slate-600 mb-2">Tanggal</label>
                        <select id="berita-filter-day" class="w-full border border-gray-300 rounded-xl px-3 py-2">
                            <option value="">Semua Tanggal</option>
                            @for($d = 1; $d <= 31; $d++)
                                <option value="{{ str_pad((string) $d, 2, '0', STR_PAD_LEFT) }}">{{ $d }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-slate-600 mb-2">Bulan</label>
                        <select id="berita-filter-month" class="w-full border border-gray-300 rounded-xl px-3 py-2">
                            <option value="">Semua Bulan</option>
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ str_pad((string) $m, 2, '0', STR_PAD_LEFT) }}">{{ $m }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-slate-600 mb-2">Tahun</label>
                        <select id="berita-filter-year" class="w-full border border-gray-300 rounded-xl px-3 py-2">
                            <option value="">Semua Tahun</option>
                            @foreach(($beritaDesa ?? collect())->map(fn($b) => optional($b->tanggal_publish ?? $b->created_at)->format('Y'))->filter()->unique()->sortDesc()->values() as $y)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="button" id="berita-filter-reset" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl px-4 py-2 font-medium">Reset Filter</button>
                    </div>
                </div>
            </div>

            <div id="berita-dashboard-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($beritaDesa as $berita)
                    @php
                        $beritaImage = null;
                        if (!empty($berita->gambar)) {
                            if (\Illuminate\Support\Str::startsWith($berita->gambar, 'berita/')) {
                                $beritaImage = file_exists(public_path($berita->gambar)) ? asset($berita->gambar) : null;
                            } else {
                                $beritaImage = file_exists(public_path('storage/' . $berita->gambar)) ? asset('storage/' . $berita->gambar) : null;
                            }
                        }
                        $publishDate = optional($berita->tanggal_publish ?? $berita->created_at)->format('Y-m-d');
                    @endphp
                    <article class="news-card berita-dashboard-item"
                        data-publish="{{ $publishDate }}">
                        <div class="news-image-wrap bg-gradient-to-br from-orange-500 to-amber-500 flex items-center justify-center">
                            @if($beritaImage)
                                <img src="{{ $beritaImage }}" alt="{{ $berita->judul }}">
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
                            <p class="news-meta">{{ optional($berita->tanggal_publish ?? $berita->created_at)->format('d M Y') ?? '-' }}</p>
                            <h3 class="news-title text-lg mt-2 line-clamp-2">{{ $berita->judul }}</h3>
                            <p class="news-text text-sm mt-3 line-clamp-3">
                                {{ \Illuminate\Support\Str::limit(strip_tags($berita->isi), 130) }}
                            </p>
                            <a href="{{ route('berita.show', $berita->slug) }}" class="news-readmore text-sm mt-5">
                                <span>Baca selengkapnya</span>
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M5 12h14"></path>
                                    <path d="m13 6 6 6-6 6"></path>
                                </svg>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
            <div id="berita-dashboard-empty" class="news-empty-state hidden p-10 text-center mt-6">
                Tidak ada berita sesuai filter tanggal/bulan/tahun.
            </div>
        @else
            <div class="news-empty-state p-10 text-center">
                Belum ada berita yang dipublikasikan.
            </div>
        @endif

        <div class="mt-8 text-center">
            <a href="{{ route('berita.index') }}" class="inline-flex items-center px-5 py-3 rounded-2xl bg-blue-600 text-white hover:bg-blue-700 font-medium">
                Lihat Semua Berita
            </a>
        </div>
    </div>

    <!-- ==================== FOOTER DASHBOARD PUBLIK ==================== -->
    @php
        $footerAlamat = trim((string) (data_get($data ?? null, 'alamat') ?? data_get($data ?? null, 'alamat_desa') ?? ''));
        $footerEmail = trim((string) (data_get($data ?? null, 'email') ?? data_get($data ?? null, 'email_desa') ?? ''));
        $footerTelepon = trim((string) (data_get($data ?? null, 'telepon') ?? data_get($data ?? null, 'no_telp') ?? data_get($data ?? null, 'nomor_telepon') ?? ''));
        $footerJam = trim((string) (data_get($data ?? null, 'jam_pelayanan') ?? data_get($data ?? null, 'jam_buka') ?? ''));
    @endphp
    </main>
</div>

    <x-public-footer />

<!-- Swiper CSS -->
<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
/>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" 
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
function showSection(section) {
    document.querySelectorAll('.section').forEach(s => s.classList.add('hidden'));
    const el = document.getElementById(`section-${section}`);
    if (el) el.classList.remove('hidden');

    document.querySelectorAll('.menu-item').forEach(item => {
        item.classList.remove('active', 'border-white');
        item.classList.remove('bg-white/15', 'shadow-sm');
        if (item.dataset.section === section) {
            item.classList.add('active', 'border-white');
            item.classList.add('bg-white/15', 'shadow-sm');
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    showSection('home');
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenuPanel = document.getElementById('mobile-menu-panel');

    function syncMobileMenuButton(isOpen) {
        if (!mobileMenuToggle) return;
        mobileMenuToggle.textContent = isOpen ? '✕' : '☰';
        mobileMenuToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    }

    window.toggleMobileMenu = function(forceOpen = null) {
        if (!mobileMenuPanel || !mobileMenuToggle) return;

        const shouldOpen = typeof forceOpen === 'boolean'
            ? forceOpen
            : mobileMenuPanel.classList.contains('hidden');

        mobileMenuPanel.classList.toggle('hidden', !shouldOpen);
        syncMobileMenuButton(shouldOpen);
    };

    if (mobileMenuToggle && mobileMenuPanel) {
        syncMobileMenuButton(false);
        mobileMenuToggle.addEventListener('click', () => {
            window.toggleMobileMenu();
        });
    }

    // YouTube autoplay + loop:
    // - Jika popup kebijakan aktif, mulai autoplay setelah popup ditutup
    // - Jika tidak ada popup, autoplay langsung saat dashboard dibuka
    const yt = document.getElementById('desaYoutubeIframe');
    const buildYoutubeSrc = (videoId, autoplay) => {
        const params = new URLSearchParams({
            rel: '0',
            playsinline: '1',
            mute: '1',
            autoplay: autoplay ? '1' : '0',
            loop: '1',
            playlist: videoId,
        });
        return `https://www.youtube.com/embed/${encodeURIComponent(videoId)}?${params.toString()}`;
    };

    const startYoutubeAutoplay = () => {
        if (!yt) return;
        const videoId = yt.getAttribute('data-video-id');
        if (!videoId) return;
        yt.setAttribute('src', buildYoutubeSrc(videoId, true));
    };

    if (yt) {
        const hasPopup = !!document.querySelector('[data-popup-kebijakan]');
        if (!hasPopup) {
            startYoutubeAutoplay();
        } else {
            window.addEventListener('popup-kebijakan:closed', startYoutubeAutoplay, { once: true });
        }
    }

    const initBeritaFilter = () => {
        const dayEl = document.getElementById('berita-filter-day');
        const monthEl = document.getElementById('berita-filter-month');
        const yearEl = document.getElementById('berita-filter-year');
        const resetEl = document.getElementById('berita-filter-reset');
        const cards = Array.from(document.querySelectorAll('.berita-dashboard-item'));
        const emptyEl = document.getElementById('berita-dashboard-empty');

        if (!dayEl || !monthEl || !yearEl || cards.length === 0) return;

        const applyFilter = () => {
            const day = dayEl.value;
            const month = monthEl.value;
            const year = yearEl.value;
            let visible = 0;

            cards.forEach((card) => {
                const publish = String(card.dataset.publish || '');
                const [y, m, d] = publish.split('-');
                const matchDay = !day || day === d;
                const matchMonth = !month || month === m;
                const matchYear = !year || year === y;
                const ok = matchDay && matchMonth && matchYear;
                card.classList.toggle('hidden', !ok);
                if (ok) visible++;
            });

            if (emptyEl) emptyEl.classList.toggle('hidden', visible > 0);
        };

        dayEl.addEventListener('change', applyFilter);
        monthEl.addEventListener('change', applyFilter);
        yearEl.addEventListener('change', applyFilter);
        if (resetEl) {
            resetEl.addEventListener('click', () => {
                dayEl.value = '';
                monthEl.value = '';
                yearEl.value = '';
                applyFilter();
            });
        }
    };

    initBeritaFilter();

    const barCanvas = document.getElementById('statistikBarChart');
    if (barCanvas) {
        new Chart(barCanvas, {
            type: 'bar',
            data: {
                labels: ['Penduduk', 'Pengajuan Surat', 'Pengaduan'],
                datasets: [{
                    label: 'Total',
                    data: [
                        {{ (int) ($totalPenduduk ?? 0) }},
                        {{ (int) ($totalPengajuanSurat ?? 0) }},
                        {{ (int) ($totalPengaduan ?? 0) }}
                    ],
                    backgroundColor: ['#2563eb', '#f97316', '#ef4444'],
                    borderRadius: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });
    }

    const pieCanvas = document.getElementById('statistikPieChart');
    if (pieCanvas) {
        new Chart(pieCanvas, {
            type: 'pie',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    data: [
                        {{ (int) ($totalLaki ?? 0) }},
                        {{ (int) ($totalPerempuan ?? 0) }}
                    ],
                    backgroundColor: ['#3b82f6', '#ec4899']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    const aparaturSwiperEl = document.querySelector('.aparatur-swiper');
    if (aparaturSwiperEl && typeof Swiper !== 'undefined') {
        new Swiper('.aparatur-swiper', {
            loop: true,
            speed: 700,
            spaceBetween: 20,
            autoplay: {
                delay: 2000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.aparatur-swiper .swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.aparatur-next',
                prevEl: '.aparatur-prev',
            },
            breakpoints: {
                0: { slidesPerView: 1 },
                768: { slidesPerView: 2 },
                1024: { slidesPerView: 3 },
            },
        });
    }
});
</script>

<script>
let wilayahMap = null;
let kantorMarker = null;
let banjarLayer = null;
let desaBoundaryLayer = null;
let banjarLayerById = {};
let banjarMarkerLayers = [];
let banjarLoaded = false;

function getBanjarStyle(isSelected = false) {
    return {
        color: isSelected ? '#ea580c' : '#1e40af',
        weight: isSelected ? 3 : 2,
        opacity: 0.9,
        fillColor: isSelected ? '#fb923c' : '#3b82f6',
        fillOpacity: isSelected ? 0.4 : 0.22
    };
}

function renderBanjarButtons(features) {
    const listEl = document.getElementById('banjar-list');
    if (!listEl) return;

    if (!features.length) {
        listEl.innerHTML = '<p class="text-sm text-amber-700">Data banjar dinas belum tersedia di database.</p>';
        return;
    }

    listEl.innerHTML = features.map((feature) => {
        const id = feature?.properties?.id ?? '';
        const nama = feature?.properties?.nama ?? 'Banjar';
        const total = Number(feature?.properties?.total_penduduk ?? 0);

        return `
            <div class="flex items-center justify-between gap-2 rounded-2xl border border-gray-100 p-3">
                <div>
                    <p class="font-semibold text-gray-800">${nama}</p>
                    <p class="text-xs text-gray-500">Penduduk: ${total.toLocaleString('id-ID')} jiwa</p>
                </div>
                <button
                    type="button"
                    class="shrink-0 rounded-xl bg-blue-600 px-3 py-2 text-xs font-medium text-white hover:bg-blue-700"
                    onclick="focusBanjarById('${id}')"
                >
                    Lihat Posisi
                </button>
            </div>
        `;
    }).join('');
}

function focusBanjarById(banjarId) {
    if (!wilayahMap || !banjarLayerById[banjarId]) return;

    Object.values(banjarLayerById).forEach((layer) => layer.setStyle(getBanjarStyle(false)));

    const targetLayer = banjarLayerById[banjarId];
    targetLayer.setStyle(getBanjarStyle(true));
    wilayahMap.fitBounds(targetLayer.getBounds(), { padding: [28, 28] });
    targetLayer.openPopup();
}

function getBalaiMarkerIcon(iconUrl = null) {
    return L.icon({
        iconUrl: iconUrl || '/image/marker-balai.png',
        iconSize: [34, 44],
        iconAnchor: [17, 42],
        popupAnchor: [0, -34]
    });
}

function renderBanjarMarkers(features) {
    banjarMarkerLayers.forEach((m) => wilayahMap.removeLayer(m));
    banjarMarkerLayers = [];

    features.forEach((feature) => {
        const banjarNama = feature?.properties?.nama ?? 'Banjar';
        const markers = Array.isArray(feature?.properties?.markers) ? feature.properties.markers : [];

        markers.forEach((item) => {
            const lat = Number(item?.lat);
            const lng = Number(item?.lng);
            if (!Number.isFinite(lat) || !Number.isFinite(lng)) return;

            const marker = L.marker([lat, lng], {
                icon: getBalaiMarkerIcon(item?.icon_url || null)
            }).addTo(wilayahMap);

            marker.bindPopup(`<b>${item?.nama ?? 'Balai Banjar'}</b><br>${banjarNama}${item?.alamat ? `<br>${item.alamat}` : ''}`);
            banjarMarkerLayers.push(marker);
        });
    });
}

async function loadBanjarDinas() {
    const response = await fetch('/api/wilayah-desa/banjar-dinas', {
        headers: { 'Accept': 'application/json' }
    });

    if (!response.ok) {
        throw new Error('Gagal memuat data banjar dinas');
    }

    return response.json();
}

async function initMap() {
    const markerKantor = [-8.543817207683, 115.3028445063262];
    const batasDesaBuruan = [
        [-8.535158, 115.303405],[-8.535113, 115.302385],[-8.535075, 115.302010],[-8.535186, 115.301521],
        [-8.535146, 115.301180],[-8.534847, 115.300921],[-8.534434, 115.300809],[-8.532862, 115.300740],
        [-8.532336, 115.300553],[-8.531925, 115.300293],[-8.531736, 115.299917],[-8.531657, 115.299541],
        [-8.531806, 115.299202],[-8.532179, 115.298861],[-8.532850, 115.298446],[-8.534382, 115.297762],
        [-8.535914, 115.297231],[-8.536328, 115.297151],[-8.536700, 115.297187],[-8.537076, 115.297336],
        [-8.537449, 115.297445],[-8.537860, 115.297408],[-8.538158, 115.297256],[-8.538498, 115.296756],
        [-8.540687, 115.291566],[-8.540678, 115.290574],[-8.540600, 115.289909],[-8.540933, 115.289870],
        [-8.541482, 115.289861],[-8.542015, 115.289714],[-8.542662, 115.289340],[-8.542853, 115.289328],
        [-8.543119, 115.289479],[-8.543295, 115.289770],[-8.543297, 115.290129],[-8.543623, 115.290664],
        [-8.544212, 115.291205],[-8.544707, 115.291133],[-8.545209, 115.290955],[-8.547116, 115.289946],
        [-8.547288, 115.289946],[-8.547477, 115.290007],[-8.547770, 115.290183],[-8.547904, 115.290427],
        [-8.547968, 115.290628],[-8.547995, 115.291198],[-8.548151, 115.291485],[-8.548327, 115.291586],
        [-8.549119, 115.291723],[-8.549344, 115.291795],[-8.549868, 115.291878],[-8.550235, 115.291994],
        [-8.551475, 115.292144],[-8.551702, 115.292140],[-8.551863, 115.292094],[-8.552047, 115.292003],
        [-8.551699, 115.293192],[-8.551038, 115.294947],[-8.550069, 115.296791],[-8.549854, 115.297410],
        [-8.549826, 115.298735],[-8.549999, 115.299355],[-8.550311, 115.300035],[-8.550718, 115.300624],
        [-8.551121, 115.300940],[-8.551355, 115.301284],[-8.551547, 115.301300],[-8.551742, 115.301400],
        [-8.551992, 115.301479],[-8.552404, 115.301569],[-8.553113, 115.301840],[-8.554660, 115.302323],
        [-8.554870, 115.302773],[-8.555052, 115.303621],[-8.555091, 115.304282],[-8.555095, 115.305192],
        [-8.555121, 115.305960],[-8.555195, 115.306428],[-8.555351, 115.306833],[-8.555890, 115.307553],
        [-8.556191, 115.307874],[-8.556412, 115.308187],[-8.556252, 115.308275],[-8.556111, 115.308440],
        [-8.555901, 115.308669],[-8.555895, 115.308671],[-8.555368, 115.308945],[-8.555231, 115.309101],
        [-8.555126, 115.309334],[-8.554984, 115.310112],[-8.554424, 115.310729],[-8.554361, 115.310819],
        [-8.553922, 115.311178],[-8.553627, 115.311315],[-8.553420, 115.311355],[-8.553261, 115.311398],
        [-8.552781, 115.311571],[-8.552559, 115.311716],[-8.552474, 115.311792],[-8.552393, 115.311921],
        [-8.552349, 115.312041],[-8.552411, 115.312103],[-8.552315, 115.312013],[-8.552140, 115.312174],
        [-8.551517, 115.312568],[-8.549348, 115.312525],[-8.546245, 115.312198],[-8.544571, 115.312121],
        [-8.544199, 115.312030],[-8.543644, 115.312044],[-8.543393, 115.312100],[-8.543114, 115.312236],
        [-8.542803, 115.312150],[-8.541745, 115.312115],[-8.541160, 115.311987],[-8.540228, 115.312046],
        [-8.539344, 115.311820],[-8.539305, 115.311132],[-8.539594, 115.309400],[-8.539632, 115.308725],
        [-8.539594, 115.308086],[-8.539317, 115.307144],[-8.538840, 115.306318],[-8.538389, 115.305650],
        [-8.535935, 115.303434],[-8.535683, 115.303401]
    ];

    if (!wilayahMap) {
        wilayahMap = L.map('map');
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(wilayahMap);
    }

    if (!kantorMarker) {
        kantorMarker = L.marker(markerKantor).addTo(wilayahMap)
            .bindPopup('<b>🏛️ Kantor Desa Buruan</b><br>Blahbatuh, Gianyar');
    }

    if (!desaBoundaryLayer) {
        desaBoundaryLayer = L.polygon(batasDesaBuruan, {
            color: '#0f172a',
            weight: 4,
            opacity: 0.95,
            fillOpacity: 0.03
        }).addTo(wilayahMap);
        desaBoundaryLayer.bindPopup('<b>Wilayah Desa Buruan</b><br>Batas utama desa');
    }

    if (banjarLoaded) {
        setTimeout(() => wilayahMap.invalidateSize(), 80);
        return;
    }

    const listEl = document.getElementById('banjar-list');
    if (listEl) listEl.textContent = 'Memuat data banjar dinas...';

    try {
        const geojson = await loadBanjarDinas();
        const features = Array.isArray(geojson?.features) ? geojson.features : [];

        banjarLayerById = {};

        if (banjarLayer) {
            wilayahMap.removeLayer(banjarLayer);
            banjarLayer = null;
        }

        banjarLayer = L.geoJSON(geojson, {
            style: () => getBanjarStyle(false),
            onEachFeature: (feature, layer) => {
                const id = String(feature?.properties?.id ?? '');
                const nama = feature?.properties?.nama ?? 'Banjar';
                const total = Number(feature?.properties?.total_penduduk ?? 0);

                banjarLayerById[id] = layer;
                layer.bindPopup(`<b>${nama}</b><br>Penduduk: ${total.toLocaleString('id-ID')} jiwa`);
                layer.on('click', () => {
                    Object.values(banjarLayerById).forEach((l) => l.setStyle(getBanjarStyle(false)));
                    layer.setStyle(getBanjarStyle(true));
                });
            }
        }).addTo(wilayahMap);

        renderBanjarMarkers(features);
        renderBanjarButtons(features);

        if (features.length) {
            wilayahMap.fitBounds(banjarLayer.getBounds(), { padding: [20, 20] });
        } else {
            wilayahMap.fitBounds(desaBoundaryLayer.getBounds(), { padding: [20, 20] });
        }

        banjarLoaded = true;
    } catch (error) {
        console.error(error);
        if (listEl) {
            listEl.innerHTML = '<p class="text-sm text-red-600">Gagal memuat data banjar dinas dari database.</p>';
        }
        if (desaBoundaryLayer) {
            wilayahMap.fitBounds(desaBoundaryLayer.getBounds(), { padding: [20, 20] });
        } else {
            wilayahMap.setView(markerKantor, 15);
        }
    } finally {
        setTimeout(() => wilayahMap.invalidateSize(), 120);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    window.showSection = function(section) {
        document.querySelectorAll('.section').forEach(s => s.classList.add('hidden'));
        const target = document.getElementById(`section-${section}`);
        if (target) target.classList.remove('hidden');

        document.querySelectorAll('.menu-item').forEach(item => {
            item.classList.remove('active', 'border-white');
            item.classList.remove('bg-white/15', 'shadow-sm');
            if (item.dataset.section === section) {
                item.classList.add('active', 'border-white');
                item.classList.add('bg-white/15', 'shadow-sm');
            }
        });

        if (section === 'wilayah') {
            setTimeout(() => {
                initMap();
            }, 250);
        }
    };
});
</script>

</x-app-layout>


