<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\KeranjangProduk;
use App\Models\ReviewProduk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\SpesialProduk;

class ProdukController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function create(Request $request)
    {
        $this->validate($request, [

            'nama_produk' => 'required',
            'satuan' => 'required',
            'harga_jual' => 'required|numeric',
            'jumlah_produk' => 'required|numeric',
            'deskripsi' => 'required',
            'status_produk' => 'required'
        ]);

        if ($request->has('foto_produk')) {
            $produk = Produk::query()->create(
                [
                    'nama_produk' => $request->input('nama_produk'),
                    'satuan' => $request->input('satuan'),
                    'harga_jual' => $request->input('harga_jual'),
                    'jumlah_produk' => $request->input('jumlah_produk'),
                    'deskripsi' => $request->input('deskripsi'),
                    'foto_produk' => $request->input('foto_produk'),
                    'status_produk' => $request->input('status_produk')
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
                    'status_produk' => $request->input('status_produk')
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
    public function index()
    {
       
        $produk = Produk::all();
        return response($produk);
    	
    }

    public function show($id_produk)
    {
        $produk = Produk::find($id_produk);
        
        if (empty($produk)) {
            return response()->json(['error' => 'Produk Tidak Ditemukan'], 402);
        }

        return response()->json($produk);
        
    }

    public function produkreview()
    {
        $review = ReviewProduk::all();
        $produk = Produk::all();
        
        return response()->json(['message'=>'',
        'produk'=>$produk,
        'review'=>$review],200);
    
    }

    public function spesialshow($id_produk, $id)
    {
        $produk = Produk::find($id_produk);
        $spesialproduk = SpesialProduk::find($id);

        return response()->json([
            'messages' => 'Diskon produk',
            'produk' => $produk,
            'diskon' => $spesialproduk
        ], 200);
    }

    public function update(Request $request, $id_produk)
    {

        $this->validate($request, [

            'nama_produk' => 'required',
            'satuan' => 'required',
            'harga_jual' => 'required|numeric',
            'jumlah_produk' => 'required|numeric',
            'deskripsi' => 'required',
            'status_produk' => 'required'
        ]);

        if ($request->has('foto_produk')) {
            $update = Produk::query()->find($id_produk)->update(
                [
                    'nama_produk' => $request->input('nama_produk'),
                    'satuan' => $request->input('satuan'),
                    'harga_jual' => $request->input('harga_jual'),
                    'deskripsi' => $request->input('deskripsi'),
                    'status_produk' => $request->input('status_produk')
                ]
            );
        } else {
            $update = Produk::query()->find($id_produk)->update(
                [
                    'nama_produk' => $request->input('nama_produk'),
                    'satuan' => $request->input('satuan'),
                    'harga_jual' => $request->input('harga_jual'),
                    'deskripsi' => $request->input('deskripsi'),
                    'status_produk' => $request->input('status_produk')
                ]
            );
        }
            
            $produk = Produk::find($request->input('id_produk'));
            
            $produk->jumlah_produk =$produk->jumlah_produk+$request->jumlah_produk;
            $produk->save();
        

        if (!$update) {
            return response()->json(['error' => 'unknown error'], 500);
        }
       
        
        return response()->json([
            'message' => 'Produk update!',
            'code' => 200
        ]);

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
            $data = Produk::query()
                ->whereRaw("MATCH(nama_produk,deskripsi) AGAINST(? IN BOOLEAN MODE)", array($query))
                ->orderBy($sorts[0], $sorts[1])
                ->get();
            return response()->json($data);
        }

        $data = Produk::query()
            ->where('nama_produk', 'like', '%' . $query . '%')
            ->orWhere('deskripsi', 'like', '%' . $query . '%')
            ->orderBy($sorts[0], $sorts[1])
            ->get();

        return response()->json($data);
     
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
