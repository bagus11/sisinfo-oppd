<?php

namespace App\Http\Controllers\Report;

use App\Exports\AssetCategoryExport;
use App\Exports\AssetExport;
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
class ReportAssetController extends Controller
{
    function index() {
        return view('report.asset.report_asset-index');
    }
    function getAssetPivot() {
        if(auth()->user()->hasPermissionTo('get-except_satgas-master_asset')){
            $categories = Asset::join('master_satgas', 'assets.lokasi', '=', 'master_satgas.id')
            ->pluck('master_satgas.type')
            ->unique()
            ->values();

            // Fetch asset data grouped by category and satgas type
            $data = Asset::selectRaw('inventory_categories.name as category_name, COUNT(*) as total, master_satgas.type as satgas_type')
                ->join('inventory_categories', 'assets.kategori', '=', 'inventory_categories.id')
                ->join('master_satgas', 'assets.lokasi', '=', 'master_satgas.id')
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
    public function exportAssetCategoryPDF(Request $request)
    {
        // Ambil chart dalam format Base64 dari request
        $chartBase64 = $request->input('chart'); 
    
        // 1️⃣ **Validasi Base64 Chart**
        if (empty($chartBase64) || !preg_match('/^data:image\/(png|jpeg|jpg);base64,/', $chartBase64)) {
            return response()->json(['error' => 'Invalid or missing chart image'], 400);
        }
    
        // 2️⃣ **Cek Permission User**
        if(auth()->user()->hasPermissionTo('get-except_satgas-master_asset')) {
            $categories = Asset::join('master_satgas', 'assets.lokasi', '=', 'master_satgas.id')
                ->pluck('master_satgas.type')
                ->unique()
                ->values();
    
            // Fetch asset data grouped by category and satgas type
            $asset_category = Asset::selectRaw('inventory_categories.name as category_name, COUNT(*) as total, master_satgas.type as satgas_type')
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
                                COUNT(*) as total, 
                                master_satgas.type as satgas_type
                            ")
                            ->leftJoin('inventory_categories', 'assets.kategori', '=', 'inventory_categories.id')
                            ->join('master_satgas', 'assets.lokasi', '=', 'master_satgas.id')
                            ->where('master_satgas.type', $type->type)
                            ->groupBy('category_name', 'master_satgas.type')
                            ->get()
                            ->groupBy('category_name');
        }
    
        // 3️⃣ **Transform Data untuk Tabel Pivot**
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
    
        // 4️⃣ **Siapkan Data untuk PDF**
        $data = [
            'title' => 'Report Asset by Category',
            'data'  => $pivotData,
            'date' => now()->format('d F Y'),
            'chartBase64' => $chartBase64, // Kirim base64 chart ke Blade
        ];
    
        // 5️⃣ **Header & Footer PDF**
        $imageLogo = '<img src="'.public_path('logo.png').'" width="50px" style="float: right;"/>';
        $header = '<table width="100%">
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
    
        $footer = '<hr>
                    <table width="100%" style="font-size: 10px;">
                        <tr>
                            <td width="90%" align="left"><b>Disclaimer</b><br>this document is strictly private, confidential and personal to recipients and should not be copied, distributed or reproduced in whole or in part, not passed to any third party.</td>
                            <td width="10%" style="text-align: right;"> {PAGENO}</td>
                        </tr>
                    </table>';
    
        // 6️⃣ **Render View Blade**
        $html = view('report.asset.master_asset.asset_category-report', $data)->render();
    
        // 7️⃣ **Konfigurasi mPDF**
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L',
            'tempDir' => storage_path('app/mpdf_temp'), // Direktori sementara
            'setAutoTopMargin' => 'stretch',
            'setAutoBottomMargin' => 'stretch',
        ]);
    
        // Buat folder temp jika belum ada
        if (!file_exists(storage_path('app/mpdf_temp'))) {
            mkdir(storage_path('app/mpdf_temp'), 0777, true);
        }
    
        // 8️⃣ **Set Header & Footer**
        $mpdf->SetHTMLHeader($header);
        $mpdf->SetHTMLFooter($footer);
        
        // 9️⃣ **Set Halaman & Tulis HTML**
        $mpdf->AddPage(
            'L', // Landscape
            '',
            '',
            '',
            '',
            5, // Margin kiri
            5, // Margin kanan
            25, // Margin atas
            20, // Margin bawah
            5, // Margin header
            5  // Margin footer
        );
    
        // 10️⃣ **Cegah Output Buffer Bermasalah**
        ob_clean(); 
    
        // 11️⃣ **Tulis HTML ke PDF**
        $mpdf->WriteHTML($html);
    
        // 12️⃣ **Output PDF ke Browser**
        return response()->stream(
            function () use ($mpdf) {
                $mpdf->Output('Report_Kategori_Aset_'.date('Y-m-d').'.pdf', 'I');
            },
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="Report_Kategori_Aset_'.date('Y-m-d').'.pdf"',
            ]
        );
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
    
}
