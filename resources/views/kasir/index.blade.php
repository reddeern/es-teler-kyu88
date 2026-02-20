@extends('layouts.app')

@section('content')

<style>
.kasir-container{
    display:flex;
    gap:30px;
}

.produk-area{
    flex:2;
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(180px,1fr));
    gap:20px;
}

.card-produk{
    background:#EFE6C8;
    border-radius:20px;
    padding:15px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    transition:0.2s;
    position:relative;
}

.card-produk:hover{
    transform:translateY(-5px);
}

.card-produk img{
    width:100%;
    height:120px;
    object-fit:cover;
    border-radius:15px;
    margin-bottom:10px;
}

.qty-input{
    width:100%;
    padding:6px;
    border-radius:8px;
    border:1px solid #ccc;
    margin-top:8px;
}

.panel-transaksi{
    flex:1;
    background:#EFE6C8;
    padding:25px;
    border-radius:20px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    height:fit-content;
}

.btn-proses{
    width:100%;
    background:#F08A8A;
    border:none;
    padding:12px;
    border-radius:12px;
    color:white;
    font-weight:bold;
    margin-top:15px;
    cursor:pointer;
}

.btn-proses:hover{
    opacity:0.9;
}
</style>

<h2 style="font-size:26px;font-weight:bold;margin-bottom:20px;">
    Halaman Kasir
</h2>

{{-- NOTIFIKASI STOK --}}
@if(session('stok_habis'))
<div style="
    background:#FFE5B4;
    color:#8B0000;
    padding:12px;
    border-radius:12px;
    margin-bottom:20px;
    font-weight:bold;
">
    ⚠️ {{ session('stok_habis') }}
</div>
@endif

<form action="{{ route('kasir.store') }}" method="POST">
@csrf

<div class="kasir-container">

    <!-- PRODUK -->
    <div class="produk-area">
        @foreach($produk as $item)
        <div class="card-produk">
            <img src="{{ asset('storage/'.$item->gambar) }}">

            <h4 style="font-size:15px;font-weight:bold;">
                {{ $item->nama_produk }}
            </h4>

            <p style="color:#4b7b2b;font-weight:bold;">
                Rp {{ number_format($item->harga) }}
            </p>

            <p style="font-size:12px;color:#666;">
                Stok: {{ $item->stok }}
            </p>

            <input type="number"
                name="produk[{{ $item->id }}]"
                min="0"
                value="0"
                class="qty-input"
                placeholder="Qty">
        </div>
        @endforeach
    </div>

    <!-- PANEL KANAN -->
    <div class="panel-transaksi">

        <label>Nama Pelanggan</label>
        <input type="text"
            name="nama_pelanggan"
            style="width:100%;padding:8px;border-radius:8px;border:1px solid #ccc;margin-bottom:15px;">

        <label>Metode Pembayaran</label>
        <select name="metode_pembayaran"
            style="width:100%;padding:8px;border-radius:8px;border:1px solid #ccc;">
            <option value="Cash">Cash</option>
            <option value="QRIS">QRIS</option>
        </select>

        <button class="btn-proses">
            Proses Transaksi
        </button>

    </div>

</div>

</form>

@endsection
