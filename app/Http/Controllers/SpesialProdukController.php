<<<<<<< HEAD
<?php

namespace App\Http\Controllers;

use App\Models\SpesialProduk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class SpesialProdukController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function create(Request $request)
    {
        $this->validate($request, [
            'id_produk' => 'required',
            'diskon' => 'required'
        ]);

        $id_produk = $request->input('id_produk');
        $diskon = $request->input('diskon');

        $spesialproduk = SpesialProduk::create([
            'id_produk' => $id_produk,
            'diskon' => $diskon
        ]);

        if ($spesialproduk) {
            return response()->json([
                'message' => 'Pembuatan spesial produk berhasil',
                'data' => $spesialproduk
            ], 201);
        }
    }

    public function index()
    {
        $spesialproduk = SpesialProduk::all();
        return response()->json($spesialproduk);
    }

    public function show($id)
    {
        $spesialproduk = SpesialProduk::find($id);
        return response()->json($spesialproduk);
    }

    public function update(Request $request, $id)
    {
        $spesialproduk = SpesialProduk::find($id);

        if (!$spesialproduk) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'data' => $spesialproduk
            ], 404);
        }

        $this->validate($request, [
            'nama_customer' => 'required',
            'nomor_telepon' => 'required',
            'alamat_customer' => 'required',
            'id_produk' => 'required|numeric',
            'id_pedagang' => 'required|numeric',
            'id_transaksi' => 'required|numeric',
            'pilihan_penawaran' => 'required',
            'id_driver' => 'required|numeric'
        ]);

        $dataspesialproduk = $request->all();
        $spesialproduk->fill($dataspesialproduk);
        $spesialproduk->save();

        return response()->json($spesialproduk);
    }

    public function search(Request $request)
    {
        # code...
        $query = $request->query('query');

        if (empty($query)) {
            return response()->json(['error' => 'Query not specified!'], 400);
        }

        $fulltext = $request->query('fulltext', 'false');
        $sortBy = $request->query('sort_by', 'id_produk.asc');
        $sorts = explode('.', $sortBy);


        if ($fulltext == 'true') {
            $data = SpesialProduk::query()
                ->whereRaw("MATCH(id_produk) AGAINST(? IN BOOLEAN MODE)", array($query))
                ->orderBy($sorts[0], $sorts[1])
                ->get();
            return response()->json($data);
        }

        $data = SpesialProduk::query()
            ->where('id_produk', 'like', '%' . $query . '%')
            ->orderBy($sorts[0], $sorts[1])
            ->get();

        return response()->json($data);
    }

    public function destroy($id)
    {
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
