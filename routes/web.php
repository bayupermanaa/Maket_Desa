<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\PengajuanSuratController;
use App\Http\Controllers\Admin\SettingsDesaController;
use App\Http\Controllers\Admin\DataPendudukController;
use App\Http\Controllers\Admin\AparaturDesaController;
use App\Models\SettingsDesa;
use App\Models\AparaturDesa;
use App\Http\Controllers\Admin\PengaduanController;

// ==================== ROUTE PUBLIK ====================

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Dashboard Publik
Route::get('/dashboard', function () {
    $data = SettingsDesa::first();
    $aparaturDesa = AparaturDesa::where('is_active', true)->orderBy('urutan')->get();
    $artikelDesa = \App\Models\Artikel::latest()->take(6)->get();

    return view('dashboard', compact('data', 'aparaturDesa', 'artikelDesa')); // resources/views/dashboard.blade.php
})->name('dashboard');


// Dashboard Masyarakat
Route::get('/dashboard/masyarakat', function () {
    if (session('role') !== 'masyarakat') {
        return redirect('/dashboard');
    }
    return view('dashboard.masyarakat');
})->name('dashboard.masyarakat');

// ==================== ROUTE ADMIN ====================
Route::prefix('admin')->name('admin.')->group(function() {

  // Dashboard Admin
    Route::get('/dashboard', [SettingsDesaController::class, 'dashboard'])->name('dashboard');

    // Settings Desa
    Route::get('/settings-desa', [SettingsDesaController::class, 'edit'])->name('settings-desa.edit');
    Route::put('/settings-desa', [SettingsDesaController::class, 'update'])->name('settings-desa.update');

    // Data Penduduk
    Route::get('/data-penduduk', [DataPendudukController::class, 'index'])->name('penduduk.index');
    Route::post('/data-penduduk/{id}/toggle-status', [DataPendudukController::class, 'toggleStatus'])->name('penduduk.toggleStatus');
    Route::post('/data-penduduk/preview-import', [DataPendudukController::class, 'previewImport'])->name('penduduk.previewImport');
    Route::post('/data-penduduk/confirm-import', [DataPendudukController::class, 'confirmImport'])->name('penduduk.confirmImport');

    // Aparatur Desa
    Route::resource('/aparatur-desa', AparaturDesaController::class)->except(['show']);

    // Pengajuan Surat
    Route::resource('/pengajuan-surat', PengajuanSuratController::class);
    Route::patch('/pengajuan-surat/{id}/setujui', [PengajuanSuratController::class, 'setujui'])->name('pengajuan-surat.setujui');
    Route::patch('/pengajuan-surat/{id}/tolak', [PengajuanSuratController::class, 'tolak'])->name('pengajuan-surat.tolak');

    // Artikel
    Route::resource('/artikel', \App\Http\Controllers\Admin\ArtikelController::class);

    // ==================== PENGADUAN MASYARAKAT ====================
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan');
    Route::get('/pengaduan/data', [PengaduanController::class, 'data'])->name('pengaduan.data');
    Route::get('/pengaduan/{id}', [PengaduanController::class, 'show'])->name('pengaduan.show');
    Route::put('/pengaduan/{id}', [PengaduanController::class, 'update'])->name('pengaduan.update');
});
// ==================== LOGIN ====================

// Login Masyarakat
Route::get('/login/masyarakat', function () {
    return view('auth.login-masyarakat');
})->name('login.masyarakat');

Route::post('/login/masyarakat', function (Request $request) {
    session(['role' => 'masyarakat']);
    session(['user_name' => $request->input('nik_email', 'Bayu Permana')]);
    return redirect()->route('dashboard.masyarakat');
})->name('login.masyarakat.post');

// Login Admin
Route::get('/login/admin', function () {
    return view('auth.login-admin');
})->name('login.admin');

Route::post('/login/admin', function (Request $request) {
    session(['role' => 'admin_desa']);
    session(['user_name' => $request->input('username', 'Admin Desa')]);
    return redirect()->route('admin.dashboard');
})->name('login.admin.post');

// Login Kepala Desa
Route::get('/login/kepala-desa', function () {
    return view('auth.login-kepala-desa');
})->name('login.kepala-desa');

Route::post('/login/kepala-desa', function (Request $request) {
    session(['role' => 'kepala_desa']);
    session(['user_name' => 'I Wayan Sudiana']);
    return redirect('/dashboard');
})->name('login.kepala-desa.post');

// ==================== LOGOUT ====================
Route::post('/logout', function () {
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