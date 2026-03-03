@extends('layouts.app')

@section('content')
<style>
    /* 1. CSS UNTUK TAMPILAN DI LAYAR (SCREEN) */
    .printer-wrapper {
        position: relative;
        overflow: hidden;
        padding-top: 4px;
    }

    .printer-slot {
        height: 12px;
        background: #222;
        border-radius: 6px 6px 0 0;
        position: relative;
        z-index: 30;
        box-shadow: 0 2px 5px rgba(0,0,0,0.3);
    }

    @keyframes printerPrint {
        0% { transform: translateY(-100%); }
        100% { transform: translateY(0); }
    }

    @keyframes textReveal {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .animate-receipt {
        animation: printerPrint 2s cubic-bezier(0.45, 0.05, 0.55, 0.95) forwards;
        transform-origin: top;
    }

    .animate-item {
        opacity: 0;
        animation: textReveal 0.3s ease-out forwards;
    }

    .receipt-body {
        background: white;
        padding: 30px;
        font-family: 'Courier New', Courier, monospace;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border-left: 1px solid #eee;
        border-right: 1px solid #eee;
    }

    .receipt-edge {
        height: 15px;
        background: white;
        background-image: linear-gradient(135deg, transparent 75%, #f4f4f4 75%), 
                          linear-gradient(225deg, transparent 75%, #f4f4f4 75%);
        background-position: 0 0;
        background-repeat: repeat-x;
        background-size: 15px 15px;
        margin-top: -1px;
    }

    /* 2. CSS KHUSUS UNTUK PRINT (TIDAK AKAN MUNCUL DI LAYAR) */
    @media print {
        /* Menghilangkan elemen yang tidak perlu dicetak */
        .no-print, .printer-slot, .receipt-edge { 
            display: none !important; 
        }
        
        /* SOLUSI HALAMAN KOSONG: Memaksa padding bottom jadi 0 */
        .max-w-md { 
            padding-bottom: 0 !important; 
            margin: 0 !important; 
        }

        .printer-wrapper { 
            overflow: visible !important; 
        }

        .animate-receipt { 
            animation: none !important; 
            transform: none !important; 
        }

        .receipt-body { 
            box-shadow: none !important; 
            border: none !important; 
            padding: 0 !important; 
        }
    }
</style>

<div class="max-w-md mx-auto pb-20 px-4">
    <div class="printer-slot no-print"></div>

    <div class="printer-wrapper">
        <div class="animate-receipt">
            <div class="receipt-body border-t-[8px] border-pink-500">
                
                <div class="text-center mb-6">
                    <div class="inline-block bg-pink-100 text-pink-600 px-3 py-1 rounded-full text-[10px] font-black mb-2 animate-pulse">
                        TRANSAKSI BERHASIL
                    </div>
                    <h1 class="text-3xl font-black italic tracking-tighter text-gray-800">KYUU 88</h1>
                    <p class="text-[9px] text-gray-400 uppercase tracking-widest mt-1">Es Teler & Minuman Segar</p>
                    <div class="border-b-2 border-dashed border-gray-100 my-4"></div>
                    <p class="text-[11px] font-bold text-gray-500">
                        {{ $transaksi->created_at->format('d/m/Y H:i:s') }}
                    </p>
                </div>

                <div class="space-y-4 mb-8">
                    @foreach($transaksi->detail_produk as $index => $item)
                    <div class="flex justify-between items-end animate-item" 
                         style="animation-delay: {{ 0.5 + ($index * 0.2) }}s">
                        <div class="flex flex-col">
                            <span class="font-black text-gray-800 text-sm uppercase">{{ $item['nama'] }}</span>
                            <span class="text-[10px] text-gray-400">{{ $item['quantity'] }} x Rp {{ number_format($item['harga']) }}</span>
                        </div>
                        <span class="font-bold text-gray-700 text-sm">Rp {{ number_format($item['harga'] * $item['quantity']) }}</span>
                    </div>
                    @endforeach
                </div>

                <div class="border-t-2 border-dashed border-gray-100 pt-5 space-y-2">
                    <div class="flex justify-between text-[11px] font-bold text-gray-400 uppercase animate-item" style="animation-delay: 1.5s">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($transaksi->subtotal) }}</span>
                    </div>
                    <div class="flex justify-between text-[11px] font-bold text-gray-400 uppercase animate-item" style="animation-delay: 1.7s">
                        <span>Pajak (5%)</span>
                        <span>Rp {{ number_format($transaksi->pajak) }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-4 border-t-2 border-double border-gray-100 animate-item" style="animation-delay: 1.9s">
                        <span class="text-base font-black text-gray-800 tracking-tighter">TOTAL AKHIR</span>
                        <span class="text-2xl font-black text-pink-600">
                            Rp {{ number_format($transaksi->total_akhir) }}
                        </span>
                    </div>
                </div>

                <div class="mt-10 text-center animate-item" style="animation-delay: 2.2s">
                    <p class="text-[10px] font-bold text-gray-300 italic mb-2">~ Thank You for Coming! ~</p>
                    <div class="flex justify-center opacity-10">
                        <i class="fas fa-ice-cream text-3xl"></i>
                    </div>
                </div>
            </div>
            <div class="receipt-edge no-print"></div>
        </div>
    </div>

    <div class="mt-10 flex gap-3 no-print">
        <a href="{{ route('kasir.index') }}" class="flex-1 bg-white text-center py-4 rounded-2xl font-black text-gray-400 border-2 border-gray-100 hover:bg-gray-50 transition-all active:scale-95 text-sm">
            KEMBALI
        </a>
        <button onclick="window.print()" class="flex-[1.5] bg-[#b9db5a] text-gray-800 py-4 rounded-2xl font-black shadow-[0_6px_0_#9dbb4d] hover:shadow-none hover:translate-y-1 transition-all flex items-center justify-center gap-2 text-sm">
            <i class="fas fa-print"></i> CETAK STRUK
        </button>
    </div>
</div>
@endsection