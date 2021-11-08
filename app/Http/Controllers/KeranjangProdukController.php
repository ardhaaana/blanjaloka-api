<?php

namespace App\Http\Controllers;

use App\Models\KeranjangProduk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class KeranjangProdukController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function create(Request $request)
    {
        $this->validate($request, [
            'nama_produk' => 'required',
            'harga_jual' => 'required',
            'jumlah_beli' => 'required',
            'total_harga' => 'required',
            'detail_produk' => 'required'
        ]);

        $nama_produk = $request->input('nama_produk');
        $harga_jual = $request->input('harga_jual');
        $jumlah_beli = $request->input('jumlah_beli');
        $total_harga = $request->input('total_harga');
        $detail_produk = $request->input('detail_produk');

        $keranjang = KeranjangProduk::create([
            'nama_produk' => $nama_produk,
            'harga_jual' => $harga_jual,
            'jumlah_beli' => $jumlah_beli,
            'total_harga' => $total_harga,
            'detail_produk' => $detail_produk
        ]);

        if ($keranjang) {
            return response()->json([
                'message' => 'Penambahan data berhasil',
                'data' => $keranjang
            ], 201);
        }
    }

    public function index()
    {
        $keranjang = KeranjangProduk::all();
        return response()->json($keranjang);
    }

    public function show($id_keranjang)
    {
        $keranjang = KeranjangProduk::find($id_keranjang);
        return response()->json($keranjang);
    }

    public function update(Request $request, $id_keranjang)
    {
        $keranjang = KeranjangProduk::find($id_keranjang);

        if (!$keranjang) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'data' => $keranjang
            ], 404);
        }

        $this->validate($request, [
            'nama_produk' => 'required',
            'harga_jual' => 'required',
            'jumlah_beli' => 'required',
            'total_harga' => 'required',
            'detail_produk' => 'required'
        ]);

        $datakeranjang = $request->all();
        $keranjang->fill($datakeranjang);
        $keranjang->save();

        return response()->json($keranjang);
    }

    public function search(Request $request)
    {
        # code...
        $query = $request->query('query');

        if (empty($query)) {
            return response()->json(['error' => 'Query not specified!'], 400);
        }

        $fulltext = $request->query('fulltext', 'false');
        $sortBy = $request->query('sort_by', 'nama_produk.asc');
        $sorts = explode('.', $sortBy);


        if ($fulltext == 'true') {
            $data = KeranjangProduk::query()
                ->whereRaw("MATCH(nama_produk) AGAINST(? IN BOOLEAN MODE)", array($query))
                ->orderBy($sorts[0], $sorts[1])
                ->get();
            return response()->json($data);
        }

        $data = KeranjangProduk::query()
            ->where('nama_produk', 'like', '%' . $query . '%')
            ->orderBy($sorts[0], $sorts[1])
            ->get();

        return response()->json($data);
    }

    public function destroy($id_keranjang)
    {
        $keranjang = KeranjangProduk::find($id_keranjang);

        if (!$keranjang) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'data' => $keranjang
            ], 404);
        }

        $keranjang->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus',
            'data' => $keranjang
        ], 200);
    }
}
