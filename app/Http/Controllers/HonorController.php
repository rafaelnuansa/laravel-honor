<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Honor;
use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\PegawaiMapel;
use App\Models\SettingHonor;
use App\Models\StatusMengajar;

class HonorController extends Controller
{
    public function index()
    {
        $honorList = Honor::orderByDesc('tanggal')->paginate(15);
        return view('honor.index', compact('honorList'));
    }

    public function create()
    {
        $pegawaiList = Pegawai::all();
        $mapelList = Mapel::all();
        $kelasList = Kelas::all();
        $KBMList = StatusMengajar::all();
        return view('honor.create', compact('pegawaiList',  'mapelList', 'kelasList', 'KBMList'));
    }

    public function store(Request $request)
    {
        try {
            $honor = new Honor;
            $honor->pegawai_id = $request->pegawai_id;
            $honor->mapel_id = $request->mapel_id;
            $honor->tanggal = $request->tanggal;
            $honor->kelas_id = $request->kelas_id;
            $honor->jtm = $request->jtm;
            $honor->jumlah = $request->jumlah;
            $honor->status_mengajar_id = $request->status_mengajar_id;

            // Mengambil data pegawai
            $pegawai = Pegawai::find($request->pegawai_id);
            if ($pegawai) {
                // Mengambil jabatan dari pegawai
                $jabatan = $pegawai->jabatan;
                $honor->jabatan_id = $jabatan->id;

                if ($jabatan) {
                    // Mengambil setting honor berdasarkan jabatan
                    $jabatanHonor = Jabatan::where('id', $jabatan->id)->first();

                    if ($jabatanHonor) {
                        // Set nilai honor berdasarkan setting honor dan dikalikan jtm
                        $honor->honor = $jabatanHonor->honor_jabatan;
                        $honor->jumlah = $jabatanHonor->honor_jabatan * $request->jtm;
                    } else {
                        throw new \Exception('Honor belum diatur untuk jabatan ini.');
                    }
                }
            }
            $honor->save();
            return redirect()->route('honor.index')->with('success', 'Data honor berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit(Honor $honor)
    {
        $pegawaiList = Pegawai::all();
        $jabatanList = Jabatan::all();
        $mapelList = Mapel::all();
        $kelasList = Kelas::all();
        $KBMList = StatusMengajar::all();
        return view('honor.edit', compact('honor', 'pegawaiList', 'jabatanList', 'mapelList', 'kelasList', 'KBMList'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = $request->validate([
                'pegawai_id' => 'required',
            ]);

            $honor = Honor::findOrFail($id);
            $honor->pegawai_id = $request->pegawai_id;
            $honor->mapel_id = $request->mapel_id;
            $honor->tanggal = $request->tanggal;
            $honor->kelas_id = $request->kelas_id;
            $honor->jtm = $request->jtm;
            $honor->jumlah = $request->jumlah;
            $honor->status_mengajar_id = $request->status_mengajar_id;

            // Mengambil data pegawai
            $pegawai = Pegawai::find($request->pegawai_id);
            if ($pegawai) {
                // Mengambil jabatan dari pegawai
                $jabatan = $pegawai->jabatan;
                $honor->jabatan_id = $jabatan->id;

                if ($jabatan) {
                    // Mengambil setting honor berdasarkan jabatan
                    $jabatanHonor = Jabatan::where('id', $jabatan->id)->first();

                    if ($jabatanHonor) {
                        // Set nilai honor berdasarkan setting honor dan dikalikan jtm
                        $honor->honor = $jabatanHonor->honor_jabatan;
                        $honor->jumlah = $jabatanHonor->honor_jabatan * $request->jtm;
                    } else {
                        throw new \Exception('Honor belum diatur untuk jabatan ini.');
                    }
                }
            }
            $honor->save();
            return redirect()->route('honor.index')->with('success', 'Data honor berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Honor $honor)
    {
        try {
            $honor->delete();
            return redirect()->route('honor.index')->with('success', 'Data honor berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function getMapelByPegawai(Request $request)
    {
        $pegawaiId = $request->input('pegawai_id');

        // Query untuk mendapatkan daftar mata pelajaran berdasarkan pegawai yang dipilih
        $mapelList = PegawaiMapel::with('mapel')->where('pegawai_id', $pegawaiId)->get();
        // dd($mapelList);
        return response()->json(['mapelList' => $mapelList]);
    }


    public function getMapelByKelas(Request $request)
    {
        $kelasId = $request->input('kelas_id');
        // Query untuk mendapatkan daftar mata pelajaran berdasarkan kelas yang dipilih
        $mapelList = Mapel::where('kelas_id', $kelasId)->get();

        return response()->json(['mapelList' => $mapelList]);
    }
}
