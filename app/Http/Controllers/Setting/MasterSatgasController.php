<?php

namespace App\Http\Controllers\Setting;

use App\Helper\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\Satgas\AddSatgasRequest;
use App\Models\Setting\MasterSatgas;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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
}
