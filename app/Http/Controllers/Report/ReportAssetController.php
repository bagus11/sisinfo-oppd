<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Master\AssetLog;
use App\Models\Master\MasterAsset;
use App\Models\Transaction\Asset\Inventaris;
use App\Models\Transaction\Asset\InventarisDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Mpdf\Mpdf as PDF;
class ReportAssetController extends Controller
{
    function index() {
        return view('report.asset.report_asset-index');
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
        $asset_code = str_replace('_','/', $id);
        $detail = MasterAsset::with([
            'categoryRelation',
            'subCategoryRelation',
            'typeRelation',
            'merkRelation',
            'satgasRelation',
        ])->where('asset_code', $asset_code)->first();

        $log =AssetLog::with([
            'categoryRelation',
            'subCategoryRelation',
            'typeRelation',
            'merkRelation',
            'satgasRelation',
            'picRelation',
        ])->where('asset_code', $asset_code)->orderBy('id','desc')->get();
    }
}
