<?php

namespace App\Exports;

use App\Models\Payment;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HonorPaymentExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting, WithColumnWidths, WithStyles
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
        $paymentQuery = Payment::with(['pegawai'])
            ->select(
                'kode_bayar',
                'pegawai_id',
                'total_jtm',
                'total_honor',
                'tugas_honor',
                'payroll',
                'koperasi',
                'total_bersih',
                'bulan',
                'tanggal_bayar'
            );

        if ($this->startDate && $this->endDate) {
            $paymentQuery->whereBetween('tanggal_bayar', [$this->startDate, $this->endDate]);
        }

        if ($this->employeeId) {
            $paymentQuery->where('pegawai_id', $this->employeeId);
        }

        $paymentQuery->orderByDesc('tanggal_bayar'); // Order by tanggal_bayar in descending order

        return $paymentQuery->get();
    }

    public function headings(): array
    {
        return [
            'Kode Bayar',
            'Nama Pegawai',
            'Total JTM',
            'Total Honor',
            'Total Tugas Honor',
            'Payroll',
            'Koperasi',
            'Total Bersih',
            'Bulan',
            'Tanggal Bayar',
        ];
    }

    public function map($payment): array
    {
        $tugasHonor = json_decode($payment->tugas_honor, true);
        $totalTugasHonor = 0;

        $tugasColumns = array_map(function ($item) use (&$totalTugasHonor) {
            $totalTugasHonor += $item['honor'];
            return [
                'nama_tugas' => $item['nama_tugas'],
                'honor' => $item['honor'],
            ];
        }, $tugasHonor);

        return [
            $payment->kode_bayar,
            $payment->pegawai->nama_pegawai,
            $payment->total_jtm,
            $payment->total_honor,
            $totalTugasHonor,
            $payment->payroll,
            $payment->koperasi,
            $payment->total_bersih,
            $payment->bulan,
            $payment->tanggal_bayar,
        ];
    }


    public function columnFormats(): array
    {
        return [
            'C' => '#,##0',
            'D' => '#,##0',
            'F' => '#,##0',
            'G' => '#,##0',
            'H' => '#,##0',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 35,
            'C' => 15,
            'D' => 15,
            'E' => 35,
            'F' => 15,
            'G' => 15,
            'H' => 15,
            'I' => 15,
            'J' => 15,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Apply styles to the sheet as per your requirement
        // ...
    }
}
