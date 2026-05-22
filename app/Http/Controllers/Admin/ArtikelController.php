<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikels = Artikel::latest()->paginate(10);
        return view('admin.artikel.index', compact('artikels'));
    }

    public function create()
    {
        return view('admin.artikel.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'judul' => 'required|string|max:255',
        'isi'   => 'required',
        'gambar'=> 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $data = [
        'judul'        => $request->judul,
        'slug'         => \Illuminate\Support\Str::slug($request->judul),
        'isi'          => $request->isi,
        'is_published' => true,
    ];

    if ($request->hasFile('gambar')) {
        $file = $request->file('gambar');
        $ext = strtolower($file->getClientOriginalExtension() ?: 'jpg');
        $filename = 'artikel-' . now()->format('YmdHis') . '-' . Str::random(6) . '.' . $ext;

        $destDir = public_path('artikel');
        if (!is_dir($destDir)) {
            @mkdir($destDir, 0775, true);
        }

        $file->move($destDir, $filename);
        $data['gambar'] = 'artikel/' . $filename;
    }

    \App\Models\Artikel::create($data);

    return redirect()->route('admin.artikel.index')
                     ->with('success', 'Artikel berhasil ditambahkan!');
}

    public function edit(Artikel $artikel)
    {
        return view('admin.artikel.edit', compact('artikel'));
    }

    public function update(Request $request, Artikel $artikel)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi'   => 'required',
            'gambar'=> 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['judul', 'isi']);
        $data['slug'] = Str::slug($request->judul);

        if ($request->hasFile('gambar')) {
            if (!empty($artikel->gambar)) {
                if (Str::startsWith($artikel->gambar, 'artikel/')) {
                    $oldPath = public_path($artikel->gambar);
                    if (is_file($oldPath)) {
                        @unlink($oldPath);
                    }
                } else {
                    // Backward-compat: dulu sempat disimpan di storage/public
                    Storage::disk('public')->delete($artikel->gambar);
                }
            }

            $file = $request->file('gambar');
            $ext = strtolower($file->getClientOriginalExtension() ?: 'jpg');
            $filename = 'artikel-' . now()->format('YmdHis') . '-' . Str::random(6) . '.' . $ext;

            $destDir = public_path('artikel');
            if (!is_dir($destDir)) {
                @mkdir($destDir, 0775, true);
            }

            $file->move($destDir, $filename);
            $data['gambar'] = 'artikel/' . $filename;
        }

        $artikel->update($data);

        return redirect()->route('admin.artikel.index')
                         ->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy(Artikel $artikel)
    {
        if (!empty($artikel->gambar)) {
            if (Str::startsWith($artikel->gambar, 'artikel/')) {
                $path = public_path($artikel->gambar);
                if (is_file($path)) {
                    @unlink($path);
                }
            } else {
                // Backward-compat: dulu sempat disimpan di storage/public
                Storage::disk('public')->delete($artikel->gambar);
            }
        }
        $artikel->delete();

        return back()->with('success', 'Artikel berhasil dihapus!');
    }
}
