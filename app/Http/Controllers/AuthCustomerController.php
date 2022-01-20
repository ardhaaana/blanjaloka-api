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
use DateTime;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;


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

            $customer->save();
            //return successful response
            return response()->json(['code' =>  200,'success' => true,'message' => 'Registrasi Sukses',
            'customer' => $customer,
            ]);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['code' => 404 ,'success' => false,'message' => $e->getMessage()]);
        }
    }

    public function loginemail(Request $request){

        # Validasi
        $validate = [ 'email_customer' => 'required', 'password' => 'required' ];
        $pesan = [ 'email_customer.required' => 'Email Tidak Boleh Kosong', 'password.required' => 'Password Tidak Boleh Kosong'];
        $validator = Validator::make($request->all(), $validate, $pesan);
        
        if($validator->fails()){
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 404);
        }
        
        # Query get 1 customer
        $customer = $request->only(['email_customer', 'password']);
        $customer_data = Customer::select('id_customer', 'email_customer', 'nama_customer')->where('email_customer', $request->input('email_customer'))->get();
        
        foreach ($customer_data as $c){
            $email_customer = $c->email_customer;
            $nama_customer = $c->nama_customer;
        }
        
        # Check data Customer, ada atau tidak di database
        if (! $token = Auth::attempt($customer)) {
            return response()->json(['code' => 404,'success' => false, 'message' => 'Login Gagal, Email atau Password Salah']);
        } 

        # Jika ada & login sukses, kirimkan kode OTP ke email
        $this->SendingKodeOTP($request);
        
        # UPDATE BARRER TOKEN 
        Customer::where('email_customer', $email_customer)->update(['token_barrer'=>$token]);

        # Return response sukses
        return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'Hai, '.$nama_customer.' Sebelum masuk ke akun anda silahkan masukkan kode OTP yang telah kami kirimkan ke email '.$email_customer
        ], 200);

    }

    public function reloadKodeOTP(Request $request){

        # Validasi
        $validator = Validator::make($request->all(), [
            'email_customer' => 'required|email'
        ]);

        if($validator->fails()){
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => $validator->errors()->first(),
            ],404);
        }

        # Cek email yang masuk (ada tidak didatabase)
        if(count(Customer::where('email_customer', $request->input('email_customer'))->get()) == 0){

            return response()->json([
                'code' => 402,
                'message' => "Email yang anda masukkan tidak terdaftar di Blanjaloka",
                'success' => false
            ],402);

        }else{

            # SENDING NEW KODE OTP
            $this->SendingKodeOTP($request);

            foreach(Customer::where('email_customer', $request->input('email_customer'))->get() as $c){
                $nama_customer = $c->nama_customer;
                $email_customer = $c->email_customer;
            }

            return response()->json([
                'code' => 200,
                'success' => true,
                'message' => 'Hai, '.$nama_customer.' kami telah mengirimkan kode OTP terbaru ke email '.$email_customer
            ], 200);

        }

    }

    public function SendingKodeOTP(Request $request){

        # Restart TOKEN dari database
        $data = [
            'otp' => mt_rand(100000,999999),
            'created_otp' => date("Y-m-d H:i:s")
        ];

        Customer::where('email_customer', $request->input('email_customer'))->update($data);

        # Kirim Link Aktifasi Akun, Lewat Email
        Mail::to($request->post('email_customer'))->send(new EmailVerification(['email_customer'=>$request->post('email_customer'), 'kode_otp'=>$data['otp']]));
       
    }

    public function VerifikasiOTP(Request $request){

        # Validasi
        $validator = Validator::make($request->all(),[
            'email_customer' => 'required|email',
            'kode_otp' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 404);
        }

        if(count(Customer::where('email_customer', $request->input('email_customer'))->get()) == null){
            return response()->json([
                'code' => 402,
                'success' => false,
                'message' => 'Email tidak terdaftar'
            ]);
        }

        # GET CUSTOMER DATA
        foreach(Customer::where('email_customer', $request->input('email_customer'))->get() as $cs){
            $otp = $cs->otp;
            $created_otp = $cs->created_otp;
            $email_customer = $cs->email_customer;
            $token = $cs->token_barrer;
        }

        $_created_otp = new DateTime($created_otp);
        $_date_now = new DateTime(date("Y-m-d H:i:s"));
        $interval = $_date_now->diff($_created_otp);

        # Cek OTP KADALUARASA HARUS LOGIN ULANG
        if($interval->i > 30){
            return response()->json([
                'code' => 402,
                'message' => "Sesi anda untuk melakukan verifikasi kode OTP berakhir, silahkan login ulang untuk mendapatkan kode OTP lagi",
                'success' => false
            ], 402);
        }

        if($otp == $request->input('kode_otp') && $email_customer = $request->input('email_customer')){

            foreach(Customer::where('email_customer', $request->input('email_customer'))->get() as $c){
                $nama_customer = $c->nama_customer;
                $email_customer = $c->email_customer;

                $request->session()->put('id_customer', $c->id_customer);
            }

            return response()->json([
                'code' => 200,
                'success' => true,
                'message' => 'Login Berhasil & Kode OTP berhasil terverifikasi',
                'data' => [
                    'email_customer'=>$email_customer,
                    'nama_customer'=>$nama_customer,
                    'id_customer' => $request->session()->get('id_customer')
                ],
                'token' => $token,
                'token_type' => 'baerer',
                'interval' => $interval->i
            ]);
        
        }elseif($email_customer != $request->input('email_customer')){

            return response()->json([
                'code' => 402,
                'success' => false,
                'message' => 'Kode OTP dan Email tidak sesuai'
            ]);

        }else{
            return response()->json([
                'code' => 402,
                'success' => false,
                'message' => 'Kode OTP salah'
            ]);
        }
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
        # DELETE BARRER 
        
        $data = [
            'token_barrer' => null,
            'otp' => null,
            'created_otp' => null
        ];


        return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'Logout sukses'
        ]);
    }

}
