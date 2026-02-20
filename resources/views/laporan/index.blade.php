@extends('layouts.app')

@section('content')

<style>
.laporan-container{
    background:#E7E0B5;
    padding:30px;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

.search-box{
    width:100%;
    padding:10px 15px;
    border-radius:20px;
    border:1px solid #ddd;
    margin-bottom:20px;
}

.table-laporan{
    width:100%;
    border-collapse:collapse;
    background:white;
    border-radius:15px;
    overflow:hidden;
}

.table-laporan th{
    background:#9BC34A;
    color:white;
    padding:12px;
    text-align:center;
}

.table-laporan td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid #eee;
}

.table-laporan tr:hover{
    background:#f5f5f5;
}
</style>

<h2 style="font-weight:bold;margin-bottom:20px;">
    Laporan Keuangan
</h2>

<div class="laporan-container">

    <form method="GET" action="{{ route('laporan.index') }}">
        <input type="number" 
               name="search"
               class="search-box"
               placeholder="Cari bulan (1-12)">
    </form>

    <table class="table-laporan">
        <thead>
            <tr>
                <th>No</th>
                <th>Bulan</th>
                <th>Total Omset</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->bulan }}</td>
                <td>Rp {{ number_format($item->total_omset) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3">Belum ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection
