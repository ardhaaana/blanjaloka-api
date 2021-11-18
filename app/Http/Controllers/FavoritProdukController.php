<?php


namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\FavoritProduk;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FavoritProdukController extends Controller
{
    public function index()
    {

       $favoritproduk = favoritproduk::with('produk')->get();

        if (!$favoritproduk) {
            return response()->json(['success' => 0, 'message' => 'Favorit tidak ditemukan'], 404);
        }

        return response()->json([
            'success' => 1,
            'message' => 'Menampilkan Favorit Produk',
            'Favorit Produk' => $favoritproduk
        ], 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->only('id_produk'), [
            'id_produk' => "required"
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => 0, 'message' => 'Required or incorrect fields', 'errors' => $validator->errors()], 500);
        }

        $produk = Produk::find($request->input('id_produk'));

        if (!$produk) {
            return response()->json(['success' => 0, 'message' => 'Produk tidak ditemukan'], 404);
        }

        $favoritproduk = new FavoritProduk();
        $favoritproduk->id_produk = $request->input('id_produk');
        $favoritproduk->id_customer = $request->input('id_customer');
        $favoritproduk->save();

        $favoritproduk = FavoritProduk::with('produk')->where('id_customer')->where('id_produk', $request->input('id_produk'))->first();

        return response()->json([
            'success' => 1,
            'message' => 'Produk ditambah di favorit',
            'Favorit Produk' => $produk
        ], 200);
    }

    public function show($id)
    {
        $favoritproduk = favoritproduk::with('produk')->find($id);

        if (!$favoritproduk) {
            return response()->json(['success' => 0, 'message' => 'Favorit tidak ditemukan'], 404);
        }

        return response()->json(['item' => $favoritproduk], 200);
    }

    public function destroy($id)
    {
        $favoritproduk = FavoritProduk::with('produk')->find($id);

        if (!$favoritproduk) {
            return response()->json(['success' => 0, 'message' => 'Favorit tidak ditemukan'], 404);
        }

        $favoritproduk->delete();

        return response()->json(['success' => 1, 'message' => 'Produk Berhasil Dihapus Di Favorit'], 200);
    }
}
