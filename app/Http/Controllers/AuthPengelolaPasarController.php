<?php

namespace App\Http\Controllers;

use App\Models\PengelolaPasar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;



class AuthPengelolaPasarController extends Controller
{

    public function register(Request $request)
    {
        $this->validate($request, [
            'nama_pengelola' => 'required|min:5',
            'alamat_pengelola' => 'required',
            'nomor_telepon' => 'required|min:10',
            'email' => 'required|email|unique:PengelolaPasar',
            'username' => 'required|min:5',
            'password' => 'required|min:8'

        ]);

        $nama_pengelola = $request->input('nama_pengelola');
        $alamat_pengelola = $request->input('alamat_pengelola');
        $nomor_telepon = $request->input('nomor_telepon');
        $email = $request->input('email');
        $username = $request->input('username');
        $password = Hash::make($request->input('password'));

        $register = PengelolaPasar::create([
            'nama_pengelola' => $nama_pengelola,
            'alamat_pengelola' => $alamat_pengelola,
            'nomor_telepon' => $nomor_telepon,
            'email' => $email,
            'username' => $username,
            'password' => $password
        ]);

        if ($register) {
            return response()->json([
                'message' => 'Register sukses',
                'data' => $register
            ], 201);
        } else {
            return response()->json([
                'message' => 'Register gagal',
                'data' => ''
            ], 400);
        }
    }
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required|min:8'
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        $login = PengelolaPasar::where('email', $email)->first();

        if (Hash::check($password, $login->password)) {
            $token =  Str::random(40);

            $login->update([
                'token_pp' => $token
            ]);

            return response()->json([
                'message' => 'Login sukses',
                'data' => [
                    'data' => $login,
                    'token' => $token
                ]
            ]);
        } else {
            return response()->json([
                'message' => 'Login gagal',
                'data' => ''
            ]);
        }
    }

    public function update(Request $request, $id_pengelola)
    {
      
        $this->validate($request, [
            'nama_pengelola' => 'required|min:5',
            'alamat_pengelola' => 'required',
            'nomor_telepon' => 'required|min:10',
            'email' => 'required|email',
            'username' => 'required|min:5',
            'password' => 'required|min:8'
        ]);

      if ($request->has('email')) {
            $update = PengelolaPasar::query()->find($id_pengelola)->update(
                [
                'nama_pengelola' => $request->input('nama_customer'),
                'alamat_pengelola' => $request->input( 'alamat_pengelola'),
                'nomor_telepon' => $request->input('nomor_telepon'),
                'email' => $request->input('email'),
                'username' => $request->input('username'),
                'password' => Hash::make($request->input('password')),
                ]
            );
        } else {
            $update = PengelolaPasar::query()->find($id_pengelola)->update(
                [
                'nama_pengelola' => $request->input('nama_customer'),
                'alamat_pengelola' => $request->input( 'alamat_pengelola'),
                'nomor_telepon' => $request->input('nomor_telepon'),
                'username' => $request->input('username'),
                'password' => Hash::make($request->input('password')),
                ]
            );
        }

        
        if (!$update) {
            return response()->json(['error' => 'unknown error'], 500);
        }

         return response()->json([
            'message' => 'Edit Profile update!',
            'code' => 200
        ]);
    }
    public function index()
    {
        $pengelola = PengelolaPasar::all();

        if (empty($pengelola)) {
            return response()->json(['error' => 'Data Akun Tidak Ditemukan'], 402);
        }
        return response()->json($pengelola);
    }
}
