@extends('layouts.app')

@section('content')
<style>
    /* Animasi Masuk Utama */
    @keyframes slideInDown {
        from { opacity: 0; transform: translateY(-30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes cardPop {
        from { opacity: 0; transform: scale(0.8) translateY(30px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    .animate-header {
        animation: slideInDown 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .kasir-card {
        opacity: 0;
        animation: cardPop 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
    }

    /* Efek Angka Berubah */
    .count-bump {
        animation: bump 0.3s ease-out;
    }

    @keyframes bump {
        0% { transform: scale(1); }
        50% { transform: scale(1.5); color: #ec4899; }
        100% { transform: scale(1); }
    }

    /* Floating Button Animation */
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }

    .btn-checkout {
        animation: float 3s ease-in-out infinite;
    }
    
    .btn-checkout:active {
        animation: none;
        transform: translateY(2px);
    }
</style>

<div class="max-w-7xl mx-auto px-4">
    <div class="flex justify-between items-start mb-10 animate-header">
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
                <span id="cartCount" class="font-black text-pink-500 text-2xl transition-all inline-block">0</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 mb-24">
        @foreach($produks as $index => $produk)
        <div class="kasir-card bg-[#F2E3B6] p-5 rounded-[40px] shadow-xl border-b-8 border-black/10 flex flex-col items-center group hover:-translate-y-2 transition-all duration-300"
             style="animation-delay: {{ $index * 0.1 }}s">
            
            <div class="w-full h-40 bg-white rounded-[30px] mb-4 overflow-hidden border-4 border-transparent group-hover:border-pink-300 transition shadow-inner relative">
                <img id="img-{{ $produk->id }}" src="{{ asset('storage/'.$produk->gambar) }}" class="w-full h-full object-contain p-4 group-hover:scale-110 transition-transform">
            </div>
            
            <h4 class="font-black text-gray-800 uppercase text-center text-sm mb-1 px-2">{{ $produk->nama_produk }}</h4>
            <p class="text-pink-600 font-black text-lg mb-4">Rp {{ number_format($produk->harga_produk) }}</p>
            
            <button onclick="tambahItem(event, {{ $produk->id }}, '{{ $produk->nama_produk }}', {{ $produk->harga_produk }})"
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
                class="btn-checkout bg-[#b9db5a] hover:bg-[#a6c74d] text-gray-800 px-12 py-5 rounded-[25px] text-2xl font-black shadow-[0_15px_0_rgb(140,170,60)] flex items-center gap-4 transition-all active:translate-y-2 active:shadow-none">
                INPUT PESANAN <i class="fas fa-arrow-right"></i>
            </button>
        </form>
    </div>
</div>

<script>
    // 1. Script Jam
    function updateClock() {
        const now = new Date();
        document.getElementById('liveClock').innerText = now.toLocaleTimeString('id-ID', { hour12: false });
    }
    setInterval(updateClock, 1000);
    updateClock();

    // 2. Script Keranjang
    let cart = [];

    function tambahItem(event, id, nama, harga) {
        const img = document.getElementById('img-' + id);
        const cartTarget = document.getElementById('cartCount');
        
        // Ambil posisi awal & akhir
        const startRect = img.getBoundingClientRect();
        const endRect = cartTarget.getBoundingClientRect();

        // Buat kloning gambar untuk terbang
        const flyingImg = img.cloneNode();
        
        Object.assign(flyingImg.style, {
            position: 'fixed',
            zIndex: '9999',
            width: startRect.width + 'px',
            height: startRect.height + 'px',
            top: startRect.top + 'px',
            left: startRect.left + 'px',
            opacity: '1',
            pointerEvents: 'none',
            borderRadius: '20px',
            backgroundColor: 'white', 
            boxShadow: '0 0 30px rgba(236, 72, 153, 0.8)',
            border: '4px solid #ec4899',
            transition: 'all 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275)',
        });

        document.body.appendChild(flyingImg);

        requestAnimationFrame(() => {
            flyingImg.style.transform = 'scale(1.2) rotate(15deg)';
            
            setTimeout(() => {
                flyingImg.style.top = (endRect.top - 20) + 'px';
                flyingImg.style.left = (endRect.left - 20) + 'px';
                flyingImg.style.width = '40px';
                flyingImg.style.height = '40px';
                flyingImg.style.opacity = '0.5';
                flyingImg.style.transform = 'scale(0.5) rotate(360deg)';
            }, 100);
        });

        setTimeout(() => {
            flyingImg.remove();
            
            // Logika Update Cart
            const item = cart.find(i => i.id === id);
            if (item) { 
                item.quantity++; 
            } else { 
                cart.push({id, nama, harga, quantity: 1}); 
            }
            
            // Update UI Angka
            const counter = document.getElementById('cartCount');
            counter.innerText = cart.reduce((sum, i) => sum + i.quantity, 0);
            
            // Efek Bump
            counter.classList.remove('count-bump');
            void counter.offsetWidth; 
            counter.classList.add('count-bump');
        }, 800);
    }

    function kirimKeInput() {
        if (cart.length === 0) {
            alert('Pilih menu dulu dong!');
            return;
        }
        document.getElementById('cartInput').value = JSON.stringify(cart);
        document.getElementById('formCheckout').submit();
    }
</script>
@endsection