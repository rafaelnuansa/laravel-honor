<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Models\Honor;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {
        // dd(auth()->guard('pegawai')->user()->id);
        if (Auth::guard('users')->check()) {
            $totalJtmDaily = Honor::where('tanggal', Carbon::today())->sum('jtm');
            $totalJtmWeek = Honor::whereBetween('tanggal', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('jtm');
            $totalJtmMonth = Honor::where('tanggal', '>=', Carbon::now()->startOfMonth())->where('tanggal', '<=', Carbon::now()->endOfMonth())->sum('jtm');
            $totalJtmYear = Honor::where('tanggal', '>=', Carbon::now()->startOfYear())->where('tanggal', '<=', Carbon::now()->endOfYear())->sum('jtm');
            $totalHonorMonth = Honor::whereMonth('tanggal', Carbon::now()->month)->sum('jumlah');
            $riwayatHonorBulanIni = Honor::whereMonth('tanggal', Carbon::now()->month)->orderBy('tanggal', 'desc')->take(10)->get();

            return view('dashboard.index', [
                'totalJtmDaily' => $totalJtmDaily,
                'totalJtmWeek' => $totalJtmWeek,
                'totalJtmMonth' => $totalJtmMonth,
                'totalJtmYear' => $totalJtmYear,
                'totalHonorMonth' => $totalHonorMonth,
                'riwayatHonorBulanIni' => $riwayatHonorBulanIni,
            ]);
        } elseif (Auth::guard('pegawai')->check()) {
            //Pegawai

            $pegawai_id = auth()->guard('pegawai')->id();
            $totalJtmDaily = Honor::where('pegawai_id', $pegawai_id)
                ->where('tanggal', Carbon::today())
                ->sum('jtm');

            $totalJtmWeek = Honor::where('pegawai_id', $pegawai_id)
                ->whereBetween('tanggal', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->sum('jtm');

            $totalJtmMonth = Honor::where('pegawai_id', $pegawai_id)
                ->where('tanggal', '>=', Carbon::now()->startOfMonth())
                ->where('tanggal', '<=', Carbon::now()->endOfMonth())
                ->sum('jtm');

            $totalJtmYear = Honor::where('pegawai_id', $pegawai_id)
                ->where('tanggal', '>=', Carbon::now()->startOfYear())
                ->where('tanggal', '<=', Carbon::now()->endOfYear())
                ->sum('jtm');

            $totalHonorMonth = Honor::where('pegawai_id', $pegawai_id)
                ->whereMonth('tanggal', Carbon::now()->month)
                ->sum('jumlah');

            $riwayatHonorBulanIni = Honor::where('pegawai_id', $pegawai_id)
                ->whereMonth('tanggal', Carbon::now()->month)
                ->orderBy('tanggal', 'desc')
                ->take(10)
                ->get();

            return view('dashboard.indexPegawai', [
                'totalJtmDaily' => $totalJtmDaily,
                'totalJtmWeek' => $totalJtmWeek,
                'totalJtmMonth' => $totalJtmMonth,
                'totalJtmYear' => $totalJtmYear,
                'totalHonorMonth' => $totalHonorMonth,
                'riwayatHonorBulanIni' => $riwayatHonorBulanIni,
            ]);
        } else {
            return redirect()->route('login.index')->with('warning', 'Please login with your account');
        }
    }

    public function pegawai_index()
    {
        $totalJtmDaily = Honor::where('tanggal', Carbon::today())->sum('jtm');
        $totalJtmWeek = Honor::whereBetween('tanggal', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('jtm');
        $totalJtmMonth = Honor::where('tanggal', '>=', Carbon::now()->startOfMonth())->where('tanggal', '<=', Carbon::now()->endOfMonth())->sum('jtm');
        $totalJtmYear = Honor::where('tanggal', '>=', Carbon::now()->startOfYear())->where('tanggal', '<=', Carbon::now()->endOfYear())->sum('jtm');
        $totalHonorMonth = Honor::whereMonth('tanggal', Carbon::now()->month)->sum('jumlah');
        $riwayatHonorBulanIni = Honor::whereMonth('tanggal', Carbon::now()->month)->orderBy('tanggal', 'desc')->take(10)->get();

        return view('dashboard.indexPegawai', [
            'totalJtmDaily' => $totalJtmDaily,
            'totalJtmWeek' => $totalJtmWeek,
            'totalJtmMonth' => $totalJtmMonth,
            'totalJtmYear' => $totalJtmYear,
            'totalHonorMonth' => $totalHonorMonth,
            'riwayatHonorBulanIni' => $riwayatHonorBulanIni,
        ]);
    }

    public function history()
    {
    }

    public function logout(Request $request)
    {
        Auth::logout();
        Auth::guard('users')->logout();
        Auth::guard('pegawai')->logout();
        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }
}
