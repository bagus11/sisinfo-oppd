<?php

namespace App\Http\Controllers\Master;

use App\Helper\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreMasterAsset;
use App\Http\Requests\Master\UpdateMasterAsset;
use App\Imports\AssetsImport;
use App\Models\Master\Asset;
use App\Models\Master\AssetLog;
use App\Models\Master\MasterAsset;
use App\Models\Setting\Inventory_type;
use App\Models\Setting\InventoryBrand;
use App\Models\Setting\InventoryCategory;
use App\Models\Setting\InventorySubCategory;
use App\Models\Setting\MasterSatgas;
use Database\Seeders\InventoryType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use NumConvert;
use Yajra\DataTables\Facades\DataTables;
class MasterAssetController extends Controller
{
    function index() {
        $userHasPermission = auth()->user()->can('get-except_satgas-master_asset');
        return view('master.asset.asset-index', compact('userHasPermission'));
    }
    
    function getMasterAsset(Request $request) {
        $currentYear = date('Y');
        $query = Asset::query()
        ->leftJoin('inventory_categories', 'assets.kategori', '=', 'inventory_categories.id')
        ->leftJoin('inventory_sub_categories', 'assets.subkategori', '=', 'inventory_sub_categories.id')
        ->leftJoin('inventory_types', 'assets.jenis', '=', 'inventory_types.id')
        ->leftJoin('inventory_brands', 'assets.merk', '=', 'inventory_brands.id')
        ->leftJoin('master_satgas', 'assets.lokasi', '=', 'master_satgas.id')
        ->select([
            'assets.*',
            'inventory_categories.name as categoryRelation',
            'inventory_sub_categories.name as subCategoryRelation',
            'inventory_types.name as typeRelation',
            'inventory_brands.name as merkRelation',
            'master_satgas.name as satgasName',
            'master_satgas.type as satgasType',
        ])
        ->where('assets.kondisi', 'like', '%' . $request->kondisi . '%');
        if(auth()->user()->hasPermissionTo('get-except_satgas-master_asset')){
            if (!empty($request->satgas_type)) {
                $query->where('master_satgas.type', 'like', '%' . $request->satgas_type . '%');
            }
        } else {
            $type = MasterSatgas::find(auth()->user()->satgas);
            if (!empty($request->satgas_type)) {
                $query->where('master_satgas.type', $type->type);
            }
        }
    
        // Filter Tahun Operasi
        if (!empty($request->th_operasi)) {
            $this->applyYearFilter($query, 'assets.th_operasi', $request->th_operasi, $currentYear);
        }
    
        // Filter Tahun Pembuatan
        if (!empty($request->th_pembuatan)) {
            $this->applyYearFilter($query, 'assets.th_pembuatan', $request->th_pembuatan, $currentYear);
        }
    
        if ($request->ajax()) {
            return DataTables::of($query)
                ->addColumn('action', function ($row) {
                    $editBtn = '<button class="btn btn-sm btn-warning edit" data-id="' . $row->id . '">
                                <i class="fas fa-edit"></i>
                                </button>';
                    $printBtn = '<button class="btn btn-sm btn-success print" data-id="' . $row->id . '">
                                <i class="fas fa-file"></i>
                                </button>';
                    return $printBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    
        return response()->json(['data' => $query->get()]);
    }
    
    function getMasterAssetInventarisTable(Request $request) {
       
    if(auth()->user()->hasPermissionTo('get-except_satgas-asset_inventaris')){
        $data = Asset::with([
            'detailInventarisRelation',
            'categoryRelation',
            'subCategoryRelation',
            'typeRelation',
            'merkRelation',
            'satgasRelation',
        
        ])
        ->whereDoesntHave('detailInventarisRelation', function ($query) {
            $query->whereDate('bulan', now()); // Filter untuk mengecualikan data dengan tanggal hari ini
        })
        ->get();
    }else{
        $data = Asset::with([
            'detailInventarisRelation',
            'categoryRelation',
            'subCategoryRelation',
            'typeRelation',
            'merkRelation',
            'satgasRelation',
        
        ])
        ->whereDoesntHave('detailInventarisRelation', function ($query) {
            $query->whereDate('bulan', now()); 
        })
        ->where('lokasi', auth()->user()->satgas)
        ->get();
    }
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
    function getMasterAssetInventaris() {
        $data = Asset::with([
            'detailInventarisRelation',
            'categoryRelation',
            'subCategoryRelation',
            'typeRelation',
            'merkRelation',
            'satgasRelation',
        
        ])
        ->whereDoesntHave('detailInventarisRelation', function ($query) {
            $query->whereDate('bulan', now()); // Filter untuk mengecualikan data dengan tanggal hari ini
        })->get();
        return response()->json([
            'data'=>$data,
        ]);
    }
    function getInventoryCategory() {
        $data =  InventoryCategory::all();
        return response()->json([
            'data'=>$data,
        ]);
    }
    function getInventorySubCategory() {
        $data =  InventorySubCategory::all();
        return response()->json([
            'data'=>$data,
        ]);
    }
    function getInventoryType() {
        $data =  Inventory_type::all();
        return response()->json([
            'data'=>$data,
        ]);
    }
    
    function getInventoryBrand() {
        $data =  InventoryBrand::all();
        return response()->json([
            'data'=>$data,
        ]);
    }
    function addMasterAsset(Request $request, StoreMasterAsset $storeMasterAsset) {
        // try{
            $storeMasterAsset->validated();
            $increment_code = Asset::withTrashed()->orderBy('id', 'desc')->first();
            $date_month =strtotime(date('Y-m-d'));
            $month =idate('m', $date_month);
            $year = idate('y', $date_month);
            $month_convert =  NumConvert::roman($month);
            if($increment_code ==null){
                $ticket_code = '1/ASSET/'.$month_convert.'/'.$year;
            }else{
                $month_before = explode('/',$increment_code->asset_code);
               
                if($month_convert != $month_before[2]){
                    $ticket_code = '1/ASSET/'.$month_convert.'/'.$year;
                }else{
                    $ticket_code = $month_before[0] + 1 .'/ASSET/'.$month_convert.'/'.$year;
                }   
            }
            // dd($ticket_code);
            $post=[
                'asset_code'    => $ticket_code,
                'no_un'         =>$request->no_un,
                'no_rangka'         =>$request->no_rangka,
                'no_mesin'         =>$request->no_mesin,
                'kategori'          =>$request->kategori,
                'subkategori'          =>$request->subkategori,
                'jenis'          =>$request->jenis,
                'merk'          =>$request->merk,
                'th_pembuatan'          =>$request->th_pembuatan,
                'th_operasi'          =>$request->th_operasi,
                'user_id'       =>auth()->user()->id,
                'pic'           =>0,
                'kondisi'           =>1,
                'lokasi'        =>0
            ];
            $postLog=[
                'asset_code'    => $ticket_code,
                'no_un'         =>$request->no_un,
                'no_rangka'         =>$request->no_rangka,
                'no_mesin'         =>$request->no_mesin,
                'kategori'          =>$request->kategori,
                'subkategori'          =>$request->subkategori,
                'jenis'          =>$request->jenis,
                'merk'          =>$request->merk,
                'user_id'       =>auth()->user()->id,
                'th_pembuatan'          =>$request->th_pembuatan,
                'th_operasi'          =>$request->th_operasi,
                'pic'           =>0,
                'kondisi'           =>1,
                'lokasi'        =>0,
                'remark'        => auth()->user()->name. ' telah menambahkan asset'
            ];
            Asset::create($post);
            AssetLog::create($postLog);
            return ResponseFormatter::success(
                $post,
                 'Asset berhasil ditambahkan'
             );          
        // }catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Asset gagal ditambahkan',
        //         500
        //     );
        // }
       
    }
    function getLogAsset(Request $request) {
        $data = AssetLog::with([
            'categoryRelation',
            'subCategoryRelation',
            'typeRelation',
            'merkRelation',
            'satgasRelation',
            'picRelation',
        ])->where('asset_code', $request->asset_code)->orderBy('id','desc')->get();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->rawColumns(['action'])
                ->make(true);
        }
        return response()->json([
            'data'=>$data,
        ]);
    }
    function getSatgas() {
        $data = MasterSatgas::all();
        return response()->json([
            'data'=>$data,
        ]);
    }
    
    function updateAsset(Request $request, UpdateMasterAsset $updateMasterAsset ) {
         // try{
            $updateMasterAsset->validated();
            $detail = Asset::where('asset_code', $request->asset_code)->first();
            $post=[
                'asset_code'        => $detail->asset_code,
                'no_un'             =>$request->edit_no_un,
                'no_rangka'         =>$request->edit_no_rangka,
                'no_mesin'          =>$request->edit_no_mesin,
                'kategori'          =>$request->edit_kategori,
                'subkategori'       =>$request->edit_subkategori,
                'jenis'             =>$request->edit_jenis,
                'merk'              =>$request->edit_merk,
                'th_pembuatan'      =>$request->edit_th_pembuatan,
                'th_operasi'        =>$request->edit_th_operasi,
                'user_id'           =>$detail->user_id,
                'pic'               =>$detail->pic,
                'kondisi'           =>$detail->kondisi,
                'lokasi'            =>$detail->lokasi,
            ];
            $post_log =[
                'asset_code'        => $detail->asset_code,
                'no_un'             =>$request->edit_no_un,
                'no_rangka'         =>$request->edit_no_rangka,
                'no_mesin'          =>$request->edit_no_mesin,
                'kategori'          =>$request->edit_kategori,
                'subkategori'       =>$request->edit_subkategori,
                'jenis'             =>$request->edit_jenis,
                'merk'              =>$request->edit_merk,
                'th_pembuatan'              =>$request->edit_th_pembuatan,
                'th_operasi'              =>$request->edit_th_operasi,
                'user_id'           =>auth()->user()->id,
                'pic'               =>$detail->pic,
                'kondisi'           =>$detail->kondisi,
                'lokasi'            =>$detail->lokasi,
                'remark'            =>auth()->user()->name . ' telah mengubah di master asset'
            ];
            Asset::where('asset_code', $request->asset_code)->update($post);
            AssetLog::create($post_log);
            return ResponseFormatter::success(
                $post,
                 'Asset berhasil ditambahkan'
             );          
        // }catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Asset gagal ditambahkan',
        //         500
        //     );
        // }
    }
 
    function deleteAsset(Request $request)
    {
        foreach($request->asset_code as $asset_code){  
            $data =Asset::where('asset_code', $asset_code)->delete();
        }
        return ResponseFormatter::success(
            $data,
             'Asset berhasil dihapus'
         );
    }
    public function uploadAsset(Request $request) {
        $request->validate([
            'file_upload_asset' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);
    
        try {
            $file = $request->file('file_upload_asset');
    
            // Import file data
            Excel::import(new AssetsImport, $file);
    
            // Ambil data yang memiliki lokasi = 0
            $assetsWithNoLocation = Asset::where('lokasi', 0)->get(['asset_code', 'no_un', 'no_rangka', 'no_mesin']);
    
            return response()->json([
                'success' => true,  
                'message' => 'Assets imported successfully!',
                'assets_no_location' => $assetsWithNoLocation, // Tampilkan asset tanpa lokasi
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error importing assets: ' . $e->getMessage(),
            ], 500);
        }
    }
    
}
