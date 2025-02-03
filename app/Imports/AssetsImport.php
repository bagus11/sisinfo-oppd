<?php
namespace App\Imports;
use App\Models\Master\Asset;
use App\Models\Master\AssetLog;
use App\Models\Setting\Inventory_type;
use App\Models\Setting\InventoryType;
use App\Models\Setting\InventoryBrand;
use App\Models\Setting\InventoryCategory;
use App\Models\Setting\InventorySubCategory;
use App\Models\Setting\MasterSatgas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use NumConvert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class AssetsImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2; // Skip the first row (header)
    }

    public function model(array $row)
    {
        $increment_code = Asset::withTrashed()->orderBy('id', 'desc')->first();
        $date_month = strtotime(date('Y-m-d'));
        $month = idate('m', $date_month);
        $year = idate('y', $date_month);
        $month_convert = NumConvert::roman($month);
    
        if ($increment_code == null) {
            $ticket_code = '1/ASSET/' . $month_convert . '/' . $year;
        } else {
            $month_before = explode('/', $increment_code->asset_code);
            if ($month_convert != $month_before[2]) {
                $ticket_code = '1/ASSET/' . $month_convert . '/' . $year;
            } else {
                $ticket_code = ($month_before[0] + 1) . '/ASSET/' . $month_convert . '/' . $year;
            }
        }
    
        // Transform Excel serialized date and append the time
        $created_at = $this->transformDate($row[0], date('H:i:s'));
    
        // Cek apakah data ditemukan sebelum mengakses properti id
        $kategori = InventoryCategory::where('name', $row[4])->first();
        $subkategori = InventorySubCategory::where('name', $row[5])->first();
        $jenis = Inventory_type::where('name', $row[6])->first();
        $merk = InventoryBrand::where('name', $row[7])->first();
        $lokasi = MasterSatgas::where('name', $row[8])->first();
        $lokasiType = MasterSatgas::where('type', $row[8])->first();
        $lokasi_id = $lokasi->id ?? ($lokasiType->id ?? 0);

        $kondisi = 0;
        switch ($row[9]) {
            case 'BAIK':
                $kondisi = 1;
                break;
            case 'RR OPS':
                $kondisi = 2;
                break;
            case 'RB':
                $kondisi = 3;
                break;
            case 'RR TDK OPS':
                $kondisi = 4;
                break;
            case 'M':
                $kondisi = 5;
                break;
            case 'D':
                $kondisi = 6;
                break;
        }
       
        $post = [
            'asset_code'    => $ticket_code,
            'created_at'    => $created_at,
            'no_un'         => $row[1] ?? '',
            'no_rangka'     => $row[2] ?? '',
            'no_mesin'      => $row[3] ?? '',
            'kategori'      => $kategori->id ?? 0,
            'subkategori'   => $subkategori->id ?? 0,
            'jenis'         => $jenis->id ?? 0,
            'merk'          => $merk->id ?? 0,
            'user_id'       => auth()->user()->id ?? 0,
            'pic'           => 0,
            'kondisi'       => $kondisi,
            'lokasi'        => $lokasi_id,
        ];
        if ($lokasi == null && $lokasiType == null) {
            
            Log::warning("Asset dengan lokasi kosong: " . $ticket_code. " , Lokasi : " . json_encode($lokasi). " : Type ". json_encode($lokasiType));
        }
        
        Asset::create($post);
    
        return new AssetLog([
            'asset_code'    => $ticket_code,
            'created_at'    => $created_at,
            'no_un'         => $row[1] == null ? '' : $row[1],
            'no_rangka'     => $row[2] == null ? '' : $row[2],
            'no_mesin'      => $row[3] == null ? '' : $row[3],
            'kategori'      => $kategori->id ?? 0,
            'subkategori'   => $subkategori ? $subkategori->id : 0, // Ensure null if not found
            'jenis'         => $jenis->id ?? 0,
            'merk'          => $merk->id ?? 0,
            'user_id'       => auth()->user()->id ?? 0,
            'pic'           => 0,
            'kondisi'       => $kondisi,
            'lokasi'        => $lokasi->id ?? 0,
            'remark'        => auth()->user()->name. ' telah menambahkan asset'
        ]);
    }
    

    /**
     * Transform Excel serialized date into Y-m-d format with timezone adjustment and append time.
     *
     * @param mixed $dateValue
     * @param string $time
     * @return string|null
     */
    private function transformDate($dateValue, $time)
    {
        // Check if the value is numeric (Excel date format)
        if (is_numeric($dateValue)) {
            $date = Carbon::instance(Date::excelToDateTimeObject($dateValue));

            // Apply the app's timezone and append the time
            return $date->setTimezone(config('app.timezone'))->format('Y-m-d') . ' ' . $time;
        }

        // Return parsed date with the appended time for non-numeric values
        return Carbon::parse($dateValue)->setTimezone(config('app.timezone'))->format('Y-m-d') . ' ' . $time;
    }
}
