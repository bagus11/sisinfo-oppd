<?php

namespace App\Http\Controllers\Setting;

use App\Helper\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\UserAccess\AddRoleUserRequest;
use App\Http\Requests\Setting\UserAccess\UpdateRoleUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserAccessController extends Controller
{
    function index() {
        return view('setting.user_access.user_access-index');
    }
    function getRoleUser() {
        $roleUser   =   DB::table('model_has_roles')->select('roles.name as rolesName','users.id as user_id', 'users.name as userName','users.employee_id','roles.id as role_id')
                            ->join('users', 'users.id','=', 'model_has_roles.model_id')
                            ->join('roles','roles.id','=', 'model_has_roles.role_id')
                            ->get();
        $role       =   Role::all();
                    
        return response()->json([
            'roleUser'=>$roleUser,
            'role'=>$role,
            
        ]);  
    }
    function addRoleUser(Request $request,AddRoleUserRequest $addRoleUserRequest) {
        // try {
            $addRoleUserRequest->validated();
            $user = User::find($request->user);
            $role = Role::find($request->role);
            $user->assignRole($role->name);
            return ResponseFormatter::success(   
                $role->name,                              
                'Role User successfully added'
            );            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Role User failed to add',
        //         500
        //     );
        // }
    }
    function updateRoleUser(Request $request, UpdateRoleUserRequest $updateRoleUserRequest){
        try {
            $updateRoleUserRequest->validated();
            $user = User::find($request->user_edit);
            $role = Role::find($request->role_edit);
            $delete = DB::table('model_has_roles')->where('model_id', $request->user_edit)->delete();
            if($delete){
                $user->assignRole($role->name);
            }
            return ResponseFormatter::success(   
                $role->name,                              
                'Roles successfully updated'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Roles failed to add',
                500
            );
        }
    }
    function getUser() {
        $data = User::where('active', 1)->get();
        return response()->json([
            'data'  => $data
        ]);  
    }
    function getRolePermissionDetail(Request $request) {
          $inactive   = Permission::select(DB::raw('id,name,"0" as is_active'))
                                ->whereNotIn('id',DB::table('role_has_permissions')
                                ->select('permission_id')
                                ->where('role_id',$request->id))
                                ->get();
        $active     =DB::table('permissions')
                        ->select('*')
                        ->join('role_has_permissions', 'role_has_permissions.permission_id','=','permissions.id')
                        ->where('role_id',$request->id)
                        ->get();
        return response()->json([
            'inactive'=>$inactive,
            'active'=>$active,
        ]);
    }
    function saveRolePermission(Request $request) {
        try {    
            $role = Role::find($request->roleIdPermissionAdd);
            $role->givePermissionTo($request->checkArray);

            return ResponseFormatter::success(   
                $role->name,                              
                'Roles permission successfully updated'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Roles permission failed to add',
                500
            );
        }
    }
    function destroyRolePermission(Request $request){
        $status =500;
        $message ="Role permission failed to update";

        foreach($request->checkArray as $row){
            $delete = DB::table('role_has_permissions')
                            ->where('permission_id',$row)
                            ->where('role_id',$request->roleIdPermissionDelete)
                            ->delete();
            if($delete){
                $status =200;
                $message ="Role permission successfully updated";
            }
        }
        return response()->json([
            'status'=>$status,
            'message'=>$message,
        ]);
       
    }
}
