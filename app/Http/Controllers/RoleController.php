<?php 

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class RoleController extends Controller
{
    
    public function create(Request $request)
    {
        $this->validate($request, [
            'status_user' => 'required|unique:role'
        ]);

        $role = [
            'status_user' => $request->input('status_user')
        ];

        $role = Role::create($role);

        if ($role){
            $result = [
                'message' => 'Data berhasil ditambahkan',
                'data' => $role
            ];
        } else {
            $result = [
                'message' => 'Data tidak berhasil ditambahkan',
                'data' => ''
            ];
        }

        return response()->json($result);     

    }

    public function index()
    { 
        $role = Role::all();
        return response()->json($role);
    }

    public function show($id_role)
    {
        $role = Role::find($id_role);
        return response()->json($role);
    }

    public function update(Request $request, $id_role)
    {
        $role = Role::find($id_role);

       if (!$role){
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'data' => $role
            ], 404);
        }
        
        $this->validate($request, [
            'status_user' => 'required'
        ]);

        $datarole = $request->all();
        $role->fill($datarole);
        $role->save();
        
        return response()->json($datarole);
    }

    public function destroy($id_role)
    {
        $role = Role::find($id_role);

        if (!$role){
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'data' => $role
            ], 404);
        }
        
        $role->delete();

        return response()->json([
                'message' => 'Data berhasil dihapus',
                'data' => $role
            ], 200);
    }

}
