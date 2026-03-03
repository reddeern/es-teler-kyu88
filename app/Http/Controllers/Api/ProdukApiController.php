<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukApiController extends Controller
{
    // ===============================
    // GET ALL PRODUK
    // ===============================
    public function index()
    {
        $produks = Produk::all();

        return response()->json([
            'success' => true,
            'data' => $produks
        ]);
    }

    // ===============================
    // GET DETAIL PRODUK
    // ===============================
    public function show($id)
    {
        $produk = Produk::find($id);

        if (!$produk) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $produk
        ]);
    }

    // ===============================
    // STORE PRODUK
    // ===============================
    public function store(Request $request)
{
    $request->validate([
        'nama_produk' => 'required',
        'harga_produk' => 'required|numeric',
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $path = null;

    if ($request->hasFile('gambar')) {
        $path = $request->file('gambar')->store('produk', 'public');
    }

    $produk = Produk::create([
        'nama_produk' => $request->nama_produk,
        'harga_produk' => $request->harga_produk,
        'gambar' => $path,
        'status' => 'aktif'
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Produk berhasil ditambahkan',
        'data' => $produk
    ], 201);
}

    // ===============================
    // UPDATE PRODUK
    // ===============================
    public function update(Request $request, $id)
    {
        $produk = Produk::find($id);

        if (!$produk) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'nama_produk' => 'required',
            'harga_produk' => 'required|numeric',
            'status' => 'required'
        ]);

        if ($request->hasFile('gambar')) {

            // Hapus gambar lama
            if ($produk->gambar) {
                Storage::disk('public')->delete($produk->gambar);
            }

            $path = $request->file('gambar')->store('produk', 'public');
            $produk->gambar = $path;
        }

        $produk->update([
            'nama_produk' => $request->nama_produk,
            'harga_produk' => $request->harga_produk,
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil diperbarui',
            'data' => $produk
        ]);
    }

    // ===============================
    // DELETE PRODUK
    // ===============================
    public function destroy($id)
    {
        $produk = Produk::find($id);

        if (!$produk) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        if ($produk->gambar) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus'
        ]);
    }
}