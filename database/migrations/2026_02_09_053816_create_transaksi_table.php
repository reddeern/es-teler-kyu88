<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Gunakan nama 'transaksi' (singular) biar konsisten sama detail_transaksi
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelanggan');
            $table->json('detail_produk'); // Untuk menyimpan array produk
            $table->decimal('subtotal', 15, 2);
            $table->decimal('pajak', 15, 2);
            $table->decimal('total_akhir', 15, 2);
            $table->decimal('total_harga', 15, 2);
            $table->string('metode_pembayaran');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};