<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengaduan Masyarakat</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111827; }
        h1 { font-size: 18px; margin-bottom: 6px; }
        p { margin: 0 0 10px; color: #4b5563; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #d1d5db; padding: 8px; text-align: left; vertical-align: top; }
        th { background: #f3f4f6; }
    </style>
</head>
<body>
    <h1>Laporan Pengaduan Masyarakat</h1>
    <p>Tanggal export: {{ now()->format('d-m-Y H:i:s') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No. Tiket</th>
                <th>Tanggal</th>
                <th>Nama Pelapor</th>
                <th>Judul</th>
                <th>Status</th>
                <th>Catatan Admin</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengaduans as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nomor_tiket ?: ('PGD-' . str_pad((string) $item->id, 5, '0', STR_PAD_LEFT)) }}</td>
                    <td>{{ optional($item->tanggal_pengaduan)->format('d-m-Y') ?: optional($item->created_at)->format('d-m-Y') }}</td>
                    <td>{{ $item->nama_pelapor }}</td>
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->catatan_admin ?: '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Belum ada data pengaduan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>

