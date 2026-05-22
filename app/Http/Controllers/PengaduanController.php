<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\PengaduanLog;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function showMasyarakat($id)
    {
        if (!auth()->check() || auth()->user()->role !== 'masyarakat') {
            abort(403);
        }

        $user = auth()->user();

        $pengaduan = Pengaduan::with('logs')
            ->where('id', $id)
            ->where(function ($query) use ($user) {
                if (!empty($user->nik)) {
                    $query->where('nik', $user->nik);
                } else {
                    $query->where('nama_pelapor', $user->name);
                }
            })
            ->firstOrFail();

        $hasAdminUpdate = $pengaduan->logs->contains(function ($log) {
            return ($log->dibuat_oleh ?? '') === 'Admin';
        });

        if ($hasAdminUpdate) {
            $pengaduan->warga_last_seen_log_at = now();
            $pengaduan->save();
        }

        return response()->json([
            'id' => $pengaduan->id,
            'nomor_tiket' => $pengaduan->nomor_tiket ?: ('PGD-' . str_pad((string) $pengaduan->id, 5, '0', STR_PAD_LEFT)),
            'judul' => $pengaduan->judul,
            'isi' => $pengaduan->isi,
            'kategori' => $pengaduan->kategori,
            'lokasi' => $pengaduan->lokasi,
            'status' => $pengaduan->status,
            'catatan_admin' => $pengaduan->catatan_admin,
            'foto_url' => $pengaduan->foto ? asset('storage/' . $pengaduan->foto) : null,
            'tanggal_pengaduan' => optional($pengaduan->tanggal_pengaduan)->format('d M Y'),
            'timeline' => $pengaduan->logs->map(function ($log) {
                return [
                    'status' => $log->status,
                    'catatan' => $log->catatan,
                    'foto_bukti_url' => $log->foto_bukti ? asset('storage/' . $log->foto_bukti) : null,
                    'dibuat_oleh' => $log->dibuat_oleh,
                    'waktu' => optional($log->created_at)->format('d M Y H:i'),
                ];
            })->values(),
        ]);
    }

    public function storeMasyarakat(Request $request)
    {
        if (!auth()->check() || auth()->user()->role !== 'masyarakat') {
            abort(403);
        }

        $validated = $request->validateWithBag('pengaduan', [
            'nama_pelapor' => 'required|string|max:255',
            'nik' => 'required|string|max:20',
            'no_hp' => 'nullable|string|max:20',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori' => 'nullable|string|max:100',
            'lokasi' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('pengaduan-foto', 'public');
        }

        $pengaduan = Pengaduan::create([
            'nama_pelapor' => $validated['nama_pelapor'],
            'nik' => $validated['nik'],
            'no_hp' => $validated['no_hp'] ?? null,
            'judul' => $validated['judul'],
            'isi' => $validated['isi'],
            'kategori' => $validated['kategori'] ?? null,
            'lokasi' => $validated['lokasi'] ?? null,
            'foto' => $fotoPath,
            'status' => Pengaduan::STATUS_BARU,
            'tanggal_pengaduan' => now()->toDateString(),
        ]);

        PengaduanLog::create([
            'pengaduan_id' => $pengaduan->id,
            'status' => Pengaduan::STATUS_BARU,
            'catatan' => 'Pengaduan dikirim oleh masyarakat.',
            'dibuat_oleh' => 'Masyarakat',
        ]);

        return redirect()
            ->route('dashboard.masyarakat', ['tab' => 'pengaduan'])
            ->with('success_pengaduan', 'Pengaduan berhasil dikirim. Terima kasih atas laporan Anda.');
    }
}
