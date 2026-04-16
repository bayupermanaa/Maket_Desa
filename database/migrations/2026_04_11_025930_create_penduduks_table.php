<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penduduks', function (Blueprint $table) {
            $table->id();
            $table->string('rw',10);
            $table->string('rt',10);
            $table->string('dusun',50);
            $table->string('alamat',255);
            $table->string('kode_keluarga',50);
            $table->string('nama_kepala_keluarga',100);
            $table->string('nik',20);
            $table->string('nama',100);
            $table->string('jk',10);
            $table->string('hubungan',50);
            $table->string('tempat_lahir',50);
            $table->date('tgl_lahir');
            $table->integer('usia')->nullable();
            $table->string('status',50)->nullable();
            $table->string('agama',50)->nullable();
            $table->string('gol_darah',5)->nullable();
            $table->string('kewarganegaraan',50)->nullable();
            $table->string('suku',50)->nullable();
            $table->string('pendidikan',50)->nullable();
            $table->string('pekerjaan',50)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penduduks');
    }
};