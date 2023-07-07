<?php

namespace App\Http\Controllers;

use App\Exports\HonorExport;
use App\Exports\HonorPaymentExport;
use App\Exports\OtherPaymentExport;
use App\Models\Honor;
use App\Models\OtherPayment;
use App\Models\OtherPaymentItem;
use App\Models\Payment;
use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $pegawaiId = auth()->guard('pegawai')->user()->id;
        $honorList = Honor::orderByDesc('tanggal')->where('pegawai_id', $pegawaiId)->paginate(15);
        // return view('history.index', compact('honorList'));

        $startDate = $request->start_at;
        $endDate = $request->end_at;
        $employeeId = auth()->guard('pegawai')->user()->id;
        // dd($employeeId);
        $honor = Honor::query();

        if ($startDate && $endDate) {
            $honor->whereRaw('DATE_FORMAT(tanggal, "%Y-%m") BETWEEN ? AND ?', [$startDate, $endDate]);
        }

        $honor->where('pegawai_id', $employeeId);
        $honor = $honor->paginate(15);
        $honorList = $honor;
        $totalHonor = $honor->sum('jumlah');
        $totalJtm = $honor->sum('jtm');
        if ($request->has('export')) {
            $export = new HonorExport($startDate, $endDate, $employeeId);
            return Excel::download($export, 'honor_export.xlsx');
        }
        return view('history.index', compact('honorList', 'startDate', 'endDate', 'employeeId', 'totalHonor', 'totalJtm'));
    }


    public function pencairan(Request $request)
    {
        $startDate = $request->start_at;
        $endDate = $request->end_at;
        $employeeId = auth()->guard('pegawai')->user()->id;

        $payment = Payment::query();

        if ($startDate && $endDate) {
            $payment->whereBetween('bulan', [$startDate, $endDate]);
        }

        $payment->where('pegawai_id', $employeeId);
        $payment = $payment->paginate(15);
        $payments = $payment;
        $totalHonor = $payment->sum('total_bersih');
        $totalJtm = $payment->sum('total_jtm');
        if ($request->has('export')) {
            $export = new HonorPaymentExport($startDate, $endDate, $employeeId);
            return Excel::download($export, 'payment_export.xlsx');
        }
        return view('history.pencairan', compact('payments', 'startDate', 'endDate', 'employeeId', 'totalHonor', 'totalJtm'));
    }

    public function pencairanshow(Payment $payment)
    {
        $pegawai = Pegawai::findOrFail($payment->pegawai_id);
        $pegawaiId = $pegawai->id;
        $empId = auth()->guard('pegawai')->user()->id;
        if ($pegawaiId = $empId) {
            $bulan = Carbon::parse($payment->bulan)->format('Y-m');
            $totalJtm = Honor::where('pegawai_id', $pegawaiId)
                ->whereDate('tanggal', 'LIKE', $bulan . '%')
                ->sum('jtm');

            $totalHonor = Honor::where('pegawai_id', $pegawaiId)
                ->whereMonth('tanggal', Carbon::parse($payment->bulan)->format('m'))
                ->whereYear('tanggal', Carbon::parse($payment->bulan)->format('Y'))
                ->sum('jumlah');
            return view('history.pencairanshow', compact('payment', 'pegawai', 'totalJtm', 'totalHonor'));
        }
    }
    public function lainnya(Request $request)
    {
        $pegawaiId = auth()->guard('pegawai')->user()->id;
        $otherPayments = OtherPayment::orderByDesc('tgl_payment')->where('pegawai_id', $pegawaiId)->paginate(15);
        $startDate = $request->start_at;
        $endDate = $request->end_at;
        $employeeId = $pegawaiId;
        $otherPayments = OtherPayment::query();
        if ($startDate && $endDate) {
            $otherPayments->whereRaw('DATE_FORMAT(tgl_payment, "%Y-%m") BETWEEN ? AND ?', [$startDate, $endDate]);
        }

        if ($employeeId) {
            $otherPayments->where('pegawai_id', $employeeId);
        }

        $otherPayments = $otherPayments->orderByDesc('tgl_payment')->paginate(15);
        // dd($otherPayments);
        $totalHonor = $otherPayments->sum('total_bersih');
        $totalJtm = $otherPayments->sum('total_jtm');
        if ($request->has('export')) {
            $export = new OtherPaymentExport($startDate, $endDate, $pegawaiId);
            return Excel::download($export, 'payment_export.xlsx');
        }
        return view('history.lainnya', compact('otherPayments', 'startDate', 'endDate', 'employeeId', 'totalHonor', 'totalJtm'));
    }

    public function lainnyashow($id)
    {
        try {
            $otherPayment = OtherPayment::findOrFail($id);
            $otherPaymentItems = OtherPaymentItem::where('kode_payment', $otherPayment->kode_payment)->get();

            return view('history.lainnyashow', compact('otherPayment', 'otherPaymentItems'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function lainnya_show()
    {
        $pegawaiId = auth()->guard('pegawai')->user()->id;
        $otherPayments = OtherPayment::orderByDesc('tgl_payment')->where('pegawai_id', $pegawaiId)->paginate(15);
        return view('history.lainnya', compact('otherPayments'));
    }

}
