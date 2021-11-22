<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class TransaksiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            // 'id_transaksi' => 'required',
            'jenis_pembayaran' => 'required',
            'pajak' => 'required',
            'id_customer' => 'required|numeric',
            'id_pedagang' => 'required|numeric',
            'total_pembayaran' => 'required|numeric'
        ]);

        // $id_transaksi = $request->input('id_transaksi');
        $jenis_pembayaran = $request->input('jenis_pembayaran');
        $pajak = $request->input('pajak');
        $id_customer = $request->input('id_customer');
        $id_pedagang = $request->input('id_pedagang');
        $total_pembayaran = $request->input('total_pembayaran');

        $transaksi = Transaksi::create([
            // 'id_transaksi' => $id_transaksi,
            'jenis_pembayaran' => $jenis_pembayaran,
            'pajak' => $pajak,
            'id_customer' => $id_customer,
            'id_pedagang' => $id_pedagang,
            'total_pembayaran' => $total_pembayaran
        ]);

        if ($transaksi) {
            return response()->json([
                'message' => 'Pembayaran pesanan berhasil',
                'data' => $transaksi
            ], 201);
        }
    }

    public function index()
    {
        $transaksi = Transaksi::all();
        return response()->json($transaksi);
    }

    public function show($id)
    {
        $transaksi = Transaksi::find($id);
        return response()->json($transaksi);
    }

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'data' => $transaksi
            ], 404);
        }

        $this->validate($request, [
            'id_transaksi' => 'required',
            'jenis_pembayaran' => 'required',
            'pajak' => 'required',
            'id_customer' => 'required|numeric',
            'id_pedagang' => 'required|numeric',
            'total_pembayaran' => 'required|numeric'
        ]);

        $datatransaksi = $request->all();
        $transaksi->fill($datatransaksi);
        $transaksi->save();

        return response()->json($transaksi);
    }

    // public function search(Request $request)
    // {
    //     # code...
    //     $query = $request->query('query');

    //     if (empty($query)) {
    //         return response()->json(['error' => 'Query not specified!'], 400);
    //     }

    //     $fulltext = $request->query('fulltext', 'false');
    //     $sortBy = $request->query('sort_by', 'id_transaksi.asc');
    //     $sorts = explode('.', $sortBy);


    //     if ($fulltext == 'true') {
    //         $data = Transaksi::query()
    //             ->whereRaw("MATCH(nama_customer) AGAINST(? IN BOOLEAN MODE)", array($query))
    //             ->orderBy($sorts[0], $sorts[1])
    //             ->get();
    //         return response()->json($data);
    //     }

    //     $data = Pesanan::query()
    //         ->where('nama_customer', 'like', '%' . $query . '%')
    //         ->orderBy($sorts[0], $sorts[1])
    //         ->get();

    //     return response()->json($data);
    // }

    public function destroy($id)
    {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'data' => $transaksi
            ], 404);
        }

        $transaksi->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus',
            'data' => $transaksi
        ], 200);
    }
}