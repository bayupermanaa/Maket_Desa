<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanSurat extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_surats';

    protected $fillable = [
        'nama',
        'nik',
        'jenis_surat',
        'keperluan',
        'no_hp',
        'alamat',
        'status',        // Menunggu | Disetujui | Ditolak
        'keterangan',    // catatan admin
        'file_lampiran', // upload berkas masyarakat
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ADMIN MENYETUJUI SURAT
public function setujui($id)
{
    $surat = PengajuanSurat::findOrFail($id);
    $surat->update([
        'status' => 'Disetujui'
    ]);

    return back()->with('success', 'Pengajuan berhasil disetujui');
}

// ADMIN MENOLAK SURAT
public function tolak($id)
{
    $surat = PengajuanSurat::findOrFail($id);
    $surat->update([
        'status' => 'Ditolak'
    ]);

    return back()->with('success', 'Pengajuan berhasil ditolak');
}
}