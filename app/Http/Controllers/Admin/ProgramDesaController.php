<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProgramDesaController extends Controller
{
    public function index()
    {
        $programs = ProgramDesa::orderBy('urutan')->orderByDesc('created_at')->get();
        return view('admin.program.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.program.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'nullable|string|max:100',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'anggaran' => 'nullable|numeric|min:0',
            'tahun' => 'nullable|integer|min:2000|max:2100',
            'status' => 'required|in:perencanaan,berjalan,selesai',
            'urutan' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['urutan'] = (int) ($validated['urutan'] ?? 0);
        $validated['gambar'] = $this->storeImage($request);

        ProgramDesa::create($validated);

        return redirect()->route('admin.program.index')->with('success', 'Program desa berhasil ditambahkan.');
    }

    public function edit(ProgramDesa $program)
    {
        return view('admin.program.edit', compact('program'));
    }

    public function update(Request $request, ProgramDesa $program)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'nullable|string|max:100',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'anggaran' => 'nullable|numeric|min:0',
            'tahun' => 'nullable|integer|min:2000|max:2100',
            'status' => 'required|in:perencanaan,berjalan,selesai',
            'urutan' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['urutan'] = (int) ($validated['urutan'] ?? 0);
        if ($request->hasFile('gambar')) {
            $this->deleteImage($program->gambar);
            $validated['gambar'] = $this->storeImage($request);
        }

        $program->update($validated);

        return redirect()->route('admin.program.index')->with('success', 'Program desa berhasil diperbarui.');
    }

    public function destroy(ProgramDesa $program)
    {
        $this->deleteImage($program->gambar);
        $program->delete();
        return redirect()->route('admin.program.index')->with('success', 'Program desa berhasil dihapus.');
    }

    private function storeImage(Request $request): ?string
    {
        if (!$request->hasFile('gambar')) {
            return null;
        }

        $file = $request->file('gambar');
        $ext = strtolower($file->getClientOriginalExtension() ?: 'jpg');
        $filename = 'program-' . now()->format('YmdHis') . '-' . uniqid() . '.' . $ext;
        $destDir = public_path('images/program');

        if (!File::isDirectory($destDir)) {
            File::makeDirectory($destDir, 0775, true);
        }

        $file->move($destDir, $filename);
        return 'images/program/' . $filename;
    }

    private function deleteImage(?string $path): void
    {
        if (empty($path)) {
            return;
        }

        $absolute = public_path($path);
        if (File::exists($absolute)) {
            File::delete($absolute);
        }
    }
}
