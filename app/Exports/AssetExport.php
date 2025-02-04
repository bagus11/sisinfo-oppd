<?php

namespace App\Exports;

use App\Models\Master\Asset;
use App\Models\Master\Asset as MasterAsset;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AssetExport implements  FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $assets;

    public function __construct($assets)
    {
        $this->assets = $assets;
    }

    public function collection()
    {
        return $this->assets;
    }

    public function headings(): array
    {
        return [
            'Asset Code',
            'No. Un',
            'Kategori',
            'Sub Kategori',
            'Jenis',
            'Merk',
            'No. Rangka',
            'No. Mesin',
            'Satgas',
            'Lokasi',
            'Kondisi',
        ];
    }

    public function map($asset): array
    {
        $kondisi = '-';
        switch ($asset->kondisi) {
            case 1:
                $kondisi = "BAIK";
                break;
            case 2:
                $kondisi = "RR OPS";
                break;
            case 3:
                $kondisi = "RB";
                break;
            case 4:
                $kondisi = "RR TDK OPS";
                break;
            case 5:
                $kondisi = "M";
                break;
            case 6:
                $kondisi = "D";
                break;
          
        }
        return [
            $asset->asset_code,                           // Asset Code
            $asset->no_un,                                // No Un
            $asset->categoryRelation->name ?? '',         // Category Relation Name
            $asset->subCategoryRelation->name ?? '',      // Sub Category Relation Name
            $asset->typeRelation->name ?? '',             // Type Relation Name
            $asset->merkRelation->name ?? '',             // Merk Relation Name
            $asset->no_rangka,                            // No Rangka
            $asset->no_mesin,                             // No Mesin
            $asset->satgasRelation->type ?? '',           // Satgas Type
            $asset->satgasRelation->name ?? '',           // Satgas Name
            $kondisi,                              // Kondisi
        ];
    }
    public function styles($sheet)
    {
        // Set column width for A-K
        foreach (range('A', 'K') as $column) {
            $sheet->getColumnDimension($column)->setWidth(20);
        }
    
        // Set column width for C-F to 40
        foreach (range('C', 'F') as $column) {
            $sheet->getColumnDimension($column)->setWidth(50);
        }
    
        // Style header row
        $sheet->getStyle('A1:K1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['rgb' => 'FFFFFF'], // Set text color to white
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '7298AD', // Set header background color
                ],
            ],
        ]);
    }
    
    
       
}
