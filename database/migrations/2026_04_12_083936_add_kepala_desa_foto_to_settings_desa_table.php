<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings_desa', function (Blueprint $table) {
            
            // Cek dulu sebelum menambahkan agar tidak error duplicate
            if (!Schema::hasColumn('settings_desa', 'kepala_desa_foto')) {
                $table->string('kepala_desa_foto')->nullable();
            }

            if (!Schema::hasColumn('settings_desa', 'video_desa')) {
                $table->string('video_desa')->nullable();
            }

            if (!Schema::hasColumn('settings_desa', 'jumlah_penduduk')) {
                $table->integer('jumlah_penduduk')->nullable();
            }

        });
    }

    public function down(): void
    {
        Schema::table('settings_desa', function (Blueprint $table) {
            $table->dropColumn(['kepala_desa_foto', 'video_desa', 'jumlah_penduduk']);
        });
    }
};