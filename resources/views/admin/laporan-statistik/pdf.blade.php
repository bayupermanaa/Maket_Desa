<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Statistik Desa Maket</title>
    <style>
        body { font-family: Arial, sans-serif; color: #111827; font-size: 12px; }
        h1 { margin: 0 0 6px; font-size: 20px; }
        p { margin: 0 0 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        th, td { border: 1px solid #d1d5db; padding: 6px; text-align: left; }
        th { background: #f3f4f6; }
    </style>
</head>
<body>
    <h1>Laporan & Statistik Desa Maket</h1>
    <p>Periode: {{ $periodeLabel }}</p>

    <table>
        <tr><th>Ringkasan</th><th>Nilai</th></tr>
        <tr><td>Total Penduduk</td><td>{{ number_format($totalPenduduk) }}</td></tr>
        <tr><td>Penduduk Aktif</td><td>{{ number_format($pendudukAktif) }}</td></tr>
        <tr><td>Penduduk Nonaktif</td><td>{{ number_format($pendudukNonaktif) }}</td></tr>
        <tr><td>Penduduk Laki-laki</td><td>{{ number_format($pendudukLaki) }}</td></tr>
        <tr><td>Penduduk Perempuan</td><td>{{ number_format($pendudukPerempuan) }}</td></tr>
        <tr><td>Total Pendapatan</td><td>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td></tr>
        <tr><td>Total Belanja</td><td>Rp {{ number_format($totalBelanja, 0, ',', '.') }}</td></tr>
        <tr><td>Saldo</td><td>Rp {{ number_format($saldo, 0, ',', '.') }}</td></tr>
    </table>

    <table>
        <tr><th>Status Pengajuan Surat</th><th>Total</th></tr>
        @forelse($suratByStatus as $status => $total)
            <tr><td>{{ $status }}</td><td>{{ number_format($total) }}</td></tr>
        @empty
            <tr><td colspan="2">Belum ada data.</td></tr>
        @endforelse
    </table>

    <table>
        <tr><th>Status Pengaduan</th><th>Total</th></tr>
        @forelse($pengaduanByStatus as $status => $total)
            <tr><td>{{ $status }}</td><td>{{ number_format($total) }}</td></tr>
        @empty
            <tr><td colspan="2">Belum ada data.</td></tr>
        @endforelse
    </table>

    <table>
        <tr><th>Bulan</th><th>Pengajuan Surat</th><th>Pengaduan</th></tr>
        @foreach($bulanLabels as $index => $label)
            <tr>
                <td>{{ $label }}</td>
                <td>{{ $suratBulanan[$index] ?? 0 }}</td>
                <td>{{ $pengaduanBulanan[$index] ?? 0 }}</td>
            </tr>
        @endforeach
    </table>

    <script>
        window.print();
    </script>
</body>
</html>
