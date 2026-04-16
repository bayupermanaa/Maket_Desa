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
    ]);

    \App\Models\Artikel::create([
        'judul'        => $request->judul,
        'slug'         => \Illuminate\Support\Str::slug($request->judul),
        'isi'          => $request->isi,
        'is_published' => true,
    ]);

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
            if ($artikel->gambar) {
                Storage::delete('public/' . $artikel->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('artikel', 'public');
        }

        $artikel->update($data);

        return redirect()->route('admin.artikel.index')
                         ->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy(Artikel $artikel)
    {
        if ($artikel->gambar) {
            Storage::delete('public/' . $artikel->gambar);
        }
        $artikel->delete();

        return back()->with('success', 'Artikel berhasil dihapus!');
    }
}