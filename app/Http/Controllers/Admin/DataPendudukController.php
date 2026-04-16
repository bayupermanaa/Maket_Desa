<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class DataPendudukController extends Controller
{
    public function index()
    {
        $penduduk = Penduduk::orderBy('id','desc')->paginate(50);
        return view('admin.data-penduduk.index', compact('penduduk'));
    }

    public function toggleStatus($id)
    {
        $p = Penduduk::findOrFail($id);
        $p->is_active = !$p->is_active;
        $p->save();
        return redirect()->back()->with('success','Status penduduk berhasil diperbarui.');
    }

    // ==================== PREVIEW IMPORT ====================
    public function previewImport(Request $request)
    {
        $file = $request->file('file');
        $data = Excel::toArray([], $file)[0];

        $previewData = [];

        foreach ($data as $index => $row) {
            if ($index === 0) continue; // skip header

            // Bersihkan kutip dan karakter aneh
            $row = array_map(function($val) {
                return trim(str_replace(["'", '"', "\n", "\r"], '', $val ?? ''));
            }, $row);

            $previewData[] = [
                'row_number'           => $index,
                'rw'                   => $row[0] ?? null,
                'rt'                   => $row[1] ?? null,
                'dusun'                => $row[2] ?? null,
                'alamat'               => $row[3] ?? null,
                'kode_keluarga'        => $row[4] ?? null,
                'nama_kepala_keluarga' => $row[5] ?? null,
                'no'                   => $row[6] ?? null,
                'nik'                  => $row[7] ?? null,
                'nama'                 => $row[8] ?? null,
                'jk'                   => $row[9] ?? null,
                'hubungan'             => $row[10] ?? null,
                'tempat_lahir'         => $row[11] ?? null,
                'tgl_lahir'            => $this->parseTanggal($row[12] ?? null),
                'usia'                 => $row[13] ?? null,
                'status'               => $row[14] ?? null,
                'agama'                => $row[15] ?? null,
                'gol_darah'            => $row[16] ?? null,
                'kewarganegaraan'      => $row[17] ?? null,
                'suku'                 => $row[18] ?? null,
                'pendidikan'           => $row[19] ?? null,
                'pekerjaan'            => $row[20] ?? null,

                'valid' => true,
            ];
        }

        return view('admin.data-penduduk.preview', compact('previewData'));
    }

    // ==================== CONFIRM IMPORT ====================
    public function confirmImport(Request $request)
    {
        $rowsJson = $request->input('rows');

        if (empty($rowsJson)) {
            return redirect()->back()->with('error', 'Tidak ada data yang dikirim.');
        }

        $rows = json_decode($rowsJson, true);

        if (!is_array($rows)) {
            return redirect()->back()->with('error', 'Format data tidak valid.');
        }

        $successCount = 0;

        foreach ($rows as $row) {
            if (empty($row['nik']) || empty($row['nama'])) {
                continue;
            }

            try {
                Penduduk::create([
                    'rw'                   => $row['rw'],
                    'rt'                   => $row['rt'],
                    'dusun'                => $row['dusun'],
                    'alamat'               => $row['alamat'],
                    'kode_keluarga'        => $row['kode_keluarga'],
                    'nama_kepala_keluarga' => $row['nama_kepala_keluarga'],
                    'no'                   => $row['no'],
                    'nik'                  => $row['nik'],
                    'nama'                 => $row['nama'],
                    'jk'                   => $row['jk'],
                    'hubungan'             => $row['hubungan'],
                    'tempat_lahir'         => $row['tempat_lahir'],
                    'tgl_lahir'            => $row['tgl_lahir'],
                    'usia'                 => $row['usia'],
                    'status'               => $row['status'],
                    'agama'                => $row['agama'],
                    'gol_darah'            => $row['gol_darah'],
                    'kewarganegaraan'      => $row['kewarganegaraan'],
                    'suku'                 => $row['suku'],
                    'pendidikan'           => $row['pendidikan'],
                    'pekerjaan'            => $row['pekerjaan'],
                    'is_active'            => true,
                ]);

                $successCount++;
            } catch (\Exception $e) {
                continue; // skip data error
            }
        }

        return redirect()->route('admin.penduduk.index')
            ->with('success', "$successCount data penduduk berhasil diimport.");
    }

    // ==================== FUNGSI BANTU ====================
    private function parseTanggal($value)
    {
        if (empty($value)) return null;

        $value = trim($value);
        try {
            if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $value)) {
                return Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
            }
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}