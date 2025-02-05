<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;

class AssetCategoryExport implements FromCollection, WithHeadings, WithStyles
{
    protected $categories;
    protected $assetCategory;

    public function __construct($categories, $assetCategory)
    {
        $this->categories = $categories;
        $this->assetCategory = $assetCategory;
    }

    // Return the data collection to export
    public function collection()
    {
        $pivotData = [];
        foreach ($this->assetCategory as $categoryName => $assets) {
            $row = ['category' => $categoryName]; // Row title
            foreach ($this->categories as $satgas) {
                $row[$satgas] = 0; // Initialize all columns with 0
            }
            foreach ($assets as $asset) {
                $row[$asset->satgas_type] = $asset->total ?? 0; // Set total to 0 if null
            }
            $pivotData[] = $row;
        }
        return collect($pivotData);
    }

    // Define the headings for the columns
    public function headings(): array
    {
        $headings = ['Category'];
        foreach ($this->categories as $satgas) {
            $headings[] = $satgas;
        }
        return $headings;
    }

    // Apply styles to the export
    public function styles($sheet)
    {
        $sheet->getColumnDimension('A')->setWidth(50);
        foreach (range('C', 'E') as $column) {
            $sheet->getColumnDimension($column)->setWidth(30);
        }
    
        // Style header row
        $sheet->getStyle('A1:E1')->applyFromArray([
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
