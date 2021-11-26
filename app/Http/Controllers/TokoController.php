<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class TokoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'nama_toko' => 'required',
            'alamat_toko' => 'required',
            'id_pedagang' => 'required'
        ]);

        $toko = [
            'nama_toko' => $request->input('nama_toko'),
            'alamat_toko' => $request->input('alamat_toko'),
            'id_pedagang' => $request->input('id_pedagang')
        ];

        $toko = Toko::create($toko);

        if ($toko) {
            $result = [
                'message' => 'Data berhasil ditambahkan',
                'data' => $toko
            ];
        } else {
            $result = [
                'message' => 'Data tidak berhasil ditambahkan',
                'data' => ''
            ];
        }
        return response()->json($result);
    }

    public function index()
    {
        
        if (empty($toko)) {
            return response()->json(['error' => 'Toko Tidak Ditemukan'], 402);
        }
        $toko = Toko::all();
        return response()->json($toko);
    }

    // Menampilkan isi data toko beserta pemilik
    public function show($id_toko)
    {
        $datatoko = DB::table('toko')
        ->select('toko.id_toko', 'toko.nama_toko', 'toko.alamat_toko', 'toko.id_pedagang', 'pedagang.id_pedagang', 'pedagang.nama_pedagang', 'pedagang.nomor_telepon', 'pedagang.alamat_pedagang')
        ->join('pedagang', 'toko.id_pedagang', '=', 'pedagang.id_pedagang')
        ->where('toko.id_toko', $id_toko)
        ->get();

        return response()->json([
            'Message' => 'Success',
            'Informasi Toko' => $datatoko,
            200
        ]);
    }

    public function update(Request $request, $id_toko)
    {
        $toko = Toko::find($id_toko);

        if (!$toko) {
            return response()->json([
                'message' => 'Data toko tidak ditemukan',
                'data' => $toko
            ], 404);
        }

        $this->validate($request, [
            'nama_toko' => 'required',
            'alamat_toko' => 'required',
            'id_pedagang' => 'required'
        ]);

        $datatoko = $request->all();
        $toko->fill($datatoko);
        $toko->save();

        return response()->json($toko);
    }

     public function search(Request $request)
    {
        # code...
        $query = $request->query('query');

        if (empty($query)) {
            return response()->json(['error' => 'Query not specified!'], 400);
        }

        $fulltext = $request->query('fulltext', 'false');
        $sortBy = $request->query('sort_by', 'nama_toko.asc');
        $sorts = explode('.', $sortBy);


        if ($fulltext == 'true') {
            $data = Toko::query()
                ->whereRaw("MATCH(nama_toko,alamat_toko) AGAINST(? IN BOOLEAN MODE)", array($query))
                ->orderBy($sorts[0], $sorts[1])
                ->get();
            return response()->json($data);
        }

        $data = Toko::query()
            ->where('nama_toko', 'like', '%' . $query . '%')
            ->orWhere('alamat_toko', 'like', '%' . $query . '%')
            ->orderBy($sorts[0], $sorts[1])
            ->get();

        return response()->json($data);
    }

    public function destroy($id_toko)
    {
        $toko = Toko::find($id_toko);

        if (!$toko) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'data' => $toko
            ], 404);
        }

        $toko->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus',
            'data' => $toko
        ], 200);
    }
}
