<?php 

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class PendaftaranController extends Controller
{
    
    public function create(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'alamat' => 'required',
            'nomor_telepon' => 'required|',
            'tanggal_lahir' => 'required',
            'nomor_ktp' => 'required|unique:pendaftaran',
            'foto_ktp' => 'required'
        ]);

         if ($request->has('foto_ktp')) {
            $pendaftaran = Pendaftaran::query()->create(
                [
                'nama' => $request->input('nama'),
                'alamat' => $request->input('alamat'),
                'nomor_telepon' => $request->input('nomor_telepon'),
                'tanggal_lahir' => $request->input('tanggal_lahir'),
                'nomor_ktp' => $request->input('nomor_ktp'),
                'foto_ktp' => $request->input('foto_ktp')
                ]
            );
        } else {
            $pendaftaran = Pendaftaran::query()->create(
                [
                'nama' => $request->input('nama'),
                'alamat' => $request->input('alamat'),
                'nomor_telepon' => $request->input('nomor_telepon'),
                'tanggal_lahir' => $request->input('tanggal_lahir'),
                'nomor_ktp' => $request->input('nomor_ktp')
                ]
            );
        }
             
            if (empty($pendaftaran)) {
            return response()->json(['error' => 'unknown error'], 501);
            }

            return response()->json([
                'message' => 'Pedagang create success!',
                'code' => 200,
                'data' => $pendaftaran
            ]);

    }

    public function index()
    {
        $pendaftaran = Pendaftaran::all();

        
        if (empty($pendaftaran)) {
            return response()->json(['error' => 'Data Pendaftaran Tidak Ditemukan'], 402);
        }
        return response()->json($pendaftaran);
    }

    public function show($id_pendaftaran)
    {
        $pendaftaran = Pendaftaran::find($id_pendaftaran);
   
        if (empty($pendaftaran)) {
            return response()->json(['error' => 'Data Pendaftaran Tidak Ditemukan'], 402);
        }
        return response()->json($pendaftaran);
    }

    public function update(Request $request, $id_pendaftaran)
    {
       $this->validate($request, [
            'nama' => 'required',
            'alamat' => 'required',
            'nomor_telepon' => 'required|',
            'tanggal_lahir' => 'required',
            'nomor_ktp' => 'required|unique:pendaftaran',
            'foto_ktp' => 'required'
        ]);

        if ($request->has('foto_ktp')) {
            $update = Pendaftaran::query()->find($id_pendaftaran)->update(
                [
                'nama' => $request->input('nama'),
                'alamat' => $request->input('alamat'),
                'nomor_telepon' => $request->input('nomor_telepon'),
                'tanggal_lahir' => $request->input('tanggal_lahir'),
                'nomor_ktp' => $request->input('nomor_ktp'),
                'foto_ktp' => $request->input('foto_ktp')
                ]
            );
        } else {
            $update = Pendaftaran::query()->find($id_pendaftaran)->update(
                [
                'nama' => $request->input('nama'),
                'alamat' => $request->input('alamat'),
                'nomor_telepon' => $request->input('nomor_telepon'),
                'tanggal_lahir' => $request->input('tanggal_lahir'),
                'nomor_ktp' => $request->input('nomor_ktp')
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

    public function destroy($id_pendaftaran)
    {
        $pendaftaran = Pendaftaran::find($id_pendaftaran);

        if (!$pendaftaran) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'data' => $pendaftaran
            ], 404);
        }

        $pendaftaran->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus',
            'data' => $pendaftaran
        ], 200);
    }

}
