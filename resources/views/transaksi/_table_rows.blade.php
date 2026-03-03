@forelse($transaksi as $index => $item)
{{-- Tambah class tr-animate dan hitungan delay biar munculnya berurutan --}}
<tr class="tr-animate border-b border-black/5 hover:bg-white/40 transition-colors" 
    style="animation-delay: {{ $index * 0.05 }}s">
    <td class="p-4">{{ $loop->iteration }}</td>
    <td class="p-4 uppercase">{{ $item->nama_pelanggan }}</td>
    <td class="p-4 text-pink-600 font-black">Rp {{ number_format($item->total_akhir) }}</td>
    <td class="p-4 text-xs font-bold">{{ $item->metode_pembayaran }}</td>
    <td class="p-4 text-xs text-gray-500">{{ $item->created_at->format('d/m/Y H:i') }}</td>
    <td class="p-4 text-center">
        <a href="{{ route('transaksi.show', $item->id) }}" 
           class="bg-white px-3 py-1 rounded-lg shadow-sm border border-pink-200 text-xs font-bold hover:bg-pink-500 hover:text-white transition-all active:scale-90 inline-block">
           DETAIL
        </a>
    </td>
</tr>
@empty
<tr class="animate-fade-up">
    <td colspan="6" class="p-10 text-center text-gray-400 italic">
        <div class="flex flex-col items-center gap-2">
            <i class="fas fa-search text-2xl opacity-20"></i>
            <span>Data tidak ditemukan...</span>
        </div>
    </td>
</tr>
@endforelse