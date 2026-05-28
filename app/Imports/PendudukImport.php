<?php

namespace App\Imports;

use App\Models\Penduduk;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class PendudukImport implements ToCollection, WithStartRow
{
    public function startRow(): int
    {
        return 2; // row 1 adalah header
    }

    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            $r = $row->toArray();

            $dusun = (string) ($this->cleanText($r[2] ?? null) ?? '');
            $nik = $this->sanitizeNik($r[7] ?? null);
            $nama = (string) ($this->cleanText($r[8] ?? null) ?? '');

            if ($dusun === '' && $nik === null && $nama === '') {
                continue; // skip baris kosong
            }

            if ($dusun === '') {
                continue; // field wajib
            }

            $payload = [
                'rw' => $this->cleanText($r[0] ?? null) ?? '0',
                'rt' => $this->cleanText($r[1] ?? null) ?? '0',
                'dusun' => $dusun,
                'alamat' => $this->cleanText($r[3] ?? null),
                'kode_keluarga' => $this->cleanText($r[4] ?? null),
                'nama_kepala_keluarga' => $this->cleanText($r[5] ?? null),
                'no' => $this->normalizeNo($r[6] ?? null),
                'nik' => $nik,
                'nama' => $nama !== '' ? $nama : '-',
                'jk' => $this->normalizeJk($r[9] ?? null),
                'hubungan' => $this->cleanText($r[10] ?? null),
                'tempat_lahir' => $this->cleanText($r[11] ?? null),
                'tgl_lahir' => $this->parseTanggal($r[12] ?? null),
                'usia' => $this->normalizeUsia($r[13] ?? null),
                'status' => $this->cleanText($r[14] ?? null),
                'agama' => $this->cleanText($r[15] ?? null),
                'gol_darah' => $this->normalizeGolDarah($r[16] ?? null),
                'kewarganegaraan' => $this->cleanText($r[17] ?? null),
                'suku' => $this->cleanText($r[18] ?? null),
                'pendidikan' => $this->cleanText($r[19] ?? null),
                'pekerjaan' => $this->cleanText($r[20] ?? null),
                'is_active' => $this->normalizeActive($r[21] ?? null),
                'keterangan_nonaktif' => $this->inactiveNote($r[21] ?? null, $r[22] ?? null),
            ];

            if ($nik !== null) {
                Penduduk::updateOrCreate(
                    ['nik' => $nik],
                    $payload
                );
            } else {
                Penduduk::create($payload);
            }
        }
    }

    private function cleanText($value): ?string
    {
        $text = (string) $value;
        $text = str_replace(["\u{FFFD}", 'ï¿½', 'Â'], '', $text);
        $text = preg_replace('/[^\PC\s]/u', '', $text) ?? $text;
        $text = trim(preg_replace('/\s+/', ' ', $text) ?? $text);
        return $text === '' ? null : $text;
    }

    private function normalizeNo($value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        $digits = preg_replace('/\D/', '', (string) $value) ?? '';
        return $digits !== '' ? (int) $digits : null;
    }

    private function sanitizeNik($value): ?string
    {
        if ($value === null) {
            return null;
        }
        $digits = preg_replace('/\D/', '', (string)$value) ?? '';
        return $digits !== '' ? $digits : null;
    }

    private function normalizeJk($value): ?string
    {
        $v = strtolower(trim((string)$value));
        if ($v === 'l' || str_contains($v, 'laki')) {
            return 'L';
        }
        if ($v === 'p' || str_contains($v, 'perem')) {
            return 'P';
        }
        return null;
    }

    private function normalizeUsia($value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }
        $u = (int)$value;
        return ($u >= 0 && $u <= 130) ? $u : null;
    }

    private function normalizeGolDarah($value): ?string
    {
        $v = strtoupper(trim((string)$value));
        if ($v === '' || str_contains($v, 'TIDAK')) {
            return null;
        }
        if (in_array($v, ['A', 'B', 'AB', 'O'], true)) {
            return $v;
        }
        return substr($v, 0, 5);
    }

    private function normalizeActive($value): int
    {
        $v = strtolower(trim((string)$value));
        if ($v === '' || $v === '1' || $v === 'aktif' || $v === 'true' || $v === 'ya' || $v === 'y') {
            return 1;
        }
        return 0;
    }

    private function inactiveNote($activeValue, $noteValue): ?string
    {
        if ($this->normalizeActive($activeValue) === 1) {
            return null;
        }

        return $this->cleanText($noteValue) ?? 'Tidak aktif berdasarkan data import.';
    }

    private function parseTanggal($value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        try {
            if ($value instanceof DateTimeInterface) {
                return Carbon::instance($value)->format('Y-m-d');
            }

            if (is_numeric($value)) {
                return ExcelDate::excelToDateTimeObject($value)->format('Y-m-d');
            }

            $str = trim((string)$value);
            $formats = ['d/m/Y', 'd-m-Y', 'Y-m-d', 'Y/m/d', 'm/d/Y'];

            foreach ($formats as $format) {
                $parsed = Carbon::createFromFormat($format, $str);
                if ($parsed && $parsed->format($format) === $str) {
                    return $parsed->format('Y-m-d');
                }
            }

            return Carbon::parse($str)->format('Y-m-d');
        } catch (\Throwable $e) {
            return null;
        }
    }
}
