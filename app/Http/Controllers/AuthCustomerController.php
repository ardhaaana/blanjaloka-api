<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Claims\Custom;

class AuthCustomerController extends Controller
{

    public function register(Request $request)
    {
        $this->validate($request, [
            'nama_customer' => 'required|min:5',
            // 'nomor_telepon' => 'required',
            'email_customer' => 'required|email|unique:customer',
            // 'alamat_customer' => 'required',
            // 'tanggal_lahir' => 'required',
            // 'username' => 'required|unique:customer|min:5',
            'password' => 'required|min:8',
            // 'jenis_kelamin' => 'required',
           
        ]);

        try {
            $customer = new Customer;
            $customer->nama_customer = $request->input('nama_customer');
            // $customer->nomor_telepon = $request->input('nomor_telepon');
            // $customer->email_customer = $request->input('email_customer');
            // $customer->alamat_customer = $request->input('alamat_customer');
            // $customer->tanggal_lahir = $request->input('tanggal_lahir');
            // $customer->username = $request->input('username');
            $customer->email_customer = $request->input('email_customer');
            // $customer->jenis_kelamin = $request->input('jenis_kelamin');
            $customer->id_role = 1;
            $plainPassword = $request->input('password');
            $customer->password = app('hash')->make($plainPassword);


            $customer->save();
            //return successful response
            return response()->json(['code' => 200,'Success' => true,'message' => 'Registrasi Sukses',
            'Data' => $customer]);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function loginemail(Request $request)
    {
        $this->validate($request, [
            'email_customer' => 'required|email',
            'password' => 'required|min:8'
        ]);
        
        $login = $request->only(['email_customer','password']);
        
        if (! $token = Auth::attempt($login)) {
            return response()->json(['code' => 401,'Success' => false,'message' => 'Login Gagal']);
        }
        
        $email_customer = $request->input('email_customer');

        $customer = DB::table('customer')->select('customer.email_customer', 'customer.id_customer')
                                        ->where('customer.email_customer', $email_customer)->get();
        return response()->json([
              'code' => 200,
              'Success' => true,
              'message' => 'Login sukses',
              'data' => [$customer],
                  'token' => $token,
                  'token_type' => 'bearer'
          ]);
    }

    public function loginnomor(Request $request)
    {
        $this->validate($request, [
            'nomor_telepon' => 'required',
            'password' => 'required|min:8'
        ]);

        $login = $request->only(['nomor_telepon', 'password']);

        if (! $token = Auth::attempt($login)) {
            return response()->json(['code' => 401,'success' => false,'message' => 'Login Gagal']);
        }

        $customer = $request->all('nomor_telepon');

        return response()->json([
              'code' => 200,
              'Success' => true,
              'message' => 'Login sukses',
              'data' => $customer,
                  'token' => $token,
                  'token_type' => 'bearer'
          ]);
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
                    // 'alamat_customer' => $request->input('alamat_customer'),
                    // 'tanggal_lahir' => $request->input('tanggal_lahir'),
                    // 'jenis_kelamin' => $request->input('jenis_kelamin')
                ]
            );
        } else {
            $update = Customer::query()->find($id_customer)->update(
                [
                    'nama_customer' => $request->input('nama_customer'),
                    // 'alamat_customer' => $request->input('alamat_customer'),
                    // 'tanggal_lahir' => $request->input('tanggal_lahir'),
                    // 'jenis_kelamin' => $request->input('jenis_kelamin')
                ]
            );
        }

        if (!$update) {
            return response()->json(['code' => 500,'Success' => false,'error' => 'unknown error']);
        }

        return response()->json([
            'code' => 200,
            'Success' => true,
            'message' => 'Edit Profile update!'
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
                    'alamat_customer' => $request->input('alamat_customer')
                ]
            );
        }


        if (!$update) {
            return response()->json(['code' => 500,'success' => false,'error' => 'unknown error']);
        }

        return response()->json([
            'code' => 200,
            'Success' => true,
            'message' => 'Edit Email update!'
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
            return response()->json([ 'code' => 500,'success' => false,'error' => 'unknown error']);
        }

        return response()->json([
            'code' => 200,
            'Success' => true,
            'message' => 'Edit Password update!'
            
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
            return response()->json(['code' => 500,'success' => false,'error' => 'unknown error']);
        }

        return response()->json([
            'code' => 200,
            'Success' => true,
            'message' => 'Edit Nomor telepon update!'
        ]);
    }
    public function index()
    {
        $customer = Customer::all();

        if (empty($customer)) {
            return response()->json(['code' => 402,'error' => 'Data Akun Tidak Ditemukan']);
        }
        return response()->json(['code' => 200,'Success' => true, 'Message' => 'Berhasil Menampilkan Data Customer', 'Data Customer' => $customer]);
    }

    public function destroy($id_customer)
    {
        $customer = Customer::find($id_customer);

        if (!$customer) {
            return response()->json([
                'code' => 404,
                'Success' => false,
                'message' => 'Data tidak ditemukan',
                'data' => $customer
            ]);
        }

        $customer->delete();

        return response()->json([
            'code' => 200,
            'Success' => true,
            'message' => 'Data berhasil dihapus',
            'data' => $customer
        ]);
    }

    // public function logout(Request $request)
    // {
    //     $login = $request->login();
    //     $login->token()->delete();

    //     return response()->json([
    //         'message' => 'Logout sukses'
    //     ], 200);
    // }

}
