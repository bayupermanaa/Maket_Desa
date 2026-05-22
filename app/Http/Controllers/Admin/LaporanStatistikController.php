<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LaporanStatistikExport;
use App\Http\Controllers\Controller;
use App\Models\Keuangan;
use App\Models\Penduduk;
use App\Models\Pengaduan;
use App\Models\PengajuanSurat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LaporanStatistikController extends Controller
{
    public function index(Request $request)
    {
        $reportData = $this->buildReportData($request);

        return view('admin.laporan-statistik.index', $reportData);
    }

    public function exportExcel(Request $request)
    {
        $reportData = $this->buildReportData($request);
        $filename = 'laporan-statistik-' . now()->format('Ymd-His') . '.xlsx';

        return Excel::download(new LaporanStatistikExport($reportData), $filename);
    }

    public function exportPdf(Request $request)
    {
        $reportData = $this->buildReportData($request);
        return response()
            ->view('admin.laporan-statistik.pdf', $reportData)
            ->header('Content-Type', 'text/html; charset=UTF-8');
    }

    private function buildReportData(Request $request): array
    {
        $dari = $request->query('dari');
        $sampai = $request->query('sampai');

        $tanggalDari = $dari ? Carbon::parse($dari)->startOfDay() : Carbon::now()->subMonths(5)->startOfMonth();
        $tanggalSampai = $sampai ? Carbon::parse($sampai)->endOfDay() : Carbon::now()->endOfDay();

        if ($tanggalDari->gt($tanggalSampai)) {
            [$tanggalDari, $tanggalSampai] = [$tanggalSampai->copy()->startOfDay(), $tanggalDari->copy()->endOfDay()];
        }

        $periodeLabel = $tanggalDari->translatedFormat('d M Y') . ' - ' . $tanggalSampai->translatedFormat('d M Y');

        $totalPenduduk = Penduduk::count();
        $pendudukAktif = Penduduk::where('is_active', true)->count();
        $pendudukNonaktif = Penduduk::where('is_active', false)->count();

        $pendudukLaki = Penduduk::where(function ($query) {
            $query->whereRaw('LOWER(jk) = ?', ['l'])
                ->orWhereRaw('LOWER(jk) = ?', ['laki-laki'])
                ->orWhereRaw('LOWER(jk) = ?', ['laki laki']);
        })->count();

        $pendudukPerempuan = Penduduk::where(function ($query) {
            $query->whereRaw('LOWER(jk) = ?', ['p'])
                ->orWhereRaw('LOWER(jk) = ?', ['perempuan']);
        })->count();

        $suratByStatus = PengajuanSurat::whereBetween('created_at', [$tanggalDari, $tanggalSampai])
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $pengaduanByStatus = Pengaduan::whereBetween('created_at', [$tanggalDari, $tanggalSampai])
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $totalPendapatan = Keuangan::where('jenis', 'pendapatan')
            ->whereBetween('tanggal', [$tanggalDari->toDateString(), $tanggalSampai->toDateString()])
            ->sum('jumlah');
        $totalBelanja = Keuangan::where('jenis', 'belanja')
            ->whereBetween('tanggal', [$tanggalDari->toDateString(), $tanggalSampai->toDateString()])
            ->sum('jumlah');
        $saldo = $totalPendapatan - $totalBelanja;

        $suratBulananRaw = PengajuanSurat::whereBetween('created_at', [$tanggalDari, $tanggalSampai])
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as ym"), DB::raw('COUNT(*) as total'))
            ->groupBy('ym')
            ->orderBy('ym')
            ->pluck('total', 'ym');

        $pengaduanBulananRaw = Pengaduan::whereBetween('created_at', [$tanggalDari, $tanggalSampai])
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as ym"), DB::raw('COUNT(*) as total'))
            ->groupBy('ym')
            ->orderBy('ym')
            ->pluck('total', 'ym');

        $bulanLabels = [];
        $suratBulanan = [];
        $pengaduanBulanan = [];

        $iterasi = $tanggalDari->copy()->startOfMonth();
        $akhirBulan = $tanggalSampai->copy()->startOfMonth();

        while ($iterasi->lte($akhirBulan)) {
            $date = $iterasi->copy();
            $key = $date->format('Y-m');
            $bulanLabels[] = $date->translatedFormat('M Y');
            $suratBulanan[] = (int) ($suratBulananRaw[$key] ?? 0);
            $pengaduanBulanan[] = (int) ($pengaduanBulananRaw[$key] ?? 0);
            $iterasi->addMonth();
        }

        return compact(
            'dari',
            'sampai',
            'periodeLabel',
            'totalPenduduk',
            'pendudukAktif',
            'pendudukNonaktif',
            'pendudukLaki',
            'pendudukPerempuan',
            'suratByStatus',
            'pengaduanByStatus',
            'totalPendapatan',
            'totalBelanja',
            'saldo',
            'bulanLabels',
            'suratBulanan',
            'pengaduanBulanan'
        );
    }
}
