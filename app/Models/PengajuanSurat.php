<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class PengajuanSurat extends Model
{
    use HasFactory;

    public const STATUS_MENUNGGU = 'Menunggu';
    public const STATUS_DIPROSES = 'Diproses';
    public const STATUS_PERLU_PERBAIKAN = 'Perlu Perbaikan';
    public const STATUS_DIAJUKAN_KE_KEPALA = 'Diajukan ke Kepala Desa';
    public const STATUS_DISETUJUI_KEPALA = 'Disetujui Kepala Desa';
    public const STATUS_DITOLAK_KEPALA = 'Ditolak Kepala Desa';
    public const STATUS_DISETUJUI = 'Disetujui';
    public const STATUS_DITOLAK = 'Ditolak';

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
        'detail_surat',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'detail_surat' => 'array',
    ];

    public function penduduk(): BelongsTo
    {
        return $this->belongsTo(Penduduk::class, 'nik', 'nik');
    }
}
