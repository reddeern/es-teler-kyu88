@extends('layouts.app')

@section('content')

<div class="max-w-md mx-auto bg-white p-6 rounded-xl shadow">

<h2 class="text-center text-xl font-bold mb-4">STRUK PEMBELIAN</h2>

<p><strong>Pelanggan:</strong> {{ $transaksi->nama_pelanggan }}</p>
<p><strong>Tanggal:</strong> {{ $transaksi->created_at }}</p>

<hr class="my-3">

@foreach($transaksi->detail_produk as $item)
<div class="flex justify-between text-sm">
    <span>{{ $item['nama'] }} x{{ $item['qty'] }}</span>
    <span>Rp {{ number_format($item['total']) }}</span>
</div>
@endforeach

<hr class="my-3">

<div class="flex justify-between">
    <span>Subtotal</span>
    <span>Rp {{ number_format($transaksi->subtotal) }}</span>
</div>

<div class="flex justify-between">
    <span>Pajak (10%)</span>
    <span>Rp {{ number_format($transaksi->pajak) }}</span>
</div>

<div class="flex justify-between font-bold">
    <span>Total</span>
    <span>Rp {{ number_format($transaksi->total_akhir) }}</span>
</div>

<button onclick="window.print()"
    class="mt-6 w-full bg-green-600 text-white py-2 rounded">
    Cetak Struk
</button>

</div>

@endsection
