<?php 

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Customer;
use App\Models\PengelolaPasar;
use App\Models\Pedagang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class RoleController extends Controller
{
    
    public function create(Request $request)
    {
       
        $validate = [
            'status_user' => 'required|unique:role'
        ];

        $pesan = [
            'status_user.required' => 'Status User Tidak Boleh Kosong'
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

        $role = [
            'status_user' => $request->input('status_user')
        ];

        $role = Role::create($role);

        if ($role){
            $result = [
                'code' => 200,
                'success' => true, 
                'message' => 'Data berhasil ditambahkan',
                'data' => $role
            ];
        } else {
            $result = [
                'code' => 404,
                'success' => false, 
                'message' => 'Data tidak berhasil ditambahkan',
                'data' => ''
            ];
        }

        return response()->json($result);     

    }

    public function index()
    {
        $role = Role::all();
        
          if (!$role){
            return response()->json([
                'code' => 404,
                'success' => false, 
                'message' => 'Data tidak ditemukan',
                'data' => $role
            ]);
        }

        return response()->json([
            'code' => 200,
            'success' => true, 
            'Message' => 'Data ditemukan',
            'Role' => $role
        ]);

    }
    public function show($id_role)
    {
        $role = Role::find($id_role);
        
          if (!$role){
            return response()->json([
                'code' => 404,
                'success' => false, 
                'message' => 'Data tidak ditemukan',
                'data' => $role
            ]);
        }

        return response()->json([
            'code' => 200,
            'success' => true, 
            'Message' => 'Data ditemukan',
            'Role' => $role
        ]);

    }

    public function update(Request $request, $id_role)
    {
        $role = Role::find($id_role);

       if (!$role){
            return response()->json([
                'code' => 404,
                'success' => false, 
                'message' => 'Data tidak ditemukan',
                'data' => $role
            ]);
        }
        
       $validate = [
            'status_user' => 'required|unique:role'
        ];

        $pesan = [
            'status_user.required' => 'Status User Tidak Boleh Kosong'
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

        $datarole = $request->all();
        $role->fill($datarole);
        $role->save();
        
        return response()->json(['code' => 200,'success' => true, 'message' => 'Menampilkan Role', 'Data' => $datarole]);
    }

    public function destroy($id_role)
    {
        $role = Role::find($id_role);

        if (!$role){
            return response()->json([
                'code' => 404,
                'success' => false, 
                'message' => 'Data tidak ditemukan',
                'data' => $role
            ]);
        }
        
        $role->delete();

        return response()->json([
                'code' => 200,
                'success' => true, 
                'message' => 'Data berhasil dihapus',
                'data' => $role
            ]);
    }

}
