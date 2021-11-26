<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\KeranjangProduk;
use App\Models\ReviewProduk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\SpesialProduk;

class ProdukController extends Controller
{
    
//     public function __construct()
//     {
//         $this->middleware('auth');
//     }

    
    public function create(Request $request)
    {
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

     public function kategoriproduk($id_kategori)
    {
        $datakategori = DB::table('produk')->select('kategori_produk.id_kategori','kategori_produk.jenis_kategori', 'produk.id_produk', 'produk.id_kategori', 'produk.nama_produk', 'produk.satuan', 'produk.harga_jual', 'produk.jumlah_produk',	
                                                    'produk.deskripsi',	'produk.foto_produk', 'produk.status_produk')
                                           ->join('kategori_produk','produk.id_kategori', '=', 'kategori_produk.id_kategori')
                                           ->where('kategori_produk.id_kategori', $id_kategori)
                                           ->get();
        return response()->json([
            'Message' => 'Success',
            'Kategori Produk' => $datakategori,
            200]);
    }

    public function update(Request $request, $id_produk)
    {

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
            $update = Produk::query()->find($id_produk)->update(
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
            $update = Produk::query()->find($id_produk)->update(
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
