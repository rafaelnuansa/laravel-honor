<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Honor;
use App\Models\Pegawai;
use Carbon\Carbon;
use App\Exports\HonorExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanHonorController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->start_at;
        $endDate = $request->end_at;
        $employeeId = $request->pegawai_id;

        $honor = Honor::query();

        if ($startDate && $endDate) {
            $honor->whereRaw('DATE_FORMAT(tanggal, "%Y-%m") BETWEEN ? AND ?', [$startDate, $endDate]);
        }

        if ($employeeId) {
            $honor->where('pegawai_id', $employeeId);
        }

        $honor = $honor->get();
        $totalHonor = $honor->sum('jumlah');
        $totalJtm = $honor->sum('jtm');
        $pegawais = Pegawai::all(); // Menampilkan semua data pegawai

        if ($request->has('export')) {
            $export = new HonorExport($startDate, $endDate, $employeeId);
            return Excel::download($export, 'honor_export.xlsx');
        }

        return view('laporan.honor.index', compact('honor', 'startDate', 'endDate' , 'employeeId', 'totalHonor', 'totalJtm', 'pegawais'));
    }
}
