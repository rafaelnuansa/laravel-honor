<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jabatan;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatanList = Jabatan::latest()->get();
        return view('jabatan.index', compact('jabatanList'));
    }

    public function create()
    {
        return view('jabatan.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama_jabatan' => 'required',
            'honor_jabatan' => 'required|numeric',
        ]);

        try {
            // Simpan data pada tabel Jabatan
            $jabatan = new Jabatan;
            $jabatan->nama_jabatan = $validatedData['nama_jabatan'];
            $jabatan->honor_jabatan = $validatedData['honor_jabatan'];
            $jabatan->save();

            return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function show(Jabatan $jabatan)
    {
        return view('jabatan.show', compact('jabatan'));
    }

    public function edit(Jabatan $jabatan)
    {
        return view('jabatan.edit', compact('jabatan'));
    }

    public function update(Request $request, Jabatan $jabatan)
    {
        $jabatan->nama_jabatan = $request->nama_jabatan;
        $jabatan->honor_jabatan = $request->honor_jabatan;
        $jabatan->save();

        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil diperbarui');
    }

    public function destroy(Jabatan $jabatan)
    {
        $jabatan->delete();

        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil dihapus');
    }
}
