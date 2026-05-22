<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penduduk;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PendudukImport;

class DataPendudukController extends Controller
{
    // Tampilkan data penduduk dengan pagination
    public function index(Request $request)
    {
        $query = Penduduk::query();

        // Filter aktif/nonaktif
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

    // Import Excel
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048',
        ]);

        try {
            Excel::import(new PendudukImport, $request->file('file'));
            return redirect()->back()->with('success', 'Data penduduk berhasil diimpor!');
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

    // Toggle status aktif/nonaktif
    public function toggleStatus($id)
    {
        $penduduk = Penduduk::findOrFail($id);
        $penduduk->update([
            'is_active' => !$penduduk->is_active, // toggle 1 ↔ 0
        ]);

        return redirect()->back()->with('success', 'Status penduduk berhasil diubah.');
    }
}
