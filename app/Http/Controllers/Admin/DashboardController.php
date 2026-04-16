<?php

namespace App\Http\Controllers;

use App\Models\SettingsDesa; 
use App\Models\AparaturDesa;

class DashboardController extends Controller
{
    public function publik()
    {
        $data = SettingsDesa::first(); // Ambil record pertama
        $aparaturDesa = AparaturDesa::where('is_active', true)
            ->orderBy('urutan')
            ->get();

        return view('dashboard.publik', compact('data', 'aparaturDesa'));
    }
}