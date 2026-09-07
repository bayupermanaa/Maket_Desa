@props(['role' => null, 'notification' => 0])

@php
    $sidebarRole = $role ?: (request()->routeIs('kepala.*') ? 'kepala' : (request()->routeIs('dashboard.masyarakat') ? 'masyarakat' : 'admin'));
    $isMasyarakat = $sidebarRole === 'masyarakat';
    $isKepala = $sidebarRole === 'kepala';
    $routePrefix = $isKepala ? 'kepala' : 'admin';
    $notifikasiSurat = $isMasyarakat
        ? 0
        : ($isKepala
            ? \App\Models\PengajuanSurat::where('status', \App\Models\PengajuanSurat::STATUS_DIAJUKAN_KE_KEPALA)->count()
            : \App\Models\PengajuanSurat::where('status', \App\Models\PengajuanSurat::STATUS_MENUNGGU)->count());
    $notifikasiPengaduan = $isMasyarakat ? (int) $notification : ($pengaduanBaru ?? 0);

    $icons = [
        'dashboard' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m3 10 9-7 9 7"></path><path d="M5 9v11h14V9"></path><path d="M9 20v-6h6v6"></path></svg>',
        'people' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M16 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"></path><circle cx="9.5" cy="7.5" r="3.5"></circle><path d="M20 21v-1.5a3.5 3.5 0 0 0-2.5-3.35"></path><path d="M16.5 4.5a3.5 3.5 0 0 1 0 7"></path></svg>',
        'document' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 3h9l3 3v15H6z"></path><path d="M14 3v4h4"></path><path d="M9 12h6"></path><path d="M9 16h6"></path></svg>',
        'megaphone' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m4 13 13-5v8L4 12z"></path><path d="M4 12v5a2 2 0 0 0 2 2h1l2-5"></path><path d="M17 10a3 3 0 0 1 0 4"></path></svg>',
        'chart' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 19V5"></path><path d="M4 19h16"></path><path d="M8 16v-5"></path><path d="M12 16V8"></path><path d="M16 16v-3"></path></svg>',
        'wallet' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 6h16v13H4z"></path><path d="M4 6V4h13l3 2"></path><path d="M16 13h4"></path></svg>',
        'newspaper' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 4h11l3 3v13H5z"></path><path d="M16 4v4h4"></path><path d="M8 11h6"></path><path d="M8 15h6"></path></svg>',
        'building' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 21V5l8-3 8 3v16"></path><path d="M2 21h20"></path><path d="M8 9h1"></path><path d="M15 9h1"></path><path d="M8 13h1"></path><path d="M15 13h1"></path><path d="M10 21v-4h4v4"></path></svg>',
        'clipboard' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="5" y="4" width="14" height="17" rx="2"></rect><path d="M9 4V2h6v2"></path><path d="M9 10h6"></path><path d="M9 14h6"></path></svg>',
        'settings' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.7 1.7 0 0 0 .34 1.88l.06.06-1.7 1.7-.06-.06a1.7 1.7 0 0 0-1.88-.34 1.7 1.7 0 0 0-1.03 1.56V20h-2.4v-.2a1.7 1.7 0 0 0-1.03-1.56 1.7 1.7 0 0 0-1.88.34l-.06.06-1.7-1.7.06-.06A1.7 1.7 0 0 0 8.46 15a1.7 1.7 0 0 0-1.56-1.03H6v-2.4h.9A1.7 1.7 0 0 0 8.46 10a1.7 1.7 0 0 0-.34-1.88l-.06-.06 1.7-1.7.06.06a1.7 1.7 0 0 0 1.88.34A1.7 1.7 0 0 0 12.73 5.2V5h2.4v.2a1.7 1.7 0 0 0 1.03 1.56 1.7 1.7 0 0 0 1.88-.34l.06-.06 1.7 1.7-.06.06A1.7 1.7 0 0 0 19.4 10a1.7 1.7 0 0 0 1.56 1.03h.04v2.4h-.04A1.7 1.7 0 0 0 19.4 15z"></path></svg>',
    ];

    $adminItems = [
        ['label' => 'Dashboard', 'icon' => 'dashboard', 'href' => route($routePrefix . '.dashboard'), 'active' => request()->routeIs($routePrefix . '.dashboard')],
        ['label' => 'Data Penduduk', 'icon' => 'people', 'href' => route('admin.data-penduduk.index'), 'active' => request()->is('admin/data-penduduk*'), 'adminOnly' => true],
        ['label' => 'Pengajuan Surat', 'icon' => 'document', 'href' => route($routePrefix . '.pengajuan-surat.index'), 'active' => request()->routeIs($routePrefix . '.pengajuan-surat.*'), 'badge' => $notifikasiSurat],
        ['label' => 'Pengaduan Masyarakat', 'icon' => 'megaphone', 'href' => route($routePrefix . '.pengaduan'), 'active' => request()->routeIs($routePrefix . '.pengaduan*'), 'badge' => $notifikasiPengaduan],
        ['label' => 'Laporan & Statistik', 'icon' => 'chart', 'href' => route($routePrefix . '.laporan-statistik.index'), 'active' => request()->routeIs($routePrefix . '.laporan-statistik.*')],
        ['label' => 'Keuangan Desa', 'icon' => 'wallet', 'href' => route('admin.keuangan'), 'active' => request()->routeIs('admin.keuangan*'), 'adminOnly' => true],
        ['label' => 'Artikel Desa', 'icon' => 'newspaper', 'href' => route('admin.artikel.index'), 'active' => request()->routeIs('admin.artikel.*'), 'adminOnly' => true],
        ['label' => 'Berita Desa', 'icon' => 'newspaper', 'href' => route('admin.berita.index'), 'active' => request()->routeIs('admin.berita.*'), 'adminOnly' => true],
        ['label' => 'Aparatur Desa', 'icon' => 'building', 'href' => route('admin.aparatur-desa.index'), 'active' => request()->routeIs('admin.aparatur-desa.*'), 'adminOnly' => true],
        ['label' => 'Program Desa', 'icon' => 'clipboard', 'href' => route('admin.program.index'), 'active' => request()->routeIs('admin.program.*'), 'adminOnly' => true],
        ['label' => 'CMS Dashboard Desa', 'icon' => 'settings', 'href' => route('admin.settings-desa.edit'), 'active' => request()->routeIs('admin.settings-desa.*'), 'adminOnly' => true],
    ];

    $masyarakatItems = [
        ['label' => 'Dashboard', 'icon' => 'dashboard', 'target' => 'beranda'],
        ['label' => 'Pengajuan Surat', 'icon' => 'document', 'target' => 'pengajuan'],
        ['label' => 'Status Pengajuan Surat', 'icon' => 'clipboard', 'target' => 'status-surat'],
        ['label' => 'Pengaduan Masyarakat', 'icon' => 'megaphone', 'target' => 'pengaduan'],
        ['label' => 'Status Pengaduan', 'icon' => 'clipboard', 'target' => 'status-pengaduan', 'badge' => $notifikasiPengaduan],
    ];
@endphp

<div x-data="{ open: false }" class="contents">
    <button type="button" @click="open = true" class="fixed left-4 top-4 z-30 inline-flex h-11 w-11 items-center justify-center rounded-xl bg-gray-900 text-white shadow-lg md:hidden" aria-label="Buka navigasi">
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M4 6h16"></path><path d="M4 12h16"></path><path d="M4 18h16"></path>
        </svg>
    </button>

    <div x-show="open" x-cloak @click="open = false" class="fixed inset-0 z-30 bg-gray-950/50 md:hidden" aria-hidden="true"></div>

    <aside class="fixed inset-y-0 left-0 z-40 flex w-72 -translate-x-full flex-shrink-0 flex-col bg-gray-900 p-6 text-white transition-transform duration-200 md:static md:translate-x-0" :class="{ 'translate-x-0': open }">
        <div class="mb-8 flex items-center justify-between gap-3">
            <a href="{{ $isMasyarakat ? route('dashboard.masyarakat') : route($routePrefix . '.dashboard') }}" class="flex min-w-0 items-center gap-3">
                <div class="h-14 w-14 flex-shrink-0 overflow-hidden rounded-2xl bg-white flex items-center justify-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo MAKET DESA" class="h-full w-full object-contain">
                </div>
                <div class="min-w-0">
                    <h1 class="truncate text-lg font-semibold">MAKET DESA</h1>
                    <p class="text-xs text-gray-400">{{ $isMasyarakat ? 'Portal Masyarakat' : ($isKepala ? 'Kepala Desa Panel' : 'Admin Panel') }}</p>
                </div>
            </a>
            <button type="button" @click="open = false" class="inline-flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white md:hidden" aria-label="Tutup navigasi">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="m6 6 12 12"></path><path d="M18 6 6 18"></path>
                </svg>
            </button>
        </div>

        <nav class="space-y-1 overflow-y-auto" id="{{ $isMasyarakat ? 'menu-masyarakat-side' : 'app-sidebar-nav' }}">
            @if($isMasyarakat)
                @foreach($masyarakatItems as $item)
                    <button type="button" data-target="{{ $item['target'] }}" class="menu-side-item flex w-full items-center justify-between gap-3 rounded-2xl px-4 py-3.5 text-left text-sm font-medium transition {{ $loop->first ? 'bg-orange-600 text-white' : 'hover:bg-gray-800' }}">
                        <span class="flex min-w-0 items-center gap-3">
                            <span class="app-sidebar-icon h-5 w-5 flex-shrink-0">{!! $icons[$item['icon']] !!}</span>
                            <span class="truncate">{{ $item['label'] }}</span>
                        </span>
                        @if(($item['badge'] ?? 0) > 0)
                            <span class="flex h-6 min-w-6 items-center justify-center rounded-full bg-red-500 px-2 text-xs font-semibold">{{ $item['badge'] }}</span>
                        @endif
                    </button>
                @endforeach
            @else
                @foreach($adminItems as $item)
                    @if(!($item['adminOnly'] ?? false) || !$isKepala)
                        <a href="{{ $item['href'] }}" class="flex items-center justify-between gap-3 rounded-2xl px-4 py-3.5 text-sm font-medium transition {{ $item['active'] ? 'bg-orange-600 text-white' : 'text-gray-200 hover:bg-gray-800' }}">
                            <span class="flex min-w-0 items-center gap-3">
                                <span class="app-sidebar-icon h-5 w-5 flex-shrink-0">{!! $icons[$item['icon']] !!}</span>
                                <span class="truncate">{{ $item['label'] }}</span>
                            </span>
                            @if(($item['badge'] ?? 0) > 0)
                                <span class="flex h-6 min-w-6 items-center justify-center rounded-full bg-red-500 px-2 text-xs font-semibold">{{ $item['badge'] }}</span>
                            @endif
                        </a>
                    @endif
                @endforeach
            @endif
        </nav>
    </aside>
</div>

@once
    <style>
        .app-sidebar-icon svg {
            display: block;
            width: 100%;
            height: 100%;
        }
    </style>
@endonce
