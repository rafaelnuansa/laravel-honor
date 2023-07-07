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

class HonorExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting, WithColumnWidths, WithStyles
{
    protected $startDate;
    protected $endDate;
    protected $employeeId;

    public function __construct($startDate = null , $endDate = null, $employeeId = null)
    {
        $this->startDate = $startDate ? Carbon::parse($startDate) : null;
        $this->endDate = $endDate ? Carbon::parse($endDate) : null;
        $this->employeeId = $employeeId;
    }

    public function collection()
    {
        $honorQuery = Honor::with(['pegawai', 'mapel', 'kelas', 'status_mengajar'])
            ->select(
                'pegawai_id',
                'mapel_id',
                'kelas_id',
                'jtm',
                'honor',
                'jumlah',
                'status_mengajar_id',
                'tanggal'
            );

            if ($this->startDate && $this->endDate) {
                $startYear = $this->startDate->format('Y');
                $startMonth = $this->startDate->format('m');
                $endYear = $this->endDate->format('Y');
                $endMonth = $this->endDate->format('m');

                $honorQuery->whereYear('tanggal', '>=', $startYear)
                    ->whereMonth('tanggal', '>=', $startMonth)
                    ->whereYear('tanggal', '<=', $endYear)
                    ->whereMonth('tanggal', '<=', $endMonth);
            }

            if ($this->employeeId) {
                $honorQuery->where('pegawai_id', $this->employeeId);
            }

            $honorQuery->orderByDesc('tanggal'); // Order by tanggal in descending order

            return $honorQuery->get();
    }

    public function headings(): array
    {
        $title = 'LAPORAN DATA HARIAN & JTM PEGAWAI';
        if ($this->startDate && $this->endDate) {
            $title .= ' Periode: ' . $this->startDate->format('M Y') . ' - ' . $this->endDate->format('M Y');
        }

        return [
            [$title],
            [],
            [],
            [
                'Kode Pegawai',
                'Nama Pegawai',
                'Mata Pelajaran',
                'Kelas',
                'JTM',
                'Honor',
                'Jumlah',
                'Status KBM',
                'Tanggal',
            ],
        ];
    }

    public function map($honor): array
    {
        return [
            $honor->pegawai->kode_pegawai ?? '',
            $honor->pegawai->nama_pegawai ?? '',
            $honor->mapel->nama_mapel ?? '',
            $honor->kelas->nama_kelas ?? '',
            $honor->jtm,
            $honor->honor,
            $honor->jumlah,
            $honor->status_mengajar->status_mengajar ?? '',
            $honor->tanggal,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => '#,##0',
            'E' => '#,##0',
            'F' => '#,##0',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 35,
            'C' => 25,
            'D' => 25,
            'E' => 25,
            'F' => 25,
            'G' => 25,
            'H' => 25,
            'I' => 25,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:I3');
        $sheet->getStyle('A1:I3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:I3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(12);

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
