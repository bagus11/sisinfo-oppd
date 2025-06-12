<?php

namespace App\Http\Controllers\Transaction\Asset;

use App\Helper\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\Asset\Inventaris\UpdateInventaris;
use App\Http\Requests\Transaction\Asset\Maintenance\AddMaintenanceRequest;
use App\Http\Requests\Transaction\Asset\Maintenance\UpdateMaintenanceDetail;
use App\Models\Master\Asset;
use App\Models\Setting\Approval;
use App\Models\Setting\ApprovalDetail;
use App\Models\Setting\MasterSatgas;
use App\Models\Transaction\Asset\Maintenance;
use App\Models\Transaction\Asset\MaintenanceDetail;
use App\Models\Transaction\Asset\MaintenanceDetailLog;
use App\Models\Transaction\Asset\MaintenanceLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use NumConvert;
class LaporanController extends Controller
{
    function index() {
        return view('transaction.asset.laporan.laporan-index');
    }

    function getMaintenance(Request $request) {
        $data = Maintenance::with([
            'reporterRelation',

        ])->get();
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
    
    function getAssetMaintenance(Request $request) {
       $data = Asset::with([
                'categoryRelation',
                'subCategoryRelation',
                'typeRelation',
                'merkRelation',
                'satgasRelation',
                'maintenanceRelation' => function ($query) {
                    $query->whereNotIn('status', [0, 1]); // ambil yang status bukan 0 atau 1
                },
                'latestHistoryRelation',
            ])
            ->where('kondisi', '!=', 1)
            ->whereHas('historyRelation')
            ->whereHas('maintenanceRelation', function ($query) {
                $query->whereNotIn('status', [0, 1]);
            })
            ->orderBy('updated_at', 'desc')
            ->get();


        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('attachment', function ($row) {
                    if ($row->latestHistoryRelation && $row->latestHistoryRelation->attachment) {
                        return '<a href="' . asset('storage/' . $row->latestHistoryRelation->attachment) . '" target="_blank">Lihat</a>';
                    }
                    return '-';
                })
                ->addColumn('action', function ($row) {
                    $printBtn = '<button class="btn btn-sm btn-success print" data-id="' . $row->id . '">
                    <i class="fas fa-file"></i>
                    </button>';
                    return $printBtn;
                })
                ->rawColumns(['action', 'attachment'])
                ->make(true);
        }

        return response()->json([
            'data' => $data,
        ]);
    }

    function getDetailMaintenance(Request $request) {
        $data = MaintenanceDetail::with([
            'assetRelation',
            'assetRelation.categoryRelation',
            'assetRelation.subCategoryRelation',
            'assetRelation.typeRelation',
            'assetRelation.inventarisRelation',
            'assetRelation.merkRelation',
            'assetRelation.satgasRelation',
        ])->where('request_code', $request->request_code)->get();
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
    function addLaporanHeader(Request $request, AddMaintenanceRequest $addMaintenanceRequest) {

        // try {
            // Validate input
            $addMaintenanceRequest->validated();

            // Get the last increment code
            $increment_code = Maintenance::orderBy('id', 'desc')->first();
            $file=null;
            // Get the current month and year
            $currentDate = strtotime(date('Y-m-d'));
            $month = idate('m', $currentDate);
            $year = idate('y', $currentDate);
        
            // Convert month to Roman numeral
            $month_convert = NumConvert::roman($month);
            $ticket_code ='';
            // Generate ticket code
            if ($increment_code === null) {
                $ticket_code = '1/REQ/' . $month_convert . '/' . $year;
            } else {
                $month_before = explode('/', $increment_code->inventaris_code);
        
                if ($month_convert !== $month_before[2]) {
                    $ticket_code = '1/REQ/' . $month_convert . '/' . $year;
                } else {
                    $ticket_code = ($month_before[0] + 1) . '/REQ/' . $month_convert . '/' . $year;
                }
            }
            // Replace '/' with '_' in the ticket code for file naming
            $sanitized_ticket_code = str_replace('/', '_', $ticket_code);
            // dd($sanitized_ticket_code);
        
            // Handle file attachment upload
            $attachmentPath = '';
            $attachmentPathLog = '';
            $fileName='';
            $fileNameLog='';
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $fileNameLog = $sanitized_ticket_code . '_' . time() . '.' . $file->getClientOriginalExtension(); // Add timestamp to prevent overwriting
                $fileName = $sanitized_ticket_code . '.' . $file->getClientOriginalExtension();
                $attachmentPath = 'transaction/asset/Maintenance/' . $fileName;
                $attachmentPathLog = 'transaction/asset/MaintenanceLog/' . $fileNameLog;
            }
            $asset = json_decode($request->assets, true);
            $post_array = [];
            $post_array_detail = [];
            $asset_location = 0;
            foreach($asset as $row){
                $detailAsset = Asset::where('asset_code', $row['asset_code'])->first();
                $postArray =[
                    'request_code'  => $ticket_code,
                    'asset_code'    => $detailAsset->asset_code,
                    'user_id'       => $request->reporter,
                    'status'        => 0,
                    'type'          => 0,
                    'attachment'    => '',
                    'new_asset_code'=> '',
                    'remark'        =>'',
                    'user_id'       => auth()->user()->id
                ];
                $postArrayDetail =[
                    'request_code'  => $ticket_code,
                    'asset_code'    => $detailAsset->asset_code,
                    'new_asset_code'=> $detailAsset->asset_code,
                    'user_id'       => $request->reporter,
                    'status'        => 0,
                    'type'        => 0,
                    'user_id'       => auth()->user()->id
                ];
                $asset_location = $detailAsset->lokasi; 
                array_push($post_array,$postArray);
                array_push($post_array_detail,$postArrayDetail);
            }
            $currentUrl = url()->current();
            $satgas = MasterSatgas::find($asset_location)->type;
            $approval = Approval::where("satgas", $satgas)->where('link', $currentUrl)->first()->approval_code;
            $approval_id = ApprovalDetail::where('approval_code', $approval)->first();

            $post=[
                'request_code'  => $ticket_code,
                // 'type'          => 0,
                'user_id'       => auth()->user()->id,
                'reporter'      => auth()->user()->id,
                'status'        => 0,
                'attachment'    => $attachmentPath,
                'remark'        => $request->catatan,
                'approval_code' => $approval,
                'approval_id'   => $approval_id->user_id,
                'step'          => $approval_id->step
                
            ];
            $postLog=[
                'request_code'  => $ticket_code,
                // 'type'          => 0,
                'user_id'       => auth()->user()->id,
                'reporter'      => auth()->user()->id,
                'status'        => 0,
                'attachment'    => $attachmentPathLog,
                'remark'        => 'Tiket berhasil dibuat',
                'approval_code' => $approval,
                'approval_id'   => $approval_id->user_id,
                'step'          => $approval_id->step
                
            ];
            // dd($post);
            DB::transaction(function() use($request,$postLog ,$post,$post_array, $file,$fileName,$fileNameLog, $post_array_detail) {
                Maintenance::create($post);
                MaintenanceLog::create($postLog);
                MaintenanceDetail::insert($post_array);
                MaintenanceDetailLog::insert($post_array_detail);
                if($request->file('attachment')){
                    $file->storeAs('transaction/asset/Maintenance',$fileName,'public');
                    $file->storeAs('transaction/asset/MaintenanceLog',$fileNameLog,'public');
                }

            });
            
            return ResponseFormatter::success(
                $post,
                'Pengajuan berhasil ditambahkan'
            );
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th->getMessage(),
        //         'Asset gagal ditambahkan',
        //         500
        //     );get
        // }
        // dd($request->assets);
      
    }

    function updateMaintenanceUpdate(Request $request, UpdateMaintenanceDetail $updateMaintenanceDetail) {
          // try {
            // Validate input
            $updateMaintenanceDetail->validated();
            $head = Maintenance::where('request_code', $request->request_code)->first();
            $asset = Asset::where('asset_code', $request->update_asset_code)->first();
            $detail = MaintenanceDetail::where('request_code',$request->request_code)->where('asset_code',$request->update_asset_code)->first();
            $post = [
                'request_code'  => $request->request_code,
                'asset_code'    => $request->update_asset_code,
                'status'        => $detail->status + 1,
                'remark'        => $request->update_catatan,
            ];
            DB::transaction(function() use($request, $post,) {
                

            });
            
            return ResponseFormatter::success(
                
                'Pengajuan berhasil ditambahkan'
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
