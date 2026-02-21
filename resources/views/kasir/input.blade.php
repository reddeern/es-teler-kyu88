@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h2 class="text-3xl font-black text-gray-800 mb-8 uppercase text-center">Detail Pembayaran</h2>

    <div class="bg-[#F2E3B6] p-10 rounded-[40px] shadow-2xl border-4 border-white/50">
        <form action="{{ route('kasir.store') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="cart_data" value="{{ json_encode($cart) }}">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-4">
                    <div>
                        <label class="block font-black text-gray-700 mb-2">NAMA PELANGGAN</label>
                        <input type="text" name="nama_pelanggan" required class="w-full p-4 rounded-2xl border-none shadow-inner outline-none focus:ring-4 focus:ring-pink-300 font-bold">
                    </div>
                    <div>
                        <label class="block font-black text-gray-700 mb-2">METODE PEMBAYARAN</label>
                        <div class="flex gap-4">
                            <label class="flex-1">
                                <input type="radio" name="metode_pembayaran" value="QRIS" class="hidden peer" required>
                                <div class="p-4 text-center bg-white rounded-2xl font-black peer-checked:bg-pink-500 peer-checked:text-white cursor-pointer transition shadow-md">QRIS</div>
                            </label>
                            <label class="flex-1">
                                <input type="radio" name="metode_pembayaran" value="CASH" class="hidden peer" checked>
                                <div class="p-4 text-center bg-white rounded-2xl font-black peer-checked:bg-pink-500 peer-checked:text-white cursor-pointer transition shadow-md">CASH</div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="bg-white/50 p-6 rounded-[32px] space-y-4">
                    <div class="flex justify-between font-bold text-gray-600">
                        <span>Total Belanja:</span>
                        <span id="total_belanja" data-val="{{ $total }}">Rp {{ number_format($total) }}</span>
                    </div>
                    <div>
                        <label class="block font-black text-gray-700 mb-2">UANG TERIMA</label>
                        <input type="number" name="uang_terima" id="uang_terima" oninput="hitungKembali()" required 
                            class="w-full p-4 rounded-2xl border-none shadow-inner text-2xl font-black text-green-600 focus:ring-4 focus:ring-green-300">
                    </div>
                    <div>
                        <label class="block font-black text-gray-700 mb-2">UANG KEMBALI</label>
                        <div id="uang_kembali" class="text-3xl font-black text-pink-500">Rp 0</div>
                    </div>
                </div>
            </div>

            <button type="submit" class="nav-link w-full py-5 rounded-3xl text-3xl font-black mt-6 shadow-xl uppercase tracking-tighter">
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
        document.getElementById('uang_kembali').innerText = 'Rp ' + (kembali > 0 ? kembali.toLocaleString() : 0);
    }
</script>
@endsection