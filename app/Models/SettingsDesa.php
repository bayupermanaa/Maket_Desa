<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingsDesa extends Model
{
    protected $table = 'settings_desa';

  protected $fillable = [
    'nama_desa',
    'kecamatan',
    'kabupaten',
    'provinsi',
    'luas_wilayah',
    'kepadatan',
    'jumlah_penduduk',
    'video_desa',
    'nama_kepala_desa',      
    'foto_kepala_desa',
    'jumlah_banjar',
    'penduduk_baru_tahun_ini'
];
}