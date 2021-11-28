<?php


namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\FavoritProduk;
use App\Models\Produk;
use Illuminate\Http\Request;

class FavoritProdukController extends Controller{

    public function __construct(){
        
        $this->middleware('auth');

    }


    # Tambah Favorite
    public function create(Request $request){

        $this->validate($request,[
            'id_produk' => 'required|numeric',
            'id_customer' => 'required|numeric'
        ]);

        # Error jika user menambahkan produk yang sama ke favorit 
        if(count(FavoritProduk::where('id_customer', $request->input('id_customer'))->where('id_produk', $request->input('id_produk'))->get()) > 0){

            $data = FavoritProduk::select('id', 'nama_produk')
                    ->join('produk', 'produk.id_produk', '=', 'favorit_produk.id_produk')
                    ->where('favorit_produk.id_customer', $request->input('id_customer'))
                    ->where('favorit_produk.id_produk', $request->input('id_produk'))->get();

            return response()->json([
                'code' => 200,
                'success' => false,
                'message' => 'Produk Ini Telah Ada di List Produk Favorit',
                'data' => $data
            ]);
        }

        # Handler Jika id Produk Tidak Ditemukan
        if(count(Produk::where('id_produk', $request->input('id_produk'))->get()) == false){

            return response()->json([
                'code' => 500,
                'success' => false,
                'message' => 'id produk tidak ditemukan'
            ]);

        }

        # Handler Jika id customer Tidak Ditemukan
        if(count(Customer::where('id_customer', $request->input('id_customer'))->get()) == false){

            return response()->json([
                'code' => 500,
                'success' => false,
                'message' => 'id customer tidak ditemukan'
            ]);

        }

        # Input Favorit
        $data = [
            'id_customer' => $request->input('id_customer'),
            'id_produk' => $request->input('id_produk')
        ];

        FavoritProduk::create($data);

        $favoritproduk = FavoritProduk::select('favorit_produk.id', 'nama_produk')
                        ->join('produk', 'produk.id_produk', '=', 'favorit_produk.id_produk')
                        ->where('favorit_produk.id_customer', $request->input('id_customer'))
                        ->where('favorit_produk.id_produk', $request->input('id_produk'))->get();

        return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'Produk ditambah di favorit',
            'data' => $favoritproduk
        ]);

    }

    # Nampilin data favorit by customer
    public function show($id_customer){

        // id disini yang ditampilin adalah id favorit_produk
        $listprodukfavorit = Produk::select('id', 'nama_produk', 'satuan', 'harga_jual', 'jumlah_produk', 'deskripsi', 'foto_produk', 'status_produk', 'id_pedagang')
                            ->join('favorit_produk', 'favorit_produk.id_produk', '=', 'produk.id_produk')
                            ->where('favorit_produk.id_customer', $id_customer)->get();

        $customers = Customer::select('id_customer', 'nama_customer')->where('id_customer', $id_customer)->get();

        return response()->json([
            'code' => 200,
            'success' => true,
            'customer' => $customers,
            'listfavoritproduk' => $listprodukfavorit
        ]);
        
    }

    # Nampilin data favorit by customer
    public function destroy($id){

        $favoritproduk = FavoritProduk::with('produk')->find($id);

        if (!$favoritproduk) {
            return response()->json([
                'code' => 404,
                'success' => false, 
                'message' => 'Favorit tidak ditemukan'
            ]);
        }

        $favoritproduk->delete();
        return response()->json([
            'code' => 200,
            'success' => true, 
            'message' => 'Produk Berhasil Dihapus Di Favorit'
        ]);
    }
}
