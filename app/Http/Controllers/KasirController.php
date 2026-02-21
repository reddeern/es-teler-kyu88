<?php
namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function index()
    {
        // Hanya ambil produk aktif
        $produks = Produk::where('status', 'aktif')->get();
        return view('kasir.index', compact('produks'));
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'nama_pelanggan' => 'required',
            'metode_pembayaran' => 'required',
            'cart_data' => 'required' // Kita kirim JSON dari JS
        ]);

        $cart = json_decode($request->cart_data, true);
        $subtotal = collect($cart)->sum(fn($item) => $item['harga'] * $item['quantity']);
        $pajak = $subtotal * 0.1;
        $total_akhir = $subtotal + $pajak;

        $transaksi = Transaksi::create([
            'nama_pelanggan' => $request->nama_pelanggan,
            'detail_produk' => $cart, // Pastikan field ini 'json' atau 'array' di Model
            'subtotal' => $subtotal,
            'pajak' => $pajak,
            'total_akhir' => $total_akhir,
            'total_harga' => $total_akhir,
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);

        return redirect()->route('kasir.struk', $transaksi->id)->with('success', 'Transaksi Berhasil!');
    }

    public function struk($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        return view('kasir.struk', compact('transaksi'));
    }
}