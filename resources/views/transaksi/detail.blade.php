@extends('layouts.app')

@section('content')

<style>
.detail-card{
    background:#EFE6C8;
    padding:30px;
    border-radius:20px;
    max-width:700px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
}
</style>

<h2 style="font-size:26px;font-weight:bold;margin-bottom:30px;">
    Detail Transaksi
</h2>

<div class="detail-card">

<p><strong>Nama Pelanggan:</strong> {{ $transaksi->nama_pelanggan }}</p>
<p><strong>Metode Pembayaran:</strong> {{ $transaksi->metode_pembayaran }}</p>
<p><strong>Tanggal:</strong> {{ $transaksi->created_at->format('d-m-Y H:i') }}</p>

<hr style="margin:20px 0;">

@foreach($transaksi->detail_produk as $item)
<div style="display:flex;justify-content:space-between;margin-bottom:8px;">
    <span>{{ $item['nama'] }} x{{ $item['qty'] }}</span>
    <span>Rp {{ number_format($item['total']) }}</span>
</div>
@endforeach

<hr style="margin:20px 0;">

<p>Subtotal: Rp {{ number_format($transaksi->subtotal) }}</p>
<p>Pajak: Rp {{ number_format($transaksi->pajak) }}</p>
<p style="font-weight:bold;">
Total Akhir: Rp {{ number_format($transaksi->total_akhir) }}
</p>

</div>

@endsection
