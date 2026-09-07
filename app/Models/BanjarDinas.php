<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BanjarDinas extends Model
{
    use HasFactory;

    protected $table = 'banjar_dinas';

    protected $fillable = [
        'nama',
        'geojson',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function markers(): HasMany
    {
        return $this->hasMany(BanjarMarker::class, 'banjar_dinas_id');
    }
}
