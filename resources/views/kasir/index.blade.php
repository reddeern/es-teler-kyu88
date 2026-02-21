@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <div class="flex justify-between items-start mb-10">
        <div>
            <h2 class="text-4xl font-black text-gray-800 uppercase tracking-widest">Pilih Pesanan</h2>
            <p class="text-gray-500 font-bold">Es Teler Kyuu 88 - Kasir Mode</p>
        </div>

        <div class="flex flex-col items-end gap-3">
            <div class="bg-white border-4 border-[#b9db5a] rounded-2xl p-3 px-5 shadow-lg flex items-center gap-4 hover:scale-105 transition-transform duration-300">
                <div class="text-right">
                    <div id="liveClock" class="text-2xl font-black text-gray-800 tracking-tighter tabular-nums">00:00:00</div>
                    <div class="text-[10px] font-bold text-pink-500 uppercase">
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </div>
                </div>
                <div class="bg-[#b9db5a] text-white p-2 rounded-xl shadow-inner">
                    <i class="fas fa-clock text-xl animate-pulse"></i>
                </div>
            </div>

            <div class="bg-white px-6 py-2 rounded-full shadow-md border-2 border-pink-400 flex items-center gap-3">
                <span class="font-bold text-gray-600 uppercase text-xs tracking-widest">Items Terpilih:</span>
                <span id="cartCount" class="font-black text-pink-500 text-2xl">0</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 mb-24">
        @foreach($produks as $produk)
        <div class="bg-[#F2E3B6] p-5 rounded-[40px] shadow-xl border-b-8 border-black/10 flex flex-col items-center group hover:-translate-y-2 transition-all duration-300">
            <div class="w-full h-40 bg-white rounded-[30px] mb-4 overflow-hidden border-4 border-transparent group-hover:border-pink-300 transition shadow-inner">
                <img src="{{ asset('storage/'.$produk->gambar) }}" class="w-full h-full object-contain p-4 group-hover:scale-110 transition-transform">
            </div>
            
            <h4 class="font-black text-gray-800 uppercase text-center text-sm mb-1 px-2">{{ $produk->nama_produk }}</h4>
            <p class="text-pink-600 font-black text-lg mb-4">Rp {{ number_format($produk->harga_produk) }}</p>
            
            <button onclick="tambahItem({{ $produk->id }}, '{{ $produk->nama_produk }}', {{ $produk->harga_produk }})"
                class="bg-pink-400 hover:bg-pink-500 text-white w-14 h-14 rounded-2xl shadow-lg flex items-center justify-center transition active:scale-90 hover:rotate-12">
                <i class="fas fa-plus text-2xl"></i>
            </button>
        </div>
        @endforeach
    </div>

    <div class="fixed bottom-10 right-10 z-50">
        <form action="{{ route('kasir.checkout_session') }}" method="POST" id="formCheckout">
            @csrf
            <input type="hidden" name="cart_data" id="cartInput">
            <button type="button" onclick="kirimKeInput()" 
                class="bg-[#b9db5a] hover:bg-[#a6c74d] text-gray-800 px-12 py-5 rounded-[25px] text-2xl font-black shadow-[0_15px_0_rgb(140,170,60)] flex items-center gap-4 transition-all active:translate-y-2 active:shadow-none">
                INPUT PESANAN <i class="fas fa-arrow-right"></i>
            </button>
        </form>
    </div>
</div>

<script>
    // 1. Script Jam
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('liveClock').innerText = `${hours}:${minutes}:${seconds}`;
    }
    setInterval(updateClock, 1000);
    updateClock();

    // 2. Script Keranjang
    let cart = [];
    function tambahItem(id, nama, harga) {
        const item = cart.find(i => i.id === id);
        if (item) { 
            item.quantity++; 
        } else { 
            cart.push({id, nama, harga, quantity: 1}); 
        }
        
        // Update angka di bulatan pink
        const totalItems = cart.reduce((sum, i) => sum + i.quantity, 0);
        document.getElementById('cartCount').innerText = totalItems;

        // Efek visual saat nambah (opsional)
        const counter = document.getElementById('cartCount');
        counter.classList.add('scale-125', 'text-green-500');
        setTimeout(() => counter.classList.remove('scale-125', 'text-green-500'), 200);
    }

    // 3. Kirim Data
    function kirimKeInput() {
        if (cart.length === 0) {
            alert('Pilih menu dulu dong!');
            return;
        }
        document.getElementById('cartInput').value = JSON.stringify(cart);
        document.getElementById('formCheckout').submit();
    }
</script>

<style>
    /* Tabular nums buat angka jam biar gak geser-geser pas detik jalan */
    .tabular-nums {
        font-variant-numeric: tabular-nums;
    }
</style>
@endsection