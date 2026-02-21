<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index() {
        $produks = Produk::all();
        return view('produk.index', compact('produks'));
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nama_produk' => 'required',
        'harga_produk' => 'required|numeric',
        'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Proses Simpan Gambar
    $path = $request->file('gambar')->store('produk', 'public');

    // Simpan ke Database
    Produk::create([
        'nama_produk' => $request->nama_produk,
        'harga_produk' => $request->harga_produk,
        'gambar' => $path,
        'status' => 'aktif'
    ]);

    return redirect()->route('produk.index')->with('success', 'Menu berhasil ditambahkan!');
}

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('produk', 'public');
            $produk->gambar = $path;
        }

        $produk->update([
            'nama_produk' => $request->nama_produk,
            'harga_produk' => $request->harga_produk,
            'status' => $request->status
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('produk.index')
                         ->with('success', 'Produk berhasil dihapus');
    }
}