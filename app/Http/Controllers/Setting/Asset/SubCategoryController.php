<?php

namespace App\Http\Controllers\Setting\Asset;

use App\Helper\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Setting\InventoryCategory;
use App\Models\Setting\InventorySubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    function index() {
         return view('setting.asset.sub_category.sub_category_asset-index');
    }
    function getSubCategory() {
        $data = InventorySubCategory::all();
        return response()->json([
                'data' => $data
            ]);
    }
      function addSubCategoryAsset(Request $request) {
           // try {
            $request->validate([
                'name' => 'required'
            ]);
            $post = InventorySubCategory::create(
                [
                    'name'  => $request->name,
                    'status' => 1
                ]
            );
            return ResponseFormatter::success(
                $post,
                 'Sub Category successfully added'
             );          
            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Menus failed to update',
        //         500
        //     );
        // }
      
    }
    function updateSubCategory(Request $request) {
           // try {
            $request->validate([
                'edit_name' => 'required'
            ]);
            $post = InventorySubCategory::find($request->id)->update(
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
