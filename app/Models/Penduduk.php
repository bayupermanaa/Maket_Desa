<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    use HasFactory;

    protected $table = 'penduduks';

    protected $fillable = [
        'rw','rt','dusun','alamat','kode_keluarga','nama_kepala_keluarga','no',
        'nik','nama','nama_anggota','jk','jenis_kelamin','hubungan','tempat_lahir','tgl_lahir',
        'usia','status','agama','gol_darah','kewarganegaraan','suku','pendidikan','pekerjaan','is_active'
    ];

    protected $casts = [
        'tgl_lahir' => 'date',
        'usia' => 'integer',
        'no' => 'integer',
    ];

    private function cleanText(?string $value): string
    {
        $text = preg_replace('/[^\PC\s]/u', '', (string) $value) ?? '';
        return trim(preg_replace('/\s+/', ' ', $text) ?? '');
    }

    public function getNikAttribute($value): ?string
    {
        $current = preg_replace('/\D/', '', (string) $value) ?? '';
        if (strlen($current) >= 16) {
            return substr($current, -16);
        }

        $fromKk = preg_replace('/\D/', '', (string) ($this->attributes['nama_kepala_keluarga'] ?? '')) ?? '';
        if (strlen($fromKk) === 16) {
            return $fromKk;
        }

        return $current !== '' ? $current : null;
    }

    public function getNamaAnggotaAttribute($value): ?string
    {
        $name = $this->cleanText((string) $value);
        if ($name !== '' && $name !== '-') {
            return $name;
        }

        $fromNama = $this->cleanText((string) ($this->attributes['nama'] ?? ''));
        $fromNama = preg_replace('/^\d+/', '', $fromNama) ?? $fromNama;
        $fromNama = trim($fromNama);

        return $fromNama !== '' ? $fromNama : null;
    }

    public function getJenisKelaminAttribute($value): ?string
    {
        $jk = strtolower($this->cleanText((string) $value));
        if ($jk === '' || $jk === '-') {
            $jk = strtolower($this->cleanText((string) ($this->attributes['jk'] ?? '')));
        }

        if (str_contains($jk, 'perem') || $jk === 'p') {
            return 'Perempuan';
        }

        if (str_contains($jk, 'laki') || $jk === 'l') {
            return 'Laki-laki';
        }

        return null;
    }

    public function getUsiaAttribute($value): ?int
    {
        $age = (int) $value;
        if ($age < 0 || $age > 130) {
            return null;
        }
        return $age;
    }

    public function getIsActiveAttribute($value): bool
    {
        return (int) $value > 0;
    }

    public function setTanggalLahirAttribute($value): void
    {
        $this->attributes['tgl_lahir'] = $value;
    }

    public function getTanggalLahirAttribute()
    {
        return $this->attributes['tgl_lahir'] ?? null;
    }

    public function getTglLahirAttribute($value): ?string
    {
        if (empty($value)) {
            return null;
        }

        $raw = (string) $value;
        if (str_starts_with($raw, '0000-00-00')) {
            return null;
        }

        try {
            $date = Carbon::parse($raw);
            if ((int) $date->format('Y') < 1900) {
                return null;
            }
            return $date->format('Y-m-d');
        } catch (\Throwable $e) {
            return null;
        }
    }

    public function pengajuanSurats(): HasMany
    {
        return $this->hasMany(PengajuanSurat::class, 'nik', 'nik');
    }
}
