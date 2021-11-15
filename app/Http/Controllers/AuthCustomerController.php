<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;



class AuthCustomerController extends Controller
{
    
    public function register(Request $request)
    {
        $this->validate($request, [
            'nama_customer' => 'required|min:5',
            'nomor_telepon' => 'required',
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
                    'data' => $login
                ]
                ]);
        }else{
            return response()->json([
                'message' => 'Login gagal',
                'data' => ''
                ]);
        }
    }

    public function logout(Request $request)
    {
            $login = $request->login();
            $login->currentAccessTokenn()->delete();

            dd($login);
            return response()->json([
                'message' => 'Logout sukses'
                
            ], 200);
    }

    public function update(Request $request, $id_customer)
    {
      
        $this->validate($request, [
            'nama_customer' => 'required|min:5'
        ]);

      if ($request->has('email_customer')) {
            $update = Customer::query()->find($id_customer)->update(
                [
                'nama_customer' => $request->input('nama_customer'),
                'alamat_customer' => $request->input( 'alamat_customer'),
                'tanggal_lahir' => $request->input( 'tanggal_lahir')
                ]
            );
        } else {
            $update = Customer::query()->find($id_customer)->update(
                [
                'nama_customer' => $request->input('nama_customer'),
                'alamat_customer' => $request->input( 'alamat_customer'),
                'tanggal_lahir' => $request->input( 'tanggal_lahir')
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
    public function emailupdate(Request $request, $id_customer)
    {
      
        $this->validate($request, [
            'email_customer' => 'required|email',
        ]);

      if ($request->has('email_customer')) {
            $update = Customer::query()->find($id_customer)->update(
                [
                'email_customer' => $request->input('email_customer'),
                ]
            );
        } else {
            $update = Customer::query()->find($id_customer)->update(
                [
                'alamat_customer' => $request->input( 'alamat_customer')
                ]
            );
        }

        
        if (!$update) {
            return response()->json(['error' => 'unknown error'], 500);
        }

         return response()->json([
            'message' => 'Edit Email update!',
            'code' => 200
        ]);
    }
    public function passwordupdate(Request $request, $id_customer)
    {
      
        $this->validate($request, [
            'username' => 'required|min:5',
            'password' => 'required|min:8'
        ]);

      if ($request->has('email_customer')) {
            $update = Customer::query()->find($id_customer)->update(
                [
                'username' => $request->input('username'),
                'password' => Hash::make($request->input('password')),
                ]
            );
        } else {
            $update = Customer::query()->find($id_customer)->update(
                [
                'username' => $request->input('username'),
                'password' => Hash::make($request->input('password'))
                ]
            );
        }

        
        if (!$update) {
            return response()->json(['error' => 'unknown error'], 500);
        }

         return response()->json([
            'message' => 'Edit Password update!',
            'code' => 200
        ]);
    }
    public function teleponupdate(Request $request, $id_customer)
    {
      
        $this->validate($request, [
            'nomor_telepon' => 'required'
        ]);

      if ($request->has('email_customer')) {
            $update = Customer::query()->find($id_customer)->update(
                [
                'nomor_telepon' => $request->input('nomor_telepon')
                ]
            );
        } else {
            $update = Customer::query()->find($id_customer)->update(
                [
                'nomor_telepon' => $request->input('nomor_telepon')
                ]
            );
        }

        
        if (!$update) {
            return response()->json(['error' => 'unknown error'], 500);
        }

         return response()->json([
            'message' => 'Edit Nomor telepon update!',
            'code' => 200
        ]);
    }
    public function index()
    {
        $customer = Customer::all();

        if (empty($customer)) {
            return response()->json(['error' => 'Data Akun Tidak Ditemukan'], 402);
        }
        return response()->json($customer);
    }
}
