<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanSurat;

class PengajuanSuratController extends Controller
{
    private function routePrefix(): string
    {
        return request()->routeIs('kepala.*') ? 'kepala' : 'admin';
    }

    private function validatePengajuanSurat(Request $request): array
    {
        return $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:20',
            'jenis_surat' => 'required|string|max:100',
            'keperluan' => 'required|string',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);
    }

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
        $validated = $this->validatePengajuanSurat($request);

        PengajuanSurat::create([
            'nama' => $validated['nama'],
            'nik' => $validated['nik'],
            'jenis_surat' => $validated['jenis_surat'],
            'keperluan' => $validated['keperluan'],
            'no_hp' => $validated['no_hp'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'keterangan' => $validated['keterangan'] ?? null,
            'status' => PengajuanSurat::STATUS_MENUNGGU,
        ]);

        return redirect()->route($this->routePrefix() . '.pengajuan-surat.index')
            ->with('success', 'Pengajuan surat berhasil ditambahkan.');
    }

    /**
     * Simpan pengajuan surat oleh masyarakat dari dashboard masyarakat.
     */
    public function storeMasyarakat(Request $request)
    {
        if (!auth()->check() || auth()->user()->role !== 'masyarakat') {
            abort(403);
        }

        $validated = $this->validatePengajuanSurat($request);

        PengajuanSurat::create([
            'nama' => $validated['nama'],
            'nik' => $validated['nik'],
            'jenis_surat' => $validated['jenis_surat'],
            'keperluan' => $validated['keperluan'],
            'no_hp' => $validated['no_hp'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'keterangan' => $validated['keterangan'] ?? null,
            'status' => PengajuanSurat::STATUS_MENUNGGU,
        ]);

        return redirect()
            ->route('dashboard.masyarakat', ['tab' => 'pengajuan'])
            ->with('success', 'Pengajuan surat berhasil dikirim. Silakan pantau di menu Status Pengajuan Surat.');
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
        $validated = $this->validatePengajuanSurat($request);

        $surat = PengajuanSurat::findOrFail($id);

        $surat->update([
            'nama' => $validated['nama'],
            'nik' => $validated['nik'],
            'jenis_surat' => $validated['jenis_surat'],
            'keperluan' => $validated['keperluan'],
            'no_hp' => $validated['no_hp'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'keterangan' => $validated['keterangan'] ?? null,
        ]);

        return redirect()->route($this->routePrefix() . '.pengajuan-surat.index')
            ->with('success', 'Pengajuan surat berhasil diupdate.');
    }

    /**
     * Hapus pengajuan
     */
    public function destroy($id)
    {
        $surat = PengajuanSurat::findOrFail($id);
        $surat->delete();

        return redirect()->route($this->routePrefix() . '.pengajuan-surat.index')
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
        $surat->status = PengajuanSurat::STATUS_DISETUJUI;
        $surat->save();

        return redirect()->route($this->routePrefix() . '.pengajuan-surat.index')
            ->with('success', 'Pengajuan surat berhasil disetujui.');
    }

    /**
     * Admin menolak pengajuan
     */
    public function tolak($id)
    {
        $surat = PengajuanSurat::findOrFail($id);
        $surat->status = PengajuanSurat::STATUS_DITOLAK;
        $surat->save();

        return redirect()->route($this->routePrefix() . '.pengajuan-surat.index')
            ->with('success', 'Pengajuan surat berhasil ditolak.');
    }
}
