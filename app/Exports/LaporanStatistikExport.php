<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class LaporanStatistikExport implements FromArray
{
    public function __construct(private readonly array $reportData)
    {
    }

    public function array(): array
    {
        $rows = [
            ['Laporan Statistik Desa Maket'],
            ['Periode', $this->reportData['periodeLabel']],
            [''],
            ['Ringkasan', 'Nilai'],
            ['Total Penduduk', $this->reportData['totalPenduduk']],
            ['Penduduk Aktif', $this->reportData['pendudukAktif']],
            ['Penduduk Nonaktif', $this->reportData['pendudukNonaktif']],
            ['Penduduk Laki-laki', $this->reportData['pendudukLaki']],
            ['Penduduk Perempuan', $this->reportData['pendudukPerempuan']],
            ['Total Pendapatan', $this->reportData['totalPendapatan']],
            ['Total Belanja', $this->reportData['totalBelanja']],
            ['Saldo', $this->reportData['saldo']],
            [''],
            ['Status Pengajuan Surat', 'Total'],
        ];

        foreach ($this->reportData['suratByStatus'] as $status => $total) {
            $rows[] = [$status, $total];
        }

        $rows[] = [''];
        $rows[] = ['Status Pengaduan', 'Total'];
        foreach ($this->reportData['pengaduanByStatus'] as $status => $total) {
            $rows[] = [$status, $total];
        }

        $rows[] = [''];
        $rows[] = ['Tren Bulanan', 'Pengajuan Surat', 'Pengaduan'];
        foreach ($this->reportData['bulanLabels'] as $index => $label) {
            $rows[] = [
                $label,
                $this->reportData['suratBulanan'][$index] ?? 0,
                $this->reportData['pengaduanBulanan'][$index] ?? 0,
            ];
        }

        return $rows;
    }
}
