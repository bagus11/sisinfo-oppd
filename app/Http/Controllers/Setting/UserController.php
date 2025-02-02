<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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
}
