<?php
namespace App\Imports;

use App\Models\Master\Asset;
use App\Models\Master\AssetLog;
use App\Models\Setting\Inventory_type;
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
    private $rowCount = 0;
    private $skippedRows = []; // Menyimpan row yang dilewati

    public function startRow(): int
    {
        return 2; // Mulai dari baris ke-2 (skip header)
    }

    public function model(array $row)
    {
        $this->rowCount++;

        // Validasi sederhana: no_un atau no_rangka tidak boleh kosong
        if (empty($row[1]) || empty($row[2])) { 
            $this->skippedRows[] = [
                'row'    => $this->rowCount + 1, // +1 karena header skip
                'data'   => $row,
                'reason' => 'no_un atau no_rangka kosong'
            ];
            return null;
        }

        // Cek lokasi
        $lokasi = MasterSatgas::where('name', $row[8])->first();
        $lokasiType = MasterSatgas::where('type', $row[8])->first();
        if (!$lokasi && !$lokasiType) {
            $this->skippedRows[] = [
                'row'    => $this->rowCount + 1,
                'data'   => $row,
                'reason' => 'Lokasi tidak ditemukan'
            ];
            // Tetap insert dengan lokasi=0? Jika tidak ingin insert, uncomment:
            // return null;
        }

        // Transformasi tanggal
        $created_at = $this->transformDate($row[0], date('H:i:s'));
    
        // Ambil ID terkait
        $kategori    = InventoryCategory::where('name', $row[4])->first();
        $subkategori = InventorySubCategory::where('name', $row[5])->first();
        $nameJenis   = strtoupper(trim($row[6]));
        $jenis       = Inventory_type::whereRaw('UPPER(name) = ?', [$nameJenis])->first();
        $merk        = InventoryBrand::where('name', $row[7])->first();
        $lokasi_id   = $lokasi->id ?? ($lokasiType->id ?? 0);
        
        // Mapping kondisi
        $kondisi = 0;
        switch ($row[9]) {
            case 'BAIK':       $kondisi = 1; break;
            case 'RR OPS':     $kondisi = 2; break;
            case 'RB':         $kondisi = 3; break;
            case 'RR TDK OPS': $kondisi = 4; break;
            case 'M':          $kondisi = 5; break;
            case 'D':          $kondisi = 6; break;
        }
    
        // Cek apakah asset sudah ada
        $existingAsset = Asset::where('no_un', $row[1] ?? '')
            ->where('no_rangka', $row[2] ?? '')
            ->where('no_mesin', $row[3] ?? '')
            ->where('kategori', $kategori->id ?? 0)
            ->where('subkategori', $subkategori->id ?? 0)
            ->where('jenis', $jenis->id ?? 0)
            ->where('merk', $merk->id ?? 0)
            ->where('lokasi', $lokasi_id)
            ->where('kondisi', $kondisi)
            ->first();
    
        // Jika ingin skip duplikat, bisa aktifkan ini:
        
        if ($existingAsset) {
            $this->skippedRows[] = [
                'row'    => $this->rowCount + 1,
                'data'   => $row,
                'reason' => 'Asset duplikat'
            ];
            return null;
        }
        
    
        // Generate kode asset
        $increment_code = Asset::withTrashed()->orderBy('id', 'desc')->first();
        $date_month     = strtotime(date('Y-m-d'));
        $month          = idate('m', $date_month);
        $year           = idate('y', $date_month);
        $month_convert  = NumConvert::roman($month);
    
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
    
        // Data untuk tabel Asset
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
            'th_pembuatan'  => $row[10] ?? 0,
            'th_operasi'    => $row[11] ?? 0,
            'lokasi'        => $lokasi_id,
        ];
    
        if ($lokasi == null && $lokasiType == null) {
            Log::warning("Asset dengan lokasi kosong: " . $ticket_code . 
                " , Lokasi : " . json_encode($lokasi) . " : Type " . json_encode($lokasiType));
        }
    
        // Insert ke tabel Asset
        Asset::create($post);

        // Data untuk AssetLog
        $postLog = [
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
            'th_pembuatan'  => $row[10] ?? 0,
            'th_operasi'    => $row[11] ?? 0,
            'lokasi'        => $lokasi_id,
            'remark'        => $row[12] ? $row[12] : '-',
            'attachment'    => ''
        ];
       
        return new AssetLog($postLog);
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
        if (empty($dateValue)) {
            return null;
        }
    
        if (is_numeric($dateValue)) {
            $date = Carbon::instance(Date::excelToDateTimeObject($dateValue));
            return $date->setTimezone(config('app.timezone'))->format('Y-m-d') . ' ' . $time;
        }
    
        try {
            return Carbon::parse($dateValue)
                ->setTimezone(config('app.timezone'))
                ->format('Y-m-d') . ' ' . $time;
        } catch (\Exception $e) {
            Log::error("Invalid date format: " . json_encode($dateValue));
            return null;
        }
    }

    /**
     * Getter jumlah row yang diproses
     */
    public function getRowCount()
    {
        return $this->rowCount;
    }

    /**
     * Getter row yang dilewati
     */
    public function getSkippedRows()
    {
        return $this->skippedRows;
    }
}
