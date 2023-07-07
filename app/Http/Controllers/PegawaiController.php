<?php

namespace App\Http\Controllers;

use App\Exports\PegawaiExport;
use App\Models\Honor;
use App\Models\Jabatan;
use App\Models\Mapel;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Tugas;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawaiList = Pegawai::latest()->get();
        return view('pegawai.index', compact('pegawaiList'));
    }

    public function create()
    {
        $jabatanList = Jabatan::all();
        return view('pegawai.create', compact('jabatanList'));
    }

    public function store(Request $request)
    {
        $pegawai = new Pegawai;
        $pegawai->jabatan_id = $request->jabatan_id;
        $pegawai->nama_pegawai = $request->nama_pegawai;
        $pegawai->kode_pegawai = $request->kode_pegawai;
        $pegawai->password = Hash::make($request->password); // Menghash password
        $pegawai->save();
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan');
    }

    public function show($pegawaiId)
    {
        $pegawai = Pegawai::findOrFail($pegawaiId);
        $mapelList = $pegawai->mapel;
        $tugasList = $pegawai->tugas;
        $honorList = Honor::where('pegawai_id', $pegawaiId)->get();

        $totalJtmDaily = $honorList->where('tanggal', Carbon::today())->sum('jtm');
        $totalJtmWeek = $honorList->whereBetween('tanggal', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('jtm');
        $totalJtmMonth = $honorList->where('tanggal', '>=', Carbon::now()->startOfMonth())->where('tanggal', '<=', Carbon::now()->endOfMonth())->sum('jtm');
        $totalJtmYear = $honorList->where('tanggal', '>=', Carbon::now()->startOfYear())->where('tanggal', '<=', Carbon::now()->endOfYear())->sum('jtm');

        $totalJtmTotal = $honorList->sum('jtm');

        // Mendapatkan daftar mapel yang tersedia
        $availableMapelList = Mapel::all();
        $availableTugasList = Tugas::all();

        return view('pegawai.show', compact('pegawai', 'honorList', 'totalJtmDaily', 'totalJtmWeek', 'totalJtmMonth', 'totalJtmYear', 'totalJtmTotal', 'mapelList', 'availableMapelList', 'tugasList', 'availableTugasList'));
    }


    public function edit(Pegawai $pegawai)
    {
        $jabatanList = Jabatan::all();
        return view('pegawai.edit', compact('pegawai', 'jabatanList'));
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        $pegawai->jabatan_id = $request->jabatan_id;
        $pegawai->nama_pegawai = $request->nama_pegawai;
        $pegawai->kode_pegawai = $request->kode_pegawai;
        // Perbarui password hanya jika ada input password baru
        if (!empty($request->password)) {
            $pegawai->password = Hash::make($request->password); // Menghash password baru
        }
        $pegawai->save();

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil diperbarui');
    }

    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus');
    }

    public function export()
    {
        return Excel::download(new PegawaiExport, 'pegawai.xlsx');
    }


    public function assignMapel(Request $request, $pegawaiId)
    {
        $pegawai = Pegawai::findOrFail($pegawaiId);
        $mapelIds = $request->input('mapel_id', []);
        $pegawai->mapel()->sync($mapelIds);
        return redirect()->route('pegawai.show', $pegawaiId)->with('success', 'Mata pelajaran berhasil ditambahkan ke pegawai.');
    }

    public function assignTugas(Request $request, $pegawaiId)
    {
        $pegawai = Pegawai::findOrFail($pegawaiId);
        $tugasIds = $request->input('tugas_id', []);
        $pegawai->tugas()->sync($tugasIds);
        return redirect()->route('pegawai.show', $pegawaiId)->with('success', 'Tugas Tambahan ditambahkan ke pegawai.');
    }
}
