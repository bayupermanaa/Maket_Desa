<?php

namespace App\Exports;

use App\Models\Pengaduan;
use Maatwebsite\Excel\Concerns\FromArray;

class PengaduanExport implements FromArray
{
    public function array(): array
    {
        $rows = [
            ['Laporan Pengaduan Masyarakat'],
            ['Tanggal Export', now()->format('d-m-Y H:i:s')],
            [''],
            ['No', 'No. Tiket', 'Tanggal', 'Nama Pelapor', 'Judul', 'Status', 'Catatan Admin'],
        ];

        $data = Pengaduan::latest()->get();

        foreach ($data as $index => $item) {
            $rows[] = [
                $index + 1,
                $item->nomor_tiket ?: ('PGD-' . str_pad((string) $item->id, 5, '0', STR_PAD_LEFT)),
                optional($item->tanggal_pengaduan)->format('d-m-Y') ?: optional($item->created_at)->format('d-m-Y'),
                $item->nama_pelapor,
                $item->judul,
                $item->status,
                $item->catatan_admin ?: '-',
            ];
        }

        return $rows;
    }
}

