<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class PublicArtikelController extends Controller
{
    public function index(Request $request)
    {
        $artikels = Artikel::query()
            ->where('is_published', true)
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('artikel.index', compact('artikels'));
    }

    public function show(string $slug)
    {
        $artikel = Artikel::query()
            ->where('is_published', true)
            ->where('slug', $slug)
            ->firstOrFail();

        return view('artikel.show', compact('artikel'));
    }
}

