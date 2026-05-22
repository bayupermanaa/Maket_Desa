<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengajuanSuratController;
use App\Http\Controllers\PengaduanController as MasyarakatPengaduanController;
use App\Http\Controllers\Admin\SettingsDesaController;
use App\Http\Controllers\Admin\DataPendudukController;
use App\Http\Controllers\Admin\AparaturDesaController;
use App\Http\Controllers\Admin\LaporanStatistikController;
use App\Http\Controllers\Admin\ProgramDesaController;
use App\Models\SettingsDesa;
use App\Models\AparaturDesa;
use App\Http\Controllers\Admin\PengaduanController;
use App\Http\Controllers\PublicArtikelController;
use App\Http\Controllers\PublicBeritaController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Auth\LoginController;

// ==================== ROUTE PUBLIK ====================

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Dashboard Publik
Route::get('/dashboard', function () {
    $safe = function (callable $callback, $default = null) {
        try {
            return $callback();
        } catch (\Throwable $e) {
            return $default;
        }
    };

    $data = $safe(fn () => \App\Models\SettingsDesa::first(), null);

    // === DATA UTAMA ===
    $totalPenduduk       = (int) $safe(fn () => \App\Models\Penduduk::count(), 0);
    $totalPengajuanSurat = (int) $safe(fn () => \App\Models\PengajuanSurat::count(), 0);
    $totalPengaduan      = (int) $safe(fn () => \App\Models\Pengaduan::count(), 0);

    // === DATA PENDUDUK BERDASARKAN JENIS KELAMIN ===
    $totalLaki = (int) $safe(fn () => \App\Models\Penduduk::where(function ($query) {
        $query->whereRaw('LOWER(jk) = ?', ['l'])
            ->orWhereRaw('LOWER(jk) = ?', ['laki-laki'])
            ->orWhereRaw('LOWER(jk) = ?', ['laki laki']);
    })->count(), 0);

    $totalPerempuan = (int) $safe(fn () => \App\Models\Penduduk::where(function ($query) {
        $query->whereRaw('LOWER(jk) = ?', ['p'])
            ->orWhereRaw('LOWER(jk) = ?', ['perempuan']);
    })->count(), 0);

    // Fallback: Jika belum ada data jenis kelamin sama sekali, bagi rata (opsional)
    if ($totalLaki == 0 && $totalPerempuan == 0 && $totalPenduduk > 0) {
        $totalLaki      = (int) round($totalPenduduk * 0.505);   // sedikit lebih banyak laki-laki
        $totalPerempuan = $totalPenduduk - $totalLaki;
    }

    $usiaProduktif  = (int) $safe(fn () => \App\Models\Penduduk::whereBetween('usia', [15, 64])->count(), 0);
    $lansia         = (int) $safe(fn () => \App\Models\Penduduk::where('usia', '>=', 65)->count(), 0);

    // Total KK (Kepala Keluarga)
    $totalKK = (int) $safe(fn () => \App\Models\Penduduk::where('hubungan', 'Kepala Keluarga')
                    ->orWhere('hubungan', 'KK')
                    ->orWhere('hubungan', 'kepala keluarga')
                    ->count(), 0);

    $rataRataKK = $totalKK > 0 
                  ? round($totalPenduduk / $totalKK, 1) 
                  : ($totalPenduduk > 0 ? 4.5 : 0);   // asumsi rata-rata KK biasanya 4-5 orang

    // Data pendukung
    $aparaturDesa = $safe(fn () => \App\Models\AparaturDesa::where('is_active', true)
                    ->orderBy('urutan')
                    ->get(), collect());

    $artikelDesa = $safe(fn () => \App\Models\Artikel::where('is_published', true)
                    ->latest()
                    ->take(6)
                    ->get(), collect());
    $beritaDesa = $safe(fn () => \App\Models\Berita::where('status', 'published')
                    ->whereDate('tanggal_publish', '<=', now()->toDateString())
                    ->orderByDesc('tanggal_publish')
                    ->orderByDesc('id')
                    ->take(6)
                    ->get(), collect());
    $programDesa = $safe(fn () => \App\Models\ProgramDesa::where('is_active', true)
                    ->orderBy('urutan')
                    ->latest('id')
                    ->take(6)
                    ->get(), collect());

    // === DATA KEUANGAN (RINGKAS UNTUK PUBLIK) ===
    $totalPendapatan = (float) $safe(fn () => \App\Models\Keuangan::where('jenis', 'pendapatan')->sum('jumlah'), 0);
    $totalBelanja = (float) $safe(fn () => \App\Models\Keuangan::where('jenis', 'belanja')->sum('jumlah'), 0);
    $saldoKeuangan = $totalPendapatan - $totalBelanja;
    $transaksiKeuanganTerbaru = $safe(fn () => \App\Models\Keuangan::orderBy('tanggal', 'desc')
                                ->orderBy('id', 'desc')
                                ->take(5)
                                ->get(), collect());

    return view('dashboard', compact(
        'data', 
        'totalPenduduk', 
        'totalPengajuanSurat', 
        'totalPengaduan',
        'totalLaki',
        'totalPerempuan',
        'usiaProduktif',
        'lansia',
        'totalKK',
        'rataRataKK',
        'totalPendapatan',
        'totalBelanja',
        'saldoKeuangan',
        'transaksiKeuanganTerbaru',
        'programDesa',
        'beritaDesa',
        'aparaturDesa', 
        'artikelDesa'
    ));
})->name('dashboard');

// Artikel Publik
Route::get('/artikel', [PublicArtikelController::class, 'index'])->name('artikel.index');
Route::get('/artikel/{slug}', [PublicArtikelController::class, 'show'])->name('artikel.show');
Route::get('/daftar-berita', [PublicBeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [PublicBeritaController::class, 'show'])->name('berita.show');


// Dashboard Masyarakat
Route::post('/dashboard/masyarakat/pengajuan-surat', [PengajuanSuratController::class, 'storeMasyarakat'])
    ->middleware('auth')
    ->name('masyarakat.pengajuan-surat.store');
Route::post('/dashboard/masyarakat/pengaduan', [MasyarakatPengaduanController::class, 'storeMasyarakat'])
    ->middleware('auth')
    ->name('masyarakat.pengaduan.store');
Route::get('/dashboard/masyarakat/pengaduan/{id}', [MasyarakatPengaduanController::class, 'showMasyarakat'])
    ->middleware('auth')
    ->name('masyarakat.pengaduan.show');

Route::get('/dashboard/masyarakat', function () {
    if (!auth()->check() || auth()->user()->role !== 'masyarakat') {
        return redirect()->route('dashboard');
    }

    $safe = function (callable $callback, $default = null) {
        try {
            return $callback();
        } catch (\Throwable $e) {
            return $default;
        }
    };

    $user = auth()->user();
    $nik = $user->nik;

    $pengajuanSuratQuery = \App\Models\PengajuanSurat::query();
    $pengaduanQuery = \App\Models\Pengaduan::query();

    if (!empty($nik)) {
        $pengajuanSuratQuery->where('nik', $nik);
        $pengaduanQuery->where('nik', $nik);
    } else {
        $pengajuanSuratQuery->where('nama', $user->name);
        $pengaduanQuery->where('nama_pelapor', $user->name);
    }

    $totalPengajuanSurat = (int) $safe(fn () => (clone $pengajuanSuratQuery)->count(), 0);
    $suratDiproses = (int) $safe(fn () => (clone $pengajuanSuratQuery)
        ->whereIn('status', ['Menunggu', 'Diproses'])
        ->count(), 0);
    $totalPengaduan = (int) $safe(fn () => (clone $pengaduanQuery)->count(), 0);
    $pengaduanSelesai = (int) $safe(fn () => (clone $pengaduanQuery)->where('status', 'selesai')->count(), 0);

    $riwayatPengajuanSurat = $safe(
        fn () => (clone $pengajuanSuratQuery)->latest()->take(8)->get(),
        collect()
    );

    $riwayatPengaduan = $safe(
        fn () => (clone $pengaduanQuery)->with('logs')->latest()->take(8)->get(),
        collect()
    );

    $pengaduanBelumDibaca = (int) $safe(function () use ($pengaduanQuery) {
        return (clone $pengaduanQuery)
            ->whereHas('logs', function ($query) {
                $query->where('dibuat_oleh', 'Admin')
                    ->whereRaw("pengaduan_logs.created_at > COALESCE(pengaduans.warga_last_seen_log_at, '1970-01-01 00:00:00')");
            })
            ->count();
    }, 0);

    session([
        'role' => 'masyarakat',
        'user_name' => $user->name,
    ]);

    return view('dashboard.masyarakat', compact(
        'totalPengajuanSurat',
        'suratDiproses',
        'totalPengaduan',
        'pengaduanSelesai',
        'riwayatPengajuanSurat',
        'riwayatPengaduan',
        'pengaduanBelumDibaca'
    ));
})->middleware('auth')->name('dashboard.masyarakat');

// ==================== ROUTE ADMIN ====================
Route::prefix('admin')->name('admin.')->middleware('admin.role')->group(function() {

  // Dashboard Admin
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])
         ->name('dashboard');

    // Settings Desa
    Route::get('/settings-desa', [SettingsDesaController::class, 'edit'])->name('settings-desa.edit');
    Route::put('/settings-desa', [SettingsDesaController::class, 'update'])->name('settings-desa.update');

    // ==================== DATA PENDUDUK ====================
    // Data Penduduk
    Route::get('/data-penduduk', [DataPendudukController::class, 'index'])->name('data-penduduk.index');
    Route::post('/data-penduduk/import', [DataPendudukController::class, 'import'])->name('penduduk.confirm-import');
    Route::get('/data-penduduk/{id}/edit', [DataPendudukController::class, 'edit'])->name('penduduk.edit');

    // Toggle status aktif/nonaktif
    Route::patch('/data-penduduk/{id}/toggle-status', [DataPendudukController::class, 'toggleStatus'])
        ->name('penduduk.toggle-status');

    // Aparatur Desa
    Route::resource('/aparatur-desa', AparaturDesaController::class)->except(['show']);

    // Pengajuan Surat
    Route::resource('/pengajuan-surat', PengajuanSuratController::class);
    Route::patch('/pengajuan-surat/{id}/setujui', [PengajuanSuratController::class, 'setujui'])->name('pengajuan-surat.setujui');
    Route::patch('/pengajuan-surat/{id}/tolak', [PengajuanSuratController::class, 'tolak'])->name('pengajuan-surat.tolak');

    // Laporan & Statistik
    Route::get('/laporan-statistik', [LaporanStatistikController::class, 'index'])->name('laporan-statistik.index');
    Route::get('/laporan-statistik/export/excel', [LaporanStatistikController::class, 'exportExcel'])->name('laporan-statistik.export.excel');
    Route::get('/laporan-statistik/export/pdf', [LaporanStatistikController::class, 'exportPdf'])->name('laporan-statistik.export.pdf');

    // Artikel
    Route::resource('/artikel', \App\Http\Controllers\Admin\ArtikelController::class);
    Route::resource('/berita', BeritaController::class)->except(['show']);
    Route::resource('/program', ProgramDesaController::class)->except(['show']);

// ==================== KEUANGAN DESA ====================
    Route::get('/keuangan', [App\Http\Controllers\Admin\KeuanganController::class, 'index'])->name('keuangan');
    Route::get('/keuangan/create', [App\Http\Controllers\Admin\KeuanganController::class, 'create'])->name('keuangan.create');
    Route::post('/keuangan', [App\Http\Controllers\Admin\KeuanganController::class, 'store'])->name('keuangan.store');
    Route::get('/keuangan/{keuangan}/edit', [App\Http\Controllers\Admin\KeuanganController::class, 'edit'])->name('keuangan.edit');
    Route::put('/keuangan/{keuangan}', [App\Http\Controllers\Admin\KeuanganController::class, 'update'])->name('keuangan.update');
    Route::delete('/keuangan/{keuangan}', [App\Http\Controllers\Admin\KeuanganController::class, 'destroy'])->name('keuangan.destroy');
    
    // ==================== PENGADUAN MASYARAKAT ====================
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan');
    Route::get('/pengaduan/data', [PengaduanController::class, 'data'])->name('pengaduan.data');
    Route::get('/pengaduan/export/excel', [PengaduanController::class, 'exportExcel'])->name('pengaduan.export.excel');
    Route::get('/pengaduan/export/pdf', [PengaduanController::class, 'exportPdf'])->name('pengaduan.export.pdf');
    Route::get('/pengaduan/{id}', [PengaduanController::class, 'show'])->name('pengaduan.show');
    Route::put('/pengaduan/{id}', [PengaduanController::class, 'update'])->name('pengaduan.update');
});

// ==================== ROUTE KEPALA DESA ====================
Route::prefix('kepala-desa')->name('kepala.')->middleware('kepala.role')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])
        ->name('dashboard');

    // Verifikasi Pengajuan Surat
    Route::get('/pengajuan-surat', [PengajuanSuratController::class, 'index'])->name('pengajuan-surat.index');
    Route::get('/pengajuan-surat/{id}', [PengajuanSuratController::class, 'show'])->name('pengajuan-surat.show');
    Route::patch('/pengajuan-surat/{id}/setujui', [PengajuanSuratController::class, 'setujui'])->name('pengajuan-surat.setujui');
    Route::patch('/pengajuan-surat/{id}/tolak', [PengajuanSuratController::class, 'tolak'])->name('pengajuan-surat.tolak');

    // Verifikasi Pengaduan
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan');
    Route::get('/pengaduan/data', [PengaduanController::class, 'data'])->name('pengaduan.data');
    Route::get('/pengaduan/export/excel', [PengaduanController::class, 'exportExcel'])->name('pengaduan.export.excel');
    Route::get('/pengaduan/export/pdf', [PengaduanController::class, 'exportPdf'])->name('pengaduan.export.pdf');
    Route::get('/pengaduan/{id}', [PengaduanController::class, 'show'])->name('pengaduan.show');
    Route::put('/pengaduan/{id}', [PengaduanController::class, 'update'])->name('pengaduan.update');

    // Laporan
    Route::get('/laporan-statistik', [LaporanStatistikController::class, 'index'])->name('laporan-statistik.index');
    Route::get('/laporan-statistik/export/excel', [LaporanStatistikController::class, 'exportExcel'])->name('laporan-statistik.export.excel');
    Route::get('/laporan-statistik/export/pdf', [LaporanStatistikController::class, 'exportPdf'])->name('laporan-statistik.export.pdf');
});
// ==================== LOGIN ====================

// Login Masyarakat
Route::get('/login/masyarakat', function () {
    return view('auth.login-masyarakat');
})->name('login.masyarakat');

Route::post('/login/masyarakat', [LoginController::class, 'loginMasyarakat'])->name('login.masyarakat.post');

// Login Admin
Route::get('/login/admin', function () {
    return view('auth.login-admin');
})->name('login.admin');

Route::post('/login/admin', [LoginController::class, 'loginAdmin'])->name('login.admin.post');

// Login Kepala Desa
Route::get('/login/kepala-desa', function () {
    return view('auth.login-kepala-desa');
})->name('login.kepala-desa');

Route::post('/login/kepala-desa', [LoginController::class, 'loginKepalaDesa'])->name('login.kepala-desa.post');

// ==================== LOGOUT ====================
Route::post('/logout', function () {
    auth()->logout();
    session()->flush();
    return redirect('/dashboard')->with('success', 'Anda telah berhasil logout.');
})->name('logout');

// ==================== PROFILE ====================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
