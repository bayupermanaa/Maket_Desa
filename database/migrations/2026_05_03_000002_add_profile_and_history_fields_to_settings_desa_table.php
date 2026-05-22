<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings_desa', function (Blueprint $table) {
            if (!Schema::hasColumn('settings_desa', 'kepala_desa_jabatan')) {
                $table->string('kepala_desa_jabatan')->nullable();
            }

            if (!Schema::hasColumn('settings_desa', 'kepala_desa_periode')) {
                $table->string('kepala_desa_periode')->nullable();
            }

            if (!Schema::hasColumn('settings_desa', 'sejarah_desa')) {
                $table->longText('sejarah_desa')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('settings_desa', function (Blueprint $table) {
            $columns = [];

            if (Schema::hasColumn('settings_desa', 'kepala_desa_jabatan')) {
                $columns[] = 'kepala_desa_jabatan';
            }
            if (Schema::hasColumn('settings_desa', 'kepala_desa_periode')) {
                $columns[] = 'kepala_desa_periode';
            }
            if (Schema::hasColumn('settings_desa', 'sejarah_desa')) {
                $columns[] = 'sejarah_desa';
            }

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};

