<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Matikan pengecekan FK biar nggak rewel pas proses bikin
        Schema::disableForeignKeyConstraints();

        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id();

            // Pake foreignId lebih pinter, dia otomatis nyari tipe data yang cocok
            $table->foreignId('transaksi_id')->constrained('transaksi')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');

            $table->integer('qty');
            $table->decimal('harga', 15, 2); // DECIMAL lebih aman buat harga daripada integer
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
    }
};