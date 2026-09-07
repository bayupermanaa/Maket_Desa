<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    public const STATUS_BARU = 'baru';
    public const STATUS_DIPROSES = 'sedang_diproses';
    public const STATUS_DIAJUKAN_KE_KEPALA = 'diajukan_ke_kepala_desa';
    public const STATUS_DISETUJUI_KEPALA = 'disetujui_kepala_desa';
    public const STATUS_DITOLAK_KEPALA = 'ditolak_kepala_desa';
    public const STATUS_SELESAI = 'selesai';
    public const STATUS_DITOLAK = 'ditolak';

    protected $table = 'pengaduans';   // nama tabel di database

    protected $fillable = [
        'nomor_tiket',
        'nama_pelapor',
        'nik',
        'no_hp',
        'judul',
        'isi',
        'kategori',
        'lokasi',
        'status',
        'catatan_admin',
        'warga_last_seen_log_at',
        'foto',           // kalau ada lampiran foto
        'tanggal_pengaduan',
    ];

    protected $casts = [
        'tanggal_pengaduan' => 'date',
        'warga_last_seen_log_at' => 'datetime',
    ];

    // Default status saat dibuat
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pengaduan) {
            if (empty($pengaduan->status)) {
                $pengaduan->status = self::STATUS_BARU;
            }
            if (empty($pengaduan->tanggal_pengaduan)) {
                $pengaduan->tanggal_pengaduan = now();
            }
            if (empty($pengaduan->nomor_tiket)) {
                $pengaduan->nomor_tiket = self::generateNomorTiket();
            }
        });
    }

    private static function generateNomorTiket(): string
    {
        do {
            $nomor = 'PGD-' . now()->format('Ymd') . '-' . str_pad((string) random_int(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (self::where('nomor_tiket', $nomor)->exists());

        return $nomor;
    }

    // Helper untuk status
    public function isBaru()
    {
        return $this->status === self::STATUS_BARU;
    }

    public function isDiproses()
    {
        return in_array($this->status, [self::STATUS_DIPROSES, 'diproses'], true);
    }

    public function isSelesai()
    {
        return $this->status === self::STATUS_SELESAI;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nik', 'nik');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(PengaduanLog::class)->latest();
    }
}
