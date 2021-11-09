<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ProdukController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function create(Request $request)
    {
        $this->validate($request, [
            'nama_produk' => 'required',
            'satuan' => 'required',
            'harga_jual' => 'required|numeric',
            'stok_saat_ini' => 'required|numeric',
            'deskripsi' => 'required',
            'status_produk' => 'required',
            'id_pedagang' => 'required|numeric'
        ]);

        //    $foto_produk = $request->file('foto_produk')->getClientOriginalName();
        //    $request->file('foto_produk')->move('upload',$foto_produk);

        // $produk = [
        //     'nama_produk' => $request->input('nama_produk'),
        //     'satuan' => $request->input('satuan'),
        //     'harga_jual' => $request->input('harga_jual'),
        //     'stok_saat_ini' => $request->input('stok_saat_ini'),
        //     'deskripsi' => $request->input('deskripsi'),
        //     'foto_produk' => url('upload/'.$foto_produk),
        //     'status_produk' => $request->input('status_produk'),
        //     'id_pedagang' => $request->input('id_pedagang')
        // ];

        // $produk = Produk::create($produk);

        // if ($produk){
        //     $result = [
        //         'message' => 'Data berhasil ditambahkan',
        //         'data' => $produk
        //     ];
        // } else {
        //     $result = [
        //         'message' => 'Data tidak berhasil ditambahkan',
        //         'data' => ''
        //     ];
        // }

        //  if (empty($produk)) {
        //     return response()->json(['error' => 'unknown error'], 501);
        // }

        // return response()->json([
        //     'message' => 'Produk create success!',
        //     'code' => 201,
        //     'data' => $produk
        // ]);

        // return response()->json($produk);     

        if ($request->has('foto_produk')) {
            $produk = Produk::query()->create(
                [
                    'nama_produk' => $request->input('nama_produk'),
                    'satuan' => $request->input('satuan'),
                    'harga_jual' => $request->input('harga_jual'),
                    'stok_saat_ini' => $request->input('stok_saat_ini'),
                    'deskripsi' => $request->input('deskripsi'),
                    'foto_produk' => $request->input('foto_produk'),
                    'status_produk' => $request->input('status_produk'),
                    'id_pedagang' => $request->input('id_pedagang')
                ]
            );
        } else {
            $produk = Produk::query()->create(
                [
                    'nama_produk' => $request->input('nama_produk'),
                    'satuan' => $request->input('satuan'),
                    'harga_jual' => $request->input('harga_jual'),
                    'stok_saat_ini' => $request->input('stok_saat_ini'),
                    'deskripsi' => $request->input('deskripsi'),
                    'status_produk' => $request->input('status_produk'),
                    'id_pedagang' => $request->input('id_pedagang')
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

        if (empty($produk)) {
            return response()->json(['error' => 'Produk Tidak Ditemukan'], 402);
        }
        return response()->json($produk);
    }

    public function show($kode_produk)
    {
        $produk = Produk::find($kode_produk);
        
        if (empty($produk)) {
            return response()->json(['error' => 'Produk Tidak Ditemukan'], 402);
        }

        return response()->json($produk);
        
    }

    public function update(Request $request, $kode_produk)
    {
        // $produk = Produk::find($kode_produk);

        // if (!$produk) {
        //     return response()->json([
        //         'message' => 'Data tidak ditemukan',
        //         'data' => $produk
        //     ], 404);
        // }

        $this->validate($request, [
            'nama_produk' => 'required',
            'satuan' => 'required',
            'harga_jual' => 'required|numeric',
            'stok_saat_ini' => 'required|numeric',
            'deskripsi' => 'required',
            'status_produk' => 'required',
            'id_pedagang' => 'required|numeric'
        ]);

        if ($request->has('foto_produk')) {
            $update = Produk::query()->find($kode_produk)->update(
                [
                    'nama_produk' => $request->input('nama_produk'),
                    'satuan' => $request->input('satuan'),
                    'harga_jual' => $request->input('harga_jual'),
                    'stok_saat_ini' => $request->input('stok_saat_ini'),
                    'deskripsi' => $request->input('deskripsi'),
                    'foto_produk' => $request->input('foto_produk'),
                    'status_produk' => $request->input('status_produk'),
                    'id_pedagang' => $request->input('id_pedagang')
                ]
            );
        } else {
            $update = Produk::query()->find($kode_produk)->update(
                [
                   'nama_produk' => $request->input('nama_produk'),
                    'satuan' => $request->input('satuan'),
                    'harga_jual' => $request->input('harga_jual'),
                    'stok_saat_ini' => $request->input('stok_saat_ini'),
                    'deskripsi' => $request->input('deskripsi'),
                    'status_produk' => $request->input('status_produk'),
                    'id_pedagang' => $request->input('id_pedagang')
                ]
            );
        }

        if (!$update) {
            return response()->json(['error' => 'unknown error'], 500);
        }
       
        // $dataproduk = $request->all();
        // $produk->fill($dataproduk);
        // $produk->save();
        
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

    public function destroy($kode_produk)
    {
        $produk = Produk::find($kode_produk);

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
