<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ======================
// LOGIN
// ======================

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ======================
// DASHBOARD (protected)
// ======================

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('produk', ProdukController::class);

    // ======================
    // KASIR
    // ======================

    Route::get('/kasir', [TransaksiController::class, 'kasir'])->name('kasir.index');
    Route::post('/kasir/store', [TransaksiController::class, 'store'])->name('kasir.store');
    Route::get('/kasir/struk/{id}', [TransaksiController::class, 'struk'])->name('kasir.struk');

    // ======================
    // TRANSAKSI
    // ======================

    Route::get('/transaksi', [TransaksiController::class, 'index'])
        ->name('transaksi.index');

    Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])
        ->name('transaksi.show');

    // ======================
    // LAPORAN
    // ======================

    Route::get('/laporan', [TransaksiController::class, 'laporan'])
        ->name('laporan.index');
});

// ======================
// ROOT
// ======================

Route::get('/', function () {
    return redirect('/dashboard');
});
