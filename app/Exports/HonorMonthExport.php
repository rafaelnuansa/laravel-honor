<?php

namespace App\Exports;

use App\Models\Honor;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HonorMonthExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting, WithColumnWidths, WithStyles
{
    protected $bulan;
    protected $employeeId;

    public function __construct($bulan = null, $employeeId = null)
    {
        $this->bulan = $bulan;
        $this->employeeId = $employeeId;
    }

    public function collection()
    {
        $honorQuery = Honor::with(['pegawai'])
            ->select('pegawai_id', 'jtm', 'jumlah', 'tanggal');

        if ($this->bulan) {
            $honorQuery->whereYear('tanggal', '=', Carbon::parse($this->bulan)->format('Y'))
                ->whereMonth('tanggal', '=', Carbon::parse($this->bulan)->format('m'));
        }

        if ($this->employeeId) {
            $honorQuery->where('pegawai_id', $this->employeeId);
        }

        $honorQuery->orderBy('tanggal', 'desc'); // Order by tanggal in descending order

        // Grouping based on pegawai_id and formatted date (Y-m)
        $groupedHonor = $honorQuery->get()->groupBy(function ($item) {
            return $item->pegawai_id . '-' . Carbon::parse($item->tanggal)->format('Y-m');
        });

        // Flatten the grouped collection
        $flattenedHonor = $groupedHonor->flatMap(function ($group) {
            return $group;
        });

        return $flattenedHonor;
    }

    public function headings(): array
    {
        $title = 'LAPORAN DATA SIHONOR';
        if ($this->bulan) {
            $title .= ' Bulan: ' . Carbon::parse($this->bulan)->format('F Y');
        }

        $employeeName = 'Semua Data Pegawai';
        if ($this->employeeId) {
            $employee = Honor::find($this->employeeId)->pegawai;
            if ($employee) {
                $employeeName = $employee->nama_pegawai;
            }
        }

        return [
            [$title],
            [],
            [$employeeName],
            ['NO', 'NAMA GURU', 'TOTAL JTM', 'TOTAL HONOR', 'BULAN'],
        ];
    }

    public function map($honor): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        return [
            $rowNumber,
            $honor->pegawai->nama_pegawai ?? '',
            $honor->jtm,
            $honor->jumlah,
            Carbon::parse($honor->tanggal)->format('F Y'),
        ];
    }


    public function columnFormats(): array
    {
        return [
            'C' => '#,##0',
            'D' => '#,##0',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 35,
            'C' => 25,
            'D' => 25,
            'E' => 25,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:E2');
        $sheet->getStyle('A1:E2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:E2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(12);
        $sheet->mergeCells('A3:E3');
        $sheet->getStyle('A3:E3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A3:E3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A3')->getFont()->setBold(true)->setSize(12);
        $lastColumn = $sheet->getHighestColumn();
        $lastRow = $sheet->getHighestRow();

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $sheet->getStyle('A1:' . $lastColumn . $lastRow)->applyFromArray($styleArray);
    }
}
