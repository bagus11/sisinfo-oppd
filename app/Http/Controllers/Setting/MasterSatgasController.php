<?php

namespace App\Http\Controllers\Setting;

use App\Helper\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\Satgas\AddSatgasRequest;
use App\Models\Setting\MasterSatgas;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Intervention\Image\Colors\Rgb\Channels\Red;

class MasterSatgasController extends Controller
{
    function index() {
        return view('setting.master_satgas.master_satgas-index');
    }
    function getSatgasTable(Request $request) {
        $data = MasterSatgas::all();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $editBtn = '<button class="btn btn-sm btn-warning edit" data-id="' . $row->id . '">
                    <i class="fas fa-edit"></i>
                    </button>';
                    $printBtn = '<button class="btn btn-sm btn-success print" data-id="' . $row->id . '">
                    <i class="fas fa-file"></i>
                    </button>';
                    $return =
                    ' '
                    .$printBtn ;
                    return $return;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return response()->json([
            'data'=>$data,
        ]);
    }
    function addSatgas(Request $request, AddSatgasRequest $addSatgasRequest) {
            // try {
                $addSatgasRequest->validated();
                $post = [
                    'name'  => $request->nama,
                    'type'     => $request->tipe,
                    'x'     => $request->x,
                    'y'     => $request->y,
                    'country'     => $request->negara,
                ];
                    MasterSatgas::create($post);
                
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
    function getSatgasType(){
        $data = MasterSatgas::select('type')->distinct()->get();
        return response()->json([
            'data' => $data
        ]);
    }
    public function updatePass(Request $request)
    {
        $request->validate([
            'current_pass' => 'required',
            'new_pass_confirmation' => 'required',
            'new_pass' => 'required|min:6|confirmed',
        ], [
            'current_pass.required' => 'Password lama wajib diisi.',
            'new_pass.required' => 'Password baru wajib diisi.',
            'new_pass.min' => 'Password baru minimal 6 karakter.',
            'new_pass.confirmed' => 'Konfirmasi password tidak sesuai.',
        ]);
    
        $user = Auth::user();
        $isMatch = Hash::check($request->current_pass, $user->password);
        // dd($isMatch);
        if (!Hash::check($request->current_pass, $user->password)) {
            throw ValidationException::withMessages([
                'current_pass' => 'Password lama salah.',
            ]);
        }
        $user->update([
            'password' => Hash::make($request->new_pass),
        ]);
    
        return response()->json([
            'meta' => [
                'message' => 'Password berhasil diperbarui!',
                'status' => true,
            ]
        ]);
    }

    function changeImage(Request $request) {
        try {
            $fileName = '';
        if ($request->hasFile('profile_image')) {
            $user = User::where('id',auth()->user()->id)->first();
            $currentAvatar = $user->avatar;
        
            // Check if current avatar is not the default one
            if ($currentAvatar != 'avatar.png') {
                // Delete the existing avatar image
                Storage::disk('public')->delete('users-avatar/' . $currentAvatar);
            }
        
            $file = $request->file('profile_image');
            $fileName = Str::slug(date('YmdHis')) . '.png';
            $path = $file->storeAs('users-avatar', $fileName, 'public');
        
            User::where('id',auth()->user()->id)->update([
                'avatar' => $fileName
            ]);
        
            return ResponseFormatter::success(
                $path,
                'Profile successfully updated'
            );
        }
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th->getMessage(),
                'Profile failed to update',
                500
            );
        }
    }
    function updateProfile(Request $request) {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'no_hp' => ['required', 'regex:/^08\d{8,11}$/'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.regex' => 'Nomor HP harus dimulai dari 08 dan memiliki 10-13 digit.',
        ]);
      
        User::find(auth()->user()->id)->update([
            'email' =>$request->email,
            'no_hp' =>$request->no_hp,
        ]);
    
        return response()->json([
            'meta' => [
                'message' => 'Profil berhasil diperbarui!',
                'status' => true
            ]
        ]);
    }
}
