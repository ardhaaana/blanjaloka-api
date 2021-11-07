<?php

namespace App\Http\Controllers;

use App\Models\JamOperasionalPasar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class JamOperasionalPasarController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'hari_operasional' => '',
            'jam_operasional' => 'required',
            'id_pengelola' => 'required|numeric'
        ]);

        $hari_operasional = $request->input('hari_operasional');
        $jam_operasional = $request->input('jam_operasional');
        $id_pengelola = $request->input('id_pengelola');

        $jam_operasional_pasar = JamOperasionalPasar::create([
            'hari_operasional' => $hari_operasional,
            'jam_operasional' => $jam_operasional,
            'id_pengelola' => $id_pengelola
        ]);

        if ($jam_operasional_pasar) {
            return response()->json([
                'message' => 'Penambahan data berhasil',
                'data' => $jam_operasional_pasar
            ], 201);
        }
    }

    public function index()
    {
        $jam_operasional_pasar = JamOperasionalPasar::all();
        return response()->json($jam_operasional_pasar);
    }

    public function show($id_toko)
    {
        $jam_operasional_pasar = JamOperasionalPasar::find($id_toko);
        return response()->json($jam_operasional_pasar);
    }

    public function update(Request $request, $id_toko)
    {
        $jam_operasional_pasar = JamOperasionalPasar::find($id_toko);

        if (!$jam_operasional_pasar) {
            return response()->json([
                'message' => 'Data jam tidak ditemukan',
                'data' => $jam_operasional_pasar
            ], 404);
        }

        $this->validate($request, [
            'hari_operasional' => '',
            'jam_operasional' => 'required',
            'id_pengelola' => 'required|numeric'
        ]);

        $dataproduk = $request->all();
        $jam_operasional_pasar->fill($dataproduk);
        $jam_operasional_pasar->save();

        return response()->json($jam_operasional_pasar);
    }

    public function destroy($id_toko)
    {
        $jam_operasional_pasar = JamOperasionalPasar::find($id_toko);

        if (!$jam_operasional_pasar) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'data' => $jam_operasional_pasar
            ], 404);
        }

        $jam_operasional_pasar->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus',
            'data' => $jam_operasional_pasar
        ], 200);
    }
}
