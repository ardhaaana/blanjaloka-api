<?php
namespace App\Http\Controllers;

use App\Models\KeranjangProduk;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KeranjangProdukController extends Controller{

    public function __construct(){

        $this->middleware('auth');
    
    }

    # Tambah data keranjang
    public function create(Request $request){

        $validate = [
            'id_produk' => 'required|numeric',
            'jumlah_produk' => 'required|numeric'
        ];

        $pesan = [
            'id_produk.required' => 'ID Produk Tidak Boleh Kosong',
            'jumlah_produk.required' => 'Jumlah Produk Telepon Tidak Boleh Kosong'
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

        $isikeranjang = DB::table('keranjang_produk')->select('keranjang_produk.id_keranjang', 'keranjang_produk.id_produk', 'produk.nama_produk', 'keranjang_produk.jumlah_produk', 'produk.harga_jual', DB::raw("keranjang_produk.`jumlah_produk` * produk.`harga_jual` AS total"))
                        ->join('produk', 'keranjang_produk.id_produk', '=', 'produk.id_produk')
                        ->where('keranjang_produk.id_customer', $request->session()->get('id_customer'))
                        ->get();
                        
        $subtotal = KeranjangProduk::select(DB::raw("keranjang_produk.`jumlah_produk` * produk.`harga_jual` AS subtotal"))
                    ->join('produk', 'keranjang_produk.id_produk', '=', 'produk.id_produk')
                    ->where('id_customer', $request->session()->get('id_customer'))
                    ->get();

        $_subtotal = 0;
        
        foreach ($subtotal as $s){
            $_subtotal = $_subtotal + $s->subtotal;
        }

        if($isikeranjang && $subtotal){
        
            return response()->json([
                'keranjang' => $isikeranjang,
                'sub_total' => $_subtotal
            ], 200);
        
        }else{

            return response()->json(['error' => 'unknown error'], 500);
        
        }

    }

    # Edit data Keranjang
    public function update(Request $request, $id_keranjang){

        $validate = [
            'jumlah_produk' => 'required|numeric'
        ];

        $pesan = [
            'jumlah_produk.required' => 'Jumlah Produk Telepon Tidak Boleh Kosong'
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
