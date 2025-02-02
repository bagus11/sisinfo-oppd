<?php

namespace App\Http\Controllers\Setting;

use App\Helper\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\Location\AddLocationRequest;
use App\Models\Setting\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class LocationController extends Controller
{
    function  index() {
        return view('setting.location.location-index');
    }
    function getLocation() {
        $data = Location::all();
        return response()->json([
            'data'=>$data,
        ]);
    }
    function addLocation(Request $request, AddLocationRequest $addLocationRequest) {
        try {
            $addLocationRequest->validated();

            $post =[
                'name'  =>$request->name,
                'type'  =>$request->type,
                'x'  =>$request->x,
                'y'  =>$request->y,
                'status'  =>1,
                'address'  =>$request->address,
            ];
            $insert = Location::create($post);
            return ResponseFormatter::success(
            //    $post,
                'Menus successfully added'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Menus failed to update',
                500
            );
        }
    }
}
