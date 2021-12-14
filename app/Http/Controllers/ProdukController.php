<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\KeranjangProduk;
use App\Models\ReviewProduk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\KategoriProduk;
use App\Models\SpesialProduk;

class ProdukController extends Controller{

   # Membuat Produk Baru
    public function create(Request $request){

        $this->validate($request, [

            'nama_produk' => 'required',
            'satuan' => 'required',
            'harga_jual' => 'required|numeric',
            'jumlah_produk' => 'required|numeric',
            'deskripsi' => 'required',
            'status_produk' => 'required',
            'id_kategori' => 'required'
        ]);

        if(count(KategoriProduk::where('id_kategori', $request->input('id_kategori'))->get()) == 0){
            return response()->json([
                'error'=>"id kategori produk tidak ditemukan"
            ], 501);
        }
        
        if ($request->has('foto_produk')) {
            $produk = Produk::query()->create(
                [
                    'nama_produk' => $request->input('nama_produk'),
                    'satuan' => $request->input('satuan'),
                    'harga_jual' => $request->input('harga_jual'),
                    'jumlah_produk' => $request->input('jumlah_produk'),
                    'deskripsi' => $request->input('deskripsi'),
                    'foto_produk' => $request->input('foto_produk'),
                    'status_produk' => $request->input('status_produk'),
                    'id_kategori' => $request->input('id_kategori')
                ]
            );
        } else {
            $produk = Produk::query()->create(
                [
                    'nama_produk' => $request->input('nama_produk'),
                    'satuan' => $request->input('satuan'),
                    'harga_jual' => $request->input('harga_jual'),
                    'jumlah_produk' => $request->input('jumlah_produk'),
                    'deskripsi' => $request->input('deskripsi'),
                    'status_produk' => $request->input('status_produk'),
                    'id_kategori' => $request->input('id_kategori')
                ]
            );
        }

        if (empty($produk)) {
            return response()->json(['error' => 'unknown error'], 501);
        }

        return response()->json([
            'message' => 'Product create success!',
            'code' => 201,
            'data' => $produk
        ]);

    }

    # Menampilkan Seluruh Data Produk
    public function index(){
       
        $produk_biasa = DB::table('spesial_produk')->select('produk.id_produk', 'produk.nama_produk', 'kategori_produk.jenis_kategori', 'produk.satuan', 'produk.satuan', 'produk.harga_jual', 'produk.jumlah_produk', 'produk.deskripsi', 'produk.foto_produk', 'produk.status_produk')
                ->rightJoin('produk', 'produk.id_produk', '=', 'spesial_produk.id_produk')
                ->join('kategori_produk', 'kategori_produk.id_kategori', '=', 'produk.id_kategori')
                ->whereNull('spesial_produk.diskon')
                ->get();

        $spesialproduk = DB::table('spesial_produk')
                ->select('produk.id_produk', 'produk.nama_produk', 'kategori_produk.jenis_kategori', 'produk.satuan', 'produk.satuan', 'produk.harga_jual', 'produk.jumlah_produk', 'produk.deskripsi', 'produk.foto_produk', 'produk.status_produk', 'spesial_produk.diskon')
                ->join('produk', 'produk.id_produk', '=', 'spesial_produk.id_produk')
                ->join('kategori_produk', 'kategori_produk.id_kategori', '=', 'produk.id_kategori')
                ->get();
        $produkspesial = array();

        foreach ($spesialproduk as $s){

            $persen_diskon = preg_replace("/[^0-9]/", "", $s->diskon);
            $potongan = ($persen_diskon/100) * $s->harga_jual;

            $produkspesial [] = [

                'id_produk' => $s->id_produk,
                'nama_produk' => $s->nama_produk,
                'jenis_kategori' => $s->jenis_kategori,
                'satuan' => $s->satuan,
                'total_produk' => $s->jumlah_produk,
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
            'message' => 'Seluruh Produk',
            'produk_spesial' => $produkspesial,
            'produk_biasa' => $produk_biasa
        ], 200);
        
    	
    }

    # Menampilkan Detail Produk Berdasarkan id produk
    public function show($id_produk){

        # cek id produk ada harga diskon tidak
        if(count(SpesialProduk::where('id_produk', $id_produk)->get()) == 0){

            # Produk gak diskon
            $produk = Produk::select('produk.id_produk', 'produk.nama_produk', 'kategori_produk.jenis_kategori', 'produk.satuan', 'produk.harga_jual', 'produk.jumlah_produk', 'produk.deskripsi', 'produk.foto_produk', 'produk.status_produk')
                    ->join('kategori_produk', 'produk.id_kategori', '=', 'kategori_produk.id_kategori')
                    ->where('produk.id_produk', $id_produk)
                    ->get();
        }else{

            # Produk diskon
            $_produk = DB::table('spesial_produk')
                    ->select('produk.id_produk', 'produk.nama_produk', 'kategori_produk.jenis_kategori', 'produk.satuan', 'produk.harga_jual', 'produk.jumlah_produk', 'produk.deskripsi', 'produk.foto_produk', 'produk.status_produk', 'spesial_produk.diskon')
                    ->join('produk', 'produk.id_produk', '=', 'spesial_produk.id_produk')
                    ->join('kategori_produk', 'kategori_produk.id_kategori', '=', 'produk.id_kategori')
                    ->where('produk.id_produk', $id_produk)
                    ->get();

            $produk = array();

            foreach ($_produk as $s){

                $persen_diskon = preg_replace("/[^0-9]/", "", $s->diskon);
                $potongan = ($persen_diskon/100) * $s->harga_jual;

                $produk [] = [

                    'id_produk' => $s->id_produk,
                    'nama_produk' => $s->nama_produk,
                    'jenis_kategori' => $s->jenis_kategori,
                    'satuan' => $s->satuan,
                    'total_produk' => $s->jumlah_produk,
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

        }
        
        if (count(Produk::where('id_produk', $id_produk)->get()) == 0){ 
            return response()->json([
                'error' => 'Produk Tidak Ditemukan'
            ],404);
        }

        return response()->json($produk);
        
    }

    # Menampilkan List Produk Berdasarkan Kategori Produk
    public function kategoriproduk($id_kategori){

        $produk_biasa = DB::table('spesial_produk')->select('produk.id_produk', 'produk.nama_produk', 'kategori_produk.jenis_kategori', 'produk.satuan', 'produk.harga_jual', 'produk.jumlah_produk', 'produk.deskripsi', 'produk.foto_produk', 'produk.status_produk')
                ->rightJoin('produk', 'produk.id_produk', '=', 'spesial_produk.id_produk')
                ->join('kategori_produk', 'kategori_produk.id_kategori', '=', 'produk.id_kategori')
                ->where('produk.id_kategori', $id_kategori)
                ->whereNull('spesial_produk.diskon')
                ->get();

        $spesialproduk = DB::table('spesial_produk')
                ->select('produk.id_produk', 'produk.nama_produk', 'kategori_produk.jenis_kategori', 'produk.satuan', 'produk.harga_jual', 'produk.jumlah_produk', 'produk.deskripsi', 'produk.foto_produk', 'produk.status_produk', 'spesial_produk.diskon')
                ->join('produk', 'produk.id_produk', '=', 'spesial_produk.id_produk')
                ->join('kategori_produk', 'kategori_produk.id_kategori', '=', 'produk.id_kategori')
                ->where('produk.id_kategori', $id_kategori)
                ->get();
        $produkspesial = array();

        foreach ($spesialproduk as $s){

            $persen_diskon = preg_replace("/[^0-9]/", "", $s->diskon);
            $potongan = ($persen_diskon/100) * $s->harga_jual;

            $produkspesial [] = [

                'id_produk' => $s->id_produk,
                'nama_produk' => $s->nama_produk,
                'jenis_kategori' => $s->jenis_kategori,
                'satuan' => $s->satuan,
                'total_produk' => $s->jumlah_produk,
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

        # nama kategori
        $jeniskategori = KategoriProduk::select('jenis_kategori')->where('id_kategori', $id_kategori)->get();
        foreach ($jeniskategori as $j){
            $_jeniskategori = $j->jenis_kategori;
        }

        if(count(KategoriProduk::where('id_kategori', $id_kategori)->get()) == 0){
            return response()->json(['error' => 'id kategori produk tidak ditemukan'], 400);
        }

        return response()->json([
            'success' => 1,
            'Message' => 'Produk Berdasarkan Jenis Kategori',
            'jenis_kategori' => $_jeniskategori,
            'data' => [
                'produk_spesial' => $produkspesial,
                'produk_biasa' => $produk_biasa
            ],
        ], 200);
    }

    public function update(Request $request, $id_produk){

        $this->validate($request, [

            'nama_produk' => 'required',
            'satuan' => 'required',
            'harga_jual' => 'required|numeric',
            'jumlah_produk' => 'required|numeric',
            'deskripsi' => 'required',
            'status_produk' => 'required',
            'id_kategori' => 'required'
        ]);

        if ($request->has('foto_produk')) {
            $update = Produk::where('id_produk', $id_produk)->update(
                [
                    'nama_produk' => $request->input('nama_produk'),
                    'satuan' => $request->input('satuan'),
                    'harga_jual' => $request->input('harga_jual'),
                    'deskripsi' => $request->input('deskripsi'),
                    'status_produk' => $request->input('status_produk'),
                    'id_kategori' => $request->input('id_kategori')
                ]
            );
        } else {
            $update = Produk::where('id_produk', $id_produk)->update(
                [
                    'nama_produk' => $request->input('nama_produk'),
                    'satuan' => $request->input('satuan'),
                    'harga_jual' => $request->input('harga_jual'),
                    'deskripsi' => $request->input('deskripsi'),
                    'status_produk' => $request->input('status_produk'),
                    'id_kategori' => $request->input('id_kategori')
                ]
            );
        }
        
        if (!$update) {
            return response()->json(['error' => 'id produk tidak ditemukan'], 400);
        }
       
        return response()->json([
            'message' => 'Produk update!',
            'code' => 200
        ]);

    }

    # Pencarian Produk Berdasarkan Keyword
    public function search(Request $request){

        $query = $request->query('query');

        if (empty($query)) {
            return response()->json(['error' => 'Query not specified!'], 400);
        }

        $produk_biasa = DB::table('spesial_produk')->select('produk.id_produk', 'produk.nama_produk', 'kategori_produk.jenis_kategori', 'produk.satuan', 'produk.harga_jual', 'produk.jumlah_produk', 'produk.deskripsi', 'produk.foto_produk', 'produk.status_produk')
                ->rightJoin('produk', 'produk.id_produk', '=', 'spesial_produk.id_produk')
                ->join('kategori_produk', 'kategori_produk.id_kategori', '=', 'produk.id_kategori')
                ->whereNull('spesial_produk.diskon')
                ->where('produk.nama_produk', 'like', '%'.$query.'%')
                ->get();

        $spesialproduk = DB::table('spesial_produk')
                ->select('produk.id_produk', 'produk.nama_produk', 'kategori_produk.jenis_kategori', 'produk.satuan', 'produk.harga_jual', 'produk.jumlah_produk', 'produk.deskripsi', 'produk.foto_produk', 'produk.status_produk', 'spesial_produk.diskon')
                ->join('produk', 'produk.id_produk', '=', 'spesial_produk.id_produk')
                ->join('kategori_produk', 'kategori_produk.id_kategori', '=', 'produk.id_kategori')
                ->where('produk.nama_produk', 'like', '%'.$query.'%')
                ->get();
        $produkspesial = array();

        foreach ($spesialproduk as $s){

            $persen_diskon = preg_replace("/[^0-9]/", "", $s->diskon);
            $potongan = ($persen_diskon/100) * $s->harga_jual;

            $produkspesial [] = [

                'id_produk' => $s->id_produk,
                'nama_produk' => $s->nama_produk,
                'jenis_kategori' => $s->jenis_kategori,
                'satuan' => $s->satuan,
                'total_produk' => $s->jumlah_produk,
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
            'message' => 'Pencarian Produk Berdasarkan Kata Kunci',
            'keyword' => $query,
            'data' => [
                'produk_spesial' => $produkspesial,
                'produk_biasa' => $produk_biasa
            ]
        ]);

    }

    public function destroy($id_produk){

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
