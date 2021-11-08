<?php

namespace App\Http\Controllers;

use App\Models\ShopCart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ShopController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function create(Request $request)
    {
        $this->validate($request, [
            'nama_produk' => 'required|min:5',
            'satuan' => 'required',
            'harga_produk' => 'required|numeric',
            'status_produk' => 'required',
            'id_pedagang' => 'required|numeric'
        ]);

        $nama_produk = $request->input('nama_produk');
        $satuan = $request->input('satuan');
        $harga_produk = $request->input('harga_produk');
        $status_produk = $request->input('status_produk');
        $id_pedagang = $request->input('id_pedagang');

        $produk = Produk::create([
            'nama_produk' => $nama_produk,
            'satuan' => $satuan,
            'harga_produk' => $harga_produk,
            'status_produk' => $status_produk,
            'id_pedagang' => $id_pedagang
        ]);

        if ($produk) {
            return response()->json([
                'message' => 'Penambahan data berhasil',
                'data' => $produk
            ], 201);
        }
    }

    public function index()
    {
        $produk = Produk::all();
        return response()->json($produk);
    }

    public function show($id_produk)
    {
        $produk = Produk::find($id_produk);
        return response()->json($produk);
    }

    public function update(Request $request, $id_produk)
    {
        $produk = Produk::find($id_produk);

        if (!$produk) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'data' => $produk
            ], 404);
        }

        $this->validate($request, [
            'nama_produk' => 'required|min:5',
            'satuan' => 'required',
            'harga_produk' => 'required|numeric',
            'status_produk' => 'required',
            'id_pedagang' => 'required|numeric'
        ]);

        $dataproduk = $request->all();
        $produk->fill($dataproduk);
        $produk->save();

        return response()->json($produk);
    }

    public function destroy($id_produk)
    {
        $produk = Produk::find($id_produk);

        if (!$produk) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'data' => $produk
            ], 404);
        }

        $produk->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus',
            'data' => $produk
        ], 200);
    }

}
