<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'nama_produk',
        'harga_produk',
        'gambar',
        'status'
    ];

    // 🔥 TAMBAHAN BIAR SINKRON
    public function getHargaAttribute()
    {
        return $this->harga_produk;
    }
}
