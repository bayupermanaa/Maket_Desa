<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AparaturDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AparaturDesaController extends Controller
{
    public function index()
    {
        $aparaturs = AparaturDesa::orderBy('urutan')->latest()->get();
        return view('admin.aparatur-desa.index', compact('aparaturs'));
    }

    public function create()
    {
        return view('admin.aparatur-desa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'urutan' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $ext = strtolower($file->getClientOriginalExtension() ?: 'jpg');
            $filename = 'aparatur-' . now()->format('YmdHis') . '-' . Str::random(6) . '.' . $ext;

            $destDir = public_path('images/aparatur-desa');
            if (!is_dir($destDir)) {
                @mkdir($destDir, 0775, true);
            }

            $file->move($destDir, $filename);
            $validated['foto'] = 'images/aparatur-desa/' . $filename;
        }

        $validated['is_active'] = $request->has('is_active');

        AparaturDesa::create($validated);

        return redirect()->route('admin.aparatur-desa.index')
            ->with('success', 'Aparatur desa berhasil ditambahkan.');
    }

    public function edit(AparaturDesa $aparatur_desa)
    {
        return view('admin.aparatur-desa.edit', [
            'aparatur' => $aparatur_desa
        ]);
    }

    public function update(Request $request, AparaturDesa $aparatur_desa)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'urutan' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            // Hapus file lama jika ada
            if (!empty($aparatur_desa->foto)) {
                if (Str::startsWith($aparatur_desa->foto, 'images/')) {
                    $oldPath = public_path($aparatur_desa->foto);
                    if (is_file($oldPath)) {
                        @unlink($oldPath);
                    }
                } else {
                    // Backward-compat: dulu sempat disimpan di storage/public
                    Storage::disk('public')->delete($aparatur_desa->foto);
                }
            }

            $file = $request->file('foto');
            $ext = strtolower($file->getClientOriginalExtension() ?: 'jpg');
            $filename = 'aparatur-' . now()->format('YmdHis') . '-' . Str::random(6) . '.' . $ext;

            $destDir = public_path('images/aparatur-desa');
            if (!is_dir($destDir)) {
                @mkdir($destDir, 0775, true);
            }

            $file->move($destDir, $filename);
            $validated['foto'] = 'images/aparatur-desa/' . $filename;
        }

        $validated['is_active'] = $request->has('is_active');

        $aparatur_desa->update($validated);

        return redirect()->route('admin.aparatur-desa.index')
            ->with('success', 'Aparatur desa berhasil diperbarui.');
    }

    public function destroy(AparaturDesa $aparatur_desa)
    {
        if (!empty($aparatur_desa->foto)) {
            if (Str::startsWith($aparatur_desa->foto, 'images/')) {
                $path = public_path($aparatur_desa->foto);
                if (is_file($path)) {
                    @unlink($path);
                }
            } else {
                // Backward-compat: dulu sempat disimpan di storage/public
                Storage::disk('public')->delete($aparatur_desa->foto);
            }
        }

        $aparatur_desa->delete();

        return redirect()->route('admin.aparatur-desa.index')
            ->with('success', 'Aparatur desa berhasil dihapus.');
    }
}
