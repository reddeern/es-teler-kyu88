<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;

// ======================
// ROOT (Halaman Utama)
// ======================
// Sekarang jika buka 127.0.0.1:8000 langsung ke produk
Route::get('/', function () {
    return redirect()->route('produk.index');
});

// ======================
// LOGIN & LOGOUT
// ======================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ======================
// PROTECTED ROUTES (Harus Login)
// ======================
Route::middleware('auth')->group(function () {

    // Jika kamu masih butuh dashboard, biarkan ini. 
    // Tapi jika tidak butuh sama sekali, bisa dihapus.
    Route::get('/dashboard', function () {
        return redirect()->route('produk.index'); 
    })->name('dashboard');

    // HALAMAN UTAMA SEKARANG: PRODUK
    Route::resource('produk', ProdukController::class);

    // ======================
    // KASIR
    // ======================
    Route::get('/kasir', [TransaksiController::class, 'kasir'])->name('kasir.index');
    Route::post('/kasir/checkout-session', [TransaksiController::class, 'checkoutSession'])->name('kasir.checkout_session');
    Route::post('/kasir/store', [TransaksiController::class, 'store'])->name('kasir.store');
    Route::get('/kasir/struk/{id}', [TransaksiController::class, 'struk'])->name('kasir.struk');

    // ======================
    // TRANSAKSI
    // ======================
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');

    // ======================
    // LAPORAN
    // ======================
    Route::get('/laporan', [TransaksiController::class, 'laporan'])->name('laporan.index');
});