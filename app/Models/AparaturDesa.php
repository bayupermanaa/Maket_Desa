<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AparaturDesa extends Model
{
    protected $fillable = [
        'nama',
        'jabatan',
        'foto',
        'deskripsi',
        'urutan',
        'is_active',
    ];
}