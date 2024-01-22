<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TemplateExport implements FromCollection, WithHeadings, ShouldAutoSize,WithStyles
{
    private array $cols;

    /**
     * @param array $cols
     */
    public function __construct(array $cols) { $this->cols = $cols; }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return new Collection([]);
    }

    public function headings(): array
    {
        return $this->cols;
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
