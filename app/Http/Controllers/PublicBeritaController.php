<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class PublicBeritaController extends Controller
{
    public function index(Request $request)
    {
        $day = $request->integer('day');
        $month = $request->integer('month');
        $year = $request->integer('year');

        $query = Berita::query()
            ->where('status', 'published')
            ->whereDate('tanggal_publish', '<=', now()->toDateString());

        if ($year) {
            $query->whereYear('tanggal_publish', $year);
        }

        if ($month) {
            $query->whereMonth('tanggal_publish', $month);
        }

        if ($day) {
            $query->whereDay('tanggal_publish', $day);
        }

        $beritas = $query
            ->orderByDesc('tanggal_publish')
            ->orderByDesc('id')
            ->paginate(9)
            ->withQueryString();

        $availableYears = Berita::query()
            ->where('status', 'published')
            ->whereDate('tanggal_publish', '<=', now()->toDateString())
            ->whereNotNull('tanggal_publish')
            ->selectRaw('YEAR(tanggal_publish) as year_value')
            ->distinct()
            ->orderByDesc('year_value')
            ->pluck('year_value')
            ->filter()
            ->values();

        return view('berita.index', compact('beritas', 'availableYears', 'day', 'month', 'year'));
    }

    public function show(string $slug)
    {
        $berita = Berita::query()
            ->where('status', 'published')
            ->whereDate('tanggal_publish', '<=', now()->toDateString())
            ->where('slug', $slug)
            ->firstOrFail();

        return view('berita.show', compact('berita'));
    }
}
