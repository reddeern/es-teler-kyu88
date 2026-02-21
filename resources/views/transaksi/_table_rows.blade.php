@forelse($transaksi as $item)
<tr class="border-b border-black/5">
    <td class="p-4">{{ $loop->iteration }}</td>
    <td class="p-4 uppercase">{{ $item->nama_pelanggan }}</td>
    <td class="p-4 text-pink-600">Rp {{ number_format($item->total_akhir) }}</td>
    <td class="p-4 text-xs">{{ $item->metode_pembayaran }}</td>
    <td class="p-4 text-xs">{{ $item->created_at->format('d/m/Y H:i') }}</td>
    <td class="p-4 text-center">
        <a href="{{ route('transaksi.show', $item->id) }}" class="bg-white px-3 py-1 rounded-lg shadow-sm border border-pink-200 text-xs">DETAIL</a>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="p-10 text-center text-gray-400 italic">Data tidak ditemukan...</td>
</tr>
@endforelse