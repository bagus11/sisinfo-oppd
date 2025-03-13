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
        if ($request->ajax()) {
            $currentYear = date('Y');
    
            // Konversi kondisi ke angka
            $kondisi = match ($request->kondisi) {
                "BAIK" => 1,
                "RR OPS" => 2,
                "RB" => 3,
                "RR TDK OPS" => 4,
                "M" => 5,
                "D" => 6,
                default => 0,
            };
    
            // Query utama
            $data = Asset::query()
                ->leftJoin('master_satgas', 'assets.lokasi', '=', 'master_satgas.id')
                ->with([
                    'categoryRelation',
                    'subCategoryRelation',
                    'typeRelation',
                    'merkRelation',
                    'satgasRelation'
                ]);
            if($kondisi != 0){
                $data->where('assets.kondisi', $kondisi);
                // ->where('assets.kondisi', 'like', '%' . $kondisi . '%');
            }
    
            // **Filter berdasarkan SatgasRelation**
            if (!empty($request->type)) {
                $data->where(function ($q) use ($request) {
                    $q->whereRaw('master_satgas.type = ?', [$request->type]);
                });
            }
                        
    
            // **Filter Tahun Operasi (th_operasi)**
            if (!empty($request->th_operasi)) {
                if ($request->th_operasi == "1") {
                    $data->whereBetween('assets.th_operasi', [$currentYear - 4, $currentYear]);
                } elseif ($request->th_operasi == "2") {
                    $data->whereBetween('assets.th_operasi', [$currentYear - 10, $currentYear - 5]);
                } elseif ($request->th_operasi == "3") {
                    $data->where('assets.th_operasi', '<', $currentYear - 10);
                }
            }
    
            // **Filter Tahun Pembuatan (th_pembuatan)**
            if (!empty($request->th_pembuatan)) {
                if ($request->th_pembuatan == "1") {
                    $data->whereBetween('assets.th_pembuatan', [$currentYear - 4, $currentYear]);
                } elseif ($request->th_pembuatan == "2") {
                    $data->whereBetween('assets.th_pembuatan', [$currentYear - 10, $currentYear - 5]);
                } elseif ($request->th_pembuatan == "3") {
                    $data->where('assets.th_pembuatan', '<', $currentYear - 10);
                }
            }
    
            // **Hapus ORDER BY satgasRelation.name di Query Langsung**
            return DataTables::of($data)
                ->order(function ($query) {
                    // Sorting setelah data diambil
                    $query->get()->sortBy('satgasRelation.name');
                })
                ->make(true);
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
