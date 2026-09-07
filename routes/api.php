<?php

use App\Http\Controllers\Api\WilayahDesaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard-stats', function () {
    return response()->json([
        'penduduk' => [
            'total_jiwa'      => 2450,
            'laki_laki'       => 1240,
            'perempuan'       => 1210,
            'kepala_keluarga' => 680,
        ],
        'apbd' => [
            'total'         => 2000000000,
            'infrastruktur' => 800000000,
            'pendidikan'    => 400000000,
            'kesehatan'     => 300000000,
            'pemberdayaan'  => 250000000,
            'administrasi'  => 150000000,
            'lain_lain'     => 100000000,
        ],
    ]);
});

Route::get('/wilayah-desa/banjar-dinas', [WilayahDesaController::class, 'banjarDinas']);

