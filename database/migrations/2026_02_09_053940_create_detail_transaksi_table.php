<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('detail_transaksi')) {
            Schema::create('detail_transaksi', function (Blueprint $table) {
                $table->id();

                $table->unsignedBigInteger('transaksi_id');
                $table->unsignedBigInteger('produk_id');

                $table->integer('qty');
                $table->integer('harga');

                $table->foreign('transaksi_id')
                      ->references('id')
                      ->on('transaksi');

                $table->foreign('produk_id')
                      ->references('id')
                      ->on('produk');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
    }
};