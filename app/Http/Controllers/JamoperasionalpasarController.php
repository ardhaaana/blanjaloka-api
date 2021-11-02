<?php 

namespace App\Http\Controllers;

use App\Models\Jamoperasionalpasar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class JamoperasionalpasarController extends Controller
{
    
    public function create(Request $request)
    {
        $this->validate($request, [
            'hari_operasional' => 'required',
            'jam_operasional' => 'required',
            'id_pengelola' => 'required|numeric|unique:jam_operasional_pasar'
        ]);

            $hari_operasional = $request->input('hari_operasional');
            $jam_operasional = $request->input('jam_operasional');
            $id_pengelola = $request->input('id_pengelola');

        $jam = Jamoperasionalpasar::create([
           'hari_operasional' => $hari_operasional,
           'jam_operasional' =>  $jam_operasional,
           'id_pengelola' => $id_pengelola
        ]);

        $datajam = $request->all();
        $jam = Jamoperasionalpasar::create($datajam);
        
       if ($jam){
            return response()->json([
                'message' => 'Penambahan data berhasil',
                'data' => $jam
            ], 201);
        } else{
            return response()->json([
                'message' => 'Penambahan data tidak berhasil',
                'data' => ''
            ], 400);
        }

    }

    public function index()
    { 
        $jam = Jamoperasionalpasar::all();
        return response()->json($jam);
    }

    public function show($id_toko)
    {
        $jam = Jamoperasionalpasar::find($id_toko);
        return response()->json($jam);
    }

    public function update(Request $request, $id_toko)
    {
        $jam = Jamoperasionalpasar::find($id_toko);

       if (!$jam){
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'data' => $jam
            ], 404);
        }
        
        $this->validate($request, [
            'hari_operasional' => 'required|min:5',
            'jam_operasional' => 'required',
            'id_pengelola' => 'required|numeric'
        ]);

        $datajam = $request->all();
        $jam->fill($datajam);
        $jam->save();
        
        return response()->json($jam);
    }

    public function destroy($id_toko)
    {
        $jam = Jamoperasionalpasar::find($id_toko);

        if (!$jam){
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'data' => $jam
            ], 404);
        }
        
        $jam->delete();

        return response()->json([
                'message' => 'Data berhasil dihapus',
                'data' => $jam
            ], 200);
    }

}
