<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function index()
    {
        $beritas = Berita::latest()->paginate(10);
        return view('admin.berita.index', compact('beritas'));
    }

    public function create()
    {
        return view('admin.berita.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required',
            'tanggal_publish' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'judul' => $request->judul,
            'slug' => $this->generateUniqueSlug($request->judul),
            'isi' => $request->isi,
            'status' => 'published',
            'tanggal_publish' => $request->tanggal_publish,
        ];

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $ext = strtolower($file->getClientOriginalExtension() ?: 'jpg');
            $filename = 'berita-' . now()->format('YmdHis') . '-' . Str::random(6) . '.' . $ext;
            $destDir = public_path('berita');
            if (!is_dir($destDir)) {
                @mkdir($destDir, 0775, true);
            }
            $file->move($destDir, $filename);
            $data['gambar'] = 'berita/' . $filename;
        }

        Berita::create($data);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    public function edit(Berita $beritum)
    {
        $berita = $beritum;
        return view('admin.berita.edit', compact('berita'));
    }

    public function update(Request $request, Berita $beritum)
    {
        $berita = $beritum;
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required',
            'tanggal_publish' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['judul', 'isi', 'tanggal_publish']);
        $data['slug'] = $this->generateUniqueSlug($request->judul, $berita->id);

        if ($request->hasFile('gambar')) {
            if (!empty($berita->gambar)) {
                if (Str::startsWith($berita->gambar, 'berita/')) {
                    $oldPath = public_path($berita->gambar);
                    if (is_file($oldPath)) {
                        @unlink($oldPath);
                    }
                } else {
                    Storage::disk('public')->delete($berita->gambar);
                }
            }

            $file = $request->file('gambar');
            $ext = strtolower($file->getClientOriginalExtension() ?: 'jpg');
            $filename = 'berita-' . now()->format('YmdHis') . '-' . Str::random(6) . '.' . $ext;
            $destDir = public_path('berita');
            if (!is_dir($destDir)) {
                @mkdir($destDir, 0775, true);
            }
            $file->move($destDir, $filename);
            $data['gambar'] = 'berita/' . $filename;
        }

        $berita->update($data);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy(Berita $beritum)
    {
        $berita = $beritum;
        if (!empty($berita->gambar)) {
            if (Str::startsWith($berita->gambar, 'berita/')) {
                $path = public_path($berita->gambar);
                if (is_file($path)) {
                    @unlink($path);
                }
            } else {
                Storage::disk('public')->delete($berita->gambar);
            }
        }

        $berita->delete();
        return back()->with('success', 'Berita berhasil dihapus!');
    }

    private function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while (true) {
            $query = Berita::where('slug', $slug);
            if (!is_null($ignoreId)) {
                $query->where('id', '!=', $ignoreId);
            }

            if (!$query->exists()) {
                return $slug;
            }

            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
    }
}
