@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
    <h2 class="text-2xl font-black uppercase tracking-tighter">Data Transaksi</h2>
    
    <div class="flex flex-wrap gap-2">
        <input type="text" id="searchInput" placeholder="Cari pelanggan..." 
            class="p-3 rounded-xl border-none shadow-sm text-sm w-64 focus:ring-4 focus:ring-pink-300">
        
        <input type="date" id="startDate" class="p-3 rounded-xl border-none shadow-sm text-sm">
        <input type="date" id="endDate" class="p-3 rounded-xl border-none shadow-sm text-sm">
    </div>
</div>

<div class="bg-[#F2E3B6] p-6 rounded-[32px] shadow-xl border-4 border-black/5 overflow-x-auto">
    <table class="w-full text-left">
        <thead>
            <tr class="bg-[#DCCF9E] text-gray-800 uppercase text-xs">
                <th class="p-4">No</th>
                <th class="p-4">Pelanggan</th>
                <th class="p-4">Total Akhir</th>
                <th class="p-4">Metode</th>
                <th class="p-4">Tanggal</th>
                <th class="p-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody id="tableBody" class="font-bold text-gray-700">
            @include('transaksi._table_rows') </tbody>
    </table>
</div>

<script>
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('tableBody');

    searchInput.addEventListener('keyup', function() {
        let keyword = searchInput.value;
        
        // Fetch data secara background
        fetch(`{{ route('transaksi.index') }}?search=${keyword}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(data => {
            tableBody.innerHTML = data; // Update isi tabel saja
        });
    });
</script>
@endsection