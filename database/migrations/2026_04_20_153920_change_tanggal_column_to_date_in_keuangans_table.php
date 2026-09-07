<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('keuangans', function (Blueprint $table) {
            $table->date('tanggal')->change();   // ubah jadi tipe DATE
        });
    }

    public function down()
    {
        Schema::table('keuangans', function (Blueprint $table) {
            $table->string('tanggal')->change();
        });
    }
};