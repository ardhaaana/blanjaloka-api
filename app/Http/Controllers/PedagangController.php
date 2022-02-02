<?php

namespace App\Http\Controllers;

use App\Models\Pedagang;
use App\Models\Toko;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class PedagangController extends Controller
{
    
      public function __construct()
    {
        $this->middleware('auth');
    }
  
    public function create(Request $request)
    {

         $validate = [
            'nama_pedagang' => 'required',
            'nomor_telepon' => 'required',
            'alamat_pedagang' => 'required',
            'tanggal_lahir' => 'required',
            'nomor_ktp' => 'required|unique:pedagang',
            'foto_rekening' => 'required',
            'nama_toko' => 'required',
            'alamat_toko' => 'required'
        ];

        $pesan = [
            'nama_pedagang.required' => 'Nama Tidak Boleh Kosong',
            'nomor_telepon.required' => 'Nomor Telepon Tidak Boleh Kosong',
            'alamat_pedagang.required' => 'Alamat Pedagang Tidak Boleh Kosongr',
            'tanggal_lahir.required' => 'Tanggal lahir Tidak Boleh Kosong',
            'nomor_ktp.required' => 'Nomor KTP Tidak Boleh Kosong',
            'foto_rekening.required' => 'Foto Rekening Tidak Boleh Kosong',
            'nama_toko.required' => 'Nama Toko Tidak Boleh Kosong',
            'alamat_toko.required' => 'Alamat Toko Tidak Boleh Kosong'
        ];

        $validator = Validator::make($request->all(), $validate, $pesan);
        
        if($validator->fails())
        {
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => $validator->errors()->first(),
                'data' => null,
            ]);
        }


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
            return response()->json(['code' => 500,'success' => false, 'error' => 'unknown error']);
            }

            return response()->json([
                'code' => 200,
                'success' => true, 
                'message' => 'Pedagang create success!',
                'data' => $pedagang
            ]);

    }

    public function index()
    {
        
        $pedagang = Pedagang::all();
        
        if (empty($pedagang)) {
            return response()->json(['code' => 402,'success' => false, 'error' => 'Pedagang Tidak Ditemukan']);
        }

        return response()->json(['code' => 200,
                                'success' => true, 
                                'message' => 'Menampilkan Data Pedagang',
                                'Data' =>$pedagang
                            ]);
    }

    public function caritoko(Request $request)
    {
        # code...
        $query = $request->query('query');

        if (empty($query)) {
            return response()->json(['code' => 400,'success' => false,'error' => 'Query not specified!']);
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
            ->select('nama_toko', 'alamat_toko')
            ->where('nama_toko', 'like', '%' . $query . '%')
            ->orWhere('alamat_toko', 'like', '%' . $query . '%')
            ->orderBy($sorts[0], $sorts[1])
            ->get();

        return response()->json(['code' => 200,'success' => true,
                                'message' => 'Menampilkan Pencarian', 
                                'Data' => $data]);
     
    }

    public function show($id_pedagang)
    {
        
        $pedagang = Pedagang::find($id_pedagang);
        
        if (empty($pedagang)) {
            return response()->json(['code' => 402,'success' => false,'error' => 'Pedagang Tidak Ditemukan']);
        }
        return response()->json(['code' => 200,'success' => true, 'message' => 'Menampilkan Data Pedagang', 'Data' => $pedagang]);
        
    }

    public function update(Request $request, $id_pedagang)
    {
       $validate = [
            'nama_pedagang' => 'required',
            'nomor_telepon' => 'required',
            'alamat_pedagang' => 'required',
            'tanggal_lahir' => 'required',
            'nomor_ktp' => 'required|unique:pedagang',
            'foto_rekening' => 'required',
            'nama_toko' => 'required',
            'alamat_toko' => 'required'
        ];

        $pesan = [
            'nama_pedagang.required' => 'Nama Tidak Boleh Kosong',
            'nomor_telepon.required' => 'Nomor Telepon Tidak Boleh Kosong',
            'alamat_pedagang.required' => 'Alamat Pedagang Tidak Boleh Kosongr',
            'tanggal_lahir.required' => 'Tanggal lahir Tidak Boleh Kosong',
            'nomor_ktp.required' => 'Nomor KTP Tidak Boleh Kosong',
            'foto_rekening.required' => 'Foto Rekening Tidak Boleh Kosong',
            'nama_toko.required' => 'Nama Toko Tidak Boleh Kosong',
            'alamat_toko.required' => 'Alamat Toko Tidak Boleh Kosong'
        ];

        $validator = Validator::make($request->all(), $validate, $pesan);
        
        if($validator->fails())
        {
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => $validator->errors()->first(),
                'data' => null,
            ]);
        }

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
            return response()->json(['code' => 500,'success' => false,'error' => 'unknown error']);
        }
        
        return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'Pedagang update!',
        ]);

    }

    public function destroy($id_pedagang)
    {
        $pedagang = Pedagang::find($id_pedagang);

        if (!$pedagang) {
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => 'Data tidak ditemukan',
                'data' => $pedagang
            ]);
        }

        $pedagang->delete();

        return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'Data berhasil dihapus',
            'data' => $pedagang
        ]);
    }
}
