@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white p-8 rounded-[40px] shadow-2xl border-t-[12px] border-pink-500 font-mono">

    <div class="text-center mb-4">
        <p class="text-xs uppercase font-bold">
            Tanggal: {{ $transaksi->created_at->format('d/m/Y') }} <br>
            Jam: {{ $transaksi->created_at->format('H:i:s') }}
        </p>
    </div>
    
    <div class="text-center mb-6">
        <h1 class="text-3xl font-black italic">KYUU 88</h1>
        <p class="text-xs text-gray-400">Terima kasih sudah memesan!</p>
    </div>

    <div class="space-y-3 mb-6">
        @foreach($transaksi->detail_produk as $item)
        <div class="flex justify-between">
            <span class="font-bold">{{ $item['nama'] }} ({{ $item['quantity'] }}x)</span>
            <span>Rp {{ number_format($item['harga'] * $item['quantity']) }}</span>
        </div>
        @endforeach
    </div>

    <div class="border-t-4 border-double border-gray-200 pt-4 space-y-2">
        <div class="flex justify-between text-gray-500"><span>Subtotal:</span><span>Rp {{ number_format($transaksi->subtotal) }}</span></div>
        <div class="flex justify-between text-gray-500"><span>Pajak (5%):</span><span>Rp {{ number_format($transaksi->pajak) }}</span></div>
        <div class="flex justify-between text-2xl font-black border-t-2 border-gray-100 pt-2">
            <span>TOTAL AKHIR:</span>
            <span class="text-pink-600">Rp {{ number_format($transaksi->total_akhir) }}</span>
        </div>
    </div>

    <div class="mt-10 flex gap-4 print:hidden">
        <a href="{{ route('dashboard') }}" class="flex-1 bg-gray-200 text-center py-4 rounded-2xl font-black text-gray-600">DASHBOARD</a>
        <button onclick="window.print()" class="flex-1 bg-pink-500 text-white py-4 rounded-2xl font-black shadow-lg">CETAK STRUK</button>
    </div>
</div>
@endsection