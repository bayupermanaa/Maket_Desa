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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('masyarakat');           // masyarakat, admin_desa, kepala_desa
            $table->string('nik')->nullable()->unique();             // Untuk login masyarakat
            $table->string('username')->nullable()->unique();        // Untuk admin & kepala desa
            $table->text('alamat')->nullable();
            $table->string('no_telp')->nullable();
            
            $table->index('role');   // Untuk mempercepat query berdasarkan role
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'nik', 'username', 'alamat', 'no_telp']);
        });
    }
};