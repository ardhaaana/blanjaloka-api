<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Driver;

class DriverController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        $this->validate($request, [

            'nama_driver' => 'required',
            'nomor_telepon' => 'required|numeric',
            'alamat_driver' => 'required',
            'tanggal_lahir' => 'required|date',
            'nomor_ktp' => 'required',
            'kendaraan' => 'required',
            'foto_stnk' => 'required',
            'id_pendaftaran' => 'required'
        ]);

        //    $foto_produk = $request->file('foto_produk')->getClientOriginalName();
        //    $request->file('foto_produk')->move('upload',$foto_produk);

        // $produk = [
        //     'nama_produk' => $request->input('nama_produk'),
        //     'satuan' => $request->input('satuan'),
        //     'harga_jual' => $request->input('harga_jual'),
        //     'stok_saat_ini' => $request->input('stok_saat_ini'),
        //     'deskripsi' => $request->input('deskripsi'),
        //     'foto_produk' => url('upload/'.$foto_produk),
        //     'status_produk' => $request->input('status_produk'),
        //     'id_pedagang' => $request->input('id_pedagang')
        // ];

        // $produk = Produk::create($produk);

        // if ($produk){
        //     $result = [
        //         'message' => 'Data berhasil ditambahkan',
        //         'data' => $produk
        //     ];
        // } else {
        //     $result = [
        //         'message' => 'Data tidak berhasil ditambahkan',
        //         'data' => ''
        //     ];
        // }

        //  if (empty($produk)) {
        //     return response()->json(['error' => 'unknown error'], 501);
        // }

        // return response()->json([
        //     'message' => 'Produk create success!',
        //     'code' => 201,
        //     'data' => $produk
        // ]);

        // return response()->json($produk);     

        if ($request->has('foto_stnk')) {
            $driver = Driver::query()->create(
                [
                    'nama_driver' => $request->input('nama_driver'),
                    'nomor_telepon' => $request->input('nomor_telepon'),
                    'alamat_driver' => $request->input('alamat_driver'),
                    'tanggal_lahir' => $request->input('tanggal_lahir'),
                    'nomor_ktp' => $request->input('nomor_ktp'),
                    'kendaraan' => $request->input('kendaraan'),
                    'foto_stnk' => $request->input('foto_stnk'),
                    'id_pendaftaran' => $request->input('id_pendaftaran')
                ]
            );
        } else {
            $driver = Driver::query()->create(
                [
                    'nama_driver' => $request->input('nama_driver'),
                    'nomor_telepon' => $request->input('nomor_telepon'),
                    'alamat_driver' => $request->input('alamat_driver'),
                    'tanggal_lahir' => $request->input('tanggal_lahir'),
                    'nomor_ktp' => $request->input('nomor_ktp'),
                    'kendaraan' => $request->input('kendaraan'),
                    'id_pendaftaran' => $request->input('id_pendaftaran')
                ]
            );
        }

        if (empty($driver)) {
            return response()->json(['error' => 'unknown error'], 501);
        }

        return response()->json([
            'message' => 'Driver telah terdaftar!',
            'code' => 201,
            'data' => $driver
        ]);
    }
    public function index()
    {
        $driver = Driver::all();

        return response()->json($driver);
    }

    public function show($id_driver)
    {
        $driver = Driver::find($id_driver);

        if (empty($driver)) {
            return response()->json(['error' => 'Produk Tidak Ditemukan'], 402);
        }

        return response()->json($driver);
    }

    public function update(Request $request, $id_driver)
    {
        // $produk = Produk::find($kode_produk);

        // if (!$produk) {
        //     return response()->json([
        //         'message' => 'Data tidak ditemukan',
        //         'data' => $produk
        //     ], 404);
        // }

        $this->validate($request, [

            'nama_driver' => 'required',
            'nomor_telepon' => 'required|numeric',
            'alamat_driver' => 'required',
            'tanggal_lahir' => 'required|date',
            'nomor_ktp' => 'required',
            'kendaraan' => 'required',
            'foto_stnk' => 'required',
            'id_pendaftaran' => 'required'
        ]);

        if ($request->has('foto_stnk')) {
            $driver = Driver::query()->find($id_driver)->update(
                [
                    'nama_driver' => $request->input('nama_driver'),
                    'nomor_telepon' => $request->input('nomor_telepon'),
                    'alamat_driver' => $request->input('alamat_driver'),
                    'tanggal_lahir' => $request->input('tanggal_lahir'),
                    'nomor_ktp' => $request->input('nomor_ktp'),
                    'kendaraan' => $request->input('kendaraan'),
                    'foto_stnk' => $request->input('foto_stnk'),
                    'id_pendaftaran' => $request->input('id_pendaftaran')
                ]
            );
        } else {
            $driver = Driver::query()->find($id_driver)->update(
                [
                    'nama_driver' => $request->input('nama_driver'),
                    'nomor_telepon' => $request->input('nomor_telepon'),
                    'alamat_driver' => $request->input('alamat_driver'),
                    'tanggal_lahir' => $request->input('tanggal_lahir'),
                    'nomor_ktp' => $request->input('nomor_ktp'),
                    'kendaraan' => $request->input('kendaraan'),
                    'id_pendaftaran' => $request->input('id_pendaftaran')
                ]
            );
        }

        if (!$driver) {
            return response()->json(['error' => 'unknown error'], 500);
        }

        // $dataproduk = $request->all();
        // $produk->fill($dataproduk);
        // $produk->save();

        return response()->json([
            'message' => 'Produk update!',
            'code' => 200
        ]);
    }

    public function search(Request $request)
    {
        # code...
        $query = $request->query('query');

        if (empty($query)) {
            return response()->json(['error' => 'Query not specified!'], 400);
        }

        $fulltext = $request->query('fulltext', 'false');
        $sortBy = $request->query('sort_by', 'nama_driver.asc');
        $sorts = explode('.', $sortBy);


        if ($fulltext == 'true') {
            $data = Driver::query()
                ->whereRaw("MATCH(nama_driver,kendaraan) AGAINST(? IN BOOLEAN MODE)", array($query))
                ->orderBy($sorts[0], $sorts[1])
                ->get();
            return response()->json($data);
        }

        $data = Driver::query()
            ->where('nama_driver', 'like', '%' . $query . '%')
            ->orWhere('kendaraan', 'like', '%' . $query . '%')
            ->orderBy($sorts[0], $sorts[1])
            ->get();

        return response()->json($data);
    }

    public function destroy($id_driver)
    {
        $driver = Driver::find($id_driver);

        if (!$driver) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'data' => $driver
            ], 404);
        }

        $driver->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus',
            'data' => $driver
        ], 200);
    }
}
