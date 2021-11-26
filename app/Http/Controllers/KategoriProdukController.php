<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use App\Models\Produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class KategoriProdukController extends Controller
{
//     public function __construct()
//     {
//         $this->middleware('auth');
//     }

    public function create(Request $request)
    {
        $this->validate($request, [
            'jenis_kategori' => 'required'
        ]);

        $jenis_kategori = $request->input('jenis_kategori');

        $kategori = KategoriProduk::create([
            'jenis_kategori' => $jenis_kategori
        ]);

        if ($kategori) {
            return response()->json([
                'message' => 'Kategori Produk create success!',
                'data' => $kategori
            ], 201);
        }
    }

    public function index()
    {
        $kategori = KategoriProduk::all();

        if (empty($kategori)) {
            return response()->json(['error' => 'Kategori Produk Tidak Ditemukan'], 402);
        }
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

        if (!$kategori) {
            return response()->json(['error' => 'unknown error'], 500);
        }

        $this->validate($request, [
            'jenis_kategori' => 'required'
        ]);

        $datakategori = $request->all();
        $kategori->fill($datakategori);
        $kategori->save();
        
         return response()->json([
            'message' => 'Kategori Produk update!',
            'code' => 200
        ]);

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
