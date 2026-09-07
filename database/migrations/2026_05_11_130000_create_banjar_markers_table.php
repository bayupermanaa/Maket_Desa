<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banjar_markers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('banjar_dinas_id')->constrained('banjar_dinas')->cascadeOnDelete();
            $table->string('nama', 120);
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('icon_url')->nullable();
            $table->string('alamat')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banjar_markers');
    }
};
