<?php

namespace App\Http\Controllers\Setting\Asset;

use App\Helper\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Setting\InventoryCategory;
use Illuminate\Http\Request;

class CategoryAssetController extends Controller
{
    function index() {
        return view('setting.asset.category.category_asset-index');
    }
    function getCategoryAsset() {
        $data = InventoryCategory::all();
        return response()->json([
                'data' => $data
            ]);
    }
    function addCategoryAsset(Request $request) {
           // try {
            $request->validate([
                'name' => 'required'
            ]);
            $post = InventoryCategory::create(
                [
                    'name'  => $request->name,
                    'cateogry_code'=>'',
                    'status' => 1
                ]
            );
            return ResponseFormatter::success(
                $post,
                 'Menus successfully added'
             );          
            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Menus failed to update',
        //         500
        //     );
        // }
      
    }
    function updateCategory(Request $request) {
           // try {
          
            $post = InventoryCategory::find($request->id)->update(
                [
                    'name'  => $request->edit_name,
                ]
            );
            return ResponseFormatter::success(
                $post,
                 'Category successfully updated'
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
