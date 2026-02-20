<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('laporan_penjualan')) {
            Schema::create('laporan_penjualan', function (Blueprint $table) {
                $table->id();
                $table->date('tanggal');
                $table->integer('total_omset');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_penjualan');
    }
};
