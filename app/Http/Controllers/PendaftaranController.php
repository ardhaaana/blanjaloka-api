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
            'nomor_telepon' => 'required|numeric',
            'tanggal_lahir' => 'required',
            'nomor_ktp' => 'required|numeric|unique:pendaftaran',
            'foto_ktp' => 'required'
        ]);

           $foto_ktp = $request->file('foto_ktp')->getClientOriginalName();
           $request->file('foto_ktp')->move('upload',$foto_ktp);

        $pendaftaran = [
            'nama' => $request->input('nama'),
            'alamat' => $request->input('alamat'),
            'nomor_telepon' => $request->input('nomor_telepon'),
            'tanggal_lahir' => $request->input('tanggal_lahir'),
            'nomor_ktp' => $request->input('nomor_ktp'),
            'foto_ktp' => url('upload/'.$foto_ktp)
        ];

        $pendaftaran = Pendaftaran::create($pendaftaran);

        if ($pendaftaran){
            $result = [
                'message' => 'Data berhasil ditambahkan',
                'data' => $pendaftaran
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
        $pendaftaran = Pendaftaran::all();
        return response()->json($pendaftaran);
    }

    public function show($id_pendaftaran)
    {
        $pendaftaran = Pendaftaran::find($id_pendaftaran);
        return response()->json($pendaftaran);
    }

    public function update(Request $request, $id_pendaftaran)
    {
        $pendaftaran = Pendaftaran::find($id_pendaftaran);

       if (!$pendaftaran){
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'data' => $pendaftaran
            ], 404);
        }
        
        $this->validate($request, [
            'nama' => 'required',
            'alamat' => 'required',
            'nomor_telepon' => 'required|numeric',
            'tanggal_lahir' => 'required',
            'nomor_ktp' => 'required|numeric|unique:pendaftaran',
            'foto_ktp' => 'required'
        ]);

        $datapendaftaran = $request->all();
        $pendaftaran->fill($datapendaftaran);
        $pendaftaran->save();
        
        return response()->json($pendaftaran);
    }

    public function destroy($id_pendaftaran)
    {
        $pendaftaran = Pendaftaran::find($id_pendaftaran);

        if (!$pendaftaran){
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
