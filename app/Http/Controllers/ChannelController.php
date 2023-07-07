<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Channel;

class ChannelController extends Controller
{
    public function index()
    {
        $channels = Channel::all();
        return view('channels.index', compact('channels'));
    }

    public function create()
    {
        return view('channels.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
        ]);

        $channel = Channel::create($validatedData);

        return redirect()->route('channels.index')->with('success', 'Channel created successfully.');
    }

    public function edit(Channel $channel)
    {
        return view('channels.edit', compact('channel'));
    }

    public function update(Request $request, Channel $channel)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
        ]);

        $channel->update($validatedData);

        return redirect()->route('channels.index')->with('success', 'Channel updated successfully.');
    }

    public function destroy(Channel $channel)
    {
        $channel->delete();

        return redirect()->route('channels.index')->with('success', 'Channel deleted successfully.');
    }
}
