<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->string('nomor_tiket')->nullable()->unique()->after('id');
            $table->text('catatan_admin')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->dropUnique(['nomor_tiket']);
            $table->dropColumn(['nomor_tiket', 'catatan_admin']);
        });
    }
};

