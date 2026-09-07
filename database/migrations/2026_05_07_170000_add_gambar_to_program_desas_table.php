<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('program_desas', function (Blueprint $table) {
            if (!Schema::hasColumn('program_desas', 'gambar')) {
                $table->string('gambar')->nullable()->after('kategori');
            }
        });
    }

    public function down(): void
    {
        Schema::table('program_desas', function (Blueprint $table) {
            if (Schema::hasColumn('program_desas', 'gambar')) {
                $table->dropColumn('gambar');
            }
        });
    }
};

