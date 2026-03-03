@extends('layouts.app')

@section('content')

<style>
    /* Animasi Utama: Kartu muncul dari bawah ke atas */
    @keyframes slideFromBottom {
        from { 
            opacity: 0; 
            transform: translateY(50px); 
            filter: blur(5px);
        }
        to { 
            opacity: 1; 
            transform: translateY(0); 
            filter: blur(0);
        }
    }

    /* Animasi Baris Produk: Geser halus dari bawah */
    @keyframes itemSlideUp {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .detail-card {
        background: #EFE6C8;
        padding: 30px;
        border-radius: 20px;
        max-width: 700px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        /* Pasang animasi di sini */
        animation: slideFromBottom 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .product-item {
        opacity: 0; /* Sembunyi dulu sebelum animasi jalan */
        animation: itemSlideUp 0.5s ease-out forwards;
    }
</style>

<h2 style="font-size:26px;font-weight:bold;margin-bottom:30px; animation: slideFromBottom 0.5s ease-out;">
    Detail Transaksi
</h2>

<div class="detail-card">
    <div style="animation: itemSlideUp 0.5s ease-out 0.2s forwards; opacity: 0;">
        <p><strong>Nama Pelanggan:</strong> {{ $transaksi->nama_pelanggan }}</p>
        <p><strong>Metode Pembayaran:</strong> {{ $transaksi->metode_pembayaran }}</p>
        <p><strong>Tanggal:</strong> {{ $transaksi->created_at->format('d-m-Y H:i') }}</p>
    </div>

    <hr style="margin:20px 0; border: 0; border-top: 1px dashed rgba(0,0,0,0.1);">

    @foreach($transaksi->detail_produk as $index => $item)
    <div class="product-item" style="display:flex;justify-content:space-between;margin-bottom:8px; animation-delay: {{ 0.4 + ($index * 0.1) }}s">
        <span>{{ $item['nama'] }} x{{ $item['qty'] ?? 0 }}</span>
        <span>Rp {{ number_format($item['harga'] ?? 0, 0, ',', '.') }}</span>
    </div>
    @endforeach

    <hr style="margin:20px 0; border: 0; border-top: 1px dashed rgba(0,0,0,0.1);">

    <div style="animation: itemSlideUp 0.5s ease-out 0.8s forwards; opacity: 0;">
        <p>Subtotal: Rp {{ number_format($transaksi->subtotal) }}</p>
        <p>Pajak: Rp {{ number_format($transaksi->pajak) }}</p>
        <p style="font-size: 20px; font-weight:bold; margin-top: 10px; color: #be185d;">
            Total Akhir: Rp {{ number_format($transaksi->total_akhir) }}
        </p>
    </div>
</div>

{{-- Tombol Kembali --}}
<div style="margin-top: 30px; animation: itemSlideUp 0.5s ease-out 1s forwards; opacity: 0;">
    <a href="{{ route('transaksi.index') }}" style="text-decoration: none; color: #666; font-weight: bold; font-size: 14px;">
        ← KEMBALI KE DAFTAR
    </a>
</div>

@endsection