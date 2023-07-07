<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'username' => 'required|unique:users',
                'level' => 'required',
                'password' => 'required|min:8',
            ]);

            $user = new User();
            $user->name = $request->name;
            $user->username = $request->username;
            $user->level = $request->level;
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->route('users.index')->with('success', 'User created successfully');
        } catch (\Exception $e) {
            // Handle the exception here
            return redirect()->back()->with('error', 'An error occurred while creating the user: ' . $e->getMessage());
        }
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }
    public function update(Request $request, User $user)
    {
        try {
            $request->validate([
                'name' => 'required',
                'username' => 'required|unique:users,username,' . $user->id,
                'level' => 'required',
                'password' => 'nullable|min:8',
            ]);

            $user->name = $request->name;
            $user->username = $request->username;
            $user->level = $request->level;
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            return redirect()->route('users.index')->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            // Handle the exception here
            return redirect()->back()->with('error', 'An error occurred while updating the user: ' . $e->getMessage());
        }
    }


    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
