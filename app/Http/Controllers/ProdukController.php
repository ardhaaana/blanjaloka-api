<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\KeranjangProduk;
use App\Models\ReviewProduk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;
use App\Models\SpesialProduk;

class ProdukController extends Controller
{
    
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    
    public function create(Request $request)
    {
    
        $validate = [
            'nama_produk' => 'required',
            'satuan' => 'required',
            'harga_jual' => 'required|numeric',
            'jumlah_produk' => 'required|numeric',
            'deskripsi' => 'required',
            'status_produk' => 'required',
            'id_kategori' => 'required'
        ];

        $pesan = [
            'nama_produk.required' => 'Nama Produk Tidak Boleh Kosong',
            'satuan.required' => 'Satuan Tidak Boleh Kosong',
            'harga_jual.required' => 'Harga Jual Tidak Boleh Kosong',
            'jumlah_produk.required' => 'Jumlah Produk Tidak Boleh Kosong',
            'deskripsi.required' => 'Deskripsi Tidak Boleh Kosong',
            'status_produk.required' => 'Status Produk Tidak Boleh Kosong',
            'id_kategori.required' => 'Kategori Tidak Boleh Kosong'
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
            return response()->json(['code' => 500,'success' => false,'error' => 'unknown error']);
        }

        return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'Product create success!',
            'data' => $produk
        ]);

    }
    public function index()
    {
       
        $produk = Produk::all();
        return response(['code' => 200,'success' => true, 'message' => 'Menampilkan Data Produk',
        'Data' => $produk]);
    	
    }

    public function show($id_produk)
    {
        $produk = Produk::find($id_produk);
        
        if (empty($produk)) {
            return response()->json(['code' => 402,'success' => false,'error' => 'Produk Tidak Ditemukan']);
        }

        return response()->json(['code' => 200,'success' => true,'message' => 'Menampilkan Data Produk', 'Data' => $produk]);
        
    }

     public function kategoriproduk($id_kategori)
    {
        $datakategori = DB::table('produk')->select('kategori_produk.id_kategori','kategori_produk.jenis_kategori', 'produk.id_produk', 'produk.id_kategori', 'produk.nama_produk', 'produk.satuan', 'produk.harga_jual', 'produk.jumlah_produk',	
                                                    'produk.deskripsi',	'produk.foto_produk', 'produk.status_produk')
                                           ->join('kategori_produk','produk.id_kategori', '=', 'kategori_produk.id_kategori')
                                           ->where('kategori_produk.id_kategori', $id_kategori)
                                           ->get();
        return response()->json([
            'code' => 200,
            'success' => true,
            'Message' => 'Menampilkan Kategori Produk',
            'Kategori Produk' => $datakategori
            ]);
    }

    public function update(Request $request, $id_produk)
    {

        $validate = [
            'nama_produk' => 'required',
            'satuan' => 'required',
            'harga_jual' => 'required|numeric',
            'jumlah_produk' => 'required|numeric',
            'deskripsi' => 'required',
            'status_produk' => 'required',
            'id_kategori' => 'required'
        ];

        $pesan = [
            'nama_produk.required' => 'Nama Produk Tidak Boleh Kosong',
            'satuan.required' => 'Satuan Tidak Boleh Kosong',
            'harga_jual.required' => 'Harga Jual Tidak Boleh Kosong',
            'jumlah_produk.required' => 'Jumlah Produk Tidak Boleh Kosong',
            'deskripsi.required' => 'Deskripsi Tidak Boleh Kosong',
            'status_produk.required' => 'Status Produk Tidak Boleh Kosong',
            'id_kategori.required' => 'Kategori Tidak Boleh Kosong'
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
            return response()->json(['code' => 500,'success' => false,'error' => 'unknown error']);
        }
       
        
        return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'Produk update!'
        ]);

    }

    public function search(Request $request)
    {
        # code...
        
        $query = $request->query('query');
        
        if (empty($query)) {
            return response()->json(['code' => 400,'success' => false,'error' => 'Query not specified!']);
        }
        
        $fulltext = $request->query('fulltext', 'false');
        $sortBy = $request->query('sort_by', 'nama_produk.asc');
        $sorts = explode('.', $sortBy);
        
        
        if ($fulltext == 'true') {
            $data = Produk::query()
            ->whereRaw("MATCH(nama_produk) AGAINST(? IN BOOLEAN MODE)", array($query))
            ->orderBy($sorts[0], $sorts[1])
            ->get();
            return response()->json($data);
        }
        

        $data = Produk::query()
        ->where('nama_produk', 'like', '%' . $query . '%')
        ->orderBy($sorts[0], $sorts[1])
        ->get();
        
        return response()->json(['code' => 200,'success' => true, 
                                'message' => 'Menampilkan Pencarian Produk',
                                'Data' => $data]);
     
    }

    public function destroy($id_produk)
    {
        $produk = Produk::find($id_produk);

        if (!$produk) {
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => 'Data tidak ditemukan',
                'data' => $produk
            ]);
        }

        $produk->delete();

        return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'Data berhasil dihapus',
            'data' => $produk
        ]);
    }

}
