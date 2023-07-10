<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\Pegawai;
use App\Models\PegawaiMapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function index()
    {
        $mapelList = Mapel::latest()->get();
        $pegawaiList = Pegawai::all();
        return view('mapel.index', compact('mapelList', 'pegawaiList'));
    }

    public function enroll(Request $request, Mapel $mapel)
    {
        $validatedData = $request->validate([
            'pegawai_id' => 'required|exists:pegawai,id',
        ]);

        $pegawaiId = $validatedData['pegawai_id'];

        try {
            $pegawai = Pegawai::findOrFail($pegawaiId);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mencari pegawai.');
        }

        // Periksa apakah pegawai sudah di-enroll pada mapel tersebut
        if ($pegawai && $mapel->pegawaiMapel()->where('pegawai_id', $pegawaiId)->exists()) {
            return redirect()->back()->with('error', 'Pegawai sudah di-enroll ke mata pelajaran ini.');
        }

        // Enroll pegawai ke mata pelajaran
        $pegawaiMapel = new PegawaiMapel();
        $pegawaiMapel->mapel_id = $mapel->id;
        $pegawaiMapel->pegawai_id = $pegawai->id;
        $pegawaiMapel->save();

        return redirect()->back()->with('success', 'Pegawai berhasil di-enroll ke mata pelajaran.');
    }
    public function enrollAll($mapelId)
    {
        try {
            $mapel = Mapel::findOrFail($mapelId);

            // Get all pegawai
            $pegawaiList = Pegawai::all();

            // Get the enrolled pegawai IDs for the selected mapel
            $enrolledPegawaiIds = $mapel->pegawaiMapel()->pluck('pegawai_id')->toArray();

            // Filter unenrolled pegawai
            $unenrolledPegawaiList = $pegawaiList->reject(function ($pegawai) use ($enrolledPegawaiIds) {
                return in_array($pegawai->id, $enrolledPegawaiIds);
            });

            if ($unenrolledPegawaiList->isEmpty()) {
                return redirect()->back()->with('error', 'Semua pegawai sudah di-enroll ke mata pelajaran ini.');
            }

            // Enroll all unenrolled pegawai in the selected mapel
            $pegawaiMapels = [];

            foreach ($unenrolledPegawaiList as $pegawai) {
                $pegawaiMapels[] = [
                    'mapel_id' => $mapel->id,
                    'pegawai_id' => $pegawai->id,
                ];
            }

            PegawaiMapel::insert($pegawaiMapels);

            return redirect()->back()->with('success', 'Enroll semua pegawai berhasil dilakukan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan dalam melakukan enroll semua pegawai.');
        }
    }




    public function viewEnrolledPegawai(Mapel $mapel)
    {
        $pegawaiList = $mapel->pegawaiMapel()->get();

        $mapelList = Mapel::latest()->get();
        return view('mapel.enrolled_pegawai', compact('mapel', 'pegawaiList', 'mapelList'));
    }

    public function unenroll(Mapel $mapel, PegawaiMapel $pegawaiMapel)
    {
        try {
            // Temukan relasi pegawai yang sesuai pada mapel
            $pegawai = $mapel->pegawaiMapel()->where('id', $pegawaiMapel->id)->first();

            if (!$pegawai) {
                throw new \Exception('Pegawai tidak ditemukan dalam enroll mapel.');
            }

            // Hapus relasi pegawai dari enroll mapel
            $pegawai->delete();

            return redirect()->back()->with('success', 'Pegawai berhasil dihapus dari enroll mapel.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan dalam menghapus pegawai dari enroll mapel.');
        }
    }

    public function unenrollAll(Mapel $mapel)
    {
        try {
            // Hapus semua relasi pegawai dari enroll mapel
            $mapel->pegawaiMapel()->delete();

            return redirect()->back()->with('success', 'Semua pegawai berhasil dihapus dari enroll mapel.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan dalam menghapus pegawai dari enroll mapel.');
        }
    }


    public function create()
    {
        return view('mapel.create');
    }

    public function store(Request $request)
    {
        $mapel = new Mapel;
        $mapel->nama_mapel = $request->nama_mapel;
        $mapel->save();

        return redirect()->route('mapel.index')->with('success', 'Mapel berhasil ditambahkan');
    }

    public function show(Mapel $mapel)
    {
        return view('mapel.show', compact('mapel'));
    }

    public function edit(Mapel $mapel)
    {
        return view('mapel.edit', compact('mapel'));
    }

    public function update(Request $request, Mapel $mapel)
    {
        $mapel->nama_mapel = $request->nama_mapel;
        $mapel->save();

        return redirect()->route('mapel.index')->with('success', 'Mapel berhasil diperbarui');
    }

    public function destroy(Mapel $mapel)
    {
        $mapel->delete();

        return redirect()->route('mapel.index')->with('success', 'Mapel berhasil dihapus');
    }
}
