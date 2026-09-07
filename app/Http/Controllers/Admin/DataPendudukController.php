<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\PendudukImport;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DataPendudukController extends Controller
{
    public function index(Request $request)
    {
        $query = Penduduk::query();

        if ($request->filled('status_filter')) {
            if ($request->status_filter === '1') {
                $query->where('is_active', '>', 0);
            } elseif ($request->status_filter === '0') {
                $query->where('is_active', '<=', 0);
            }
        }

        $penduduk = $query->paginate(20)->withQueryString();

        return view('admin.data-penduduk.index', compact('penduduk'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048',
        ]);

        try {
            $import = new PendudukImport();
            Excel::import($import, $request->file('file'));

            $message = 'Data penduduk berhasil diimpor. Data baru: ' . $import->importedCount() . '.';

            $duplicateMessages = [];
            if ($import->skippedExistingNikCount() > 0) {
                $duplicateMessages[] = $import->skippedExistingNikCount() . ' NIK sudah ada di database';
            }
            if ($import->skippedDuplicateFileNikCount() > 0) {
                $duplicateMessages[] = $import->skippedDuplicateFileNikCount() . ' NIK dobel di file Excel';
            }

            if ($duplicateMessages !== []) {
                $message .= ' Dilewati: ' . implode(', ', $duplicateMessages) . '.';
            }

            return redirect()->back()
                ->with('success', $message)
                ->with('import_duplicate_summary', [
                    'existing_count' => $import->skippedExistingNikCount(),
                    'file_duplicate_count' => $import->skippedDuplicateFileNikCount(),
                    'existing_niks' => array_slice($import->skippedExistingNiks(), 0, 10),
                    'file_duplicate_niks' => array_slice($import->skippedDuplicateFileNiks(), 0, 10),
                ]);
        } catch (\Exception $e) {
            \Log::error('Import penduduk gagal', [
                'message' => $e->getMessage(),
            ]);

            return redirect()->back()->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        Penduduk::findOrFail($id);

        return redirect()->route('admin.data-penduduk.index')
            ->with('info', 'Fitur edit data penduduk belum tersedia.');
    }

    public function toggleStatus(Request $request, $id)
    {
        $penduduk = Penduduk::findOrFail($id);
        $newStatus = !$penduduk->is_active;

        $penduduk->update([
            'is_active' => $newStatus,
            'keterangan_nonaktif' => $newStatus
                ? null
                : trim((string) $request->input('keterangan_nonaktif', 'Dinonaktifkan oleh admin.')),
        ]);

        return redirect()->back()->with('success', 'Status penduduk berhasil diubah.');
    }
}
