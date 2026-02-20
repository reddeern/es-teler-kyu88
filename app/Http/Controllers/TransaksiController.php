<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function kasir()
    {
        // Ambil semua produk dulu biar pasti muncul
        $produk = Produk::all();
        return view('kasir.index', compact('produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required',
            'metode_pembayaran' => 'required'
        ]);

        $produkDipilih = $request->produk ?? [];
        $subtotal = 0;
        $detail = [];

        foreach ($produkDipilih as $id => $qty) {

            if ($qty > 0) {

                $produk = Produk::find($id);

                if (!$produk) {
                    continue;
                }

                if ($produk->stok < $qty) {
                    return back()->with('stok_habis',
                        'Stok '.$produk->nama_produk.' tidak mencukupi. Sisa stok hanya '.$produk->stok.'.'
                    );
                }

                $total = $produk->harga * $qty;

                $detail[] = [
                    'nama' => $produk->nama_produk,
                    'harga' => $produk->harga,
                    'qty' => $qty,
                    'total' => $total
                ];

                $subtotal += $total;

                $produk->stok -= $qty;
                $produk->save();
            }
        }

        if ($subtotal == 0) {
            return back()->with('stok_habis', 'Silakan pilih minimal 1 produk.');
        }

        $pajak = $subtotal * 0.1;
        $totalAkhir = $subtotal + $pajak;

        $transaksi = Transaksi::create([
            'nama_pelanggan' => $request->nama_pelanggan,
            'detail_produk' => $detail,
            'subtotal' => $subtotal,
            'pajak' => $pajak,
            'total_akhir' => $totalAkhir,
            'total_harga' => $totalAkhir,
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);

        return redirect()->route('kasir.struk', $transaksi->id);
    }

    public function struk($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        return view('kasir.struk', compact('transaksi'));
    }

    public function index()
    {
        $transaksi = Transaksi::latest()->get();
        return view('transaksi.index', compact('transaksi'));
    }

    public function show($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        return view('transaksi.detail', compact('transaksi'));
    }

    public function laporan(Request $request)
    {
        $search = $request->search;

        $laporan = \App\Models\Transaksi::selectRaw('
                MONTH(created_at) as bulan_angka,
                DATE_FORMAT(created_at, "%M") as bulan,
                SUM(total_akhir) as total_omset
            ')
            ->when($search, function ($query) use ($search) {
                $query->whereMonth('created_at', $search);
            })
            ->groupBy('bulan_angka', 'bulan')
            ->orderBy('bulan_angka')
            ->get();

        return view('laporan.index', compact('laporan'));
    }
}
