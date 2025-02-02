<?php

namespace App\Http\Controllers\Setting;

use App\Helper\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    function changeDarkTheme(Request $request) {
        try {
           $theme = auth()->user()->theme == 1 ? 0 : 1;
            $update = User::where('id',auth()->user()->id)->update([
                'theme' => $theme 
            ]);
            return ResponseFormatter::success(
               $update,
                'Successfully update theme'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Theme failed to update',
                500
            );
        }
    }
}
