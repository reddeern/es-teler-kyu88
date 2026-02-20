@extends('layouts.app')

@section('content')

<h2 style="font-size:24px;font-weight:bold;margin-bottom:30px;">
    Tambah Menu
</h2>

<div style="background:#E8E1C3;padding:30px;border-radius:20px;max-width:800px;">

<form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div style="margin-bottom:20px;">
        <label>Nama Produk</label>
        <input type="text" name="nama_produk" style="width:100%;padding:10px;border-radius:10px;border:1px solid #ccc;">
    </div>

    <div style="margin-bottom:20px;">
        <label>Harga Produk</label>
        <input type="number" name="harga_produk" style="width:100%;padding:10px;border-radius:10px;border:1px solid #ccc;">
    </div>

<div style="margin-bottom:20px;">
    <label>Upload Gambar</label>
    <input type="file" name="gambar" id="gambar" accept="image/*">

    <div style="margin-top:10px;">
        <img id="preview" 
             style="max-width:150px; display:none; border-radius:10px;">
    </div>
</div>


    <div style="margin-top:10px;">
        <img id="preview" 
             style="max-width:150px; display:none; border-radius:10px;">
    </div>
</div>


    <div style="margin-bottom:20px;">
        <label>Status</label><br>
        <select name="status" style="padding:8px;border-radius:8px;">
            <option value="aktif">Aktif</option>
            <option value="nonaktif">Non Aktif</option>
        </select>
    </div>

    <button type="submit" style="background:#F08A8A;color:white;padding:10px 20px;border:none;border-radius:10px;">
        TAMBAH MENU
    </button>

</form>

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
