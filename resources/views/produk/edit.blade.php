@extends('layouts.app')

@section('content')
<style>
    /* Animasi masuk */
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes scaleUp {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    @keyframes popIn {
        0% { transform: scale(0.9); opacity: 0; }
        70% { transform: scale(1.05); }
        100% { transform: scale(1); opacity: 1; }
    }

    .animate-header {
        animation: slideDown 0.6s ease-out forwards;
    }

    .animate-form {
        animation: scaleUp 0.5s ease-out 0.2s backwards;
    }

    /* Efek hover dan fokus */
    .input-focus-effect:focus {
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }
</style>

<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center gap-4 animate-header">
        <a href="{{ route('produk.index') }}" class="bg-white/20 hover:bg-white/40 p-2 rounded-full transition text-gray-800">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="text-3xl font-bold text-gray-900">Edit Menu</h2>
    </div>

    <div class="bg-[#F2E3B6] p-8 rounded-[32px] shadow-2xl border border-white/30 animate-form">
        <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-gray-800 font-bold mb-2">Nama Menu</label>
                <input type="text" name="nama_produk" value="{{ $produk->nama_produk }}"
                    class="w-full p-4 rounded-2xl border-none shadow-inner outline-none focus:ring-4 focus:ring-pink-300 input-focus-effect" required>
            </div>

            <div>
                <label class="block text-gray-800 font-bold mb-2">Harga (Rp)</label>
                <input type="number" name="harga_produk" value="{{ $produk->harga_produk }}"
                    class="w-full p-4 rounded-2xl border-none shadow-inner outline-none focus:ring-4 focus:ring-pink-300 input-focus-effect" required>
            </div>

            <div>
                <label class="block text-gray-800 font-bold mb-2">Ubah Foto (Opsional)</label>
                <div class="bg-white p-6 rounded-2xl border-2 border-dashed border-pink-400 text-center hover:bg-pink-50 transition-colors">
                    <div id="current-img-container" class="mb-3">
                        <p class="text-xs text-gray-400 mb-1 font-bold italic uppercase">Foto Sekarang:</p>
                        <img src="{{ asset('storage/'.$produk->gambar) }}" class="w-32 h-32 object-contain mx-auto rounded-xl border border-pink-100 shadow-sm">
                    </div>
                    
                    <input type="file" name="gambar" id="gambar" class="hidden" accept="image/*" onchange="previewImage(this)">
                    <label for="gambar" class="cursor-pointer block mt-2">
                        <div id="preview-wrapper" class="hidden">
                             <p class="text-xs text-green-500 mb-1 font-bold italic uppercase">Preview Foto Baru:</p>
                             <img id="preview" src="#" alt="Preview" class="w-40 h-40 object-contain mx-auto mb-3">
                        </div>
                        <span class="inline-block bg-pink-100 text-pink-600 px-6 py-3 rounded-2xl text-sm font-black hover:bg-pink-500 hover:text-white transition-all transform active:scale-90 shadow-sm uppercase">
                            <i class="fas fa-image mr-2"></i> Pilih Foto Baru
                        </span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-gray-800 font-bold mb-2">Status Menu</label>
                <select name="status" class="w-full p-4 rounded-2xl border-none shadow-inner outline-none focus:ring-4 focus:ring-pink-300 input-focus-effect">
                    <option value="aktif" {{ $produk->status == 'aktif' ? 'selected' : '' }}>🟢 Aktif (Tampil)</option>
                    <option value="nonaktif" {{ $produk->status == 'nonaktif' ? 'selected' : '' }}>🔴 Non-Aktif (Sembunyi)</option>
                </select>
            </div>

            <button type="submit" class="nav-link w-full p-4 rounded-2xl text-xl font-black mt-4 shadow-lg active:scale-95 transition-all uppercase tracking-wider">
                UPDATE MENU
            </button>
        </form>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    const previewWrapper = document.getElementById('preview-wrapper');
    const currentImg = document.getElementById('current-img-container');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            
            // Sembunyikan foto lama dengan transisi halus
            currentImg.style.display = 'none';
            
            // Tampilkan wrapper preview baru
            previewWrapper.classList.remove('hidden');
            
            // Kasih animasi popIn ke gambar baru
            preview.style.animation = 'popIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) forwards';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection