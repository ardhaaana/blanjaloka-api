<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class PesananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'nama_customer' => 'required',
            'nomor_telepon' => 'required',
            'alamat_customer' => 'required',
            'id_produk' => 'required|numeric',
            'id_pedagang' => 'required|numeric',
            'id_transaksi' => 'required|numeric',
            'pilihan_penawaran' => 'required',
            'id_driver' => 'required'
        ]);

        $nama_customer = $request->input('nama_customer');
        $nomor_telepon = $request->input('nomor_telepon');
        $alamat_customer = $request->input('alamat_customer');
        $id_produk = $request->input('id_produk');
        $id_pedagang = $request->input('id_pedagang');
        $id_transaksi = $request->input('id_transaksi');
        $pilihan_penawaran = $request->input('pilihan_penawaran');
        $id_driver = $request->input('id_driver');

        $pesanan = Pesanan::create([
            'nama_customer' => $nama_customer,
            'nomor_telepon' => $nomor_telepon,
            'alamat_customer' => $alamat_customer,
            'id_produk' => $id_produk,
            'id_pedagang' => $id_pedagang,
            'id_transaksi' => $id_transaksi,
            'pilihan_penawaran' => $pilihan_penawaran,
            'id_driver' => $id_driver
        ]);

        if ($pesanan) {
            return response()->json([
                'message' => 'Penambahan data berhasil',
                'data' => $pesanan
            ], 201);
        }
    }

    public function index()
    {
        $pesanan = Pesanan::all();
        return response()->json($pesanan);
    }

    public function show($id_pesanan)
    {
        $pesanan = Pesanan::find($id_pesanan);
        return response()->json($pesanan);
    }

    public function update(Request $request, $id_pesanan)
    {
        $pesanan = Pesanan::find($id_pesanan);

        if (!$pesanan) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'data' => $pesanan
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

        $datapesanan = $request->all();
        $pesanan->fill($datapesanan);
        $pesanan->save();

        return response()->json($pesanan);
    }

    public function search(Request $request)
    {
        # code...
        $query = $request->query('query');

        if (empty($query)) {
            return response()->json(['error' => 'Query not specified!'], 400);
        }

        $fulltext = $request->query('fulltext', 'false');
        $sortBy = $request->query('sort_by', 'nama_customer.asc');
        $sorts = explode('.', $sortBy);


        if ($fulltext == 'true') {
            $data = Pesanan::query()
                ->whereRaw("MATCH(nama_customer) AGAINST(? IN BOOLEAN MODE)", array($query))
                ->orderBy($sorts[0], $sorts[1])
                ->get();
            return response()->json($data);
        }

        $data = Pesanan::query()
            ->where('nama_customer', 'like', '%' . $query . '%')
            ->orderBy($sorts[0], $sorts[1])
            ->get();

        return response()->json($data);
    }

    public function destroy($id_pesanan)
    {
        $pesanan = Pesanan::find($id_pesanan);

        if (!$pesanan) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'data' => $pesanan
            ], 404);
        }

        $pesanan->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus',
            'data' => $pesanan
        ], 200);
    }

}
