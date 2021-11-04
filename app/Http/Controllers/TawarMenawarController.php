<?php

namespace App\Http\Controllers;

use App\Models\TawarMenawar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class TawarMenawarController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'id_pedagang' => 'required|numeric',
            'id_customer' => 'required|numeric',
            'harga_nego' => 'required|numeric'
        ]);

        $id_pedagang = $request->input('id_pedagang');
        $id_customer = $request->input('id_customer');
        $harga_nego = $request->input('harga_nego');

        $tawar_menawar = TawarMenawar::create([
            'id_pedagang' => $id_pedagang,
            'id_customer' => $id_customer,
            'harga_nego' => $harga_nego
        ]);

        $dataproduk = $request->all();
        $tawar_menawar = TawarMenawar::create($dataproduk);

        if ($tawar_menawar) {
            return response()->json([
                'message' => 'Penambahan data berhasil',
                'data' => $tawar_menawar
            ], 201);
        }
    }

    public function index()
    {
        $tawar_menawar = TawarMenawar::all();
        return response()->json($tawar_menawar);
    }

    public function show($id_tawar)
    {
        $tawar_menawar = TawarMenawar::find($id_tawar);
        return response()->json($tawar_menawar);
    }

    public function update(Request $request, $id_tawar)
    {
        $tawar_menawar = TawarMenawar::find($id_tawar);

        if (!$tawar_menawar) {
            return response()->json([
                'message' => 'Data jam tidak ditemukan',
                'data' => $tawar_menawar
            ], 404);
        }

        $this->validate($request, [
            'id_pedagang' => 'required|numeric',
            'id_customer' => 'required|numeric',
            'harga_nego' => 'required|numeric'
        ]);

        $dataproduk = $request->all();
        $tawar_menawar->fill($dataproduk);
        $tawar_menawar->save();

        return response()->json($tawar_menawar);
    }

    public function destroy($id_tawar)
    {
        $tawar_menawar = TawarMenawar::find($id_tawar);

        if (!$tawar_menawar) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'data' => $tawar_menawar
            ], 404);
        }

        $tawar_menawar->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus',
            'data' => $tawar_menawar
        ], 200);
    }
}
