<?php

namespace App\Http\Controllers\Transaction\Asset;

use App\Helper\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\Asset\Inventaris\StoreInventaris;
use App\Http\Requests\Transaction\Asset\Inventaris\UpdateInventaris;

use App\Models\Master\Asset;
use App\Models\Master\AssetLog;
use App\Models\Master\MasterAsset;
use App\Models\Setting\MasterSatgas;
use App\Models\Transaction\Asset\Inventaris;
use App\Models\Transaction\Asset\InventarisDetail;
use App\Models\Transaction\Asset\InventarisDetailLog;
use App\Models\Transaction\Asset\InventarisLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use NumConvert;
use PhpParser\Node\Stmt\Else_;
use Yajra\DataTables\Facades\DataTables;

class AssetInventarisController extends Controller
{
    function index() {
        return view('transaction.asset.asset_inventaris.asset_inventaris-index');
    }
    function getDetailAsset(Request $request) {
        $detail = Asset::with([
            'categoryRelation',
            'subCategoryRelation',
            'typeRelation',
            'merkRelation',
            'satgasRelation',
        ])->where('asset_code', $request->asset_code)->first();
        return response()->json([
            'detail'=>$detail,
        ]);
    }
    public function getInventaris(Request $request)
    {
        // Ambil data satgas user
        $satgas = MasterSatgas::find(auth()->user()->satgas);
    
        // Cek apakah user punya permission `only-gm-asset_inventaris`
        $userHasPermission = auth()->user()->can('only-gm-asset_inventaris');
    
        // Query inventaris
        $query = Inventaris::with([
            'detailRelation',
            'detailRelation.assetRelation',
            'detailRelation.assetRelation.categoryRelation',
            'detailRelation.assetRelation.subCategoryRelation',
            'detailRelation.assetRelation.typeRelation',
            'detailRelation.assetRelation.merkRelation',
            'detailRelation.assetRelation.satgasRelation',
            'satgasRelation',
            'reporterRelation',
        ]);
    
        // Jika user tidak punya permission, filter berdasarkan satgas
        if (!$userHasPermission && $satgas) {
            $query->whereHas('satgasRelation', function ($q) use ($satgas) {
                $q->where('type', $satgas->type);
            });
        }
    
        $data = $query->get()->map(function ($inventaris) {
            $kondisiMapping = [
                0 => '-',
                1 => 'BAIK',
                2 => 'RR OPS',
                3 => 'RB',
                4 => 'RR TDK OPS',
                5 => 'M',
                6 => 'D',
            ];
    
            $backgroundMapping = [
                0 => '-',
                1 => '#16C47F',
                2 => '#40A2E3',
                3 => '#E82561',
                4 => '#500073',
                5 => '#697565',
                6 => '#3C3D37',
            ];
    
            if ($inventaris->detailRelation) {
                $kondisiCounts = $inventaris->detailRelation
                    ->groupBy('kondisi')
                    ->map(function ($group) {
                        return $group->count();
                    });
    
                $kondisiBadges = $kondisiCounts->map(function ($count, $kondisi) use ($kondisiMapping, $backgroundMapping) {
                    $kondisiText = $kondisiMapping[$kondisi] ?? 'Unknown';
                    $backgroundColor = $backgroundMapping[$kondisi] ?? '#ccc';
    
                    return '<span class="badge badge-primary w-15 mx-1" style="background-color:'.$backgroundColor.';color:white;border-radius:10px !important;font-size:12px !important; font-weight:bold;">' . e($kondisiText) . ' : ' . $count . '</span>';
                })->implode(' ');
            } else {
                $kondisiBadges = '<span class="badge badge-secondary">No Data</span>';
            }
    
            $inventaris->kondisi_summary = $kondisiBadges;
            return $inventaris;
        });
    
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $editBtn = '<button class="btn btn-sm btn-warning edit" data-id="' . $row->id . '">
                                    <i class="fas fa-edit"></i> Edit
                                </button>';
                    $printBtn = '<button class="btn btn-sm btn-success print" data-id="' . $row->id . '">
                                    <i class="fas fa-file"></i> Print
                                </button>';
                    return $editBtn . ' ' . $printBtn;
                })
                ->addColumn('kondisi', function ($row) {
                    return $row->kondisi_summary;
                })
                ->rawColumns(['kondisi', 'action'])
                ->make(true);
        }
    
        return response()->json([
            'data' => $data,
        ]);
    }
    
    
    function getInventarisLog(Request $request) {
   
        $data = InventarisDetailLog::with(
            [
                'satgasRelation',
                'reporterRelation',
                'userRelation',
                'assetRelation.categoryRelation',
                'assetRelation.subCategoryRelation',
                'assetRelation.satgasRelation',
                'assetRelation.typeRelation',
                'assetRelation.merkRelation',
            ]
        )->where('inventaris_code',$request->inventaris_code)->get();
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
   
    function getInventarisDetail(Request $request) {
        $detail = InventarisDetail::with([
            'assetRelation',
            'assetRelation.categoryRelation',
            'assetRelation.subCategoryRelation',
            'assetRelation.typeRelation',
            'assetRelation.merkRelation',
            'satgasRelation',
            'reporterRelation',
            'userRelation',
        ])->where([
            'inventaris_code'   =>  $request->inventaris_code,
            'asset_code'        =>  $request->asset_code,
        ])->first();
        return response()->json([
            'detail'=>$detail,
        ]);
    }


    // public function addInventaris(Request $request, StoreInventaris $storeInventaris)
    // {
    //     // try {
    //         // Validate input
    //         $storeInventaris->validated();
    
    //         // Generate ticket code
    //         $lastCode = Inventaris::orderBy('id', 'desc')->first();
    //         $currentMonth = idate('m');
    //         $currentYear = idate('y');
    //         $romanMonth = NumConvert::roman($currentMonth);
    //         $ticketCode = $lastCode && explode('/', $lastCode->inventaris_code)[2] === $romanMonth
    //             ? (explode('/', $lastCode->inventaris_code)[0] + 1) . "/INV/{$romanMonth}/{$currentYear}"
    //             : "1/INV/{$romanMonth}/{$currentYear}";
    
    //         DB::transaction(function () use ($request, $ticketCode) {
    //             // Insert into `inventaris`
    //             $satgas = $request->satgas ?? auth()->user()->satgas;
    //             $satgasType = MasterSatgas::find($satgas)->type;
    
    //             $inventaris = Inventaris::create([
    //                 'inventaris_code' => $ticketCode,
    //                 'bulan' => date('Y-m-d'),
    //                 'satgas' => $satgas,
    //                 'satgas_type' => $satgasType,
    //                 'reporter' => auth()->user()->id,
    //                 'user_id' => auth()->user()->id,
    //                 'catatan' => '-',
    //             ]);
    
    //             // Process assets
    //             $assets = json_decode($request->data, true);

    //             $files = $request->file('attachments') ?? []; // Get the attachments array
    //             // dd($request->data);
    //             foreach ($assets as $key => $asset) {
    //                 // Determine asset condition status
    //                 $status = (int)$asset['kondisi'];
    //                 // {
    //                 //     'BAIK' => 1,
    //                 //     'RR OPS' => 2,
    //                 //     'RB' => 3,
    //                 //     'RR TDK OPS' => 4,
    //                 //     'M' => 5,
    //                 //     'D' => 6,
    //                 //     default => 0,
    //                 // };
    //                 // dd((int)$asset['kondisi']);
    //                 // Prepare attachment path
    //                 $attachmentPath = null;
    //                 if (array_key_exists($key, $files) && $status != 1) {
    //                     $file = $files[$key];
    //                     $assetCodeSanitized = str_replace('/', '_', $asset['asset_code']);
    //                     $dateSuffix = date('Ymd');
    //                     $attachmentFileName = "{$assetCodeSanitized}_{$dateSuffix}." . $file->getClientOriginalExtension();
    //                     $attachmentPath = "transaction/asset/inventaris/{$attachmentFileName}";
    //                     $file->storeAs('transaction/asset/inventaris', $attachmentFileName, 'public');
    //                 }
    //                 $asset_condition = Asset::where('asset_code', $asset['asset_code'])->first();
    //                 // Create InventarisDetail
    //                 InventarisDetail::create([
    //                     'inventaris_code' => $ticketCode,
    //                     'bulan' => date('Y-m-d'),
    //                     'satgas' => $satgas,
    //                     'satgas_type' => $satgasType,
    //                     'reporter' => auth()->user()->id,
    //                     'asset_code' => $asset['asset_code'],
    //                     'kondisi' => $status,
    //                     'user_id' => auth()->user()->id,
    //                     'catatan' => $asset['catatan'] ?? $request->catatan,
    //                     'attachment' => $status == 1 ? '' : $attachmentPath, // Save attachment if provided
    //                 ]);
    //                 InventarisDetailLog::create([
    //                     'inventaris_code' => $ticketCode,
    //                     'bulan' => date('Y-m-d'),
    //                     'satgas' => $satgas,
    //                     'satgas_type' => $satgasType,
    //                     'reporter' => auth()->user()->id,
    //                     'asset_code' => $asset['asset_code'],
    //                     'kondisi' => $status,
    //                     'kondisi_saat_ini' => $asset_condition->kondisi,
    //                     'user_id' => auth()->user()->id,
    //                     'catatan' => $asset['catatan'] ?? $request->catatan,
    //                     'attachment' => $status == 1 ? '' : $attachmentPath, // Save attachment if provided
    //                 ]);
    
    //                 // Update Asset
    //                 Asset::where('asset_code', $asset['asset_code'])->update([
    //                     'kondisi' => $status,
    //                     'user_id' => auth()->user()->id,
    //                 ]);
    
    //                 // Create AssetLog
    //                 $assetDetail = Asset::where('asset_code', $asset['asset_code'])->first();
    //                 AssetLog::create([
    //                     'asset_code' => $asset['asset_code'],
    //                     'no_un' => $assetDetail->no_un ?? '',
    //                     'no_rangka' => $assetDetail->no_rangka ?? '',
    //                     'no_mesin' => $assetDetail->no_mesin ?? '',
    //                     'kategori' => $assetDetail->kategori ?? '',
    //                     'subkategori' => $assetDetail->subkategori ?? '',
    //                     'jenis' => $assetDetail->jenis ?? '',
    //                     'merk' => $assetDetail->merk ?? '',
    //                     'th_pembuatan'  => $assetDetail->th_pembuatan,
    //                     'th_operasi'    => $assetDetail->th_operasi,
    //                     'user_id' => auth()->user()->id,
    //                     'pic' => auth()->user()->id,
    //                     'kondisi' => $status,
    //                     'lokasi' => $satgas,
    //                     'remark' => $asset['catatan'],
    //                 ]);
    //             }
    //         });
    
    //         return ResponseFormatter::success(null, 'Asset berhasil ditambahkan');
    //     // } catch (\Throwable $th) {
    //     //     return ResponseFormatter::error($th->getMessage(), 'Asset gagal ditambahkan', 500);
    //     // }
    // }
    
    // function addInventaris(Request $request, StoreInventaris $storeInventaris){
    //     $storeInventaris->validated();
    //     $lastCode = Inventaris::orderBy('id', 'desc')->first();
    //     $currentMonth = idate('m');
    //     $currentYear = idate('y');
    //     $romanMonth = NumConvert::roman($currentMonth);
    //     $ticketCode = $lastCode && explode('/', $lastCode->inventaris_code)[2] === $romanMonth
    //         ? (explode('/', $lastCode->inventaris_code)[0] + 1) . "/INV/{$romanMonth}/{$currentYear}"
    //         : "1/INV/{$romanMonth}/{$currentYear}";

    //     DB::transaction(function () use ($request, $ticketCode) {
    //         $satgas = $request->satgas ?? auth()->user()->satgas;
    //         $satgasType = MasterSatgas::find($satgas)->type;
            
    //         $inventaris = Inventaris::create([
    //             'inventaris_code' => $ticketCode,
    //             'bulan' => date('Y-m-d'),
    //             'satgas' => $satgas,
    //             'satgas_type' => $satgasType,
    //             'reporter' => auth()->user()->id,
    //             'user_id' => auth()->user()->id,
    //             'catatan' => '-',
    //         ]);

    //         $assets = json_decode($request->data, true);
    //         $attachments = $request->file('attachments') ?? [];
    //         dd($request->file);
    //         foreach ($assets as $asset) {
    //             $status = (int)$asset['kondisi'];
    //             $attachmentPaths = [];
    //             $attachmentString ='';
    //             $asset_condition = Asset::where('asset_code', $asset['asset_code'])->first();
    //             dd($attachments[$asset['asset_code']]);
    //             if ((isset($attachments[$asset['asset_code']]) && $status != 1) ||
    //                 (isset($attachmentPath[$asset['asset_code']]) && $asset_condition->status !== 1 && $status === 1)){
                       
    //                 foreach ($attachments[$asset['asset_code']] as $file) {
    //                     $assetCodeSanitized = str_replace('/', '_', $asset['asset_code']);
    //                     $dateSuffix = date('YmdHis');
    //                     $fileName = "{$assetCodeSanitized}_{$dateSuffix}_" . uniqid() . '.' . $file->getClientOriginalExtension();
    //                     $filePath = "transaction/asset/inventaris/{$fileName}";
    //                     $file->storeAs('transaction/asset/inventaris', $fileName, 'public');
    //                     $attachmentPaths[] = $filePath;
    //                 }
    //                 $attachmentString = implode(',', $attachmentPaths);
    //             }
                
    //             InventarisDetail::create([
    //                 'inventaris_code' => $ticketCode,
    //                 'bulan' => date('Y-m-d'),
    //                 'satgas' => $satgas,
    //                 'satgas_type' => $satgasType,
    //                 'reporter' => auth()->user()->id,
    //                 'asset_code' => $asset['asset_code'],
    //                 'kondisi' => $status,
    //                 'user_id' => auth()->user()->id,
    //                 'catatan' => $asset['catatan'] ?? $request->catatan,
    //                 'attachment' =>$attachmentString ,
    //             ]);

    //             InventarisDetailLog::create([
    //                 'inventaris_code' => $ticketCode,
    //                 'bulan' => date('Y-m-d'),
    //                 'satgas' => $satgas,
    //                 'satgas_type' => $satgasType,
    //                 'reporter' => auth()->user()->id,
    //                 'asset_code' => $asset['asset_code'],
    //                 'kondisi' => $status,
    //                 'kondisi_saat_ini' => $asset_condition->kondisi,
    //                 'user_id' => auth()->user()->id,
    //                 'catatan' => $asset['catatan'] ?? $request->catatan,
    //                 'attachment' =>$attachmentString,
    //             ]);

    //             Asset::where('asset_code', $asset['asset_code'])->update([
    //                 'kondisi' => $status,
    //                 'user_id' => auth()->user()->id,
    //             ]);

    //             $assetDetail = Asset::where('asset_code', $asset['asset_code'])->first();
    //             AssetLog::create([
    //                 'asset_code' => $asset['asset_code'],
    //                 'no_un' => $assetDetail->no_un ?? '',
    //                 'no_rangka' => $assetDetail->no_rangka ?? '',
    //                 'no_mesin' => $assetDetail->no_mesin ?? '',
    //                 'kategori' => $assetDetail->kategori ?? '',
    //                 'subkategori' => $assetDetail->subkategori ?? '',
    //                 'jenis' => $assetDetail->jenis ?? '',
    //                 'merk' => $assetDetail->merk ?? '',
    //                 'th_pembuatan'  => $assetDetail->th_pembuatan,
    //                 'th_operasi'    => $assetDetail->th_operasi,
    //                 'user_id' => auth()->user()->id,
    //                 'pic' => auth()->user()->id,
    //                 'kondisi' => $status,
    //                 'lokasi' => $satgas,
    //                 'remark' => $asset['catatan'],
    //             ]);
    //         }
    //     });

    //     return ResponseFormatter::success(null, 'Asset berhasil ditambahkan');
    // }

    public function addInventaris(Request $request, StoreInventaris $storeInventaris)
    {
        $storeInventaris->validated();

        $lastCode = Inventaris::orderBy('id', 'desc')->first();
        $currentMonth = idate('m');
        $currentYear = idate('y');
        $romanMonth = NumConvert::roman($currentMonth);

        $ticketCode = ($lastCode && explode('/', $lastCode->inventaris_code)[2] === $romanMonth)
            ? (explode('/', $lastCode->inventaris_code)[0] + 1) . "/INV/{$romanMonth}/{$currentYear}"
            : "1/INV/{$romanMonth}/{$currentYear}";

        DB::transaction(function () use ($request, $ticketCode) {
            $satgas = $request->satgas ?? auth()->user()->satgas;
            $satgasType = MasterSatgas::find($satgas)->type;
            $inventaris = Inventaris::create([
                'inventaris_code' => $ticketCode,
                'bulan'           => date('Y-m-d'),
                'satgas'          => $satgas,
                'satgas_type'     => $satgasType,
                'reporter'        => auth()->user()->id,
                'user_id'         => auth()->user()->id,
                'catatan'         => '-',
            ]);

            $assets      = json_decode($request->input('data'), true);
            $attachments = $request->file('attachments') ?? [];
            // dd($attachments);
            foreach ($assets as $asset) {
                
                $kondisiAsset = 0;
                if($asset['kondisi'] == 'BAIK' ){
                    $kondisiAsset = 1;
                }else if($asset['kondisi'] == 'RR OPS'){
                    $kondisiAsset = 2;
                    
                }else if($asset['kondisi'] =='RB'){
                    $kondisiAsset = 3;
                    
                }else if($asset['kondisi'] == 'RR TDK OPS'){
                    $kondisiAsset = 4;
                    
                }else if($asset['kondisi'] == 'M'){
                    $kondisiAsset = 5;
                    
                }else if($asset['kondisi'] == 'D'){
                    $kondisiAsset = 6;

                }
                $status           = $kondisiAsset;
                $assetCode        = $asset['asset_code'];
                $asset_condition  = Asset::where('asset_code', $assetCode)->first();
                $attachmentPaths  = [];
                $attachmentString = '-';
               
                if (isset($attachments[$assetCode]) && is_array($attachments[$assetCode])) {
                    
                    foreach ($attachments[$assetCode] as $file) {
                        $assetCodeSanitized = str_replace('/', '_', $assetCode);
                        $dateSuffix         = date('YmdHis');
                        $fileName           = "{$assetCodeSanitized}_{$dateSuffix}_" . uniqid() . '.' . $file->getClientOriginalExtension();
                        $filePath           = "transaction/asset/inventaris/{$fileName}";
                        $file->storeAs('transaction/asset/inventaris', $fileName, 'public');
                        $attachmentPaths[] = $filePath;
                    }
                    $attachmentString = implode(',', $attachmentPaths);
                }
                
                // Insert to InventarisDetail
                InventarisDetail::create([
                    'inventaris_code' => $ticketCode,
                    'bulan'           => date('Y-m-d'),
                    'satgas'          => $satgas,
                    'satgas_type'     => $satgasType,
                    'reporter'        => auth()->user()->id,
                    'asset_code'      => $assetCode,
                    'kondisi'         => $status,
                    'user_id'         => auth()->user()->id,
                    'catatan'         => $asset['catatan'] ?? $request->catatan,
                    'attachment'      => $attachmentString,
                ]);

                // Insert to InventarisDetailLog
                InventarisDetailLog::create([
                    'inventaris_code'   => $ticketCode,
                    'bulan'             => date('Y-m-d'),
                    'satgas'            => $satgas,
                    'satgas_type'       => $satgasType,
                    'reporter'          => auth()->user()->id,
                    'asset_code'        => $assetCode,
                    'kondisi'           => $status,
                    'kondisi_saat_ini'  => $asset_condition->kondisi ?? null,
                    'user_id'           => auth()->user()->id,
                    'catatan'           => $asset['catatan'] ?? $request->catatan,
                    'attachment'        => $attachmentString,
                ]);

                $asset_condition->update([
                    'kondisi' => $status,
                    'user_id' => auth()->user()->id,
                ]);

                // Create Asset Log
                AssetLog::create([
                    'asset_code'     => $assetCode,
                    'no_un'          => $asset_condition->no_un ?? '',
                    'no_rangka'      => $asset_condition->no_rangka ?? '',
                    'no_mesin'       => $asset_condition->no_mesin ?? '',
                    'kategori'       => $asset_condition->kategori ?? '',
                    'subkategori'    => $asset_condition->subkategori ?? '',
                    'jenis'          => $asset_condition->jenis ?? '',
                    'merk'           => $asset_condition->merk ?? '',
                    'th_pembuatan'   => $asset_condition->th_pembuatan,
                    'th_operasi'     => $asset_condition->th_operasi,
                    'user_id'        => auth()->user()->id,
                    'pic'            => auth()->user()->id,
                    'kondisi'        => $status,
                    'lokasi'         => $satgas,
                    'remark'         => $asset['catatan'] ?? '-',
                ]);
            }
        });

        return ResponseFormatter::success(null, 'Asset berhasil ditambahkan');
    }
   
    function updateInventaris(Request $request, UpdateInventaris $updateInventaris)
{
    // Validate the incoming request
    $updateInventaris->validated();
    $file=null;
    // Sanitize the inventaris code
    $sanitized_ticket_code = str_replace('/', '_', $request->asset_code);

    // Handle file attachment upload
    $attachmentPath = '';
    $attachmentPathLog = '';
    $fileName = '';
    $fileNameLog = '';
    if ($request->hasFile('update_attachment')) {
        $file = $request->file('update_attachment');
        $fileNameLog = $sanitized_ticket_code . '_' . time() . '.' . $file->getClientOriginalExtension();
        $fileName = $sanitized_ticket_code.date('Ymd'). '.' . $file->getClientOriginalExtension();
        $attachmentPath = 'transaction/asset/inventaris/' . $fileName;
        $attachmentPathLog = 'transaction/asset/inventarisLog/' . $fileNameLog;
    }

    // Get Satgas type and Asset
    $asset = Asset::where('asset_code', $request->asset_code)->first();
    $detailInventaris = InventarisDetail::where('inventaris_code', $request->inventaris_code)->where('asset_code', $request->asset_code)->first();
     
    $postInventarisDetailLog = [
        'inventaris_code' => $detailInventaris->inventaris_code,
        'bulan' => $detailInventaris-> bulan,
        'satgas' => $detailInventaris->satgas,
        'satgas_type' => $detailInventaris->satgas_type,
        'reporter' => $detailInventaris->reporter,
        'asset_code' => $detailInventaris->asset_code, 
        'kondisi' => $detailInventaris->kondisi,
        'kondisi_saat_ini' => $asset->kondisi,
        'catatan' => $request->update_catatan,
        'user_id' => auth()->user()->id,
        'attachment' => $attachmentPathLog
    ];

    $postInventarisDetail = [
        'kondisi' => $request->update_kondisi,
        'catatan' => $request->update_catatan,
        'attachment' => $attachmentPath,
    ];
    $assetLog = [
        'asset_code'  => $request->asset_code,
        'no_un'       => $asset->no_un,
        'no_rangka'   => $asset->no_rangka,
        'no_mesin'    => $asset->no_mesin,
        'kategori'    => $asset->kategori,
        'subkategori' => $asset->subkategori,
        'jenis'       => $asset->jenis,
        'merk'        => $asset->merk,
        'user_id'     => auth()->user()->id,
        'pic'         => auth()->user()->id,
        'kondisi'     => $request->update_kondisi,
        'lokasi'      => $asset->lokasi,
        'th_operasi' => $asset->th_operasi,
        'th_pembuatan' => $asset->th_pembuatan,
        'remark'     => auth()->user()->name . ' telah update kondisi aset',
    ];

    // Data for the asset update
    $assetPost = [
        'kondisi' => $request->update_kondisi,
        'user_id' => auth()->user()->id,
        'lokasi'  => $asset->lokasi,
    ];
    // dd($request->hasFile('update_attachment'));
    DB::transaction(function () use ($request, $postInventarisDetail, $postInventarisDetailLog, $assetPost, $asset, $assetLog, $file, $fileName,$fileNameLog) {
  

        // Insert data into the respective tables
        InventarisDetail::where('inventaris_code',$request->inventaris_code)->where('asset_code', $request->asset_code)->update($postInventarisDetail);
        InventarisDetailLog::create($postInventarisDetailLog);
        Asset::where('asset_code', $request->asset_code)->update($assetPost);
        AssetLog::create($assetLog);
        if ($request->hasFile('update_attachment')) {
            // Store file in the specified directories
            $oldFilePath = 'public/transaction/asset/inventaris/' . $fileName;

            // Check if the old file exists
            if (Storage::exists($oldFilePath)) {
                Storage::delete($oldFilePath); // Delete the old file
            }
        
            // Store the new file
            $file->storeAs('transaction/asset/inventaris', $fileName, 'public');
            $file->storeAs('transaction/asset/inventarisLog', $fileNameLog, 'public');
        }
    });

    return ResponseFormatter::success(
        $postInventarisDetail,
        'Asset berhasil ditambahkan'
    );
}

}
