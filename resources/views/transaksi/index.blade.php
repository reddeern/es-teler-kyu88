@extends('layouts.app')

@section('content')

<style>
.table-container{
    background:#EFE6C8;
    padding:25px;
    border-radius:20px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
}

table{
    width:100%;
    border-collapse:collapse;
}

th, td{
    padding:12px;
    text-align:left;
}

th{
    background:#DCCF9E;
}

tr:nth-child(even){
    background:#f7f1d9;
}

.btn-detail{
    background:#F08A8A;
    padding:6px 12px;
    border-radius:8px;
    color:white;
    text-decoration:none;
}
</style>

<h2 style="font-size:26px;font-weight:bold;margin-bottom:30px;">
    Data Transaksi
</h2>

<div class="table-container">

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Pelanggan</th>
            <th>Total</th>
            <th>Metode</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transaksi as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->nama_pelanggan }}</td>
            <td>Rp {{ number_format($item->total_akhir) }}</td>
            <td>{{ $item->metode_pembayaran }}</td>
            <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
            <td>
                <a href="{{ route('transaksi.show',$item->id) }}"
                   class="btn-detail">
                    Detail
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</div>

@endsection
