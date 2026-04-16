<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
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
        $pengaduan = Pengaduan::with('user')  // relasi ke tabel users (pelapor)
            ->select('id', 'nomor', 'judul', 'status', 'created_at', 'user_id')
            ->latest()
            ->get();

        $data = $pengaduan->map(function ($item) {
            return [
                'id'           => $item->id,
                'tanggal'      => $item->created_at->format('d M Y'),
                'nomor'        => $item->nomor,
                'nama_pelapor' => $item->user ? $item->user->name : 'Tidak Diketahui',
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
        $pengaduan = Pengaduan::with('user', 'tindakLanjuts')->findOrFail($id);

        return response()->json([
            'id'           => $pengaduan->id,
            'nomor'        => $pengaduan->nomor,
            'judul'        => $pengaduan->judul,
            'deskripsi'    => $pengaduan->deskripsi,
            'status'       => $pengaduan->status,
            'tanggal'      => $pengaduan->created_at->format('d M Y H:i'),
            'nama_pelapor' => $pengaduan->user ? $pengaduan->user->name : 'Tidak Diketahui',
            'foto_bukti'   => $pengaduan->foto_bukti ? json_decode($pengaduan->foto_bukti) : [],
            'catatan_admin'=> $pengaduan->catatan_admin,
            'timeline'     => $pengaduan->tindakLanjuts // jika ada tabel tindak lanjut
        ]);
    }

    /**
     * Update status & catatan pengaduan
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status'  => 'required|in:baru,sedang_diproses,selesai,ditolak',
            'catatan' => 'nullable|string',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->status = $request->status;
        $pengaduan->catatan_admin = $request->catatan;
        $pengaduan->save();

        // Simpan riwayat tindak lanjut (opsional)
        // $pengaduan->tindakLanjuts()->create([...]);

        return response()->json([
            'success' => true,
            'message' => 'Pengaduan berhasil diperbarui.'
        ]);
    }
}