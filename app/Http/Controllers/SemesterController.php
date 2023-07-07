<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Semester;

class SemesterController extends Controller
{
    public function index()
    {
        $semesters = Semester::all();
        return view('semesters.index', compact('semesters'));
    }

    public function create()
    {
        return view('semesters.create');
    }

    public function store(Request $request)
    {
        $semester = new Semester;
        $semester->nama = $request->nama;
        $semester->tanggal_mulai = $request->tanggal_mulai;
        $semester->tanggal_selesai = $request->tanggal_selesai;
        $semester->save();

        return redirect()->route('semesters.index')->with('success', 'Data semester berhasil ditambahkan');
    }

    public function edit(Semester $semester)
    {
        return view('semesters.edit', compact('semester'));
    }

    public function update(Request $request, Semester $semester)
    {
        $semester->nama = $request->nama;
        $semester->tanggal_mulai = $request->tanggal_mulai;
        $semester->tanggal_selesai = $request->tanggal_selesai;
        $semester->save();

        return redirect()->route('semesters.index')->with('success', 'Data semester berhasil diperbarui');
    }

    public function destroy(Semester $semester)
    {
        $semester->delete();
        return redirect()->route('semesters.index')->with('success', 'Data semester berhasil dihapus');
    }

    public function setAktifSemester(Request $request)
    {
        $tanggal = $request->tanggal;

        // Cari semester berdasarkan tanggal
        $semester = Semester::where('tanggal_mulai', '<=', $tanggal)
            ->where('tanggal_selesai', '>=', $tanggal)
            ->first();

        if ($semester) {
            // Set semester aktif
            Semester::setAktifSemester($semester->id);
            return redirect()->route('semesters.index')->with('success', 'Semester aktif berhasil diubah');
        }

        return redirect()->route('semesters.index')->with('error', 'Tidak ada semester aktif pada tanggal tersebut');
    }

    public function setActiveSemester(Request $request, Semester $semester)
    {
        // Set all semesters to inactive
        Semester::where('id', '!=', $semester->id)->update(['aktif' => false]);

        // Set the selected semester as active
        $semester->aktif = true;
        $semester->save();

        return redirect()->route('semesters.index')->with('success', 'Active semester set successfully');
    }
}
