@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('produk.index') }}" class="bg-white/20 hover:bg-white/40 p-2 rounded-full transition text-gray-800">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="text-3xl font-bold text-gray-900">Edit Menu</h2>
    </div>

    <div class="bg-[#F2E3B6] p-8 rounded-[32px] shadow-2xl border border-white/30">
        <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-gray-800 font-bold mb-2">Nama Menu</label>
                <input type="text" name="nama_produk" value="{{ $produk->nama_produk }}"
                    class="w-full p-4 rounded-2xl border-none shadow-inner outline-none focus:ring-4 focus:ring-pink-300" required>
            </div>

            <div>
                <label class="block text-gray-800 font-bold mb-2">Harga (Rp)</label>
                <input type="number" name="harga_produk" value="{{ $produk->harga_produk }}"
                    class="w-full p-4 rounded-2xl border-none shadow-inner outline-none focus:ring-4 focus:ring-pink-300" required>
            </div>

            <div>
                <label class="block text-gray-800 font-bold mb-2">Ubah Foto (Opsional)</label>
                <div class="bg-white p-6 rounded-2xl border-2 border-dashed border-pink-400 text-center">
                    <div id="current-img-container" class="mb-3">
                        <p class="text-xs text-gray-400 mb-1 font-bold italic">Foto Sekarang:</p>
                        <img src="{{ asset('storage/'.$produk->gambar) }}" class="w-32 h-32 object-contain mx-auto rounded-xl border">
                    </div>
                    
                    <input type="file" name="gambar" id="gambar" class="hidden" accept="image/*" onchange="previewImage(this)">
                    <label for="gambar" class="cursor-pointer block mt-2">
                        <img id="preview" src="#" alt="Preview" class="hidden w-40 h-40 object-contain mx-auto mb-3">
                        <span class="bg-pink-100 text-pink-600 px-4 py-2 rounded-xl text-sm font-bold hover:bg-pink-200 transition">
                            Pilih Foto Baru
                        </span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-gray-800 font-bold mb-2">Status Menu</label>
                <select name="status" class="w-full p-4 rounded-2xl border-none shadow-inner outline-none focus:ring-4 focus:ring-pink-300">
                    <option value="aktif" {{ $produk->status == 'aktif' ? 'selected' : '' }}>🟢 Aktif</option>
                    <option value="nonaktif" {{ $produk->status == 'nonaktif' ? 'selected' : '' }}>🔴 Non-Aktif</option>
                </select>
            </div>

            <button type="submit" class="nav-link w-full p-4 rounded-2xl text-xl font-black mt-4 shadow-lg">
                UPDATE MENU
            </button>
        </form>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    const currentImg = document.getElementById('current-img-container');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            currentImg.classList.add('hidden'); // Sembunyikan foto lama jika pilih foto baru
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection