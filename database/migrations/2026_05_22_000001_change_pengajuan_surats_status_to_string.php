<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::connection()->getDriverName() === 'sqlite') {
            return;
        }

        DB::statement("ALTER TABLE pengajuan_surats MODIFY status VARCHAR(50) NOT NULL DEFAULT 'Menunggu'");
    }

    public function down(): void
    {
        if (DB::connection()->getDriverName() === 'sqlite') {
            return;
        }

        DB::statement("ALTER TABLE pengajuan_surats MODIFY status ENUM('Menunggu', 'Diproses', 'Disetujui', 'Ditolak') NOT NULL DEFAULT 'Menunggu'");
    }
};
