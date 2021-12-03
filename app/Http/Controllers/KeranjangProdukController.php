<?php
namespace App\Http\Controllers;

use App\Models\KeranjangProduk;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class KeranjangProdukController extends Controller{

    public function __construct(){

        $this->middleware('auth');
    
    }

    # Tambah data keranjang
    public function create(Request $request){

        $this->validate($request, [
            // 'id_customer' => 'required|numeric',
            'id_produk' => 'required|numeric',
            'jumlah_produk' => 'required|numeric'
        ]);

        if(count(KeranjangProduk::where('id_produk', $request->input('id_produk'))->where('id_customer', $request->session()->get('id_customer'))->get()) > 0){

            return response([
                'message' => 'Produk Sudah Ada di Keranjang'
            ], 200);

        }else{

            $keranjang = KeranjangProduk::create([
                'id_customer' => $request->session()->get('id_customer'),
                'id_produk' => $request->input('id_produk'),
                'jumlah_produk' => $request->input('jumlah_produk')
            ]);
    
            if($keranjang){
                return response()->json([
                    'message' => 'Produk ditambahkan ke keranjang',
                    'data' => $keranjang
                ], 200);
            }

        }

    }

    # Tampilkan data Keranjang
    public function show(Request $request){
        
        $keranjang = DB::table('spesial_produk')
                    ->select('keranjang_produk.id_keranjang', 'keranjang_produk.id_produk', 'produk.nama_produk', 'keranjang_produk.jumlah_produk', 'produk.harga_jual', 'spesial_produk.diskon')
                    ->rightJoin('produk', 'produk.id_produk', '=', 'spesial_produk.id_produk')
                    ->join('keranjang_produk', 'produk.id_produk', '=', 'keranjang_produk.id_produk')
                    ->where('keranjang_produk.id_customer', $request->session()->get('id_customer'))
                    ->get();

        $isikeranjang = array();
        foreach ($keranjang as $k){
            ($k->diskon == null) ? $diskon = 0 : $diskon = $k->diskon; 

            $persen_diskon = preg_replace("/[^0-9]/", "", $diskon);
            $potongan = ($persen_diskon/100) * $k->harga_jual;
            $harga_awal = $k->jumlah_produk * $k->harga_jual;

            $isikeranjang [] = [
                'id_keranjang' => $k->id_keranjang,
                'id_produk' => $k->id_produk,
                'nama_produk' => $k->nama_produk,
                'jumlah_produk' => $k->jumlah_produk,
                'harga' => [
                    'diskon' => ($k->diskon == null) ? 0 : $k->diskon,
                    'potongan' => $potongan,
                    'harga_awal' => $harga_awal,
                    'harga_akhir' => $harga_awal - $potongan
                ]
            ];

        }

        if($keranjang){
        
            return response()->json([
                'keranjang' => $isikeranjang,
            ], 200);
        
        }else{

            return response()->json(['error' => 'unknown error'], 500);
        
        }

    }

    # Edit data Keranjang
    public function update(Request $request, $id_keranjang){

        $this->validate($request, [
            'jumlah_produk' => 'required|numeric'
        ]);

        $query = KeranjangProduk::query()->find($id_keranjang)->update([
            'jumlah_produk' => $request->input('jumlah_produk')
        ]);

        if(!$query){
            return response()->json(['error' => 'unknown error'], 500);
        }

        $data = DB::table('keranjang_produk')->select('keranjang_produk.id_keranjang', 'produk.nama_produk', 'keranjang_produk.jumlah_produk', 'produk.harga_jual', DB::raw("keranjang_produk.`jumlah_produk` * produk.`harga_jual` AS total"))
                ->join('produk', 'keranjang_produk.id_produk', '=', 'produk.id_produk')
                ->where('keranjang_produk.id_keranjang', $id_keranjang)
                ->get();

        return response()->json([
            'message' => "Keranjang Berhasil Diperbaruhi",
            'data' => $data
        ], 200);
        
    }

    # Delete
    public function destroy($id_keranjang){

        $query = KeranjangProduk::where('id_keranjang', $id_keranjang)->delete();

        if(!$query){
            return response()->json([
                'message' => 'unknown error'
            ], 500);
        }

        return response([
            'message' => "Keranjang Berhasil Dihapus"
        ]);

    }



}
