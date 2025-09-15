<?php

namespace App\Http\Controllers\Setting\Asset;

use App\Helper\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Setting\InventoryBrand;
use Illuminate\Http\Request;

class InventoryBrandController extends Controller
{
    function index() {
         return view('setting.asset.brand.brand_asset-index');
    }
    function getAssetBrand() {
        $data = InventoryBrand::all();
        return response()->json([
                'data' => $data
            ]);
    }
      function addAssetBrand(Request $request) {
           // try {
            $request->validate([
                'name' => 'required'
            ]);
            $post = InventoryBrand::create(
                [
                    'name'  => $request->name,
                ]
            );
            return ResponseFormatter::success(
                $post,
                 'Brand Asset successfully added'
             );          
            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Menus failed to update',
        //         500
        //     );
        // }
      
    }
    function updateAssetBrand(Request $request) {
           // try {
            $request->validate([
                'edit_name' => 'required'
            ]);
            $post = InventoryBrand::find($request->id)->update(
                [
                    'name'  => $request->edit_name,
                ]
            );
            return ResponseFormatter::success(
                $post,
                 'Asset Brand successfully updated'
             );          
            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Menus failed to update',
        //         500
        //     );
        // }
      
    }
}
