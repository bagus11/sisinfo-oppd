<?php

namespace App\Http\Controllers\Setting;

use App\Helper\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\RolePermission\AddRoleRequest;
use App\Http\Requests\Setting\RolePermission\UpdateRoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class RolePermissionController extends Controller
{
    function index() {
        return view('setting.role_permission.role_permission-index');
    }
    function getPermission() {
        $data = Permission::all();
        return response()->json([
            'data'=>$data,
        ]);
    }
    function getRole() {
        $data = Role::all();
        return response()->json([
            'data'=>$data,
        ]);
    }
    function detailRole(Request $request) {
        $detail = Role::find($request->id);
        return response()->json([
            'detail'=>$detail,
        ]);
    }
    function addRole(Request $request, AddRoleRequest $addRolesRequest) {
        // try {
            $addRolesRequest->validated();
            $post=[
                'name'=>$request->name,
                'guard_name'=>'web',
            ];
            Role::create($post);
            return ResponseFormatter::success(
                $post,
                'Roles successfully added'
            );            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Roles failed to add',
        //         500
        //     );
        // }
    }
    function updateRole(Request $request, UpdateRoleRequest $addRolesRequest) {
        // try {
            $addRolesRequest->validated();
            $post=[
                'name'=>$request->name_edit,
            ];
            Role::find($request->id)->update($post);
            return ResponseFormatter::success(
                $post,
                'Roles successfully updated'
            );            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Roles failed to update',
        //         500
        //     );
        // }
    }
    function savePermission(Request $request) {
        $permission_name = $request->permission_name;
        $status=500;
        $message="Data failed to save";
        $validator = Validator::make($request->all(),[
            'permission_name'=>'required|unique:permissions,name',
        ],[
            'permission_name.required'=>'Permission tidak boleh kosong',
            'permission_name.unique'=>'Permission sudah ada',
        
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->errors(), 
                'status'=>422
            ]);
        }else{
            $post=[
                'name'=>$permission_name,
                'guard_name'=>'web',
            ];
         
            $insert = Permission::create($post);
            if($insert){
                $status=200;
                $message="Data successfully inserted";
            }
        }
        return response()->json([
            'status'=>$status,
            'message'=>$message
        ]);
    }
    public function permissionMenus(){
        $data = DB::table('view_menus')
                    ->select('*')
                    ->get();
        return response()->json([
            'menus_name'=>$data,
        ]);
    }
    public function deletePermission(Request $request)
    {
        $status =200;
        $message ='Data failed to delete';
        $delete = Permission::find($request->id);
        $delete->delete();
        if($delete){
            $message ="Data successfully deleted";
            $status =200;
        }
          return response()->json([
            'message'=>$message,
            'status'=>$status,
        ]);
    }
}
