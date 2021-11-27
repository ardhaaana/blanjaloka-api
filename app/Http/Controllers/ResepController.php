<?php

namespace App\Http\Controllers;

use App\Models\Resep;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;


class ResepController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function create(Request $request)
    {
        $this->validate($request, [
            'judul_resep' => 'required',
            'waktu' => 'required',
            'resep' => 'required',
            'langkah' => 'required'
        ]);

        $judul_resep = $request->input('judul_resep');
        $waktu = $request->input('waktu');
        $resep = $request->input('resep');
        $langkah = $request->input('langkah');

        $resep = Resep::create([
            'judul_resep' => $judul_resep,
            'waktu' => $waktu,
            'resep' => $resep,
            'langkah' => $langkah
        ]);

        if ($resep) {
            return response()->json([
                'success' => true,
                'message' => 'Resep Makanan create success!',
                'data' => $resep
            ], 200);
        }
    }

    public function index()
    {
        $resep = Resep::all();

        if (empty($resep)) {
            return response()->json(['success' => false,'error' => 'Resep Tidak Ditemukan'], 402);
        }
        return response()->json(['success' => true, 'message' => 'Menampilkan Resep', 'Data' => $resep],200);
    }

    public function show($kode_resep)
    {
        $resep = Resep::find($kode_resep);

        if (empty($resep)) {
            return response()->json(['success' => false,'error' => 'Resep Tidak Ditemukan'], 402);
        }
        return response()->json(['success' => true, 'message' => 'Menampilkan Resep', 'Data' => $resep],200);
    }

    public function update(Request $request, $kode_resep)
    {
        $resep = Resep::find($kode_resep);

        if (!$resep) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
                'data' => $resep
            ], 404);
        }

        $this->validate($request, [
            'judul_resep' => 'required',
            'waktu' => 'required',
            'resep' => 'required',
            'langkah' => 'required'
        ]);

        $dataresep = $request->all();
        $resep->fill($dataresep);
        $resep->save();
        
        if (!$resep) {
            return response()->json(['success' => false,'error' => 'unknown error'], 500);
        }

         return response()->json([
            'success' => false,
            'message' => 'Resep Makanan update!'
        ],200);
    }

    public function search(Request $request)
    {
        # code...
        $query = $request->query('query');

        if (empty($query)) {
            return response()->json(['success' => false,'error' => 'Query not specified!'], 400);
        }

        $fulltext = $request->query('fulltext', 'false');
        $sortBy = $request->query('sort_by', 'judul_resep.asc');
        $sorts = explode('.', $sortBy);


        if ($fulltext == 'true') {
            $data = Resep::query()
                ->whereRaw("MATCH(judul_resep) AGAINST(? IN BOOLEAN MODE)", array($query))
                ->orderBy($sorts[0], $sorts[1])
                ->get();
            return response()->json($data);
        }

        $data = Resep::query()
            ->where('judul_resep', 'like', '%' . $query . '%')
            ->orderBy($sorts[0], $sorts[1])
            ->get();

        return response()->json(['success' => true,'message' => 'Menampilkan Pencarian', 'Data' => $data],200);
    }

    public function destroy($kode_resep)
    {
        $resep = Resep::find($kode_resep);

        if (!$resep) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
                'data' => $resep
            ], 404);
        }

        $resep->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus',
            'data' => $resep
        ], 200);
    }
}
