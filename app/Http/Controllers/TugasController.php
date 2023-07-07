<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use Illuminate\Http\Request;
class TugasController extends Controller
{
    public function index()
    {
        $tugasList = Tugas::latest()->get();
        return view('tugas.index', compact('tugasList'));
    }

    public function create()
    {
        return view('tugas.create');
    }

    public function store(Request $request)
    {
        $tugas = new Tugas;
        $tugas->nama_tugas = $request->nama_tugas;
        $tugas->honor = $request->honor;
        $tugas->save();

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil ditambahkan');
    }

    public function show(Tugas $tugas)
    {
        return view('tugas.show', compact('tugas'));
    }

    public function edit(Tugas $tugas)
    {
        return view('tugas.edit', compact('tugas'));
    }

    public function update(Request $request, Tugas $tugas)
    {
        $tugas->nama_tugas = $request->nama_tugas;
        $tugas->honor = $request->honor;
        $tugas->save();

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil diperbarui');
    }

    public function destroy(Tugas $tugas)
    {
        $tugas->delete();

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil dihapus');
    }

}
