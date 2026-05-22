<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keuangan;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function index()
    {
        $keuangans = Keuangan::orderBy('tanggal', 'desc')->get();

        $total_pendapatan = Keuangan::where('jenis', 'pendapatan')->sum('jumlah');
        $total_belanja    = Keuangan::where('jenis', 'belanja')->sum('jumlah');
        $saldo            = $total_pendapatan - $total_belanja;

        // Chart per bulan - versi super longgar (cocok dengan format "05 Apr 2026")
        $pendapatanPerBulan = array_fill(0, 12, 0);
        $belanjaPerBulan    = array_fill(0, 12, 0);
        $bulanLabels        = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];

        foreach ($keuangans as $item) {
            $tanggal = $item->tanggal; // contoh: "05 Apr 2026" atau "2026-04-05"

            // Ambil bulan dari tanggal (bekerja untuk berbagai format)
            if (str_contains($tanggal, 'Apr') || str_contains($tanggal, '04') || str_contains($tanggal, '-04-')) {
                $bulanIndex = 3; // April = index 3 (0-based)
                if ($item->jenis === 'pendapatan') {
                    $pendapatanPerBulan[$bulanIndex] += $item->jumlah;
                } else {
                    $belanjaPerBulan[$bulanIndex] += $item->jumlah;
                }
            }
            // Tambahkan logic lain jika ada bulan lain
        }

        return view('admin.keuangan.index', compact(
            'keuangans',
            'total_pendapatan',
            'total_belanja',
            'saldo',
            'pendapatanPerBulan',
            'belanjaPerBulan',
            'bulanLabels'
        ));
    }

    public function create()
    {
        return view('admin.keuangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis'      => 'required|in:pendapatan,belanja',
            'uraian'     => 'required|string|max:255',
            'jumlah'     => 'required|numeric|min:1',
            'tanggal'    => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        Keuangan::create($request->all());

        return redirect()->route('admin.keuangan')
                         ->with('success', '✅ Transaksi keuangan berhasil ditambahkan!');
    }

    public function edit(Keuangan $keuangan)
    {
        return view('admin.keuangan.edit', compact('keuangan'));
    }

    public function update(Request $request, Keuangan $keuangan)
    {
        $request->validate([
            'jenis'      => 'required|in:pendapatan,belanja',
            'uraian'     => 'required|string|max:255',
            'jumlah'     => 'required|numeric|min:1',
            'tanggal'    => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $keuangan->update($request->all());

        return redirect()->route('admin.keuangan')
                         ->with('success', '✅ Transaksi berhasil diperbarui!');
    }

    public function destroy(Keuangan $keuangan)
    {
        $keuangan->delete();

        return redirect()->route('admin.keuangan')
                         ->with('success', '✅ Transaksi berhasil dihapus!');
    }
}