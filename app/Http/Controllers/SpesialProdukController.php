<?php

namespace App\Http\Controllers;

use App\Models\SpesialProduk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SpesialProdukController extends Controller{

    public function __construct(){

        $this->middleware('auth');
    
    }

    # Buat Spesial Produk
    public function create(Request $request){

        $this->validate($request, [
            'id_produk' => 'required',
            'diskon' => 'required'
        ]);

        $id_produk = $request->input('id_produk');
        $diskon = $request->input('diskon');

        # Cek Jika Ada Produk Yang Sama dimasukkin lagi ke spesial_produk -> muncul error
        $query =  DB::table('spesial_produk')
                ->select('spesial_produk.id', 'produk.id_produk', 'produk.nama_produk', 'produk.satuan', 'produk.satuan', 'produk.harga_jual', 'produk.stok_saat_ini', 'produk.deskripsi', 'produk.foto_produk', 'produk.status_produk', 'spesial_produk.diskon')
                ->join('produk', 'produk.id_produk', '=', 'spesial_produk.id_produk')->where('spesial_produk.id_produk', $request->input('id_produk'))->get();

        if(count($query) > 0){

            return response()->json([
                'success' => 0,
                'message' => 'Produk yang anda masukkan telah terdaftar di special produk',
                'data' => $query
            ], 500);

        }

        # Cek id produk
        if(count(DB::table('produk')->where('id_produk', $request->input('id_produk'))->get()) == 0){

            return response()->json([
                'success' => 0,
                'message' => 'Id Produk Tidak Ditemukan'
            ], 500);

        }

        $spesialproduk = SpesialProduk::create([
            'id_produk' => $id_produk,
            'diskon' => $diskon
        ]);

        # query menampilkan data produk special setelah di input (baru saja diinput)
        $query =  DB::table('spesial_produk')
                ->select('spesial_produk.id', 'produk.id_produk', 'produk.nama_produk', 'produk.satuan', 'produk.satuan', 'produk.harga_jual', 'produk.stok_saat_ini', 'produk.deskripsi', 'produk.foto_produk', 'produk.status_produk', 'spesial_produk.diskon')
                ->join('produk', 'produk.id_produk', '=', 'spesial_produk.id_produk')->where('spesial_produk.id_produk', $request->input('id_produk'))->get();

        if ($spesialproduk) {
            return response()->json([
                'success' => 1,
                'message' => 'Pembuatan spesial produk berhasil',
                'data' => $query
            ], 202);
        }

    }

    # Nampilin Semua Spesial Produk
    public function index(){

        $spesialproduk = DB::table('spesial_produk')
                        ->select('spesial_produk.id', 'produk.id_produk', 'produk.nama_produk', 'produk.satuan', 'produk.satuan', 'produk.harga_jual', 'produk.stok_saat_ini', 'produk.deskripsi', 'produk.foto_produk', 'produk.status_produk', 'spesial_produk.diskon')
                        ->join('produk', 'produk.id_produk', '=', 'spesial_produk.id_produk')->get();
        $produkspesial = array();

        foreach ($spesialproduk as $s){

            $persen_diskon = preg_replace("/[^0-9]/", "", $s->diskon);
            $potongan = ($persen_diskon/100) * $s->harga_jual;

            $produkspesial [] = [

                'id' => $s->id,
                'id_produk' => $s->id_produk,
                'nama_produk' => $s->nama_produk,
                'satuan' => $s->satuan,
                'total_produk' => $s->stok_saat_ini,
                'deskripsi' => $s->deskripsi,
                'foto_produk' => $s->foto_produk,
                'status_produk' => $s->status_produk,
                'harga' => [
                    'harga_jual' => $s->harga_jual,
                    'diskon' => $s->diskon,
                    'potongan' => $potongan,
                    'harga_akhir' => $s->harga_jual - $potongan
                ]
            ];
            
        }

        return response()->json([
            'success' => 1,
            'message' => 'Produk Special',
            'total' => count($spesialproduk),
            'data' => $produkspesial
        ]);

    }

    public function search(Request $request){

        $query = $request->query('query');

        if (empty($query)) {
            return response()->json(['error' => 'Query not specified!'], 400);
        }

        $spesialproduk = DB::table('spesial_produk')
                        ->select('spesial_produk.id', 'produk.id_produk', 'produk.nama_produk', 'produk.satuan', 'produk.satuan', 'produk.harga_jual', 'produk.stok_saat_ini', 'produk.deskripsi', 'produk.foto_produk', 'produk.status_produk', 'spesial_produk.diskon')
                        ->join('produk', 'produk.id_produk', '=', 'spesial_produk.id_produk')->where('produk.nama_produk', 'like', '%'.$query.'%')->get();
        $produkspesial = array();

        foreach ($spesialproduk as $s){

            $persen_diskon = preg_replace("/[^0-9]/", "", $s->diskon);
            $potongan = ($persen_diskon/100) * $s->harga_jual;

            $produkspesial [] = [
                
                'id' => $s->id,
                'id_produk' => $s->id_produk,
                'nama_produk' => $s->nama_produk,
                'satuan' => $s->satuan,
                'total_produk' => $s->stok_saat_ini,
                'deskripsi' => $s->deskripsi,
                'foto_produk' => $s->foto_produk,
                'status_produk' => $s->status_produk,
                'harga' => [
                    'harga_jual' => $s->harga_jual,
                    'diskon' => $s->diskon,
                    'potongan' => $potongan,
                    'harga_akhir' => $s->harga_jual - $potongan
                ]
            ];

        }

        return response()->json([
            'success' => 1,
            'message' => 'Produk Special Filter',
            'keyword' => $query,
            'total' => count($spesialproduk),
            'data' => $produkspesial
        ]);

    }

    # Update Spesial Produk
    # Parameter (Update kuantitas diskon) -> ex : 30%
    public function update(Request $request, $id){

        $spesialproduk = SpesialProduk::find($id);

        if (!$spesialproduk) {
            return response()->json([
                'message' => 'Data Produk Spesial Tidak ditemukan',
                'data' => $spesialproduk
            ], 404);
        }

        $this->validate($request, [
            'diskon' => 'required'
        ]);

        $query = SpesialProduk::where('id', $id)->update(['diskon'=>$request->input('diskon')]);

        if($query){
            return response()->json([
                'success' => 1,
                'message' => 'Diskon Spesial Produk Berhasil diupdate'
            ]);
        }

    }

    public function destroy($id){

        $spesialproduk = SpesialProduk::find($id);

        if (!$spesialproduk) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'data' => $spesialproduk
            ], 404);
        }

        $spesialproduk->delete();

        return response()->json([
            'message' => 'Diskon berhasil dihapus',
            'data' => $spesialproduk
        ], 200);

    }
}
