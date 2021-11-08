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

    public function search(Request $request)
    {
        # code...
        $query = $request->query('query');

        if (empty($query)) {
            return response()->json(['error' => 'Query not specified!'], 400);
        }

        $fulltext = $request->query('fulltext', 'false');
        $sortBy = $request->query('sort_by', 'jenis_kategori.asc');
        $sorts = explode('.', $sortBy);


        if ($fulltext == 'true') {
            $data = KategoriProduk::query()
                ->whereRaw("MATCH(jenis_kategori) AGAINST(? IN BOOLEAN MODE)", array($query))
                ->orderBy($sorts[0], $sorts[1])
                ->get();
            return response()->json($data);
        }

        $data = KategoriProduk::query()
            ->where('jenis_kategori', 'like', '%' . $query . '%')
            ->orderBy($sorts[0], $sorts[1])
            ->get();

        return response()->json($data);
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
