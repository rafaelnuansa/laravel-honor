<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;

class KelasController extends Controller
{
    public function index()
    {
        $kelasList = Kelas::all();
        return view('kelas.index', compact('kelasList'));
    }

    public function create()
    {
        return view('kelas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required',
        ]);

        $kelas = new Kelas;
        $kelas->nama_kelas = $request->nama_kelas;
        $kelas->save();

        return redirect()->route('kelas.index')
            ->with('success', 'Kelas created successfully.');
    }

    public function show(Kelas $kelas)
    {
        return view('kelas.show', compact('kelas'));
    }

    public function edit(Kelas $kelas)
    {
        return view('kelas.edit', compact('kelas'));
    }

    public function update(Request $request, Kelas $kelas)
    {
        $request->validate([
            'nama_kelas' => 'required',
        ]);

        $kelas->nama_kelas = $request->nama_kelas;
        $kelas->save();

        return redirect()->route('kelas.index')
            ->with('success', 'Kelas updated successfully.');
    }

    public function destroy(Kelas $kelas)
    {
        $kelas->delete();

        return redirect()->route('kelas.index')
            ->with('success', 'Kelas deleted successfully.');
    }
}
