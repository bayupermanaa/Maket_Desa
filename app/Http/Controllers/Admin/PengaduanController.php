<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PengaduanExport;
use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\PengaduanLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PengaduanController extends Controller
{
    public function exportExcel()
    {
        $filename = 'laporan-pengaduan-' . now()->format('Ymd-His') . '.xlsx';
        return Excel::download(new PengaduanExport(), $filename);
    }

    public function exportPdf()
    {
        $pengaduans = Pengaduan::latest()->get();
        $filename = 'laporan-pengaduan-' . now()->format('Ymd-His') . '.pdf';

        $pdf = Pdf::loadView('admin.pengaduan.pdf', compact('pengaduans'))
            ->setPaper('a4', 'landscape');

        return $pdf->download($filename);
    }

    /**
     * Tampilkan halaman Pengelolaan Pengaduan
     */
    public function index()
    {
        return view('admin.pengaduan.index');
    }

    /**
     * Ambil data pengaduan untuk tabel (dipanggil via AJAX/Fetch)
     */
    public function data()
    {
        $pengaduan = Pengaduan::with('user:id,name,nik')
            ->select('id', 'judul', 'status', 'created_at', 'nama_pelapor', 'nik', 'nomor_tiket')
            ->latest()
            ->get();

        $data = $pengaduan->map(function ($item) {
            return [
                'id'           => $item->id,
                'tanggal'      => $item->created_at->format('d M Y'),
                'nomor'        => $item->nomor_tiket ?: ('PGD-' . str_pad((string) $item->id, 5, '0', STR_PAD_LEFT)),
                'nama_pelapor' => $item->user?->name ?? $item->nama_pelapor ?? 'Tidak Diketahui',
                'judul'        => $item->judul,
                'status'       => $item->status,
            ];
        });

        return response()->json($data);
    }

    /**
     * Ambil detail 1 pengaduan (untuk panel detail)
     */
    public function show($id)
    {
        $pengaduan = Pengaduan::with(['user:id,name,nik', 'logs'])->findOrFail($id);

        return response()->json([
            'id'           => $pengaduan->id,
            'nomor'        => $pengaduan->nomor_tiket ?: ('PGD-' . str_pad((string) $pengaduan->id, 5, '0', STR_PAD_LEFT)),
            'judul'        => $pengaduan->judul,
            'deskripsi'    => $pengaduan->isi,
            'status'       => $pengaduan->status,
            'tanggal'      => $pengaduan->created_at->format('d M Y H:i'),
            'nama_pelapor' => $pengaduan->user?->name ?? $pengaduan->nama_pelapor ?? 'Tidak Diketahui',
            'foto_bukti'   => $pengaduan->foto ? [$pengaduan->foto] : [],
            'catatan_admin'=> $pengaduan->catatan_admin,
            'timeline'     => $pengaduan->logs->map(function ($log) {
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

    /**
     * Update status & catatan pengaduan
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status'  => 'required|in:baru,sedang_diproses,diproses,selesai,ditolak',
            'catatan' => 'nullable|string',
            'foto_bukti' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);
        $statusLama = $pengaduan->status;
        $catatanBaru = trim((string) $request->catatan);

        $pengaduan->status = $request->status;
        $pengaduan->catatan_admin = $catatanBaru !== '' ? $catatanBaru : null;
        $pengaduan->save();

        $fotoBuktiPath = null;
        if ($request->hasFile('foto_bukti')) {
            $fotoBuktiPath = $request->file('foto_bukti')->store('pengaduan-bukti-admin', 'public');
        }

        if ($statusLama !== $pengaduan->status || $catatanBaru !== '') {
            PengaduanLog::create([
                'pengaduan_id' => $pengaduan->id,
                'status' => $pengaduan->status,
                'catatan' => $catatanBaru !== '' ? $catatanBaru : 'Status pengaduan diperbarui.',
                'foto_bukti' => $fotoBuktiPath,
                'dibuat_oleh' => 'Admin',
            ]);
        } elseif ($fotoBuktiPath) {
            PengaduanLog::create([
                'pengaduan_id' => $pengaduan->id,
                'status' => $pengaduan->status,
                'catatan' => 'Admin mengunggah bukti tindak lanjut.',
                'foto_bukti' => $fotoBuktiPath,
                'dibuat_oleh' => 'Admin',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pengaduan berhasil diperbarui.'
        ]);
    }
}
