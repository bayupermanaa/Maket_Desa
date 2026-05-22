<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('pengaduans', function (Blueprint $table) {
        $table->id();
        $table->string('nama_pelapor');
        $table->string('nik')->nullable();
        $table->string('no_hp')->nullable();
        $table->string('judul');
        $table->text('isi');
        $table->string('kategori')->nullable();     // contoh: infrastruktur, keamanan, lingkungan, dll
        $table->string('lokasi')->nullable();
        $table->string('status')->default('baru');  // baru, diproses, selesai
        $table->string('foto')->nullable();
        $table->date('tanggal_pengaduan')->nullable();
        $table->timestamps();
    });
}
};
