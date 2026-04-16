<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanSurat;

class PengajuanSuratController extends Controller
{
    /**
     * Tampilkan daftar semua pengajuan surat (ADMIN)
     */
    public function index()
    {
        $pengajuan = PengajuanSurat::latest()->paginate(15);
        return view('admin.pengajuan-surat.index', compact('pengajuan'));
    }

    /**
     * Form create (sebenarnya nanti untuk masyarakat,
     * tapi sementara kita biarkan dulu)
     */
    public function create()
    {
        return view('admin.pengajuan-surat.create');
    }

    /**
     * Simpan pengajuan baru (status otomatis MENUNGGU)
     */
    public function store(Request $request)
    {
        PengajuanSurat::create([
            'nama' => $request->nama,
            'jenis_surat' => $request->jenis_surat,
            'keterangan' => $request->keterangan,
            'status' => 'Menunggu',
        ]);

        return redirect()->route('admin.pengajuan-surat.index')
            ->with('success', 'Pengajuan surat berhasil ditambahkan.');
    }

    /**
     * Detail pengajuan (admin baca isi sebelum verifikasi)
     */
    public function show($id)
    {
        $surat = PengajuanSurat::findOrFail($id);
        return view('admin.pengajuan-surat.show', compact('surat'));
    }

    /**
     * Edit (opsional)
     */
    public function edit($id)
    {
        $surat = PengajuanSurat::findOrFail($id);
        return view('admin.pengajuan-surat.edit', compact('surat'));
    }

    /**
     * Update (opsional)
     */
    public function update(Request $request, $id)
    {
        $surat = PengajuanSurat::findOrFail($id);

        $surat->update([
            'nama' => $request->nama,
            'jenis_surat' => $request->jenis_surat,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.pengajuan-surat.index')
            ->with('success', 'Pengajuan surat berhasil diupdate.');
    }

    /**
     * Hapus pengajuan
     */
    public function destroy($id)
    {
        $surat = PengajuanSurat::findOrFail($id);
        $surat->delete();

        return redirect()->route('admin.pengajuan-surat.index')
            ->with('success', 'Pengajuan surat berhasil dihapus.');
    }

    // =====================================================
    // 🔥 FITUR VERIFIKASI ADMIN
    // =====================================================

    /**
     * Admin menyetujui pengajuan
     */
    public function setujui($id)
    {
        $surat = PengajuanSurat::findOrFail($id);
        $surat->status = 'Disetujui';
        $surat->save();

        return redirect()->route('admin.pengajuan-surat.index')
            ->with('success', 'Pengajuan surat berhasil disetujui.');
    }

    /**
     * Admin menolak pengajuan
     */
    public function tolak($id)
    {
        $surat = PengajuanSurat::findOrFail($id);
        $surat->status = 'Ditolak';
        $surat->save();

        return redirect()->route('admin.pengajuan-surat.index')
            ->with('success', 'Pengajuan surat berhasil ditolak.');
    }
}