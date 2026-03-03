@extends('layouts.app')

@section('content')
<style>
    /* Animasi Judul */
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Animasi Kartu Utama muncul dari bawah */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Animasi angka kembali saat berubah */
    @keyframes highlight {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); color: #22c55e; }
        100% { transform: scale(1); }
    }

    .animate-title {
        animation: fadeInDown 0.6s ease-out forwards;
    }

    .animate-card {
        animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .pulse-green:focus {
        box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.3);
        transition: all 0.3s ease;
    }

    .kembali-update {
        animation: highlight 0.3s ease-out;
    }
</style>

<div class="max-w-4xl mx-auto">
    <h2 class="text-3xl font-black text-gray-800 mb-8 uppercase text-center animate-title tracking-widest">
        Detail Pembayaran
    </h2>

    <div class="bg-[#F2E3B6] p-10 rounded-[40px] shadow-2xl border-4 border-white/50 animate-card">
        <form action="{{ route('kasir.store') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="cart_data" value="{{ json_encode($cart) }}">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div>
                        <label class="block font-black text-gray-700 mb-2 tracking-tighter">NAMA PELANGGAN</label>
                        <input type="text" name="nama_pelanggan" autofocus required 
                            class="w-full p-4 rounded-2xl border-none shadow-inner outline-none focus:ring-4 focus:ring-pink-300 font-bold transition-all"
                            placeholder="Masukkan nama...">
                    </div>
                    <div>
                        <label class="block font-black text-gray-700 mb-2 tracking-tighter">METODE PEMBAYARAN</label>
                        <div class="flex gap-4">
                            <label class="flex-1">
                                <input type="radio" name="metode_pembayaran" value="QRIS" class="hidden peer" required>
                                <div class="p-4 text-center bg-white rounded-2xl font-black peer-checked:bg-pink-500 peer-checked:text-white cursor-pointer transition-all shadow-md active:scale-90">
                                    <i class="fas fa-qrcode mr-2"></i>QRIS
                                </div>
                            </label>
                            <label class="flex-1">
                                <input type="radio" name="metode_pembayaran" value="CASH" class="hidden peer" checked>
                                <div class="p-4 text-center bg-white rounded-2xl font-black peer-checked:bg-pink-500 peer-checked:text-white cursor-pointer transition-all shadow-md active:scale-90">
                                    <i class="fas fa-money-bill-wave mr-2"></i>CASH
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="bg-white/40 p-6 rounded-[32px] border border-white/50 space-y-4">
                    <div class="flex justify-between font-bold text-gray-600 border-b border-dashed border-gray-400 pb-2">
                        <span>Total Belanja:</span>
                        <span id="total_belanja" data-val="{{ $total }}" class="text-gray-800">Rp {{ number_format($total) }}</span>
                    </div>
                    
                    <div>
                        <label class="block font-black text-gray-700 mb-2">UANG TERIMA</label>
                        <div class="relative">
                            <span class="absolute left-4 top-4 font-black text-green-700 text-2xl">Rp</span>
                            <input type="number" name="uang_terima" id="uang_terima" oninput="hitungKembali()" required 
                                class="w-full p-4 pl-14 rounded-2xl border-none shadow-inner text-3xl font-black text-green-600 focus:ring-4 focus:ring-green-400 outline-none pulse-green transition-all"
                                placeholder="0">
                        </div>
                    </div>

                    <div class="pt-2">
                        <label class="block font-black text-gray-700 mb-1">UANG KEMBALI</label>
                        <div id="uang_kembali" class="text-4xl font-black text-pink-500 tabular-nums transition-all">
                            Rp 0
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="nav-link w-full py-6 rounded-3xl text-3xl font-black mt-6 shadow-xl uppercase tracking-tighter transition-all active:scale-95 hover:brightness-110">
                PROSES & CETAK <i class="fas fa-print ml-2"></i>
            </button>
        </form>
    </div>
</div>

<script>
    function hitungKembali() {
        const total = parseInt(document.getElementById('total_belanja').getAttribute('data-val'));
        const terima = parseInt(document.getElementById('uang_terima').value) || 0;
        const kembali = terima - total;
        const displayKembali = document.getElementById('uang_kembali');
        
        // Update teks
        displayKembali.innerText = 'Rp ' + (kembali > 0 ? kembali.toLocaleString('id-ID') : 0);
        
        // Efek visual kaget pas angka berubah
        displayKembali.classList.remove('kembali-update');
        void displayKembali.offsetWidth; // trigger reflow
        displayKembali.classList.add('kembali-update');

        // Ubah warna jadi hijau kalau uangnya cukup
        if (kembali >= 0) {
            displayKembali.classList.replace('text-pink-500', 'text-green-600');
        } else {
            displayKembali.classList.replace('text-green-600', 'text-pink-500');
        }
    }
</script>
@endsection