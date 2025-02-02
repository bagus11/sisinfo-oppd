<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Transaction\Penerangan\NewsModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PeneranganController extends Controller
{
    function index() {
        return view('transaction.penerangan.master_penerangan-index');
    }

    function getNews(Request $request) {
        $data = NewsModel::with(
            [
                'userRelation',
                'reporterRelation',
            ]
        )->get();
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
