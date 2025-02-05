<?php

namespace App\Exports;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;

class AssetKondisiExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize,WithStyles
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    // Menentukan data yang akan diekspor
    public function collection()
    {
        return collect($this->data['data']);
    }

    // Menentukan header kolom untuk Excel
    public function headings(): array
    {
        return array_merge(['Kondisi'], $this->data['columns']);
    }

    // Menentukan pemetaan data untuk setiap baris
    public function map($row): array
    {
        return array_values($row);
    }
    public function styles($sheet)
    {
      
        foreach (range('B', 'E') as $column) {
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
