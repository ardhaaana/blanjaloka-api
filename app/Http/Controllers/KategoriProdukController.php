<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use App\Models\Produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class KategoriProdukController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function create(Request $request)
    {
        $validate = [
            'jenis_kategori' => 'required'
        ];

        $pesan = [
            'jenis_kategori.required' => 'Jenis Kategori Tidak Boleh Kosong',
        ];

        $validator = Validator::make($request->all(), $validate, $pesan);
        
        if($validator->fails())
        {
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => $validator->errors()->first(),
                'data' => null,
            ]);
        }


        $jenis_kategori = $request->input('jenis_kategori');

        $kategori = KategoriProduk::create([
            'jenis_kategori' => $jenis_kategori
        ]);

        if ($kategori) {
            return response()->json([
                'code' => 200,
                'success' => true,
                'message' => 'Kategori Produk create success!',
                'data' => $kategori
            ]);
        }
    }

    public function index()
    {
        $kategori = KategoriProduk::all();

        if (empty($kategori)) {
            return response()->json(['code' => 402,'success' => false,'error' => 'Kategori Produk Tidak Ditemukan']);
        }
        return response()->json(['code' => 200,'success' => true, 
                                'message' => 'Menampilkan Kategori Produk', 
                                'Data' => $kategori]);
    }

    public function update(Request $request, $id_kategori)
    {
        $kategori = KategoriProduk::find($id_kategori);

        if (!$kategori) {
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => 'Data tidak ditemukan',
                'data' => $kategori
            ]);
        }

        if (!$kategori) {
            return response()->json(['error' => 'unknown error'], 500);
        }

        $validate = [
            'jenis_kategori' => 'required'
        ];

        $pesan = [
            'jenis_kategori.required' => 'Jenis Kategori Tidak Boleh Kosong',
        ];

        $validator = Validator::make($request->all(), $validate, $pesan);
        
        if($validator->fails())
        {
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => $validator->errors()->first(),
                'data' => null,
            ]);
        }

        $datakategori = $request->all();
        $kategori->fill($datakategori);
        $kategori->save();
        
         return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'Kategori Produk update!',
            'Data' => $kategori
        ]);
    }

    public function destroy($id_kategori)
    {
        $kategori = KategoriProduk::find($id_kategori);

        if (!$kategori) {
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => 'Data tidak ditemukan',
                'data' => $kategori
            ]);
        }

        $kategori->delete();

        return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'Data berhasil dihapus',
            'data' => $kategori
        ]);
    }
}
