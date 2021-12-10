<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\EmailVerification;


class AuthCustomerController extends Controller
{

    public function register(Request $request)
    {
        $validate = [
            'nama_customer' => 'required|min:5',
            'nomor_telepon' => 'required|min:11',
            'email_customer' => 'required|email|unique:customer',
            'password' => 'required|min:8'
        ];

        $pesan = [
            'nama_customer.required' => 'Nama Tidak Boleh Kosong',
            'nomor_telepon.required' => 'Nomor Telepon Tidak Boleh Kosong',
            'email_customer.required' => 'Email Tidak Boleh Kosong',
            'password.required' => 'Password Tidak Boleh Kosong'
        ];

        $validator = Validator::make($request->all(), $validate, $pesan);
        
        if($validator->fails())
        {
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => $validator->errors()->first(),
                'data' => null,
            ]);
        }

        try {
            $customer = new Customer;
            
            $customer->nama_customer = $request->input('nama_customer');
            $customer->nomor_telepon = $request->input('nomor_telepon');
            $customer->email_customer = $request->input('email_customer');

            $customer->id_role = 1;
            $plainPassword = $request->input('password');
            $customer->password = app('hash')->make($plainPassword);

            # Buat Token Aktifasi Email
            // $token = Str::random(180);
            $token = mt_rand(100000,999999);
            $request->session()->put(['token' => $token]);

            # Kirim Link Aktifasi Akun, Lewat Email
            Mail::to($request->post('email_customer'))->send(new EmailVerification(['email_customer'=>$request->post('email_customer'), 'nama_customer'=>$request->post('nama_customer'), 'nomor_telepon'=>$request->post('nomor_telepon'), 'token'=>$token]));

            $customer->save();
            //return successful response
            return response()->json(['code' =>  200,'success' => true,'message' => 'Registrasi Sukses',
            'customer' => $customer,
            ]);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['code' => 404 ,'success' => false,'message' => 'User Registration Failed!']);
        }
    }

    public function loginemail(Request $request)
    {
        $validate = [
            'email_customer' => 'required',
            'password' => 'required'
        ];

        $pesan = [
            'email_customer.required' => 'Email Tidak Boleh Kosong',
            'password.required' => 'Password Tidak Boleh Kosong'
        ];

        $validator = Validator::make($request->all(), $validate, $pesan);
        
        if($validator->fails())
        {
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => $validator->errors()->first(),
                'data' => null,
            ]);
        }
        
        $customer = $request->only(['email_customer', 'password']);

        if(count(Customer::where('email_customer', $request->input('email_customer'))->get()) == false){

            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => 'Email tidak ditemukan',
                'data' => null
            ]);

        }
        
        $request->session()->flush();
        
        $customer_data = Customer::select('id_customer', 'email_customer', 'nama_customer')->where('email_customer', $request->input('email_customer'))->get();
        
        foreach ($customer_data as $c){
            $request->session()->put('id_customer', $c->id_customer);
            $request->session()->put('email_customer', $c->email_customer);
            
            $email_customer = $c->email_customer;
            $nama_customer = $c->nama_customer;
        }
        
        if (! $token = Auth::attempt($customer)) {
            return response()->json(['code' => 404,'success' => false, 'message' => 'Login Gagal']);
        } 
        
        return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'Login Sukses',
            'data' => array(
                'email_customer'=>$email_customer,
                'nama_customer'=>$nama_customer,
                'id_customer' => $request->session()->get('id_customer')
            ),
            'token' => $token,
            'token_type' => 'bearer',
        ]);

    }

    public function loginnomor(Request $request)
    {
        $validate = [
            'nomor_telepon' => 'required',
            'password' => 'required'
        ];

        $pesan = [
            'nomor_telepon.required' => 'Nomor Telepon Tidak Boleh Kosong',
            'password.required' => 'Password Tidak Boleh Kosong'
        ];

        $validator = Validator::make($request->all(), $validate, $pesan);
        
        if($validator->fails())
        {
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => $validator->errors()->first(),
                'data' => null,
            ]);
        }
        
        $customer = $request->only(['nomor_telepon', 'password']);
        
        if(count(Customer::where('nomor_telepon', $request->input('nomor_telepon'))->get()) == false){

            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => 'Nomor Telepon tidak ditemukan',
                'data' => null
            ]);

        }
        
        $request->session()->flush();
        
        $customer_data = Customer::select('id_customer', 'nomor_telepon', 'nama_customer')->where('nomor_telepon', $request->input('nomor_telepon'))->get();
        
        foreach ($customer_data as $c){
            $request->session()->put('id_customer', $c->id_customer);
            $request->session()->put('nomor_telepon', $c->nomor_telepon);
            
            $nomor_telepon = $c->nomor_telepon;
            $nama_customer = $c->nama_customer;
        }
        
        if (! $token = Auth::attempt($customer)) {
            return response()->json(['code' => 404,'success' => false, 'message' => 'Login Gagal']);
        }

        return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'Login Sukses',
            'data' => array(
                'nomor_customer'=>$nomor_telepon,
                'nama_customer'=>$nama_customer,
                'id_customer' => $request->session()->get('id_customer')
            ),
            'token' => $token,
            'token_type' => 'bearer',
        ]);

    }

    public function update(Request $request, $id_customer)
    {

         $validate = [
            'nama_customer' => 'required|min:5',
        ];

        $pesan = [
            'nama_customer.required' => 'Nama Tidak Boleh Kosong',
        ];

        $validator = Validator::make($request->all(), $validate, $pesan);
        
        if($validator->fails())
        {
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => $validator->errors()->first(),
                'data' => null,
            ]);
        }

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
            return response()->json(['code' => 500, 'success' => false,'error' => 'unknown error']);
        }

        return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'Edit Profile update!',
        ]);
    }
    public function emailupdate(Request $request, $id_customer)
    {

        $validate = [
            'email_customer' => 'required|email|unique:customer',
        ];

        $pesan = [
            'email_customer.required' => 'Email Tidak Boleh Kosong',
        ];

        $validator = Validator::make($request->all(), $validate, $pesan);
        
        if($validator->fails())
        {
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => $validator->errors()->first(),
                'data' => null,
            ]);
        }

        if ($request->has('email_customer')) {
            $update = Customer::query()->find($id_customer)->update(
                [
                    'email_customer' => $request->input('email_customer'),
                ]
            );
        }

        if (!$update) {
            return response()->json(['code' => 500, 'success' => false,'error' => 'unknown error']);
        }

        return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'Edit Email update!',
        ]);
    }
    public function passwordupdate(Request $request, $id_customer)
    {

       $validate = [
            'password' => 'required|min:8'
        ];

        $pesan = [
            'password.required' => 'Password Tidak Boleh Kosong'
        ];

        $validator = Validator::make($request->all(), $validate, $pesan);
        
        if($validator->fails())
        {
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => $validator->errors()->first(),
                'data' => null,
            ]);
        }

        if ($request->has('email_customer')) {
            $update = Customer::query()->find($id_customer)->update(
                [
                    'password' => Hash::make($request->input('password')),
                ]
            );
        } else {
            $update = Customer::query()->find($id_customer)->update(
                [
                    'password' => Hash::make($request->input('password'))
                ]
            );
        }


        if (!$update) {
            return response()->json(['code' => 500,'success' => false,'error' => 'unknown error']);
        }

        return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'Edit Password update!',
        ]);
    }
    public function teleponupdate(Request $request, $id_customer)
    {

        $validate = [
            'nomor_telepon' => 'required|min:11',
        ];

        $pesan = [
            'nomor_telepon.required' => 'Nomor Telepon Tidak Boleh Kosong'
        ];

        $validator = Validator::make($request->all(), $validate, $pesan);
        
        if($validator->fails())
        {
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => $validator->errors()->first(),
                'data' => null,
            ]);
        }

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
            return response()->json(['code' => 500 , 'success' => false,'error' => 'unknown error']);
        }

        return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'Edit Nomor telepon update!',
        ]);
    }
    public function index()
    {
        $customer = Customer::all();

        if (empty($customer)) {
            return response()->json(['code' => 404,'success' => false,'error' => 'Data Akun Tidak Ditemukan']);
        }
        return response()->json(['code' => 200,'success' => true,'message' => 'Menampilkan Data Customer Berhasil','data' => $customer]);
    }
    public function destroy($id_customer)
    {
        $customer = Customer::find($id_customer);

        if (!$customer) {
            return response()->json([
                'code' => 404,
                'message' => 'Data tidak ditemukan',
                'data' => $customer
            ]);
        }

        $customer->delete();

        return response()->json([
            'code' => 200,
            'message' => 'Data berhasil dihapus',
            'data' => $customer
        ]);
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'Logout sukses'
        ]);
    }

}
