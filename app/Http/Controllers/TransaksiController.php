<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\LaporanPenjualan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    // 1. Menampilkan Halaman Kasir (Grid Menu)
    public function kasir()
    {
        $produks = Produk::where('status', 'aktif')->get();
        return view('kasir.index', compact('produks'));
    }

    // 2. Perantara dari Grid Menu ke Form Input Pembayaran
    public function checkoutSession(Request $request) 
    {
        $cart = json_decode($request->cart_data, true);
        
        if (!$cart) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }

        $total = collect($cart)->sum(fn($item) => $item['harga'] * $item['quantity']);
        return view('kasir.input', compact('cart', 'total'));
    }

    // 3. Simpan Transaksi & Update Omset Otomatis
    public function store(Request $request) {
        $cart = json_decode($request->cart_data, true);
        $subtotal = collect($cart)->sum(fn($i) => $i['harga'] * $i['quantity']);
        $pajak = $subtotal * 0.05; // Pajak 5%
        $total_akhir = $subtotal + $pajak;
        
        // Simpan ke tabel Transaksi
        $trx = Transaksi::create([
            'nama_pelanggan' => $request->nama_pelanggan,
            'detail_produk' => $cart,
            'subtotal' => $subtotal,
            'pajak' => $pajak,
            'total_akhir' => $total_akhir,
            'total_harga' => $total_akhir, 
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);

        // LOGIKA LAPORAN: Update tabel laporan_penjualan otomatis
        $hariIni = Carbon::now()->toDateString();
        $laporan = LaporanPenjualan::firstOrCreate(
            ['tanggal' => $hariIni],
            ['total_omset' => 0]
        );
        $laporan->increment('total_omset', $total_akhir);
    
        return redirect()->route('kasir.struk', $trx->id);
    }

    // 4. Halaman Struk
    public function struk($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        return view('kasir.struk', compact('transaksi'));
    }

    public function index(Request $request)
    {
        $query = Transaksi::query();
    
        if ($request->filled('search')) {
            $query->where('nama_pelanggan', 'like', '%' . $request->search . '%');
        }
    
        $transaksi = $query->latest()->get();
    
        // Jika request datang dari JavaScript (AJAX)
        if ($request->ajax()) {
            return view('transaksi._table_rows', compact('transaksi'))->render();
        }
    
        // Jika buka halaman biasa
        return view('transaksi.index', compact('transaksi'));
    }

    // 6. Detail Transaksi
    public function show($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        return view('transaksi.detail', compact('transaksi'));
    }

    // 7. Laporan Keuangan (Mengambil dari tabel laporan_penjualan)
    public function laporan(Request $request)
    {
        $query = LaporanPenjualan::query();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }

        $laporan_data = $query->orderBy('tanggal', 'desc')->get();
        
        $total_omset_periode = $laporan_data->sum('total_omset');
        $jumlah_hari = $laporan_data->count();

        return view('laporan.index', compact('laporan_data', 'total_omset_periode', 'jumlah_hari'));
    }
}