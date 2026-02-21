<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPenjualan extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'laporan_penjualan'; 

    // Kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'tanggal',
        'total_omset'
    ];
}