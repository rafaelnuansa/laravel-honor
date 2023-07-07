<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Honor;
use App\Models\Pegawai;
use Carbon\Carbon;
use App\Exports\HonorExport;
use App\Exports\HonorMonthExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanHonorMonthController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan;
        $employeeId = $request->pegawai_id;

        $honor = Honor::query();
        if ($bulan) {
            $honor->whereRaw('DATE_FORMAT(tanggal, "%Y-%m") = ?', [$bulan]);
        }

        if ($employeeId) {
            $honor->where('pegawai_id', $employeeId);
        }

        // Include the 'pegawai' relationship
        $honor->with('pegawai');

        $honor = $honor->get();

        // Mengelompokkan baris berdasarkan bulan dan tahun
        $groupedHonor = $honor->groupBy(function ($item) {
            return $item->pegawai_id . '-' . Carbon::parse($item->tanggal)->format('Y-m');
        })->sortByDesc(function ($group) {
            return $group->first()->tanggal;
        });


        // dd($groupedHonor);
        $totalHonor = $groupedHonor->sum('jumlah');
        $totalJtm = $groupedHonor->sum('jtm');

        $pegawais = Pegawai::all(); // Get all pegawai data

        if ($request->has('export')) {
            $export = new HonorMonthExport( $bulan, $employeeId);
            $fileName = 'honor_' . $bulan . '_export.xlsx';
            return Excel::download($export, $fileName);
        }

        return view('laporan.honorMonth.index', compact('groupedHonor', 'bulan', 'employeeId', 'totalHonor', 'totalJtm', 'pegawais'));
    }
}
