<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SettingsDesa;
use App\Models\AparaturDesa;
use Illuminate\Support\Facades\Storage;

class SettingsDesaController extends Controller
{
    public function edit()
    {
        $data = SettingsDesa::first() ?? SettingsDesa::create([]);
        return view('admin.settings-desa.edit', compact('data'));
    }

    public function update(Request $request)
{
    $data = SettingsDesa::first() ?? new SettingsDesa();

    // Handle upload foto kepala desa
    if ($request->hasFile('kepala_desa_foto')) {
        if ($data->kepala_desa_foto) {
            Storage::delete('public/' . $data->kepala_desa_foto);
        }
        $fotoPath = $request->file('kepala_desa_foto')->store('kepala_desa', 'public');
        $data->kepala_desa_foto = $fotoPath;
    }

    // Update data
    $data->update([
        'nama_desa'                  => $request->nama_desa,
        'kecamatan'                  => $request->kecamatan,
        'kabupaten'                  => $request->kabupaten,
        'provinsi'                   => $request->provinsi,
        'luas_wilayah'               => $request->luas_wilayah,
        'kepadatan'                  => $request->kepadatan,
        'jumlah_penduduk'            => $request->jumlah_penduduk,
        'jumlah_banjar'              => $request->jumlah_banjar,
        'penduduk_baru_tahun_ini'    => $request->penduduk_baru_tahun_ini,
        'video_desa'                 => $request->video_desa,
        'nama_kepala_desa'           => $request->nama_kepala_desa ?? $request->kepala_desa_nama,
        'kepala_desa_jabatan'        => $request->kepala_desa_jabatan,
        'kepala_desa_periode'        => $request->kepala_desa_periode,
        'sejarah_desa'               => $request->sejarah_desa,
        'popup_judul'                => $request->popup_judul,
        'popup_isi'                  => $request->popup_isi,
        'popup_aktif'                => $request->popup_aktif ? 1 : 0,
    ]);

    return back()->with('success', 'Pengaturan desa berhasil diperbarui!');
}

    // ===== Dashboard Admin =====
    public function dashboard()
{
    $data = SettingsDesa::first();
    $aparaturDesa = AparaturDesa::where('is_active', true)
                    ->orderBy('urutan')
                    ->get();

    // Ambil artikel
    $artikelDesa = \App\Models\Artikel::where('is_published', true)
                    ->latest()
                    ->take(8)
                    ->get();

    if ($data) {
        $data->jumlah_banjar = $data->jumlah_banjar ?? 0;
        $data->penduduk_baru_tahun_ini = $data->penduduk_baru_tahun_ini ?? 0;
        $data->jumlah_penduduk = $data->jumlah_penduduk ?? 0;
    } else {
        $data = new SettingsDesa([
            'jumlah_banjar' => 0,
            'penduduk_baru_tahun_ini' => 0,
            'jumlah_penduduk' => 0
        ]);
    }

    return view('dashboard.admin', compact('data', 'aparaturDesa', 'artikelDesa'));
}
}