<?php

namespace App\Http\Controllers;

use App\Models\Pedagang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class PedagangController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function create(Request $request)
    {
        $this->validate($request, [
            'nama_pedagang' => 'required',
            'nomor_telepon' => 'required',
            'alamat_pedagang' => 'required',
            'tanggal_lahir' => 'required',
            'nomor_ktp' => 'required|unique:pedagang',
            'foto_rekening' => 'required'
        ]);

        $foto_rekening = $request->file('foto_rekening')->getClientOriginalName();
        $request->file('foto_rekening')->move('upload', $foto_rekening);

        $pedagang = [
            'nama_pedagang' => $request->input('nama_pedagang'),
            'nomor_telepon' => $request->input('nomor_telepon'),
            'alamat_pedagang' => $request->input('alamat_pedagang'),
            'tanggal_lahir' => $request->input('tanggal_lahir'),
            'nomor_ktp' => $request->input('nomor_ktp'),
            'foto_rekening' => url('upload/' . $foto_rekening)
        ];

        $pedagang = Pedagang::create($pedagang);

        if ($pedagang) {
            $result = [
                'message' => 'Data berhasil ditambahkan',
                'data' => $pedagang
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
        $pedagang = Pedagang::all();

        
        if (empty($pedagang)) {
            return response()->json(['error' => 'Pedagang Tidak Ditemukan'], 402);
        }
        return response()->json($pedagang);
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
        $pedagang = Pedagang::find($id_pedagang);

        if (!$pedagang) {
            return response()->json([
                'message' => 'Data jam tidak ditemukan',
                'data' => $pedagang
            ], 404);
        }

        $this->validate($request, [
            'nama_pedagang' => 'required',
            'nomor_telepon' => 'required',
            'alamat_pedagang' => 'required',
            'tanggal_lahir' => 'required',
            'nomor_ktp' => 'required|unique:pedagang',
            'foto_rekening' => 'required'
        ]);

        $dataproduk = $request->all();
        $pedagang->fill($dataproduk);
        $pedagang->save();

        return response()->json($pedagang);
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