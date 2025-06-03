<?php

namespace App\Http\Controllers\Transaction\Asset;

use App\Exports\AssetExport;
use App\Helper\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Master\Asset;
use App\Models\Master\MasterAsset;
use App\Models\Setting\MasterSatgas;
use App\Models\Transaction\Asset\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\Mpdf;
\Carbon\Carbon::setLocale('id');
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

            $kondisi = match ($request->kondisi) {
                "BAIK" => 1,
                "RR OPS" => 2,
                "RB" => 3,
                "RR TDK OPS" => 4,
                "M" => 5,
                "D" => 6,
                default => 0,
            };

            $data = Asset::query()
                ->leftJoin('inventory_categories', 'assets.kategori', '=', 'inventory_categories.id')
                ->leftJoin('inventory_sub_categories', 'assets.subkategori', '=', 'inventory_sub_categories.id')
                ->leftJoin('inventory_types', 'assets.jenis', '=', 'inventory_types.id')
                ->leftJoin('inventory_brands', 'assets.merk', '=', 'inventory_brands.id')
                ->leftJoin('master_satgas', 'assets.lokasi', '=', 'master_satgas.id')
                ->with([
                    'detailInventarisRelation',
                    'distribusiRelation',
                ])
                ->select(
                    'assets.*',
                    'inventory_categories.name as category_name',
                    'inventory_sub_categories.name as subcategory_name',
                    'inventory_types.name as type_name',
                    'inventory_brands.name as merk_name',
                    'master_satgas.name as satgas_name',
                    'master_satgas.type as satgas_type',
                    DB::raw('(SELECT remark FROM asset_logs WHERE asset_logs.asset_code = assets.asset_code ORDER BY created_at DESC LIMIT 1) AS latest_remark'),
                    DB::raw('(SELECT created_at FROM asset_logs WHERE asset_logs.asset_code = assets.asset_code ORDER BY created_at DESC LIMIT 1) AS latest_update'),
                );

            if ($kondisi != 0) {
                $data->where('assets.kondisi', $kondisi);
            }

            if (!empty($request->type)) {
                $data->where('master_satgas.type', $request->type);
            }

            if (!empty($request->th_operasi)) {
                if ($request->th_operasi == "1") {
                    $data->whereBetween('assets.th_operasi', [$currentYear - 4, $currentYear]);
                } elseif ($request->th_operasi == "2") {
                    $data->whereBetween('assets.th_operasi', [$currentYear - 10, $currentYear - 5]);
                } elseif ($request->th_operasi == "3") {
                    $data->where('assets.th_operasi', '<', $currentYear - 10);
                }
            }

            if (!empty($request->th_pembuatan)) {
                if ($request->th_pembuatan == "1") {
                    $data->whereBetween('assets.th_pembuatan', [$currentYear - 4, $currentYear]);
                } elseif ($request->th_pembuatan == "2") {
                    $data->whereBetween('assets.th_pembuatan', [$currentYear - 10, $currentYear - 5]);
                } elseif ($request->th_pembuatan == "3") {
                    $data->where('assets.th_pembuatan', '<', $currentYear - 10);
                }
            }

            return DataTables::of($data)
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

    function printAssetDashboard($type,$kondisi,$th_operasi,$th_pembuatan,$format) {
        
        $currentYear = date('Y');
                // Konversi kondisi ke angka
                $kondisi = match ($kondisi) {
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
                ->leftJoin('inventory_categories', 'assets.kategori', '=', 'inventory_categories.id')
                ->leftJoin('inventory_sub_categories', 'assets.subkategori', '=', 'inventory_sub_categories.id')
                ->leftJoin('inventory_types', 'assets.jenis', '=', 'inventory_types.id')
                ->leftJoin('inventory_brands', 'assets.merk', '=', 'inventory_brands.id')
                ->leftJoin('master_satgas', 'assets.lokasi', '=', 'master_satgas.id')
                ->with([
                    'detailInventarisRelation',
                    'distribusiRelation',
                ])
                ->select(
                    'assets.*',
                    'inventory_categories.name as category_name',
                    'inventory_sub_categories.name as subcategory_name',
                    'inventory_types.name as type_name',
                    'inventory_brands.name as merk_name',
                    'master_satgas.name as satgas_name',
                    'master_satgas.type as satgas_type',
                    DB::raw('(SELECT remark FROM asset_logs WHERE asset_logs.asset_code = assets.asset_code ORDER BY created_at DESC LIMIT 1) AS latest_remark'),
                );
                  
                if($kondisi != 0){
                    $data->where('assets.kondisi', $kondisi);
                }
             
                // **Filter berdasarkan SatgasRelation**
                if ($type !== '*') {
                    $data->where(function ($q) use ($type) {
                        $q->whereRaw('master_satgas.type = ?', [$type]);
                    });
                }
                            
        
                // **Filter Tahun Operasi (th_operasi)**
                if ($th_operasi !== '*') {
                    if ($th_operasi == "1") {
                        $data->whereBetween('assets.th_operasi', [$currentYear - 4, $currentYear]);
                    } elseif ($th_operasi == "2") {
                        $data->whereBetween('assets.th_operasi', [$currentYear - 10, $currentYear - 5]);
                    } elseif ($th_operasi == "3") {
                        $data->where('assets.th_operasi', '<', $currentYear - 10);
                    }
                }
        
                // **Filter Tahun Pembuatan (th_pembuatan)**
                if ($th_pembuatan !== '*') {
                    if ($th_pembuatan == "1") {
                        $data->whereBetween('assets.th_pembuatan', [$currentYear - 4, $currentYear]);
                    } elseif ($th_pembuatan == "2") {
                        $data->whereBetween('assets.th_pembuatan', [$currentYear - 10, $currentYear - 5]);
                    } elseif ($th_pembuatan == "3") {
                        $data->where('assets.th_pembuatan', '<', $currentYear - 10);
                    }
                }

                $parameter = [];

                if (!empty($type) && $type !== '*') {
                    $parameter[] = 'Satgas: ' . $type;
                }

                $kondisiMap = [
                    1 => 'BAIK',
                    2 => 'RR OPS',
                    3 => 'RB',
                    4 => 'RR TDK OPS',
                    5 => 'M',
                    6 => 'D'
                ];

                if ($kondisi != 0) {
                    $parameter[] = 'Kondisi: ' . ($kondisiMap[$kondisi] ?? 'Tidak Diketahui');
                }

                if (!empty($th_operasi) && $th_operasi !== '*') {
                    $label = match ($th_operasi) {
                        '1' => '0 - 4 Tahun',
                        '2' => '5 - 10 Tahun',
                        '3' => '> 10 Tahun',
                        default => ''
                    };
                    $parameter[] = 'Tahun Operasi: ' . $label;
                }

                if (!empty($th_pembuatan) && $th_pembuatan !== '*') {
                    $label = match ($th_pembuatan) {
                        '1' => '0 - 4 Tahun',
                        '2' => '5 - 10 Tahun',
                        '3' => '> 10 Tahun',
                        default => ''
                    };
                    $parameter[] = 'Tahun Pembuatan: ' . $label;
                }


            $filteredData = $data->get();
            
            if ($format === 'pdf') {
                $imageLogo          = '<img src="'.public_path('logo.png').'" width="50px" style="float: right;"/>';
                $header             = '';
                $header             .= '<table width="100%">
                                            <tr>
                                                <td style="padding-left:10px;">
                                                    <span style="font-size: 16px; font-weight: bold;"> SYSINFOLOG OPPD</span>
                                                    <br>
                                                    <span style="font-size:9px;">Mako PMPP Sentul, FV8J+XCP, Tangkil, Kec. Citeureup, Kabupaten Bogor, Jawa Barat 16810</span>
                                                </td>
                                                <td style="width:33%"></td>
                                                    <td style="width: 50px; text-align:right;">'.$imageLogo.'
                                                </td>
                                            </tr>
                                        </table>
                                        <hr>';
                
                $footer             = '<hr>
                                        <table width="100%" style="font-size: 10px;">
                                            <tr>
                                                <td width="90%" align="left"><b>Disclaimer</b><br>this document is strictly private, confidential and personal to recipients and should not be copied, distributed or reproduced in whole or in part, not passed to any third party.</td>
                                                <td width="10%" style="text-align: right;"> {PAGENO}</td>
                                            </tr>
                                        </table>';

                $html = view('report.asset.report_dashboard-asset', ['data' => $filteredData ,  'title' => 'Report Asset', 'parameter' => $parameter,'date'    => date('Y-m-d H:i:s')])->render();
                $mpdf = new \Mpdf\Mpdf();
                $mpdf->SetHTMLHeader($header);
                $mpdf->SetHTMLFooter($footer);
                $mpdf->AddPage(
                    'L', // L - landscape, P - portrait 
                    '',
                    '',
                    '',
                    '',
                    5, // margin_left
                    5, // margin right
                    25, // margin top
                    20, // margin bottom
                    5, // margin header
                    5
                ); // margin footer
                $mpdf->WriteHTML($html);
                $pdfOutput = $mpdf->Output('Report Aset'.'('.date('Y-m-d').').pdf', 'I');
                ob_clean();
               
                return response($pdfOutput, 200)
                    ->header('Content-Type', 'application/pdf');
            } elseif ($format === 'excel') {
                return Excel::download(new AssetExport($filteredData), 'asset-export.xlsx');
            }
          
        
    }
}
