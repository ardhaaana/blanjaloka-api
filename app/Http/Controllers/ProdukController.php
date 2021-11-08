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
            'nama_produk' => 'required|min:5',
            'satuan' => 'required',
            'harga_jual' => 'required|numeric',
            'stok_saat_ini' => 'required|numeric',
            'deskripsi' => 'required',
            'status_produk' => 'required',
            'id_pedagang' => 'required|numeric'
        ]);

        $nama_produk = $request->input('nama_produk');
        $satuan = $request->input('satuan');
        $harga_jual = $request->input('harga_jual');
        $stok_saat_ini = $request->input('stok_saat_ini');
        $deskripsi = $request->input('deskripsi');
        $status_produk = $request->input('status_produk');
        $id_pedagang = $request->input('id_pedagang');

        $produk = Produk::create([
            'nama_produk' => $nama_produk,
            'satuan' => $satuan,
            'harga_jual' => $harga_jual,
            'stok_saat_ini' => $stok_saat_ini,
            'deskripsi' => $deskripsi,
            'status_produk' => $status_produk,
            'id_pedagang' => $id_pedagang
        ]);

        if ($produk) {
            return response()->json([
                'message' => 'Penambahan data berhasil',
                'data' => $produk
            ], 201);
        }
    }

    public function index()
    {
        $produk = Produk::all();
        return response()->json($produk);
    }

    public function show($kode_produk)
    {
        $produk = Produk::find($kode_produk);
        return response()->json($produk);
    }

    public function update(Request $request, $kode_produk)
    {
        $produk = Produk::find($kode_produk);

        if (!$produk) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'data' => $produk
            ], 404);
        }

        $this->validate($request, [
            'nama_produk' => 'required|min:5',
            'satuan' => 'required',
            'harga_jual' => 'required|numeric',
            'stok_saat_ini' => 'required|numeric',
            'deskripsi' => 'required',
            'status_produk' => 'required',
            'id_pedagang' => 'required|numeric'
        ]);

        $dataproduk = $request->all();
        $produk->fill($dataproduk);
        $produk->save();

        return response()->json($produk);
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
