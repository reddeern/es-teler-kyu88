<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\LaporanPenjualan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransaksiApiController extends Controller
{
    // =====================================
    // GET PRODUK AKTIF (UNTUK KASIR DEVICE)
    // =====================================
    public function produkAktif()
    {
        $produks = Produk::where('status', 'aktif')->get();

        return response()->json([
            'success' => true,
            'data' => $produks
        ]);
    }

    // =====================================
    // STORE TRANSAKSI
    // =====================================
    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required',
            'metode_pembayaran' => 'required',
            'cart_data' => 'required|array'
        ]);

        DB::beginTransaction();

        try {

            $subtotal = collect($request->cart_data)
                ->sum(fn($i) => $i['harga'] * $i['quantity']);

            $pajak = $subtotal * 0.05;
            $total_akhir = $subtotal + $pajak;

            // simpan transaksi
            $trx = Transaksi::create([
                'nama_pelanggan' => $request->nama_pelanggan,
                'detail_produk' => $request->cart_data,
                'subtotal' => $subtotal,
                'pajak' => $pajak,
                'total_akhir' => $total_akhir,
                'total_harga' => $total_akhir,
                'metode_pembayaran' => $request->metode_pembayaran,
            ]);

            // update laporan otomatis
            $hariIni = Carbon::now()->toDateString();

            $laporan = LaporanPenjualan::firstOrCreate(
                ['tanggal' => $hariIni],
                ['total_omset' => 0]
            );

            $laporan->increment('total_omset', $total_akhir);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil',
                'data' => $trx
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal transaksi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // =====================================
    // LIST TRANSAKSI + SEARCH
    // =====================================
    public function index(Request $request)
    {
        $query = Transaksi::query();

        if ($request->filled('search')) {
            $query->where('nama_pelanggan', 'like', '%' . $request->search . '%');
        }

        $transaksi = $query->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $transaksi
        ]);
    }

    // =====================================
    // DETAIL TRANSAKSI
    // =====================================
    public function show($id)
    {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $transaksi
        ]);
    }

    // =====================================
    // LAPORAN PENJUALAN
    // =====================================
    public function laporan(Request $request)
    {
        $query = LaporanPenjualan::query();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal', [
                $request->start_date,
                $request->end_date
            ]);
        }

        $laporan_data = $query->orderBy('tanggal', 'desc')->get();

        return response()->json([
            'success' => true,
            'total_omset_periode' => $laporan_data->sum('total_omset'),
            'jumlah_hari' => $laporan_data->count(),
            'data' => $laporan_data
        ]);
    }
}