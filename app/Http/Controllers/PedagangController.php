<?php

namespace App\Http\Controllers;

use App\Models\Pedagang;
use App\Models\Toko;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class PedagangController extends Controller
{

  
    public function create(Request $request)
    {
        $this->validate($request, [
            'nama_pedagang' => 'required',
            'nomor_telepon' => 'required',
            'alamat_pedagang' => 'required',
            'tanggal_lahir' => 'required',
            'nomor_ktp' => 'required|unique:pedagang',
            'foto_rekening' => 'required',
            'nama_toko' => 'required',
            'alamat_toko' => 'required'
        ]);

          if ($request->has('foto_rekening')) {
            $pedagang = Pedagang::query()->create(
                [
                'nama_pedagang' => $request->input('nama_pedagang'),
                'nomor_telepon' => $request->input('nomor_telepon'),
                'alamat_pedagang' => $request->input('alamat_pedagang'),
                'tanggal_lahir' => $request->input('tanggal_lahir'),
                'nomor_ktp' => $request->input('nomor_ktp'),
                'foto_rekening' => $request->input('foto_rekening'),
                'nama_toko' => $request->input('nama_toko'),
                'alamat_toko' => $request->input('alamat_toko')
                ]
            );
        } else {
            $pedagang = Pedagang::query()->create(
                [
                'nama_pedagang' => $request->input('nama_pedagang'),
                'nomor_telepon' => $request->input('nomor_telepon'),
                'alamat_pedagang' => $request->input('alamat_pedagang'),
                'tanggal_lahir' => $request->input('tanggal_lahir'),
                'nomor_ktp' => $request->input('nomor_ktp'),
                'nama_toko' => $request->input('nama_toko'),
                'alamat_toko' => $request->input('alamat_toko')
                ]
            );
        }
             
            if (empty($pedagang)) {
            return response()->json(['error' => 'unknown error'], 501);
            }

            return response()->json([
                'message' => 'Pedagang create success!',
                'code' => 200,
                'data' => $pedagang
            ]);

    }

    public function index()
    {
        
        $pedagang = Pedagang::all();
        
        if (empty($pedagang)) {
            return response()->json(['error' => 'Pedagang Tidak Ditemukan'], 402);
        }

        return response()->json($pedagang);
    }

      public function __construct()
    {
        $this->middleware('auth');
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
            $data = Pedagang::query()
                ->whereRaw("MATCH(nama_toko, alamat_toko) AGAINST(? IN BOOLEAN MODE)", array($query))
                ->orderBy($sorts[0], $sorts[1])
                ->get();
            return response()->json($data);
        }

        $data = Pedagang::query()
            ->where('nama_toko', 'like', '%' . $query . '%')
            ->orWhere('alamat_toko', 'like', '%' . $query . '%')
            ->orderBy($sorts[0], $sorts[1])
            ->get();
        
        $data = DB::table('pedagang')->select('nama_toko', 'alamat_toko')
                        ->get();

        return response()->json($data);
     
    }

    public function show($id_pedagang)
    {
        
        $pedagang = Pedagang::find($id_pedagang);
        
        if (empty($pedagang)) {
            return response()->json(['error' => 'Pedagang Tidak Ditemukan'], 402);
        }
        return response()->json($pedagang);
        
    }

    public function update(Request $request, $id_pedagang)
    {
       $this->validate($request, [

            'nama_pedagang' => 'required',
            'nomor_telepon' => 'required',
            'alamat_pedagang' => 'required',
            'tanggal_lahir' => 'required',
            'nomor_ktp' => 'required|unique:pedagang',
            'foto_rekening' => 'required',
            'nama_toko' => 'required',
            'alamat_toko' => 'required'
        ]);

        if ($request->has('foto_rekening')) {
            $update = Pedagang::query()->find($id_pedagang)->update(
                [
                    'nama_pedagang' => 'required',
                    'nomor_telepon' => 'required',
                    'alamat_pedagang' => 'required',
                    'tanggal_lahir' => 'required',
                    'nomor_ktp' => 'required|unique:pedagang',
                    'foto_rekening' => 'required',
                    'nama_toko' => 'required',
                    'alamat_toko' => 'required'
                ]
            );
        } else {
            $update = Pedagang::query()->find($id_pedagang)->update(
                [
                    'nama_pedagang' => $request->input('nama_pedagang'),
                    'nomor_telepon' => $request->input('nomor_telepon'),
                    'alamat_pedagang' => $request->input('alamat_pedagang'),
                    'tanggal_lahir' => $request->input('tanggal_lahir'),
                    'nomor_ktp' => $request->input('nomor_ktp'),
                    'foto_rekening' => $request->input('foto_rekening'),
                    'nama_toko' => $request->input('nama_toko'),
                    'alamat_toko' => $request->input('alamat_toko')
                ]
            );
        }

        if (!$update) {
            return response()->json(['error' => 'unknown error'], 500);
        }
        
        return response()->json([
            'message' => 'Pedagang update!',
            'code' => 200
        ]);

    }

    public function destroy($id_pedagang)
    {
        $pedagang = Pedagang::find($id_pedagang);

        if (!$pedagang) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'data' => $pedagang
            ], 404);
        }

        $pedagang->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus',
            'data' => $pedagang
        ], 200);
    }
}
