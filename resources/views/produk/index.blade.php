@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Daftar Produk</h2>
        
        @if(session('success'))
        <div class="bg-[#D1E7DD] text-[#0F5132] p-4 rounded-2xl mb-6 border border-[#BADBCC] shadow-sm">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
        @endif

        <a href="{{ route('produk.create') }}" class="nav-link inline-block px-8 py-3 rounded-xl font-bold text-lg">
            + Menu Baru
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @foreach($produks as $produk)
        <div class="product-card p-5 flex flex-col items-center shadow-lg border border-white/20 {{ $produk->status == 'nonaktif' ? 'opacity-75 grayscale-[0.5]' : '' }}">
            
            <div class="w-full flex justify-end mb-2">
                @if($produk->status == 'aktif')
                    <span class="bg-green-100 text-green-600 text-[10px] font-black px-2 py-1 rounded-lg uppercase">Aktif</span>
                @else
                    <span class="bg-red-100 text-red-600 text-[10px] font-black px-2 py-1 rounded-lg uppercase">Nonaktif</span>
                @endif
            </div>

            <div class="w-full h-40 bg-white rounded-2xl mb-4 flex items-center justify-center overflow-hidden border border-black/5">
                <img src="{{ asset('storage/' . $produk->gambar) }}" class="w-full h-full object-contain p-2">
            </div>

            <h4 class="text-lg font-extrabold text-gray-800 text-center uppercase tracking-tight">
                {{ $produk->nama_produk }}
            </h4>
            <p class="text-gray-700 font-bold mt-1 mb-4">
                Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}
            </p>

            <div class="mt-auto flex gap-6 border-t border-black/5 pt-4 w-full justify-center">
                <a href="{{ route('produk.edit', $produk->id) }}" class="text-blue-600 font-bold hover:text-blue-800 transition text-sm">Edit</a>
                
                <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" onsubmit="return confirm('Hapus menu ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-500 font-bold hover:text-red-700 transition text-sm">Hapus</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection