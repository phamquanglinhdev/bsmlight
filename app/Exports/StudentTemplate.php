<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Sheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentTemplate implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithStyles
{
    /**
     * @var array
     */
    private array $studentColumns;
    /**
     * @var array
     */
    private array $cardColumns;

    public function __construct(
        array $studentColumns,
        array $cardColumns
    )
    {
        $this->studentColumns = $studentColumns;
        $this->cardColumns = $cardColumns;
    }

    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        return Collection::make();
    }

    public function headings(): array
    {
        $totalStudent = count($this->studentColumns);
        $totalCard = count($this->cardColumns);

        $firstHeading[] = 'Học sinh';
        for ($i = 2; $i <= $totalStudent; $i++) {
            $firstHeading[] = null;
        }

        $firstHeading[] = 'Thẻ học';

        return [
            $firstHeading,
            array_merge($this->studentColumns, $this->cardColumns)
        ];
    }

    public function registerEvents(): array
    {
        $totalStudentCol = count($this->studentColumns);
        $totalCol = $totalStudentCol + count($this->cardColumns);
        return [
            AfterSheet::class => function (AfterSheet $event) use ($totalCol, $totalStudentCol) {
                $sheet = $event->sheet;

                $sheet->mergeCells('A1:' . $this->convertToExcelColumn($totalStudentCol) . '1');
                $sheet->setCellValue('A1', "Thông tin học sinh");

                $sheet->mergeCells(($this->convertToExcelColumn($totalStudentCol + 1)) . "1:" . $this->convertToExcelColumn($totalCol) . "1");
                $sheet->setCellValue('C1', "Thẻ học");
                $workSheet = $event->sheet->getDelegate();
//                $workSheet->freezePane('B1');
                $workSheet->freezePane('B2');
                $cellRange = 'A1:' . $this->convertToExcelColumn($totalCol) . "1";

//                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);
            },
        ];
    }

    private function convertToExcelColumn($num): string
    {
        $excelColumn = '';

        while ($num > 0) {
            $remainder = ($num - 1) % 26;
            $excelColumn = chr(65 + $remainder) . $excelColumn;
            $num = intval(($num - $remainder) / 26);
        }

        return $excelColumn;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true],
                'border' =>
                    ['outline' => [
                        'borderStyle' => Border::BORDER_DASHDOT,
                    ]]],
            2 => ['font' => ['bold' => true]],

        ];
    }
}
