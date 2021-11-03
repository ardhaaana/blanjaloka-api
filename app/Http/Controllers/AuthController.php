<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;



class AuthController extends Controller
{
    
    public function register(Request $request)
    {
        $this->validate($request, [
            'nama_customer' => 'required|min:5',
            'nomor_telepon' => 'required|min:10',
            'email_customer' => 'required|email',
            'username' => 'required|unique:customer|min:5',
            'password' => 'required|min:8'

        ]);

        $nama_customer = $request->input('nama_customer');
        $nomor_telepon = $request->input('nomor_telepon');
        $alamat_customer = $request->input( 'alamat_customer');
        $tanggal_lahir = $request->input( 'tanggal_lahir');
        $email_customer = $request->input( 'email_customer');
        $username = $request->input('username');
        $password = Hash::make($request->input('password'));

       $register = Customer::create([
           'nama_customer' => $nama_customer,
           'nomor_telepon' => $nomor_telepon,
           'alamat_customer' => $alamat_customer,
           'tanggal_lahir' => $tanggal_lahir,
           'email_customer' => $email_customer, 
           'username' => $username, 
           'password' => $password
        ]);

        if ($register){
            return response()->json([
                'message' => 'Register sukses',
                'data' => $register
            ], 201);
        } else{
             return response()->json([
                'message' => 'Register gagal',
                'data' => ''
            ], 400);
        }

    }
    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required|min:8'
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        $login = Customer::where('username', $username)->first();

        if (Hash::check($password, $login->password)){
            $token =  Str::random(40);

            $login->update([
                'token' => $token
            ]);

            return response()->json([
                'message' => 'Login sukses',
                'data' => [
                    'data' => $login,
                    'token' => $token
                ]
                ]);
        }else{
            return response()->json([
                'message' => 'Login gagal',
                'data' => ''
                ]);
        }
    }

}
