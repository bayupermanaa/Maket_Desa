<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings_desa', function (Blueprint $table) {
            $table->string('popup_judul')->nullable();
            $table->text('popup_isi')->nullable();
            $table->boolean('popup_aktif')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('settings_desa', function (Blueprint $table) {
            $table->dropColumn(['popup_judul', 'popup_isi', 'popup_aktif']);
        });
    }
};

