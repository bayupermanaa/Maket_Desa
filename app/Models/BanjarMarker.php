<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BanjarMarker extends Model
{
    use HasFactory;

    protected $table = 'banjar_markers';

    protected $fillable = [
        'banjar_dinas_id',
        'nama',
        'latitude',
        'longitude',
        'icon_url',
        'alamat',
        'is_active',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'is_active' => 'boolean',
    ];

    public function banjarDinas(): BelongsTo
    {
        return $this->belongsTo(BanjarDinas::class, 'banjar_dinas_id');
    }
}
