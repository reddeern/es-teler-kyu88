@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <h2 class="text-3xl font-black text-gray-800 uppercase tracking-tighter">Ringkasan Omset</h2>
        
        <form action="{{ route('laporan.index') }}" method="GET" class="flex gap-2 bg-white p-2 rounded-2xl shadow-sm border-2 border-[#F2E3B6]">
            <input type="date" name="start_date" value="{{ request('start_date') }}" class="p-2 rounded-xl border-none outline-none">
            <span class="self-center font-bold text-gray-400">s/d</span>
            <input type="date" name="end_date" value="{{ request('end_date') }}" class="p-2 rounded-xl border-none outline-none">
            <button type="submit" class="bg-pink-500 text-white px-6 py-2 rounded-xl font-black hover:bg-pink-600 transition">FILTER</button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
        <div class="bg-[#F2E3B6] p-8 rounded-[40px] shadow-xl flex items-center justify-between border-b-8 border-black/10">
            <div>
                <p class="text-gray-600 font-bold uppercase text-xs mb-1">Total Omset Periode</p>
                <h3 class="text-4xl font-black text-gray-900">Rp {{ number_format($total_omset_periode) }}</h3>
            </div>
            <i class="fas fa-wallet text-5xl text-black/10"></i>
        </div>
        <div class="bg-white p-8 rounded-[40px] shadow-xl flex items-center justify-between border-b-8 border-pink-400">
            <div>
                <p class="text-gray-400 font-bold uppercase text-xs mb-1">Rata-rata Harian</p>
                <h3 class="text-4xl font-black text-pink-500">
                    Rp {{ number_format($jumlah_hari > 0 ? $total_omset_periode / $jumlah_hari : 0) }}
                </h3>
            </div>
            <i class="fas fa-chart-line text-5xl text-pink-100"></i>
        </div>
    </div>

    <div class="bg-white rounded-[35px] shadow-2xl overflow-hidden border-4 border-[#F2E3B6]">
        <table class="w-full text-left">
            <thead class="bg-[#F2E3B6] text-gray-800 uppercase text-sm">
                <tr>
                    <th class="p-6">Tanggal</th>
                    <th class="p-6 text-right">Total Omset Harian</th>
                    <th class="p-6 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="font-bold text-gray-700">
                @foreach($laporan_data as $data)
                <tr class="border-b border-gray-100 hover:bg-pink-50 transition">
                    <td class="p-6">{{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('d F Y') }}</td>
                    <td class="p-6 text-right text-green-600 text-xl">Rp {{ number_format($data->total_omset) }}</td>
                    <td class="p-6 text-center">
                        <span class="bg-green-100 text-green-600 px-4 py-1 rounded-full text-xs uppercase">Recorded</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection