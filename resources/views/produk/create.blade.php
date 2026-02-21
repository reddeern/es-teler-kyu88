@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('produk.index') }}" class="bg-white/20 hover:bg-white/40 p-2 rounded-full transition text-gray-800">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="text-3xl font-bold text-gray-900">Tambah Menu Baru</h2>
    </div>

    <div class="bg-[#F2E3B6] p-8 rounded-[32px] shadow-2xl border border-white/30">
        <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label class="block text-gray-800 font-bold mb-2">Nama Menu</label>
                <input type="text" name="nama_produk" 
                    class="w-full p-4 rounded-2xl border-none shadow-inner focus:ring-4 focus:ring-pink-300 outline-none" 
                    placeholder="Contoh: Es Teler Spesial" required>
            </div>

            <div>
                <label class="block text-gray-800 font-bold mb-2">Harga (Rp)</label>
                <input type="number" name="harga_produk" 
                    class="w-full p-4 rounded-2xl border-none shadow-inner focus:ring-4 focus:ring-pink-300 outline-none" 
                    placeholder="0" required>
            </div>

            <div>
                <label class="block text-gray-800 font-bold mb-2">Foto Menu</label>
                <div class="bg-white p-6 rounded-2xl border-2 border-dashed border-pink-400 text-center">
                    <input type="file" name="gambar" id="gambar" class="hidden" accept="image/*" onchange="previewImage(this)">
                    <label for="gambar" class="cursor-pointer block">
                        <img id="preview" src="#" alt="Preview" class="hidden w-40 h-40 object-contain mx-auto mb-3">
                        <i class="fas fa-cloud-upload-alt text-3xl text-pink-500 mb-2"></i>
                        <p class="text-gray-500 font-semibold">Klik untuk pilih foto</p>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-gray-800 font-bold mb-2">Status Menu</label>
                <select name="status" class="w-full p-4 rounded-2xl border-none shadow-inner outline-none focus:ring-4 focus:ring-pink-300">
                    <option value="aktif">🟢 Aktif (Tampil di Kasir)</option>
                    <option value="nonaktif">🔴 Non-Aktif</option>
                </select>
            </div>

            <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <button type="submit" class="nav-link w-full p-4 rounded-2xl text-xl font-black mt-4 shadow-lg">
                    SIMPAN MENU
                </button>
            </form>
        </form>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection