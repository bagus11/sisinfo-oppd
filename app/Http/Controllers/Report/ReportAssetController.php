<?php

namespace App\Http\Controllers\Report;

use App\Exports\AssetCategoryExport;
use App\Exports\AssetExport;
use App\Exports\AssetKondisiExport;
use App\Http\Controllers\Controller;
use App\Models\Master\Asset;
use App\Models\Master\AssetLog;
use App\Models\Master\MasterAsset;
use App\Models\Setting\MasterSatgas;
use App\Models\Transaction\Asset\Inventaris;
use App\Models\Transaction\Asset\InventarisDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use \Mpdf\Mpdf as PDF;
use Yajra\DataTables\Facades\DataTables;

class ReportAssetController extends Controller
{
    function index() {
        return view('report.asset.report_asset-index');
    }
    function getAssetPivot(Request $request) {
        if(auth()->user()->hasPermissionTo('get-except_satgas-master_asset')){
            $categories = Asset::join('master_satgas', 'assets.lokasi', '=', 'master_satgas.id')->where('master_satgas.type','like', '%'.$request->type.'%')
            ->pluck('master_satgas.type')
            ->unique()
            ->values();

            // Fetch asset data grouped by category and satgas type
            $data = Asset::selectRaw('inventory_categories.name as category_name, COUNT(*) as total, master_satgas.type as satgas_type')
                ->join('inventory_categories', 'assets.kategori', '=', 'inventory_categories.id')
                ->join('master_satgas', 'assets.lokasi', '=', 'master_satgas.id')
                ->where('master_satgas.type','like', '%'.$request->type.'%')
                ->groupBy('inventory_categories.name', 'master_satgas.type')
                ->get()
                ->groupBy(fn($asset) => $asset->category_name ?? 'Unknown'); // Fix grouping key

            // Transform the grouped data into a pivot format
            $pivotData = [];
            foreach ($data as $categoryName => $assets) {
                $row = ['category' => $categoryName]; // Row title
                foreach ($categories as $satgas) {
                    $row[$satgas] = 0; // Initialize all category columns with 0
                }
                foreach ($assets as $asset) {
                    $row[$asset->satgas_type] = $asset->total; // Fill total count
                }
                $pivotData[] = $row;
            }
        }else{
            $type = MasterSatgas::find(auth()->user()->satgas);
            $categories = Asset::join('master_satgas', 'assets.lokasi', '=', 'master_satgas.id')->where('master_satgas.type', $type->type)
            ->pluck('master_satgas.type')
            ->unique()
            ->values();

            // Fetch asset data grouped by category and satgas type
            $data = Asset::selectRaw("
                            COALESCE(inventory_categories.name, 'Unknown') as category_name, 
                            COUNT(*) as total, 
                            master_satgas.type as satgas_type
                        ")
                        ->leftJoin('inventory_categories', 'assets.kategori', '=', 'inventory_categories.id')
                        ->join('master_satgas', 'assets.lokasi', '=', 'master_satgas.id')
                        ->where('master_satgas.type', $type->type)
                        ->groupBy('category_name', 'master_satgas.type')
                        ->get()
                        ->groupBy('category_name'); // Sudah pasti tidak ada null
    

            // Transform the grouped data into a pivot format
            $pivotData = [];
            foreach ($data as $categoryName => $assets) {
                $row = ['category' => $categoryName]; // Row title
                foreach ($categories as $satgas) {
                    $row[$satgas] = 0; // Initialize all category columns with 0
                }
                foreach ($assets as $asset) {
                    $row[$asset->satgas_type] = $asset->total; // Fill total count
                }
                $pivotData[] = $row;
            }
        }
           

            return response()->json([
                'columns' => $categories,
                'data' => $pivotData
            ]);
    }
    function printInventarisDetail($id) {
        try {
            ini_set('memory_limit', '1024M');
                $inventaris_code = str_replace('_','/', $id);
                $head   = Inventaris::with([
                    'satgasRelation'
                ])->where('inventaris_code', $inventaris_code)->first();
                $child  = InventarisDetail::with([
                    'assetRelation',
                    'assetRelation.categoryRelation',
                    'assetRelation.subCategoryRelation',
                    'assetRelation.typeRelation',
                    'assetRelation.merkRelation',
                    'satgasRelation',
                    'reporterRelation',
                    'userRelation',
                ])->where('inventaris_code', $inventaris_code)->get();
                $summary = InventarisDetail::select('inventaris_code', DB::raw('count(*) as total'),'kondisi')
                ->groupBy('kondisi','inventaris_code')
                ->get();
            
                $data = [
                    'head' => $head,
                    'child' => $child,
                    'summary' => $summary,
                    'id' => $inventaris_code,
                    
                ];
        
                        $cetak              = view('report.asset.inventaris.inventaris_detail-report',$data);
                        $imageLogo          = '<img src="'.public_path('logo.png').'" width="50px" style="float: right;"/>';
                        $header             = '';
                        $header             .= '<table width="100%">
                                                    <tr>
                                                        <td style="padding-left:10px;">
                                                            <span style="font-size: 16px; font-weight: bold;"> SYSINFO OPPD</span>
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
            
                          
                            $mpdf           = new PDF();
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
                            $mpdf->WriteHTML($cetak);
                            // Output a PDF file directly to the browser
                            ob_clean();
                            $mpdf->Output('Report Wo'.'('.date('Y-m-d').').pdf', 'I');

        } catch (\Mpdf\MpdfException $e) {
            // Process the exception, log, print etc.
            echo $e->getMessage();
        }
    }
    function printDetailAsset($id) {
        try {
                $asset_code = str_replace('_','/', $id);
                $head = Asset::with([
                    'categoryRelation',
                    'subCategoryRelation',
                    'typeRelation',
                    'merkRelation',
                    'satgasRelation',
                ])->where('asset_code', $asset_code)->first();

                $child =AssetLog::with([
                    'picRelation',
                    'categoryRelation',
                    'subCategoryRelation',
                    'typeRelation',
                    'merkRelation',
                    'satgasRelation',
                ])->where('asset_code', $asset_code)->orderBy('id','desc')->get();
                
                $data = [
                    'child' => $child,
                    'head' => $head,
                    'id' => $asset_code,
                ];

                        $cetak              = view('report.asset.master_asset.master_asset_detail-report',$data);
                        $imageLogo          = '<img src="'.public_path('logo.png').'" width="50px" style="float: right;"/>';
                        $header             = '';
                        $header             .= '<table width="100%">
                                                    <tr>
                                                        <td style="padding-left:10px;">
                                                            <span style="font-size: 16px; font-weight: bold;"> SYSINFO OPPD</span>
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
            
                        
                            $mpdf           = new PDF();
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
                            $mpdf->WriteHTML($cetak);
                            // Output a PDF file directly to the browser
                            ob_clean();
                            $mpdf->Output('Report Wo'.'('.date('Y-m-d').').pdf', 'I');

        } catch (\Mpdf\MpdfException $e) {
            // Process the exception, log, print etc.
            echo $e->getMessage();
        }
    }
    function exportAsset(Request $request) {
        // Get parameters from the request
        $type = $request->query('type');
        $kondisi = $request->query('kondisi');

        // Build the query
        if(auth()->user()->hasPermissionTo('get-except_satgas-master_asset')){
            $query = Asset::query()
            ->leftJoin('master_satgas', 'assets.lokasi', '=', 'master_satgas.id')
            ->with([
                'categoryRelation',
                'subCategoryRelation',
                'typeRelation',
                'merkRelation',
                'satgasRelation'
            ])
            ->where(function ($q) use ($type) {
                if (!empty($type)) {
                    $q->where('master_satgas.type', 'like', '%' . $type . '%');
                }
            })
            ->where('assets.kondisi', 'like', '%' . $kondisi . '%')
            ->select('assets.*');
        }else{
            $type = MasterSatgas::find(auth()->user()->lokasi);
            $query = Asset::query()
            ->leftJoin('master_satgas', 'assets.lokasi', '=', 'master_satgas.id')
            ->with([
                'categoryRelation',
                'subCategoryRelation',
                'typeRelation',
                'merkRelation',
                'satgasRelation'
            ])
            ->where(function ($q) use ($type) {

                if (!empty($type)) {
                    $q->where('master_satgas.type', $type->type);
                }
            })
            ->where('assets.kondisi', 'like', '%' . $kondisi . '%')
            ->select('assets.*');
        }
    
        // Get the filtered assets
        $assets = $query->get();
        // Return the export (replace AssetsExport with your export class)
        return Excel::download(new AssetExport($assets), 'ReportMasterAsset '.date('d F Y').'.xlsx');
    }
    function exportAssetCategoryPDF(Request $request)
    {
        ini_set('max_execution_time', 720);
        $chartBase64 = $request->input('chart'); // Base64 Horizontal Bar Chart
       
        // Check if the user has permission
        if(auth()->user()->hasPermissionTo('get-except_satgas-master_asset')) {
            $categories = Asset::join('master_satgas', 'assets.lokasi', '=', 'master_satgas.id')
                                    ->when(!empty($request->type), function ($q) use ($request) {
                                        $q->where('master_satgas.type', $request->type);
                                    })
                                    ->pluck('master_satgas.type')
                                    ->unique()
                                    ->values();
    
            // Fetch asset data grouped by category and satgas type
            $asset_category = Asset::selectRaw('inventory_categories.name as category_name, COUNT(*) as total, master_satgas.type as satgas_type')
                ->join('inventory_categories', 'assets.kategori', '=', 'inventory_categories.id')
                ->join('master_satgas', 'assets.lokasi', '=', 'master_satgas.id')
                ->when(!empty($request->type), function ($q) use ($request) {
                    $q->where('master_satgas.type', $request->type);
                })
                ->groupBy('inventory_categories.name', 'master_satgas.type')
                ->get()
                ->groupBy(fn($asset) => $asset->category_name ?? 'Unknown');
            $child = Asset::query()
                ->join('master_satgas', 'assets.lokasi', '=', 'master_satgas.id')
                ->with([
                    'categoryRelation',
                    'subCategoryRelation',
                    'typeRelation',
                    'merkRelation',
                    'satgasRelation'
                ])
                ->when(!empty($request->type), function ($q) use ($request) {
                    $q->where('master_satgas.type', $request->type);
                })
                ->select('assets.*')
                ->get();
                // dd(count($child));
        } else {
            $type = MasterSatgas::find(auth()->user()->satgas);
            $categories = Asset::join('master_satgas', 'assets.lokasi', '=', 'master_satgas.id')
                ->where('master_satgas.type', $type->type)
                ->pluck('master_satgas.type')
                ->unique()
                ->values();
    
            // Fetch asset data for a specific satgas type
            $asset_category = Asset::selectRaw("
                                COALESCE(inventory_categories.name, 'Unknown') as category_name, 
                                COUNT(*) as total, 
                                master_satgas.type as satgas_type
                            ")
                            ->leftJoin('inventory_categories', 'assets.kategori', '=', 'inventory_categories.id')
                            ->join('master_satgas', 'assets.lokasi', '=', 'master_satgas.id')
                            ->where('master_satgas.type', $type->type)
                            ->groupBy('category_name', 'master_satgas.type')
                            ->get()
                            ->groupBy('category_name');
            $child = Asset::query()
                            ->leftJoin('master_satgas', 'assets.lokasi', '=', 'master_satgas.id')
                            ->with([
                                'categoryRelation',
                                'subCategoryRelation',
                                'typeRelation',
                                'merkRelation',
                                'satgasRelation'
                            ])->where('master_satgas.type', $type->type)
                            ->select('assets.*')->get();
        }
    
        // Transform data to pivot format
        $pivotData = [];
        foreach ($asset_category as $categoryName => $assets) {
            $row = ['category' => $categoryName]; // Row title
            foreach ($categories as $satgas) {
                $row[$satgas] = 0; // Initialize all columns with 0
            }
            foreach ($assets as $asset) {
                $row[$asset->satgas_type] = $asset->total ?? 0; // Set total to 0 if null
            }
            $pivotData[] = $row;
        }
    
        // Prepare data for the view
        $data = [
            'title' => 'Report Asset by Category',
            'data'  => $pivotData, // Pass pivotData instead of asset_category
            'date' => now()->format('d F Y'),
            'chartBase64' => $chartBase64, 
            'child' => $child, 
        ];
        $imageLogo          = '<img src="'.public_path('logo.png').'" width="50px" style="float: right;"/>';
        $header             = '';
        $header             .= '<table width="100%">
                                    <tr>
                                        <td style="padding-left:10px;">
                                            <span style="font-size: 16px; font-weight: bold;"> SYSINFO OPPD</span>
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

        // Render the HTML for the PDF
        $html = view('report.asset.master_asset.asset_category-report', $data)->render();
    
        // Generate PDF using mPDF
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
        $pdfOutput = $mpdf->Output('Report Kategori Aset'.'('.date('Y-m-d').').pdf', 'I');
        ob_clean();
       
        return response($pdfOutput, 200)
            ->header('Content-Type', 'application/pdf');
    }
    function exportAssetCategory() {
        if (auth()->user()->hasPermissionTo('get-except_satgas-master_asset')) {
            $categories = Asset::join('master_satgas', 'assets.lokasi', '=', 'master_satgas.id')
                ->pluck('master_satgas.type')
                ->unique()
                ->values();
        
            // Fetch asset data grouped by category and satgas type
            $asset_category = Asset::selectRaw('
                COALESCE(inventory_categories.name, "Unknown") as category_name, 
                COALESCE(COUNT(*), 0) as total, 
                master_satgas.type as satgas_type
            ')
            ->join('inventory_categories', 'assets.kategori', '=', 'inventory_categories.id')
            ->join('master_satgas', 'assets.lokasi', '=', 'master_satgas.id')
            ->groupBy('inventory_categories.name', 'master_satgas.type')
            ->get()
            ->groupBy(fn($asset) => $asset->category_name ?? 'Unknown');
        } else {
            $type = MasterSatgas::find(auth()->user()->satgas);
            $categories = Asset::join('master_satgas', 'assets.lokasi', '=', 'master_satgas.id')
                ->where('master_satgas.type', $type->type)
                ->pluck('master_satgas.type')
                ->unique()
                ->values();
        
            // Fetch asset data for a specific satgas type
            $asset_category = Asset::selectRaw("
                COALESCE(inventory_categories.name, 'Unknown') as category_name, 
                COALESCE(COUNT(*), 0) as total, 
                master_satgas.type as satgas_type
            ")
            ->leftJoin('inventory_categories', 'assets.kategori', '=', 'inventory_categories.id')
            ->join('master_satgas', 'assets.lokasi', '=', 'master_satgas.id')
            ->where('master_satgas.type', $type->type)
            ->groupBy('category_name', 'master_satgas.type')
            ->get()
            ->groupBy('category_name');
        }
        
        // After fetching the data, process it like this:
        $pivotData = [];
        foreach ($asset_category as $categoryName => $assets) {
            $row = ['category' => $categoryName];
            foreach ($categories as $satgas) {
                $row[$satgas] = 0; // Initialize with 0
            }
            foreach ($assets as $asset) {
                $row[$asset->satgas_type] = $asset->total ?? 0; // Replace null with 0
            }
            $pivotData[] = $row;
        }
    
        // Trigger the Excel export
        return Excel::download(new AssetCategoryExport($categories, $asset_category), 'asset_category_report.xlsx');
    }
    
    public function getAssetKondisi(Request $request)
    {
        // Ambil data dengan query yang telah disesuaikan
        $data = DB::table('assets as a')
                ->select(DB::raw('b.type as satgas, a.kondisi, COUNT(a.id) AS total'))
                ->join('master_satgas as b', 'a.lokasi', '=', 'b.id')
                ->when(!empty($request->type), function ($q) use ($request) {
                    $q->where('b.type', $request->type);
                })
                ->groupBy('b.type', 'a.kondisi')
                ->get();
    
        // Struktur data yang akan dikirimkan
        $kondisiMapping = [
            1 => 'BAIK',
            2 => 'RR OPS',
            3 => 'RB',
            4 => 'RR TDK OPS',
            5 => 'M',
            6 => 'D'
        ];
    
        // Memetakan data berdasarkan kondisi
        $responseData = [];
    
        foreach ($data as $item) {
            $kondisi = $kondisiMapping[$item->kondisi] ?? 'Unknown';  // Mapping kondisi
            if (!isset($responseData[$kondisi])) {
                $responseData[$kondisi] = [];
            }
            $responseData[$kondisi][$item->satgas] = $item->total;
        }
    
        // Format data untuk dikirimkan ke frontend
        $columns = array_keys($responseData[array_key_first($responseData)]);  // Mengambil satgas yang ada
    
        // Menyusun data dan kolom untuk respons JSON
        $response = [
            'columns' => $columns,
            'data' => [],
            'chart'=> $data
        ];
    
        // Membuat data baris berdasarkan kondisi
        foreach ($responseData as $kondisi => $satgasData) {
            $row = ['category' => $kondisi];  // Menyimpan kategori berdasarkan kondisi
            foreach ($columns as $satgas) {
                $row[$satgas] = $satgasData[$satgas] ?? 0;  // Mengisi nilai berdasarkan satgas, default 0
            }
            $response['data'][] = $row;
        }
    
        return response()->json($response);  // Mengirimkan response dalam format JSON
    }

    function exportAssetKondisiPDF(Request $request) {
        ini_set('max_execution_time', 720);
        $chartBase64 = $request->input('chart'); // Base64 Horizontal Bar Chart
        $kondisiMapping = [
            1 => 'BAIK',
            2 => 'RR OPS',
            3 => 'RB',
            4 => 'RR TDK OPS',
            5 => 'M',
            6 => 'D'
        ];
    
        // Check if the user has permission
        if (auth()->user()->hasPermissionTo('get-except_satgas-master_asset')) {
            $data = DB::table('assets as a')
                ->select(DB::raw('b.type as satgas, a.kondisi, COUNT(a.id) AS total'))
                ->join('master_satgas as b', 'a.lokasi', '=', 'b.id')
                ->when(!empty($request->type), function ($q) use ($request) {
                    $q->where('b.type', $request->type);
                })
                ->groupBy('b.type', 'a.kondisi')
                ->get();
            $child = Asset::query()
                ->join('master_satgas', 'assets.lokasi', '=', 'master_satgas.id')
                ->with([
                    'categoryRelation',
                    'subCategoryRelation',
                    'typeRelation',
                    'merkRelation',
                    'satgasRelation'
                ])
                ->when(!empty($request->type), function ($q) use ($request) {
                    $q->where('master_satgas.type', $request->type);
                })
                ->select('assets.*')
                ->get();
        } else {
            $type = MasterSatgas::find(auth()->user()->satgas);
            $data = DB::table('assets as a')
                ->select(DB::raw('b.type as satgas, a.kondisi, COUNT(a.id) AS total'))
                ->join('master_satgas as b', 'a.lokasi', '=', 'b.id')
                ->where('master_satgas.type', $type->type)
                ->groupBy('b.type', 'a.kondisi')
                ->get();
            $child = Asset::query()
                ->join('master_satgas', 'assets.lokasi', '=', 'master_satgas.id')
                ->with([
                    'categoryRelation',
                    'subCategoryRelation',
                    'typeRelation',
                    'merkRelation',
                    'satgasRelation'
                ])
                ->where('master_satgas.type', $type->type)
                ->select('assets.*')
                ->get();
        }
    
        $responseData = [];
        // Transform data to pivot format
        foreach ($data as $item) {
            $kondisi = $kondisiMapping[$item->kondisi] ?? 'Unknown';  // Mapping kondisi
            if (!isset($responseData[$kondisi])) {
                $responseData[$kondisi] = [];
            }
            $responseData[$kondisi][$item->satgas] = $item->total;
        }
    
        // Format data untuk dikirimkan ke frontend
        $columns = array_keys($responseData[array_key_first($responseData)]);  // Mengambil satgas yang ada
    
        // Menyusun data dan kolom untuk respons JSON
        $response = [
            'columns' => $columns,
            'data' => [],
            'chart' => $data,
           
        ];
    
        // Membuat data baris berdasarkan kondisi
        foreach ($responseData as $kondisi => $satgasData) {
            $row = ['category' => $kondisi];  // Menyimpan kategori berdasarkan kondisi
            foreach ($columns as $satgas) {
                $row[$satgas] = $satgasData[$satgas] ?? 0;  // Mengisi nilai berdasarkan satgas, default 0
            }
            $response['data'][] = $row;
        }
    
        // Prepare data for the view
        $data = [
            'title' => 'Report Asset by Category',
            'data'  => $response['data'], // Pass data for asset category table
            'date' => now()->format('d F Y'),
            'chartBase64' => $chartBase64, // Pass base64 chart to the view
            'child' => $child,
        ];
    
        $imageLogo = '<img src="' . public_path('logo.png') . '" width="50px" style="float: right;"/>';
        $header = '';
        $header .= '<table width="100%">
                        <tr>
                            <td style="padding-left:10px;">
                                <span style="font-size: 16px; font-weight: bold;"> SYSINFO OPPD</span>
                                <br>
                                <span style="font-size:9px;">Mako PMPP Sentul, FV8J+XCP, Tangkil, Kec. Citeureup, Kabupaten Bogor, Jawa Barat 16810</span>
                            </td>
                            <td style="width:33%"></td>
                            <td style="width: 50px; text-align:right;">' . $imageLogo . '</td>
                        </tr>
                    </table>
                    <hr>';
    
        $footer = '<hr>
                    <table width="100%" style="font-size: 10px;">
                        <tr>
                            <td width="90%" align="left"><b>Disclaimer</b><br>this document is strictly private, confidential and personal to recipients and should not be copied, distributed or reproduced in whole or in part, not passed to any third party.</td>
                            <td width="10%" style="text-align: right;">{PAGENO}</td>
                        </tr>
                    </table>';
    
        // Render the HTML for the PDF
        $html = view('report.asset.master_asset.asset_kondisi-report', $data)->render();
    
        // Generate PDF using mPDF
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
            5 // margin footer
        ); // margin footer
    
        // Menambahkan chart yang dikirim dalam format base64
        $chartImage = '<img src="' . $chartBase64 . '" style="width:100%; height:auto; margin-top:20px;"/>';
    
        // Menambahkan chart ke dalam PDF
        $mpdf->WriteHTML($html);
        // $mpdf->WriteHTML($chartImage); // Menambahkan chart
    
        // Output the generated PDF
        $pdfOutput = $mpdf->Output('Report Kategori Aset' . '(' . date('Y-m-d') . ').pdf', 'I');
        ob_clean();
    
        return response($pdfOutput, 200)
            ->header('Content-Type', 'application/pdf');
    }

    function exportAssetKondisi() {
        $kondisiMapping = [
            1 => 'BAIK',
            2 => 'RR OPS',
            3 => 'RB',
            4 => 'RR TDK OPS',
            5 => 'M',
            6 => 'D'
        ];
    
        // Fetch data from the database
        if (auth()->user()->hasPermissionTo('get-except_satgas-master_asset')) {
            $data = DB::table('assets as a')
                ->select(DB::raw('b.type as satgas, a.kondisi, COUNT(a.id) AS total'))
                ->join('master_satgas as b', 'a.lokasi', '=', 'b.id')
                ->groupBy('b.type', 'a.kondisi')
                ->get();
        } else {
            $type = MasterSatgas::find(auth()->user()->satgas);
            $data = DB::table('assets as a')
                ->select(DB::raw('b.type as satgas, a.kondisi, COUNT(a.id) AS total'))
                ->join('master_satgas as b', 'a.lokasi', '=', 'b.id')
                ->where('master_satgas.type', $type->type)
                ->groupBy('b.type', 'a.kondisi')
                ->get();
        }
    
        $responseData = [];
        // Transform data to pivot format
        foreach ($data as $item) {
            $kondisi = $kondisiMapping[$item->kondisi] ?? 'Unknown';  // Mapping kondisi
            if (!isset($responseData[$kondisi])) {
                $responseData[$kondisi] = [];
            }
            $responseData[$kondisi][$item->satgas] = $item->total;
        }
    
        // Menyusun data dan kolom untuk respons JSON
        $columns = array_keys($responseData[array_key_first($responseData)]);  // Mengambil satgas yang ada
    
        // Membuat data baris berdasarkan kondisi
        $response = [
            'columns' => $columns,
            'data' => [],
        ];
    
        foreach ($responseData as $kondisi => $satgasData) {
            $row = ['category' => $kondisi];  // Menyimpan kategori berdasarkan kondisi
            foreach ($columns as $satgas) {
                $row[$satgas] = $satgasData[$satgas] ?? 0;  // Mengisi nilai berdasarkan satgas, default 0
            }
            $response['data'][] = $row;
        }
    
        // Ekspor ke Excel
        return Excel::download(new AssetKondisiExport($response), 'Asset_Kondisi_Report.xlsx');
    }
    
    function getCategoryFilter(Request $request) {
        if ($request->ajax()) {
            // dd($request);
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
            ->whereHas('categoryRelation', function ($query) use ($request) {
                if (!empty($request->category)) {
                    $query->where('name', $request->category);
                }
            })
            ->where(function ($q) use ($kondisi) {
                if ($kondisi !== 0) {
                    $q->where('assets.kondisi', $kondisi);
                }
            })
            ->select('assets.*')
            ->get();
            return DataTables::of($data)->make(true);
        }
    
        return abort(403, 'Unauthorized action.');
    }
}
