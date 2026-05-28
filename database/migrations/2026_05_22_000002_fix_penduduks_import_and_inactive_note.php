<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penduduks', function (Blueprint $table) {
            if (!Schema::hasColumn('penduduks', 'no')) {
                $table->integer('no')->nullable()->after('nama_kepala_keluarga');
            }

            if (!Schema::hasColumn('penduduks', 'keterangan_nonaktif')) {
                $table->text('keterangan_nonaktif')->nullable()->after('is_active');
            }
        });

        if (DB::connection()->getDriverName() !== 'sqlite') {
            DB::statement('ALTER TABLE penduduks MODIFY rw VARCHAR(10) NULL');
            DB::statement('ALTER TABLE penduduks MODIFY rt VARCHAR(10) NULL');
            DB::statement('ALTER TABLE penduduks MODIFY dusun VARCHAR(50) NULL');
            DB::statement('ALTER TABLE penduduks MODIFY alamat VARCHAR(255) NULL');
            DB::statement('ALTER TABLE penduduks MODIFY kode_keluarga VARCHAR(50) NULL');
            DB::statement('ALTER TABLE penduduks MODIFY nama_kepala_keluarga VARCHAR(100) NULL');
            DB::statement('ALTER TABLE penduduks MODIFY nik VARCHAR(20) NULL');
            DB::statement('ALTER TABLE penduduks MODIFY nama VARCHAR(100) NULL');
            DB::statement('ALTER TABLE penduduks MODIFY jk VARCHAR(10) NULL');
            DB::statement('ALTER TABLE penduduks MODIFY hubungan VARCHAR(50) NULL');
            DB::statement('ALTER TABLE penduduks MODIFY tempat_lahir VARCHAR(50) NULL');
            DB::statement('ALTER TABLE penduduks MODIFY tgl_lahir DATE NULL');
        }
    }

    public function down(): void
    {
        Schema::table('penduduks', function (Blueprint $table) {
            if (Schema::hasColumn('penduduks', 'keterangan_nonaktif')) {
                $table->dropColumn('keterangan_nonaktif');
            }

            if (Schema::hasColumn('penduduks', 'no')) {
                $table->dropColumn('no');
            }
        });
    }
};
