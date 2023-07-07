<?php

namespace App\Exports;

use App\Models\OtherPayment;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Borders;

class OtherPaymentExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting, WithColumnWidths, WithStyles
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
        $paymentQuery = OtherPayment::with(['pegawai'])
            ->select(
                'kode_payment',
                'pegawai_id',
                'nama_payment',
                'tgl_payment',
                'total_payment',
                'channel_id'
            );

        if ($this->startDate && $this->endDate) {
            $paymentQuery->whereBetween('tgl_payment', [$this->startDate, $this->endDate]);
        }

        if ($this->employeeId) {
            $paymentQuery->where('pegawai_id', $this->employeeId);
        }

        $paymentQuery->orderByDesc('tgl_payment');

        return $paymentQuery->get();
    }

    public function headings(): array
    {
        return [
            'Pegawai',
            'Kode Payment',
            'Nama Payment',
            'Tanggal Payment',
            'Total Payment',
            'Channel Payment'
        ];
    }

    public function map($otherPayment): array
    {
        return [
            $otherPayment->pegawai->nama_pegawai,
            $otherPayment->kode_payment,
            $otherPayment->nama_payment,
            $otherPayment->tgl_payment,
            $otherPayment->total_payment,
            $otherPayment->channel->nama
        ];
    }

    public function columnFormats(): array
    {
        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 15,
            'C' => 15,
            'D' => 15,
            'E' => 15,
            'F' => 15
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Apply styles to the sheet as per your requirement
        $sheet->getStyle($sheet->calculateWorksheetDimension())->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);
    }
}
