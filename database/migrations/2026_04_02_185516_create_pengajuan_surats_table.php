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
    Schema::create('pengajuan_surats', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('nik', 16);
        $table->string('jenis_surat');
        $table->text('keperluan');
        $table->string('no_hp')->nullable();
        $table->text('alamat')->nullable();
        $table->enum('status', ['Menunggu', 'Diproses', 'Disetujui', 'Ditolak'])->default('Menunggu');
        $table->text('keterangan')->nullable();
        $table->string('file_lampiran')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_surats');
    }
};
