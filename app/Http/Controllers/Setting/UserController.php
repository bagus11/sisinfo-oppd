<?php

namespace App\Http\Controllers\Setting;

use App\Helper\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\User\StoreUserRequest;
use App\Models\Setting\Location;
use App\Models\Setting\MasterSatgas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use function Intervention\Image\Drivers\Imagick\has;

class UserController extends Controller
{
    function index() {
        return view('setting.user.user-index');
    }
    function getUser() {
        $data = User::with([
            'positionRelation',
            'locationRelation',
        ])->get();
        return response()->json([
            'data'=>$data,
            
        ]);  
    }
    function addUser(Request $request, StoreUserRequest $storeUserRequest) {
        // try {
            $storeUserRequest->validated();
            $location = MasterSatgas::where('name', $request->location)->first();
            // dd($location);
            $post =[
                'name'  => $request->name,
                'email'  => $request->email,
                'nrp'  => $request->nrp,
                'satgas'  => $location->id,
                'location'  => $location->id,
                'password'=> Hash::make('oppd-'.$request->nrp),
                'position'  => $request->position,
            ];
            $user = User::create($post);
            $role = Role::find(4); // Cari role dengan ID 4
            if ($role) {
                $user->assignRole($role->name); // Assign role ke user
            }
        
            return ResponseFormatter::success(
            //    $post,
                'User successfully  created'
            );            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'User failed to create',
        //         500
        //     );
        // }
    }

    function detailUser(Request $request) {
        $detail = User::with([
            'positionRelation',
            'locationRelation',
        ])->find($request->id);
        return response()->json([
            'detail'=>$detail,
            
        ]);  
    }
}
