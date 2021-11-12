<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class VoucherController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function create(Request $request)
    {
        $this->validate($request, [
            'nama_voucher' => 'required',
            'id_voucher' => 'required',
            
        ]);

        $voucher = [
            'nama_voucher' => $request->input('nama_voucher'),
            'id_voucher' => $request->input('id_voucher')
        ];

        $voucher = Voucher::create($voucher);

        if ($voucher) {
            $result = [
                'message' => 'Data berhasil ditambahkan',
                'data' => $voucher
            ];
        } else {
            $result = [
                'message' => 'Data tidak berhasil ditambahkan',
                'data' => ''
            ];
        }

        if (empty($voucher)) {
            return response()->json(['error' => 'unknown error'], 501);
        }
        return response()->json($result);
    }

    public function index()
    {
        $voucher = Voucher::all();
        return response()->json($voucher);
    }

    public function show($id)
    {
        $voucher = Voucher::find($id);

          if (empty($voucher)) {
            return response()->json(['error' => 'Voucher Tidak Ditemukan'], 402);
        }

        return response()->json($voucher);
    }

    public function update(Request $request, $id)
    {
        $voucher = Voucher::find($id);

        if (!$voucher) {
            return response()->json([
                'message' => 'Data voucher tidak ditemukan',
                'data' => $voucher
            ], 404);
        }

        $this->validate($request, [
            'nama_voucher' => 'required',
            'id_voucher' => 'required',
        ]);

        $datavoucher = $request->all();
        $voucher->fill($datavoucher);
        $voucher->save();

         return response()->json([
            'message' => 'Voucher update!',
            'code' => 200
        ]);

        return response()->json($voucher);
    }

     public function search(Request $request)
    {
        # code...
        $query = $request->query('query');

        if (empty($query)) {
            return response()->json(['error' => 'Query not specified!'], 400);
        }

        $fulltext = $request->query('fulltext', 'false');
        $sortBy = $request->query('sort_by', 'nama_voucher.asc');
        $sorts = explode('.', $sortBy);


        if ($fulltext == 'true') {
            $data = Voucher::query()
                ->whereRaw("MATCH(nama_toko,id_voucher) AGAINST(? IN BOOLEAN MODE)", array($query))
                ->orderBy($sorts[0], $sorts[1])
                ->get();
            return response()->json($data);
        }

        $data = Voucher::query()
            ->where('nama_voucher', 'like', '%' . $query . '%')
            ->orWhere('id_voucher', 'like', '%' . $query . '%')
            ->orderBy($sorts[0], $sorts[1])
            ->get();

        return response()->json($data);
    }

    public function destroy($id)
    {
        $voucher = Voucher::find($id);

        if (!$voucher) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'data' => $voucher
            ], 404);
        }

        $voucher->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus',
            'data' => $voucher
        ], 200);
    }
}