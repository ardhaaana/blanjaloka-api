<?php

namespace App\Http\Controllers;

use App\Models\Pedagang;
use App\Models\Toko;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class PedagangController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

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

          if ($request->has('foto_rekening')) {
            $pedagang = Pedagang::query()->create(
                [
                'nama_pedagang' => $request->input('nama_pedagang'),
                'nomor_telepon' => $request->input('nomor_telepon'),
                'alamat_pedagang' => $request->input('alamat_pedagang'),
                'tanggal_lahir' => $request->input('tanggal_lahir'),
                'nomor_ktp' => $request->input('nomor_ktp'),
                'foto_rekening' => $request->input('foto_rekening')
                ]
            );
        } else {
            $pedagang = Pedagang::query()->create(
                [
                'nama_pedagang' => $request->input('nama_pedagang'),
                'nomor_telepon' => $request->input('nomor_telepon'),
                'alamat_pedagang' => $request->input('alamat_pedagang'),
                'tanggal_lahir' => $request->input('tanggal_lahir'),
                'nomor_ktp' => $request->input('nomor_ktp')
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

    public function show($id_pedagang)
    {
        
        $pedagang = Pedagang::find($id_pedagang);
        
        if (empty($pedagang)) {
            return response()->json(['error' => 'Pedagang Tidak Ditemukan'], 402);
        }
        return response()->json($pedagang);
        
    }
    
    public function tokoshow()
    {
        $pedagang = Pedagang::all();
        $toko = Toko::all();
        
        return response()->json(['message' => 'Data Pemilik',
                'Data Pedagang' => $pedagang, 
                'Data Toko'=> $toko
        ]);
        
    }

    public function update(Request $request, $id_pedagang)
    {
       $this->validate($request, [

            'nama_produk' => 'required',
            'satuan' => 'required',
            'harga_jual' => 'required|numeric',
            'stok_saat_ini' => 'required|numeric',
            'deskripsi' => 'required',
            'status_produk' => 'required'
        ]);

        if ($request->has('foto_produk')) {
            $update = Pedagang::query()->find($id_pedagang)->update(
                [
                    'nama_produk' => $request->input('nama_produk'),
                    'satuan' => $request->input('satuan'),
                    'harga_jual' => $request->input('harga_jual'),
                    'stok_saat_ini' => $request->input('stok_saat_ini'),
                    'deskripsi' => $request->input('deskripsi'),
                    'foto_produk' => $request->input('foto_produk'),
                    'status_produk' => $request->input('status_produk')
                ]
            );
        } else {
            $update = Pedagang::query()->find($id_pedagang)->update(
                [
                    'nama_produk' => $request->input('nama_produk'),
                    'satuan' => $request->input('satuan'),
                    'harga_jual' => $request->input('harga_jual'),
                    'stok_saat_ini' => $request->input('stok_saat_ini'),
                    'deskripsi' => $request->input('deskripsi'),
                    'status_produk' => $request->input('status_produk')
                ]
            );
        }

        if (!$update) {
            return response()->json(['error' => 'unknown error'], 500);
        }
        
        return response()->json([
            'message' => 'Produk update!',
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