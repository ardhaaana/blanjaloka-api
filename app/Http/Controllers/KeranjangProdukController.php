<?php


namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\KeranjangProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KeranjangProdukController extends Controller
{
    public function index()
    {
        $produk = KeranjangProduk::with('produk')->get();

        if (!$produk) {
            return response()->json(['success' => 0, 'message' => 'Keranjang Produk tidak ditemukan'], 404);
        }

         return response()->json([
            'success' => 1,
            'message' => 'Data Keranjang Produk',
            'Keranjang Produk' => $produk,
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
            return response()->json(['success' => 0, 'message' => 'Produk Tidak Ditemukan'], 404);
        }
        
        $keranjangproduk = new KeranjangProduk();
        
        $produk->harga_jual = $produk->harga_jual;
        $keranjangproduk->id_produk = $request->input('id_produk');
        $keranjangproduk->id_customer = $request->input('id_customer');
        $keranjangproduk->jumlah_produk = $request->input('jumlah_produk');
       
        //validasi Stok
    	if($keranjangproduk->jumlah_produk > $produk->jumlah_produk)
    	{
            return response()->json([
            'message' => 'Pembelian Produk Melebihi Stok',
            'code' => 200
            ]);
    	}
        
        $keranjangproduk->jumlah_produk = $keranjangproduk->jumlah_produk;
        $keranjangproduk->subtotal = $produk->harga_jual*$request->jumlah_produk;
        $keranjangproduk->save();
        
        $produk->jumlah_produk = $produk->jumlah_produk-$request->jumlah_produk;
        $produk->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Data Keranjang Produk',
            'Harga Produk' => $produk,
            'Keranjang Produk' => $keranjangproduk,
        ], 200);
        
    }

    public function update(Request $request, $id)
    {
        $keranjangproduk = KeranjangProduk::find($id);
        
        $produk = Produk::find($request->input('id_produk'));

        $keranjangproduk->jumlah_produk = $keranjangproduk->jumlah_produk;
        
        $keranjangproduk->subtotal = $produk->harga_jual*$request->jumlah_produk;

        $keranjangproduk->save();

        return response()->json([
            'message' => 'Keranjang Produk update!',
            'code' => 200
        ]);

    }

    public function show($id)
    {
        $keranjangproduk = KeranjangProduk::with('produk')->find($id);

        if (!$keranjangproduk) {
            return response()->json(['success' => 0, 'message' => 'Keranjang Produk Tidak Ditemukan'], 404);
        }

        return response()->json(['Keranjang Produk' => $keranjangproduk], 200);
    }

    public function destroy($id)
    {
        $keranjangproduk = KeranjangProduk::with('produk')->find($id);

        if (!$keranjangproduk) {
            return response()->json(['success' => 0, 'message' => 'Keranjang Produk Tidak Ditemukan'], 404);
        }

        $keranjangproduk->delete();

        return response()->json(['success' => 1, 'message' => 'Keranjang Produk Berhasil Dihapus'], 200);
    }

}