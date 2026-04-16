<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('settings_desa', function (Blueprint $table) {
        $table->string('nama_kepala_desa')->nullable();
        $table->string('foto_kepala_desa')->nullable();
        $table->integer('jumlah_banjar')->default(0);
        $table->integer('penduduk_baru_tahun_ini')->default(0);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings_desa', function (Blueprint $table) {
            //
        });
    }
};
