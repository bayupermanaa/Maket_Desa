<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AparaturDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            $validated['foto'] = $request->file('foto')->store('aparatur-desa', 'public');
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
            if ($aparatur_desa->foto && Storage::disk('public')->exists($aparatur_desa->foto)) {
                Storage::disk('public')->delete($aparatur_desa->foto);
            }

            $validated['foto'] = $request->file('foto')->store('aparatur-desa', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $aparatur_desa->update($validated);

        return redirect()->route('admin.aparatur-desa.index')
            ->with('success', 'Aparatur desa berhasil diperbarui.');
    }

    public function destroy(AparaturDesa $aparatur_desa)
    {
        if ($aparatur_desa->foto && Storage::disk('public')->exists($aparatur_desa->foto)) {
            Storage::disk('public')->delete($aparatur_desa->foto);
        }

        $aparatur_desa->delete();

        return redirect()->route('admin.aparatur-desa.index')
            ->with('success', 'Aparatur desa berhasil dihapus.');
    }
}