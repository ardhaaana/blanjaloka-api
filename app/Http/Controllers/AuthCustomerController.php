<<<<<<< HEAD
<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;

class AuthCustomerController extends Controller
{

    public function register(Request $request)
    {
        $this->validate($request, [
            'nama_customer' => 'required|min:5',
            'nomor_telepon' => 'required',
            'email_customer' => 'required|email',
            'alamat_customer' => 'required',
            'tanggal_lahir' => 'required',
            'username' => 'required|unique:customer|min:5',
            'password' => 'required|min:8',
            'jenis_kelamin' => 'required'
        ]);

        try {
            $customer = new Customer;
            $customer->nama_customer = $request->input('nama_customer');
            $customer->nomor_telepon = $request->input('nomor_telepon');
            $customer->email_customer = $request->input('email_customer');
            $customer->alamat_customer = $request->input('alamat_customer');
            $customer->tanggal_lahir = $request->input('tanggal_lahir');
            $customer->username = $request->input('username');
            $customer->email_customer = $request->input('email_customer');
            $customer->jenis_kelamin = $request->input('jenis_kelamin');
            $plainPassword = $request->input('password');
            $customer->password = app('hash')->make($plainPassword);

            $customer->save();
            //return successful response
            return response()->json(['message' => 'Registrasi Sukses',
            'customer' => $customer,
            ], 200);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'User Registration Failed!'], 409);
        }
    }

    public function loginemail(Request $request)
    {
        $this->validate($request, [
            'email_customer' => 'required|email',
            'password' => 'required|min:8'
        ]);
        

        $customer = $request->only(['email_customer', 'password']);
        
        if (! $token = Auth::attempt($customer)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function loginnomor(Request $request)
    {
        $this->validate($request, [
            'nomor_telepon' => 'required',
            'password' => 'required|min:8'
        ]);

        $credentials = $request->only(['nomor_telepon', 'password']);

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
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
                    'alamat_customer' => $request->input('alamat_customer'),
                    'tanggal_lahir' => $request->input('tanggal_lahir'),
                    'jenis_kelamin' => $request->input('jenis_kelamin')
                ]
            );
        } else {
            $update = Customer::query()->find($id_customer)->update(
                [
                    'nama_customer' => $request->input('nama_customer'),
                    'alamat_customer' => $request->input('alamat_customer'),
                    'tanggal_lahir' => $request->input('tanggal_lahir'),
                    'jenis_kelamin' => $request->input('jenis_kelamin')
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
                    'alamat_customer' => $request->input('alamat_customer')
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
    public function destroy($id_customer)
    {
        $customer = Customer::find($id_customer);

        if (!$customer) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'data' => $customer
            ], 404);
        }

        $customer->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus',
            'data' => $customer
        ], 200);
    }

    public function logout(Request $request)
    {
        $login = $request->login();
        $login->token()->delete();

        return response()->json([
            'message' => 'Logout sukses'
        ], 200);
    }

}
=======
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
            'email_customer' => 'required|email|unique:customer',
            'username' => 'required|min:5',
            'password' => 'required|min:8',
            'jenis_kelamin' => 'required'

        ]);

        $nama_customer = $request->input('nama_customer');
        $nomor_telepon = $request->input('nomor_telepon');
        $alamat_customer = $request->input('alamat_customer');
        $tanggal_lahir = $request->input('tanggal_lahir');
        $email_customer = $request->input('email_customer');
        $username = $request->input('username');
        $password = Hash::make($request->input('password'));
        $jenis_kelamin = $request->input('jenis_kelamin');

        $register = Customer::create([
            'nama_customer' => $nama_customer,
            'nomor_telepon' => $nomor_telepon,
            'alamat_customer' => $alamat_customer,
            'tanggal_lahir' => $tanggal_lahir,
            'email_customer' => $email_customer,
            'username' => $username,
            'password' => $password,
            'jenis_kelamin' => $jenis_kelamin
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
    public function loginemail(Request $request)
    {
        $this->validate($request, [
            'email_customer' => 'required|email',
            'password' => 'required|min:8'
        ]);

        $email_customer = $request->input('email_customer');
        $password = $request->input('password');

        $login = Customer::where('email_customer', $email_customer)->first();

        if (Hash::check($password, $login->password)) {
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
        } else {
            return response()->json([
                'message' => 'Login gagal',
                'data' => ''
            ]);
        }
    }
    public function loginnomor(Request $request)
    {
        $this->validate($request, [
            'nomor_telepon' => 'required',
            'password' => 'required|min:8'
        ]);

        $nomor_telepon = $request->input('nomor_telepon');
        $password = $request->input('password');

        $login = Customer::where('nomor_telepon', $nomor_telepon)->first();

        if (Hash::check($password, $login->password)) {
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
        } else {
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
                    'alamat_customer' => $request->input('alamat_customer'),
                    'tanggal_lahir' => $request->input('tanggal_lahir'),
                    'jenis_kelamin' => $request->input('jenis_kelamin')
                ]
            );
        } else {
            $update = Customer::query()->find($id_customer)->update(
                [
                    'nama_customer' => $request->input('nama_customer'),
                    'alamat_customer' => $request->input('alamat_customer'),
                    'tanggal_lahir' => $request->input('tanggal_lahir'),
                    'jenis_kelamin' => $request->input('jenis_kelamin')
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
                    'alamat_customer' => $request->input('alamat_customer')
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
    public function destroy($id_customer)
    {
        $customer = Customer::find($id_customer);

        if (!$customer) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'data' => $customer
            ], 404);
        }

        $customer->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus',
            'data' => $customer
        ], 200);
    }
}
>>>>>>> 5c62385410c10963254565518959848154714eda
