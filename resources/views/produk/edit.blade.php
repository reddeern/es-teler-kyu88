@extends('layouts.app')

@section('content')

<h2 class="text-2xl font-bold mb-6">Edit Produk</h2>

<div class="bg-yellow-100 p-6 rounded-lg max-w-xl">

<form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label class="block mb-1 font-semibold">Nama Produk</label>
        <input type="text" name="nama_produk"
               value="{{ $produk->nama_produk }}"
               class="w-full border rounded px-3 py-2" required>
    </div>

    <div class="mb-4">
        <label class="block mb-1 font-semibold">Harga Produk</label>
        <input type="number" name="harga_produk"
               value="{{ $produk->harga_produk }}"
               class="w-full border rounded px-3 py-2" required>
    </div>

    <div class="mb-4">
        <label class="block mb-1 font-semibold">Upload Gambar</label>
        <input type="file" name="gambar" id="gambar" accept="image/*" class="w-full">
        <div class="mt-2">
            <img id="preview" 
                 src="{{ $produk->gambar ? asset('storage/'.$produk->gambar) : asset('images/default.png') }}" 
                 class="max-w-xs rounded">
        </div>
    </div>

    <div class="mb-4">
        <label class="block mb-1 font-semibold">Status</label>
        <select name="status" class="w-full border rounded px-3 py-2">
            <option value="aktif" {{ $produk->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="nonaktif" {{ $produk->status == 'nonaktif' ? 'selected' : '' }}>Non Aktif</option>
        </select>
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Update
    </button>

    <a href="{{ route('produk.index') }}" class="ml-2 text-gray-600 hover:underline">
        Batal
    </a>
</form>

</div>

<script>
document.getElementById('gambar').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('preview');

    if (file) {
        preview.src = URL.createObjectURL(file);
    }
});
</script>

@endsection
