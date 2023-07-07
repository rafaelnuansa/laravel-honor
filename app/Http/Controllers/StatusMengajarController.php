<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StatusMengajar;

class StatusMengajarController extends Controller
{
    public function index()
    {
        try {
            $statusMengajars = StatusMengajar::paginate(10);
            return view('status_mengajar.index', compact('statusMengajars'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function create()
    {
        return view('status_mengajar.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'status_mengajar' => 'required'
            ]);

            StatusMengajar::create($request->all());

            return redirect()->route('status_mengajar.index')
                ->with('success', 'Status Mengajar created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $statusMengajar = StatusMengajar::find($id);

            if (!$statusMengajar) {
                return redirect()->route('status_mengajar.index')
                    ->with('error', 'Status Mengajar not found.');
            }

            return view('status_mengajar.edit', compact('statusMengajar'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'status_mengajar' => 'required'
            ]);

            $statusMengajar = StatusMengajar::find($id);

            if (!$statusMengajar) {
                return redirect()->route('status_mengajar.index')
                    ->with('error', 'Status Mengajar not found.');
            }

            $statusMengajar->update($request->all());

            return redirect()->route('status_mengajar.index')
                ->with('success', 'Status Mengajar updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $statusMengajar = StatusMengajar::find($id);

            if (!$statusMengajar) {
                return redirect()->route('status_mengajar.index')
                    ->with('error', 'Status Mengajar not found.');
            }

            $statusMengajar->delete();

            return redirect()->route('status_mengajar.index')
                ->with('success', 'Status Mengajar deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
