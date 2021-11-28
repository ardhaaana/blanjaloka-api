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
                'code' => 200,
                'success' => true,
                'message' => 'Resep Makanan create success!',
                'data' => $resep
            ]);
        }
    }

    public function index()
    {
        $resep = Resep::all();

        if (empty($resep)) {
            return response()->json(['code' => 402,'success' => false,'error' => 'Resep Tidak Ditemukan']);
        }
        return response()->json(['code' => 200,'success' => true, 'message' => 'Menampilkan Resep', 'Data' => $resep]);
    }

    public function show($kode_resep)
    {
        $resep = Resep::find($kode_resep);

        if (empty($resep)) {
            return response()->json(['code' => 402,'success' => false,'error' => 'Resep Tidak Ditemukan']);
        }
        return response()->json(['code' => 200,'success' => true, 'message' => 'Menampilkan Resep', 'Data' => $resep]);
    }

    public function update(Request $request, $kode_resep)
    {
        $resep = Resep::find($kode_resep);

        if (!$resep) {
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => 'Data tidak ditemukan',
                'data' => $resep
            ]);
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
            return response()->json(['code' => 500,'success' => false,'error' => 'unknown error']);
        }

         return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'Resep Makanan update!'
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

        return response()->json(['code' => 200,'success' => true,
                                'message' => 'Menampilkan Pencarian', 
                                'Data' => $data]);
    }

    public function destroy($kode_resep)
    {
        $resep = Resep::find($kode_resep);

        if (!$resep) {
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => 'Data tidak ditemukan',
                'data' => $resep
            ]);
        }

        $resep->delete();

        return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'Data berhasil dihapus',
            'data' => $resep
        ]);
    }
}
