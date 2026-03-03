<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\ProdukApiController;
use App\Http\Controllers\Api\TransaksiApiController;

// ===================
// AUTH
// ===================
Route::post('/login', [AuthApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthApiController::class, 'logout']);
    // Route::get('/profile', [AuthApiController::class, 'profile']);

    // ===================
    // PRODUK
    // ===================
    Route::get('/produk', [ProdukApiController::class, 'index']);
    Route::get('/produk/{id}', [ProdukApiController::class, 'show']);
    Route::post('/produk', [ProdukApiController::class, 'store']);
    Route::put('/produk/{id}', [ProdukApiController::class, 'update']);
    Route::delete('/produk/{id}', [ProdukApiController::class, 'destroy']);

    // ===================
    // TRANSAKSI
    // ===================
    Route::get('/produk-aktif', [TransaksiApiController::class, 'produkAktif']);
    Route::post('/transaksi', [TransaksiApiController::class, 'store']);
    Route::get('/transaksi', [TransaksiApiController::class, 'index']);
    Route::get('/transaksi/{id}', [TransaksiApiController::class, 'show']);

    // ===================
    // LAPORAN
    // ===================
    Route::get('/laporan', [TransaksiApiController::class, 'laporan']);
});