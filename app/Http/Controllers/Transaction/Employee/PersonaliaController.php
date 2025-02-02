<?php

namespace App\Http\Controllers\Transaction\Employee;

use App\Http\Controllers\Controller;
use App\Models\Transaction\Employee\Personalia;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PersonaliaController extends Controller
{
    function index() {
        return view('transaction.employee.personalia.personalia-index');
    }
    function getPersonalia(Request $request){
        $data = Personalia::all();
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
}
