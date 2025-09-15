<?php

namespace App\Http\Controllers\Setting\Asset;

use App\Helper\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Setting\Inventory_type;
use Database\Seeders\InventoryType;
use Illuminate\Http\Request;

class InventoryTypeController extends Controller
{
      function index() {
         return view('setting.asset.type.type_asset-index');
    }
    function getInventoryType() {
        $data = Inventory_type::all();
        return response()->json([
                'data' => $data
            ]);
    }
      function addAssetType(Request $request) {
           // try {
            $request->validate([
                'name' => 'required'
            ]);
            $post = Inventory_type::create(
                [
                    'name'  => $request->name,
                ]
            );
            return ResponseFormatter::success(
                $post,
                 'Type Asset successfully added'
             );          
            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Menus failed to update',
        //         500
        //     );
        // }
      
    }
    function updateAssetType(Request $request) {
           // try {
            $request->validate([
                'edit_name' => 'required'
            ]);
            $post = Inventory_type::find($request->id)->update(
                [
                    'name'  => $request->edit_name,
                ]
            );
            return ResponseFormatter::success(
                $post,
                 'Asset Type successfully updated'
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
