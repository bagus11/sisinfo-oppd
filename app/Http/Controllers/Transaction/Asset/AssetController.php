<?php

namespace App\Http\Controllers\Transaction\Asset;

use App\Helper\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Master\Asset;
use App\Models\Master\MasterAsset;
use App\Models\Setting\MasterSatgas;
use App\Models\Transaction\Asset\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AssetController extends Controller
{
    public function index()
    {
        return view('transaction.asset.asset-index');
    }
    
    public function getAsset(Request $request)
    {
        if ($request->ajax()) {
            $data = MasterAsset::all();
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $editBtn = '<button class="btn btn-sm btn-warning edit" data-id="' . $row->id . '">
                    <i class="fas fa-edit"></i>
                    </button>';
                    $printBtn = '<button class="btn btn-sm btn-success edit" data-id="' . $row->id . '">
                    <i class="fas fa-file"></i>
                    </button>';
                    return $editBtn.' '.$printBtn ;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return abort(403, 'Unauthorized action.');
    }
    public function getAssetFilter(Request $request)
    {
       dd($request->kondisi);
        if ($request->ajax()) {
            // Convert kondisi to its corresponding integer value
            $kondisi = match ($request->kondisi) {
                "BAIK" => 1,
                "RR OPS" => 2,
                "RB" => 3,
                "RR TDK OPS" => 4,
                "M" => 5,
                "D" => 6,
                default => 0,
            };
    
            // Fetch assets with relationships
            $data = Asset::query()
                    ->leftJoin('master_satgas', 'assets.lokasi', '=', 'master_satgas.id')
                    ->with([
                        'categoryRelation',
                        'subCategoryRelation',
                        'typeRelation',
                        'merkRelation',
                        'satgasRelation'
                    ])
                    ->where(function ($q) use ($request) {
                        if (!empty($request->type)) {
                            $q->where('master_satgas.type', $request->type);
                        }
                    })
                    ->where('assets.kondisi', 'like', '%' . $kondisi . '%')
                    ->select('assets.*')
                    ->get();
            return DataTables::of($data)->make(true);
        }
    
        return abort(403, 'Unauthorized action.');
    }
    
    function getMasterSatgas() {
        $data = MasterSatgas::all();
        return response()->json([
            'data'=>$data,
            
        ]);  
    
    }
    function getSatgasType() {
        $data = MasterSatgas::select('type', DB::raw('COUNT(*) as total'))->whereNot('type','OPPD')
        ->groupBy('type')
        ->get();
    
    return response()->json([
        'data' => $data,
    ]);
  
    
    }
    function addAsset(Request $request) {
        // try {
            for($i = 0; $i < 99 ; $i ++){
                $post =[
                    'satgas' =>$request->satgas,
                    'no_un' =>'DUMMY_'.$i,
                    'category' =>'CATEGORY_'.$i,
                    'sub_category' =>'SUBCATEGORY_'.$i,
                    'type' =>'DUMMY_TYPE_'.$i,
                    'brand' =>'DUMMY_BRAND_'.$i,
                    'no_mesin' =>'DUMMY_MACHIINE_'.$i,
                    'no_rangka' =>'DUMMY_NO_RANGKA_'.$i,
                    'kondisi' =>$request->kondisi,
                    'country' =>3,
                    'keterangan' =>'DUMMY TESTING',
                    'user_id' =>1,
                    'status_pengajuan' =>1,
                    'pengajuan' =>1,
                ];
                MasterAsset::create($post);
            }
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
    function getPengajuanAsset(Request $request)  {
        if ($request->ajax()) {
            $data = Maintenance::whereIn('type',[1])->get();
            return DataTables::of($data)
                ->make(true);
        }
    }
    function getPengajuanAssetFilter(Request $request)  {
        if ($request->ajax()) {
            $data = Maintenance::where('type',$request->pengajuan)->get();
            return DataTables::of($data)
                ->make(true);
        }
    }
}
