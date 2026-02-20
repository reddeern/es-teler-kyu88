@extends('layouts.app')

@section('content')

<style>
.dashboard-container{
    background:#E7E0B5;
    padding:30px;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

.menu-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(180px,1fr));
    gap:20px;
    margin-top:20px;
}

.menu-card{
    background:#F4E5B5;
    border-radius:15px;
    padding:20px;
    text-align:center;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
    transition:0.2s;
}

.menu-card:hover{
    transform:translateY(-5px);
}

.menu-card img{
    width:100%;
    height:120px;
    object-fit:cover;
    border-radius:10px;
    margin-bottom:10px;
}

.btn-menu-baru{
    background:#F08A8A;
    color:white;
    padding:10px 20px;
    border-radius:10px;
    text-decoration:none;
    font-weight:bold;
    float:right;
}
</style>

<h2 style="font-weight:bold;margin-bottom:20px;">
    Dashboard
</h2>

<a href="{{ route('produk.create') }}" class="btn-menu-baru">
    Menu Baru
</a>

<div class="dashboard-container">

    <div class="menu-grid">
        @foreach(\App\Models\Produk::all() as $item)
        <div class="menu-card">
            <img src="{{ asset('storage/'.$item->gambar) }}">
            <h4>{{ $item->nama_produk }}</h4>
            <p style="color:green;font-weight:bold;">
                Rp {{ number_format($item->harga) }}
            </p>
        </div>
        @endforeach
    </div>

</div>

@endsection
