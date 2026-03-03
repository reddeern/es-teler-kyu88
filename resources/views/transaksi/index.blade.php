@extends('layouts.app')

@section('content')
<style>
    /* Animasi Masuk Awal (Fade Up) */
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Animasi Baris Tabel (Slide dari Kanan) */
    @keyframes rowIn {
        from { opacity: 0; transform: translateX(10px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .animate-main {
        animation: slideUp 0.6s ease-out forwards;
    }

    /* Class untuk baris tabel yang baru muncul */
    .tr-animate {
        opacity: 0;
        animation: rowIn 0.4s ease-out forwards;
    }

    /* Efek halus pas data lagi di-fetch */
    .loading-fade {
        opacity: 0.4;
        transition: opacity 0.2s ease;
    }
</style>

<div class="animate-main">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-2xl font-black uppercase tracking-tighter">Data Transaksi</h2>
        
        <div class="flex flex-wrap gap-2">
            <input type="text" id="searchInput" placeholder="Cari pelanggan..." 
                class="p-3 rounded-xl border-none shadow-sm text-sm w-64 focus:ring-4 focus:ring-pink-300 transition-all">
            
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
            <tbody id="tableBody" class="font-bold text-gray-700 transition-all">
                @include('transaksi._table_rows')
            </tbody>
        </table>
    </div>
</div>

<script>
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('tableBody');
    let typingTimer;

    searchInput.addEventListener('keyup', function() {
        clearTimeout(typingTimer);
        
        // Efek loading (redup) pas mulai ngetik
        tableBody.classList.add('loading-fade');

        typingTimer = setTimeout(function() {
            let keyword = searchInput.value;
            
            fetch(`{{ route('transaksi.index') }}?search=${keyword}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.text())
            .then(data => {
                tableBody.innerHTML = data;
                tableBody.classList.remove('loading-fade');

                // Tambahkan animasi ke tiap baris yang baru masuk
                const rows = tableBody.querySelectorAll('tr');
                rows.forEach((row, index) => {
                    row.classList.add('tr-animate');
                    row.style.animationDelay = (index * 0.03) + 's';
                });
            });
        }, 300); // Debounce 300ms biar nggak spam server
    });
</script>
@endsection