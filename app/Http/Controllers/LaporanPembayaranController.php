<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Honor;
use App\Models\Pegawai;
use App\Models\Payment;
use Carbon\Carbon;
use App\Exports\HonorPaymentExport;
use App\Exports\OtherPaymentExport;
use App\Models\OtherPayment;
use Maatwebsite\Excel\Facades\Excel;

class LaporanPembayaranController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->start_at;
        $endDate = $request->end_at;
        $employeeId = $request->pegawai_id;

        $payment = Payment::query();

        if ($startDate && $endDate) {
            $payment->whereBetween('bulan', [$startDate, $endDate]);
        }

        if ($employeeId) {
            $payment->where('pegawai_id', $employeeId);
        }

        $payment = $payment->get();
        $totalHonor = $payment->sum('total_bersih');
        $totalJtm = $payment->sum('total_jtm');
        $pegawais = Pegawai::all(); // Menampilkan semua data pegawai

        if ($request->has('export')) {
            $export = new HonorPaymentExport($startDate, $endDate, $employeeId);
            return Excel::download($export, 'payment_export.xlsx');
        }

        return view('laporan.payment.index', compact('payment', 'startDate', 'endDate' , 'employeeId', 'totalHonor', 'totalJtm', 'pegawais'));
    }

    public function other(Request $request)
    {
        $startDate = $request->start_at;
        $endDate = $request->end_at;
        $employeeId = $request->pegawai_id;
        $otherPayments = OtherPayment::query();
        if ($startDate && $endDate) {
            $otherPayments->whereRaw('DATE_FORMAT(tgl_payment, "%Y-%m") BETWEEN ? AND ?', [$startDate, $endDate]);
        }

        if ($employeeId) {
            $otherPayments->where('pegawai_id', $employeeId);
        }

        $otherPayments = $otherPayments->get();
        // dd($otherPayments);
        $totalHonor = $otherPayments->sum('total_bersih');
        $totalJtm = $otherPayments->sum('total_jtm');
        $pegawais = Pegawai::all(); // Menampilkan semua data pegawai

        if ($request->has('export')) {
            $export = new OtherPaymentExport($startDate, $endDate, $employeeId);
            return Excel::download($export, 'payment_export.xlsx');
        }

        return view('laporan.payment.other', compact('otherPayments', 'startDate', 'endDate' , 'employeeId', 'totalHonor', 'totalJtm', 'pegawais'));
    }
}
