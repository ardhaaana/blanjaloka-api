<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use App\Models\Produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class KategoriProdukController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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

    public function show($id_kategori)
    {
        $kategori = KategoriProduk::find($id_kategori);

         if (empty($kategori)) {
            return response()->json(['error' => 'Kategori Produk Tidak Ditemukan'], 402);
        }

        return response()->json($kategori);
    }
    public function produkshow(Request $request, $id_kategori)
    {
        $kategori = KategoriProduk::find($id_kategori);
        $produk = Produk::all();
         $query = $request->query('query');

        if (empty($query)) {
            return response()->json(['error' => 'Query not specified!'], 400);
        }

        $fulltext = $request->query('fulltext', 'false');
        $sortBy = $request->query('sort_by', 'nama_produk.asc');
        $sorts = explode('.', $sortBy);


        if ($fulltext == 'true') {
            $produk = Produk::query()
                ->whereRaw("MATCH(nama_produk,deskripsi) AGAINST(? IN BOOLEAN MODE)", array($query))
                ->orderBy($sorts[0], $sorts[1])
                ->get();
             return response()->json(['message' => 'Success',
            'Kategori' => $kategori,
            'Produk' => $produk
        ]);
        }

        $produk = Produk::query()
            ->where('nama_produk', 'like', '%' . $query . '%')
            ->orWhere('deskripsi', 'like', '%' . $query . '%')
            ->orderBy($sorts[0], $sorts[1])
            ->get();

        if (empty($kategori)) {
            return response()->json(['error' => 'Kategori Produk Tidak Ditemukan'], 402);
        }

        return response()->json(['message' => 'Success',
        'Kategori' => $kategori,
        'Produk' => $produk
    ]);
    
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
            'jenis_kategori' => 'required',
            'daftar_produk' => 'required'
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
