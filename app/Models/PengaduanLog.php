<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengaduanLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengaduan_id',
        'status',
        'catatan',
        'foto_bukti',
        'dibuat_oleh',
    ];

    public function pengaduan(): BelongsTo
    {
        return $this->belongsTo(Pengaduan::class);
    }
}
