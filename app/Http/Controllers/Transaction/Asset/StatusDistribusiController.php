<?php

namespace App\Http\Controllers\Transaction\Asset;

use App\Helper\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\Asset\StatusDistribusi\StoreDistribusiRequest;
use App\Http\Requests\Transaction\Asset\UpdateDistribusiRequest;
use App\Models\Master\Asset;
use App\Models\Master\AssetLog;
use App\Models\Master\MasterAsset;
use App\Models\Setting\MasterSatgas;
use App\Models\Transaction\Asset\StatusDistribusi;
use App\Models\Transaction\Asset\StatusDistribusiDetail;
use App\Models\Transaction\Asset\StatusDistribusiItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use NumConvert;
class StatusDistribusiController extends Controller
{
    function index() {
        return view('transaction.asset.status_distribusi.status_distribusi-index');
    }
    function getStatusDistribusi(Request $request) {
        $data = StatusDistribusi::with([
            'detailRelation',
            'detailRelation.userRelation',
            'detailRelation.locationRelation',
            'destinationRelation',
            'locationRelation',
            'reporterRelation',
            'itemRelation',
            'itemRelation.assetRelation',
            'itemRelation.assetRelation.categoryRelation',
            'itemRelation.assetRelation.subCategoryRelation',
            'itemRelation.assetRelation.typeRelation',
            'itemRelation.assetRelation.merkRelation',
            'itemRelation.assetRelation.satgasRelation',
        ])->orderBy('status','asc')->get();
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
    function getDistribusiLog(Request $request) {
        $data = StatusDistribusiDetail::with([
            'userRelation',
            'locationRelation',
        ])->where('distribution_code', $request->distribution_code)->get();
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
    function getMasterAssetDistribusi(Request $request) {
        $data = Asset::with([
            'categoryRelation',
            'subCategoryRelation',
            'typeRelation',
            'merkRelation',
            'satgasRelation',
        ])
        // ->where('lokasi', auth()->user()->satgas)
        ->get();
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
    function addDistribusi(Request $request, StoreDistribusiRequest $storeDistribusiRequest) {
        $storeDistribusiRequest->validated();
        $increment_code = StatusDistribusi::orderBy('id', 'desc')->first();
        $file = null;
        $currentDate = strtotime(date('Y-m-d'));
        $month = idate('m', $currentDate);
        $year = idate('y', $currentDate);
        $month_convert = NumConvert::roman($month);
        if ($increment_code === null) {
            $ticket_code = '1/DIST/' . $month_convert . '/' . $year;
        } else {
            $month_before = explode('/', $increment_code->distribution_code);
    
            if ($month_convert !== $month_before[2]) {
                $ticket_code = '1/DIST/' . $month_convert . '/' . $year;
            } else {
                $ticket_code = ($month_before[0] + 1) . '/DIST/' . $month_convert . '/' . $year;
            }
        }
    
        // Replace '/' with '_' in the ticket code for file naming
        $sanitized_ticket_code = str_replace('/', '_', $ticket_code);
        
        // Handle file attachment upload
        $attachmentPath = '';
        $attachmentPathLog = '';
        $fileName = '';
        $fileNameLog = '';
        
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileNameLog = $sanitized_ticket_code . '_' . time() . '.' . $file->getClientOriginalExtension(); // Add timestamp to prevent overwriting
            $fileName = $sanitized_ticket_code . '.' . $file->getClientOriginalExtension();
            $attachmentPath = 'transaction/asset/distribusi/' . $fileName;
        }
    
        // Data for the inventaris table
        $postDistribution = [
            'distribution_code' => $ticket_code,
            'des_location'      => $request->tujuan,
            'current_location'  => auth()->user()->satgas,
            'reporter'          => auth()->user()->id,
            'status'            => 0,
            'user_id'           => auth()->user()->id,
            'reporter'          => auth()->user()->id,
            'keterangan'        => $request->catatan,
            'attachment'        => $request->hasFile('attachment') ? $attachmentPath : '', // Store the attachment path
        ];
    
        DB::transaction(function() use($request, $postDistribution, $file, $fileName, $ticket_code, $attachmentPath) {
            StatusDistribusi::create($postDistribution);
    
            $increment_code = StatusDistribusiDetail::orderBy('id', 'desc')->first();
            $file = null;
            $detail_ticket_code = '';
            $currentDate = strtotime(date('Y-m-d'));
            $month = idate('m', $currentDate);
            $year = idate('y', $currentDate);
            $month_convert = NumConvert::roman($month);
            if ($increment_code === null) {
                $detail_ticket_code = '1/DET/' . $month_convert . '/' . $year;
            } else {
                $month_before = explode('/', $increment_code->detail_distribution_code);
    
                if ($month_convert !== $month_before[2]) {
                    $detail_ticket_code = '1/DET/' . $month_convert . '/' . $year;
                } else {
                    $detail_ticket_code = ($month_before[0] + 1) . '/DET/' . $month_convert . '/' . $year;
                }
            }
            
            $posDetail = [
                'distribution_code' => $ticket_code,
                'detail_distribution_code' => $detail_ticket_code,
                // 'asset_code'        => $request->asset,
                'user_id'           => auth()->user()->id,
                'status'            => 0,
                'keterangan'        => $request->catatan,
                'attachment'        => $request->hasFile('attachment') ? $attachmentPath : '',
                'location'          => auth()->user()->satgas
            ];
            StatusDistribusiDetail::create($posDetail);
            $assets = json_decode($request->assets, true);
            foreach ($assets as $asset) {
                $asset_code = $asset['asset_code'];
                $asset = Asset::where('asset_code', $asset_code)->first();
                $posDetail = [
                    'distribution_code' => $ticket_code,
                    'asset_code'        => $asset_code,
                ];
                StatusDistribusiItem::create($posDetail);
            }
    
            // Check if the file exists before trying to store it
            if ($file) {
                $file->storeAs('transaction/asset/distribusi', $fileName, 'public');
            }
        });
    
        return ResponseFormatter::success(
            $postDistribution,
            'Transaksi berhasil ditambahkan'
        );
    }
    
    function startProgressDistribution(Request $request) {
         // try {
            $increment_code = StatusDistribusiDetail::orderBy('id', 'desc')->first();
            $file=null;
            $detail_ticket_code='';
            $currentDate = strtotime(date('Y-m-d'));
            $month = idate('m', $currentDate);
            $year = idate('y', $currentDate);
            $month_convert = NumConvert::roman($month);
            if ($increment_code === null) {
                $detail_ticket_code = '1/DET/' . $month_convert . '/' . $year;
            } else {
                $month_before = explode('/', $increment_code->detail_distribution_code);
        
                if ($month_convert !== $month_before[2]) {
                    $detail_ticket_code = '1/DET/' . $month_convert . '/' . $year;
                } else {
                    $detail_ticket_code = ($month_before[0] + 1) . '/DET/' . $month_convert . '/' . $year;
                }
            }
            $head = StatusDistribusi::where('distribution_code', $request->distribution_code)->first();
            $asset = Asset::where('asset_code', $head->asset_code) ->first();
            $posDetail = [
                'distribution_code' =>$request->distribution_code,
                'detail_distribution_code'=>$detail_ticket_code,
                'user_id'           =>auth()->user()->id,
                'status'            =>1,
                'keterangan'        =>$head->keterangan,
                'attachment'        =>'',
                'location'          =>$head->current_location
            ];
            // Data for the inventaris table
            $postDistribution = [
                'status'         => 1,
                'user_id'         => auth()->user()->id,
            ];
            // dd($postDistribution);
            DB::transaction(function() use($request, $postDistribution,$posDetail) {
                StatusDistribusi::where('distribution_code', $request->distribution_code)->update($postDistribution);
                StatusDistribusiDetail::create($posDetail);
            });
            
            return ResponseFormatter::success(
                $postDistribution,
                'Aset berhasil diproses'
            );
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th->getMessage(),
        //         'Asset gagal ditambahkan',
        //         500
        //     );get
        // }
    }
    function updateDistribusi(Request $request, UpdateDistribusiRequest $updateDistribusiRequest) {
         // try {
         $updateDistribusiRequest->validated();
            $increment_code = StatusDistribusiDetail::orderBy('id', 'desc')->first();
            $file=null;
            $detail_ticket_code='';
            $currentDate = strtotime(date('Y-m-d'));
            $month = idate('m', $currentDate);
            $year = idate('y', $currentDate);
            $month_convert = NumConvert::roman($month);
            if ($increment_code === null) {
                $detail_ticket_code = '1/DET/' . $month_convert . '/' . $year;
            } else {
                $month_before = explode('/', $increment_code->detail_distribution_code);
        
                if ($month_convert !== $month_before[2]) {
                    $detail_ticket_code = '1/DET/' . $month_convert . '/' . $year;
                } else {
                    $detail_ticket_code = ($month_before[0] + 1) . '/DET/' . $month_convert . '/' . $year;
                }
            }
            $sanitized_ticket_code = str_replace('/', '_', $detail_ticket_code);
            // Handle file attachment upload
            $attachmentPathLog = '';
            $fileName='';
            $fileNameLog='';
            if ($request->hasFile('update_attachment')) {
                $file = $request->file('update_attachment');
                $fileName = $sanitized_ticket_code . '.' . $file->getClientOriginalExtension();
                $attachmentPath = 'transaction/asset/distribusiLog/' . $fileName;
            }
            
            $head = StatusDistribusi::where('distribution_code', $request->distribution_code)->first();
            $lokasiTujuan = MasterSatgas::find($head->des_location);
            $posDetail = [
                'distribution_code' =>$request->distribution_code,
                'detail_distribution_code'=>$detail_ticket_code,
                'user_id'           =>auth()->user()->id,
                'status'            =>$request->update_status,
                'keterangan'        =>$request->update_catatan,
                'attachment'        =>$request->hasFile('update_attachment') ? $attachmentPath : '',
                'location'          =>$request->update_status == 2 ? $head->des_location : auth()->user()->satgas
            ];
            // dd($posDetail);
            // Data for the inventaris table
            $postDistribution = [
                'status'         => $request->update_status,
                'user_id'         => auth()->user()->id,
            ];
          
            
            // dd($postDistribution);
            DB::transaction(function() use($request, $postDistribution,$posDetail,$head,$file,$fileName,$lokasiTujuan) {
                StatusDistribusi::where('distribution_code', $request->distribution_code)->update($postDistribution);
                StatusDistribusiDetail::create($posDetail);
                if($request->update_status == 2){
                    $item = StatusDistribusiItem::where('distribution_code', $request->distribution_code)->get();
                  
                    foreach($item as $items){
                        $asset = Asset::where('asset_code', $items->asset_code)->first();
                        $lokasiAsal = MasterSatgas::find($asset->lokasi);
                        $postAsset = [
                            'lokasi'        => $head->des_location,
                        ];
                      
                        $assetLog=[
                            'asset_code'    =>$asset->asset_code,
                            'no_un'         =>$asset->no_un,
                            'no_rangka'     =>$asset->no_rangka,
                            'no_mesin'      =>$asset->no_mesin,
                            'kategori'      =>$asset->kategori,
                            'subkategori'   =>$asset->subkategori,
                            'jenis'         =>$asset->jenis,
                            'merk'          =>$asset->merk,
                            'user_id'       =>auth()->user()->id,
                            'pic'           =>$asset->pic,
                            'kondisi'       =>$asset->kondisi,
                            'lokasi'        =>$head->des_location,
                            'remark'        =>auth()->user()->name .' telah memindahkan lokasi aset dari : '.$lokasiAsal->name.' ke '.$lokasiTujuan->name
                        ];
                        AssetLog::create($assetLog);
                        Asset::where('asset_code', $asset->asset_code)->update($postAsset);
                    }
                }
                if($request->file('update_attachment')){
                    $file->storeAs('transaction/asset/distribusiLog',$fileName,'public');
                   
                }
            });
            
            return ResponseFormatter::success(
                $postDistribution,
                'Aset berhasil diproses'
            );
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th->getMessage(),
        //         'Asset gagal ditambahkan',
        //         500
        //     );get
        // }
    }
}
