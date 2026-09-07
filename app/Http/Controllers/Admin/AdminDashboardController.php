<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use App\Models\PengajuanSurat;
use App\Models\Pengaduan;
use App\Models\Keuangan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.admin', $this->dashboardData());
    }

    public function kepala()
    {
        $data = $this->dashboardData();

        $data['suratMenungguVerifikasi'] = PengajuanSurat::where('status', PengajuanSurat::STATUS_DIAJUKAN_KE_KEPALA)->count();
        $data['suratSudahAccKepala'] = PengajuanSurat::where('status', PengajuanSurat::STATUS_DISETUJUI_KEPALA)->count();
        $data['pengaduanMenungguVerifikasi'] = Pengaduan::where('status', Pengaduan::STATUS_DIAJUKAN_KE_KEPALA)->count();
        $data['pengaduanSudahAccKepala'] = Pengaduan::where('status', Pengaduan::STATUS_DISETUJUI_KEPALA)->count();

        $data['suratUntukDiverifikasi'] = PengajuanSurat::where('status', PengajuanSurat::STATUS_DIAJUKAN_KE_KEPALA)
            ->latest()
            ->take(5)
            ->get();

        $data['pengaduanUntukDiverifikasi'] = Pengaduan::where('status', Pengaduan::STATUS_DIAJUKAN_KE_KEPALA)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.kepala', $data);
    }

    private function dashboardData(): array
    {
        // Data statistik utama
        $totalPenduduk       = Penduduk::count();
        $totalPengajuanSurat = PengajuanSurat::count();
        $pengaduanAktif      = Pengaduan::whereIn('status', [
                                            Pengaduan::STATUS_BARU,
                                            Pengaduan::STATUS_DIPROSES,
                                            'diproses',
                                        ])
                                       ->count();
        $pengaduanBaru = Pengaduan::where('status', Pengaduan::STATUS_BARU)->count();
        $pengaduanBelumDitindaklanjuti = Pengaduan::where('status', Pengaduan::STATUS_BARU)
            ->whereDoesntHave('logs', function ($query) {
                $query->where('dibuat_oleh', 'Admin');
            })
            ->count();
        $pengaduanSelesaiBulanIni = Pengaduan::where('status', Pengaduan::STATUS_SELESAI)
            ->whereBetween('updated_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->count();
        $totalPengaduanBulanIni = Pengaduan::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count();
        $persentaseSelesaiBulanIni = $totalPengaduanBulanIni > 0
            ? round(($pengaduanSelesaiBulanIni / $totalPengaduanBulanIni) * 100)
            : 0;

        // ==================== RINGKASAN KEUANGAN DESA ====================
        $total_pendapatan = Keuangan::where('jenis', 'pendapatan')->sum('jumlah');
        $total_belanja    = Keuangan::where('jenis', 'belanja')->sum('jumlah');
        $saldo            = $total_pendapatan - $total_belanja;

        // Dana Desa ditampilkan dari total pendapatan aktual
        $danaDesa = $total_pendapatan;

        // ==================== TREND PENGAJUAN SURAT 7 HARI TERAKHIR ====================
        $startDate = Carbon::now()->subDays(6)->startOfDay();

        $tren = PengajuanSurat::where('created_at', '>=', $startDate)
            ->select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('COUNT(*) as jumlah')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $hariLabels = [];
        $dataPengajuan = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $hariLabels[] = $date->isoFormat('dddd');   // Senin, Selasa, Rabu, dst
            $jumlah = $tren->firstWhere('tanggal', $date->toDateString())?->jumlah ?? 0;
            $dataPengajuan[] = $jumlah;
        }

        // Aktivitas Terbaru
        $aktivitasTerbaru = $this->getAktivitasTerbaru();

        return [
            'totalPenduduk'       => $totalPenduduk,
            'totalPengajuanSurat' => $totalPengajuanSurat,
            'pengaduanAktif'      => $pengaduanAktif,
            'danaDesa'            => $danaDesa,
            'hariLabels'          => $hariLabels,
            'dataPengajuan'       => $dataPengajuan,
            'aktivitasTerbaru'    => $aktivitasTerbaru,
            'pengaduanBaru'       => $pengaduanBaru,
            'pengaduanBelumDitindaklanjuti' => $pengaduanBelumDitindaklanjuti,
            'pengaduanSelesaiBulanIni' => $pengaduanSelesaiBulanIni,
            'totalPengaduanBulanIni' => $totalPengaduanBulanIni,
            'persentaseSelesaiBulanIni' => $persentaseSelesaiBulanIni,

            // Data Keuangan
            'total_pendapatan'    => $total_pendapatan,
            'total_belanja'       => $total_belanja,
            'saldo'               => $saldo,
        ];
    }

    /**
     * Ambil 5 aktivitas terbaru (Pengajuan Surat + Pengaduan)
     */
    private function getAktivitasTerbaru()
    {
        $list = collect();

        // 1. Pengajuan Surat Terbaru
        $surats = PengajuanSurat::latest()
                    ->limit(3)
                    ->get();

        foreach ($surats as $s) {
            $status = strtolower($s->status ?? 'diproses');
            $list->push([
                'type'   => 'surat',
                'judul'  => 'Surat ' . ($s->jenis_surat ?? 'Keterangan'),
                'nama'   => $s->nama ?? 'Warga Desa',
                'waktu'  => $s->created_at?->diffForHumans() ?? 'baru saja',
                'created_at' => $s->created_at,   // untuk sorting akurat
                'status' => in_array($status, ['selesai', 'disetujui', 'approved', 'selesai']) 
                            ? 'selesai' 
                            : 'diproses',
            ]);
        }

        // 2. Pengaduan Terbaru
        $pengaduans = Pengaduan::latest()
                       ->limit(3)
                       ->get();

        foreach ($pengaduans as $p) {
            $list->push([
                'type'   => 'pengaduan',
                'judul'  => 'Pengaduan: ' . Str::limit($p->judul ?? 'Tidak ada judul', 40),
                'nama'   => $p->nama_pelapor ?? 'Warga',
                'waktu'  => $p->created_at?->diffForHumans() ?? 'baru saja',
                'created_at' => $p->created_at,
                'status' => in_array(strtolower($p->status ?? ''), ['selesai'], true)
                            ? 'selesai'
                            : 'diproses',
            ]);
        }

        // Urutkan berdasarkan waktu created_at (paling akurat)
        return $list->sortByDesc('created_at')
                    ->take(5)
                    ->values();   // reset key
    }
}
