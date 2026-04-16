<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    use HasFactory;

    protected $table = 'penduduks';

    protected $fillable = [
        'rw','rt','dusun','alamat','kode_keluarga','nama_kepala_keluarga',
        'nik','nama','jk','hubungan','tempat_lahir','tgl_lahir','usia',
        'status','agama','gol_darah','kewarganegaraan','suku','pendidikan',
        'pekerjaan','is_active'
    ];
}