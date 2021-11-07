<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class KategoriProdukController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function create(Request $request)
    {
        $this->validate($request, [
            'jenis_kategori' => 'required',
            'daftar_produk' => 'required'
        ]);

        $jenis_kategori = $request->input('jenis_kategori');
        $daftar_produk = $request->input('daftar_produk');

        $kategori = KategoriProduk::create([
            'jenis_kategori' => $jenis_kategori,
            'daftar_produk' => $daftar_produk
        ]);

        if ($kategori) {
            return response()->json([
                'message' => 'Penambahan data berhasil',
                'data' => $kategori
            ], 201);
        }
    }

    public function index()
    {
        $kategori = KategoriProduk::all();
        return response()->json($kategori);
    }

    public function show($id_kategori)
    {
        $kategori = KategoriProduk::find($id_kategori);
        return response()->json($kategori);
    }

    public function update(Request $request, $id_kategori)
    {
        $kategori = KategoriProduk::find($id_kategori);

        if (!$kategori) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'data' => $kategori
            ], 404);
        }

        $this->validate($request, [
            'jenis_kategori' => 'required',
            'daftar_produk' => 'required'
        ]);

        $datakategori = $request->all();
        $kategori->fill($datakategori);
        $kategori->save();

        return response()->json($kategori);
    }

    public function destroy($id_kategori)
    {
        $kategori = KategoriProduk::find($id_kategori);

        if (!$kategori) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'data' => $kategori
            ], 404);
        }

        $kategori->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus',
            'data' => $kategori
        ], 200);
    }
}
