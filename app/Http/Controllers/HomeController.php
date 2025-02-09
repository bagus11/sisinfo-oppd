<?php

namespace App\Http\Controllers;

use App\Models\Master\MasterAsset;
use App\Models\Setting\MasterSatgas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $userHasPermission = auth()->user()->can('get-except_satgas-master_asset');
        return view('dashboard-index',compact('userHasPermission'));
    }
    public function getCountingAsset()
    {
        $oppd = DB::table('master_assets as a')
            ->join('master_satgas as b', 'a.satgas', '=', 'b.name')
            ->select(DB::raw('COUNT(a.id) as total'))
            ->whereNot('a.kondisi','')
            ->first();
    
        $countOppd = DB::table('assets as a')
            ->select(DB::raw('COUNT(a.id) as total'),'b.type')
            ->join('master_satgas as b', 'a.lokasi', '=', 'b.id')
            ->groupBy('b.type',)
            ->orderBy('b.type', 'desc')
            ->get();
         
            // Get totals for labels
        $totals = $countOppd->pluck('total');
        $data = DB::table('assets')
                ->select(DB::raw('COUNT(id) as total'),'kondisi')
                // ->join('master_satgas as b', 'a.lokasi', '=', 'b.id')
                ->groupBy('kondisi')
                ->orderBy('kondisi', 'desc')
                ->get();
        $satgas_type = $countOppd->pluck('type');   
    
        $group = MasterSatgas::select('type', DB::raw('COUNT(*) as total'))
            ->groupBy('type')
            ->orderBy('id', 'asc')
            ->get();
    
            $country = DB::table('assets as a')
            ->join('master_satgas as c', 'a.lokasi', '=', 'c.id')
            ->select(DB::raw('COUNT(a.id) as total'),'c.type','c.country','c.x','c.y')
            ->groupBy('c.country', 'c.x', 'c.y','c.type') // Include c.country in GROUP BY
            ->where('a.kondisi', '!=', '')
            ->get();
            // if(auth()->user()->hasPermissionTo('get-except_satgas-asset_inventaris')){
                $countingSatgasAsset = DB::table('master_satgas as a')
                ->leftJoin('assets as b', 'a.id', '=', 'b.lokasi')
                ->select('a.type', DB::raw('COUNT(b.id) AS total'))
                ->whereNot('a.type', 'OPPD')
                ->groupBy('a.type')
                ->orderBy('a.id', 'asc')
                ->get();
            // }else{
                // $countingSatgasAsset = DB::table('master_satgas as a')
                // ->leftJoin('assets as b', 'a.id', '=', 'b.lokasi')
                // ->select('a.type', DB::raw('COUNT(b.id) AS total'))
                // ->whereNot('a.type', 'OPPD')
                // ->where('b.lokasi', auth()->user()->satgas)
                // ->groupBy('a.type')
                // ->orderBy('a.id', 'asc')
                // ->get();
            // }
     
        
            $allAsset = DB::table('master_satgas as a')
            ->leftJoin('assets as b', 'a.id', '=', 'b.lokasi')
            ->whereNot('a.type', 'OPPD')
            ->select(DB::raw('COUNT(b.id) AS total'))
            ->first(); // Gunakan first() agar hanya mengambil satu nilai total

            $summaryChartCategory =  DB::table('assets as a')
                                        ->join('master_satgas as b', 'a.lokasi', '=', 'b.id')
                                        ->join('inventory_categories as c', 'a.kategori', '=', 'c.id')
                                        ->select(DB::raw('COUNT(a.id) AS total'), 'b.type as satgas_type', 'c.name as category_name')
                                        ->groupBy('b.type', 'c.name')
                                        ->orderBy('b.type', 'asc')
                                        ->orderBy('c.name', 'asc')
                                        ->get();

            $summaryChartSatgas =  DB::table('assets as a')
                                        ->join('master_satgas as b', 'a.lokasi', '=', 'b.id')
                                        ->select(DB::raw('COUNT(a.id) AS total'), 'b.name as satgas_name')
                                        ->groupBy('b.name')
                                        ->orderBy('b.name', 'asc')
                                        ->get();
        return response()->json([
            'oppd' => $oppd,
            'countOppd' => $countOppd,
            'data' => $data,       // Add data for the radial chart
            'type' => $satgas_type,       // Add data for the radial chart
            'group' => $group,
            'allAsset' => $allAsset,
            'country' => $country,
            'countingSatgasAsset' => $countingSatgasAsset,
            'summaryChartCategory' => $summaryChartCategory,
            'summaryChartSatgas' => $summaryChartSatgas,
        ]);
    }
    
    function assetChart() {
        $data = DB::table('assets as a')
        ->select(DB::raw('COUNT(a.id) as total'), 'a.kondisi')
        ->join('master_satgas as b','a.lokasi','b.id')
        // ->where('b.type','like','%'.$request->type.'%')
        ->groupBy('a.kondisi')
        ->get();
        $mappedData = $data->map(function ($item) {
            $item->kondisi_label = match ($item->kondisi) {
                1 => 'Baik',
                2 => 'RR OPS',
                3 => 'RB',
                4 => 'RR TDK OPS',
                5 => 'M',
                6 => 'D',
                default => 'Unknown',
            };
            return $item;
        });
    
        return response()->json([
            'data' => $mappedData,
        ]);
    }
    function assetChartFilter(Request $request) {
        $data = DB::table('assets as a')
        ->select(DB::raw('COUNT(a.id) as total'), 'a.kondisi')
        ->join('master_satgas as b','a.lokasi','b.id')
        ->where('b.type','like','%'.$request->type.'%')
        ->groupBy('a.kondisi')
        ->get();
        $mappedData = $data->map(function ($item) {
            $item->kondisi_label = match ($item->kondisi) {
                1 => 'Baik',
                2 => 'RR OPS',
                3 => 'RB',
                4 => 'RR TDK OPS',
                5 => 'M',
                6 => 'D',
                default => 'Unknown',
            };
            return $item;
        });
    
        return response()->json([
            'data' => $mappedData,
        ]);
    }
  
    function getSatgasPie(Request $request) {
        
        $data = DB::table('assets as a')
        ->leftJoin('master_satgas as b', 'a.lokasi', '=', 'b.id')
        ->select(DB::raw('COUNT(a.id) as total'),'kondisi')
        ->where('b.type',$request->type)
        ->groupBy('a.kondisi')
        ->get();
        return response()->json([
            'data' => $data,
        ]);
    }
}
