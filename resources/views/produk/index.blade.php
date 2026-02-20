@extends('layouts.app')

@section('content')

<h2 style="font-size:24px;font-weight:bold;margin-bottom:30px;">
    Daftar Produk
</h2>

@if(session('success'))
    <div style="background:#D4EDDA;color:#155724;padding:10px 20px;border-radius:10px;margin-bottom:20px;">
        {{ session('success') }}
    </div>
@endif

<a href="{{ route('produk.create') }}" 
   style="background:#F08A8A;color:white;padding:10px 20px;border-radius:10px;text-decoration:none;">
   Menu Baru
</a>

<div style="margin-top:30px;
display:grid;
grid-template-columns:repeat(auto-fill,minmax(200px,1fr));
gap:25px;">

@foreach($produks as $produk)
    @if($produk->status == 'aktif')
    <div style="background:#F4E5B5;padding:15px;border-radius:20px;text-align:center;box-shadow:0 5px 15px rgba(0,0,0,0.1);">
        
       <img 
    src="{{ $produk->gambar && file_exists(storage_path('app/public/'.$produk->gambar)) ? asset('storage/'.$produk->gambar) : asset('images/default.png') }}" 
    style="width:100%; height:150px; object-fit:cover; border-radius:15px; margin-bottom:10px;">

        <h4>{{ $produk->nama_produk }}</h4>
        <p>Rp {{ number_format($produk->harga_produk) }}</p>

        <div style="margin-top:10px;">
            <a href="{{ route('produk.edit',$produk->id) }}" style="font-size:12px;color:blue;">Edit</a>

            <form action="{{ route('produk.destroy',$produk->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button style="border:none;background:none;color:red;font-size:12px;">
                    Hapus
                </button>
            </form>
        </div>

    </div>
    @endif
@endforeach

</div>

<script>
document.getElementById('gambar').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('preview');

    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }
});
</script>

@endsection
