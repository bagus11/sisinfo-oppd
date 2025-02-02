<?php

namespace App\Http\Controllers\Setting;

use App\Helper\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\Menus\AddMenusRequest;
use App\Http\Requests\Setting\Menus\AddSubmenusRequest;
use App\Http\Requests\Setting\Menus\UpdateMenusRequest;
use App\Http\Requests\Setting\Menus\UpdateSubMenusRequest;
use App\Models\Setting\Menu;
use App\Models\Setting\Submenu;
use Illuminate\Http\Request;

class MenusController extends Controller
{
    function index(){
        return view('setting.menus.menus-index');
    }
    function getMenus() {
        $data = Menu::all();
        return response()->json([
            'data'=>$data,
        ]);
    }
    function getActiveParent() {
        $data = Menu::where('type', 2)->where('status',1)->get();
        return response()->json([
            'data'=>$data,
        ]);
    }
    function getSubMenus() {
        $data = Submenu::with([
            'menusRelation'
        ])->get();
        return response()->json([
            'data'=>$data,
        ]);
    }
    function addMenus(Request $request, AddMenusRequest $addMenusRequest) {
        try {
            $addMenusRequest->validated();
            $post =[
                'name'          => $request->menus_name,
                'link'          => $request->menus_link,
                'type'          => $request->menus_type,
                'icon'          => $request->menus_icon,
                'permission'    => 'view-'.$request->menus_link,
                'description'   => $request->menus_description,
                'order'         => 0,
                'status'        => 1
            ];
            Menu::create($post);
            return ResponseFormatter::success(
               $post,
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
    function updateStatusMenu(Request $request){
        try {
            $head = Menu::find($request->id);
            $post =[
                'status'        => $head->status == 1 ? 0 : 1
            ];
            $head->update($post);
            return ResponseFormatter::success(
               $post,
                'Menus successfully updated'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Menus failed to update',
                500
            );
        }
    }
    function updateMenus(Request $request, UpdateMenusRequest $updateMenusRequest){
        try {
            $updateMenusRequest->validated();
            $post =[
                'name'          => $request->menus_name_edit,
                'link'          => $request->menus_link_edit,
                'type'          => $request->menus_type_edit,
                'icon'          => $request->menus_icon_edit,
                'description'   => $request->menus_description_edit,
            ];
            Menu::find($request->id)->update($post);
            return ResponseFormatter::success(
               $post,
                'Menus successfully updated'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Menus failed to update',
                500
            );
        }
    }
    function addSubMenus(Request $request, AddSubmenusRequest $addMenusRequest){
        try {
            $addMenusRequest->validated();
            $post =[
                'name'          => $request->submenus_name,
                'link'          =>  $request->submenus_link ,
                'menus_id'      => $request->parent,
                // 'logo'          => $request->submenus_icon,
                'logo'          => '',
                'permission'    => 'view-'.$request->submenus_link,
                'description'   => $request->submenus_description,
                'status'        => 1
            ];
            Submenu::create($post);
            return ResponseFormatter::success(
                $post,
                'Submenus successfully added'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Submenus failed to update',
                500
            );
        }
    }
    function updateStatusSubMenu(Request $request){
        try {
            $head = Submenu::find($request->id);
            $post =[
                'status'        => $head->status == 1 ? 0 : 1
            ];
            $head->update($post);
            return ResponseFormatter::success(
                $post,
                'Submenus successfully updated'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Submenus failed to update',
                500
            );
        }
    }
    function updateSubMenus(Request $request, UpdateSubMenusRequest $updateSubMenusRequest){
        try {
            $updateSubMenusRequest->validated();
            $post =[
                'name'          => $request->submenus_name_edit,
                'link'          => $request->submenus_link_edit,
                'menus_id'          => $request->parent_edit,
                'logo'          => $request->submenus_icon_edit,
                'description'   => $request->submenus_description_edit,
            ];
            Submenu::find($request->id)->update($post);
            return ResponseFormatter::success(
               $post,
                'Menus successfully updated'
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
