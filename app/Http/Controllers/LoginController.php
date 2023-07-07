<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{

    use AuthenticatesUsers;
    protected $redirectTo = RouteServiceProvider::HOME;
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout'
        ]);
    }

    public function index()
    {
        return view('login');
    }


    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        // Check if user exists in the users table
        $user = User::where('username', $username)->first();

        if ($user) {
            return $this->loginAsUser($user, $password);
        }

        // User not found in the users table
        return $this->loginAsPegawai($username, $password);
    }

    private function loginAsUser($user, $password)
    {
        try {
            $loginResult = Auth::guard('users')->attempt(['username' => $user->username, 'password' => $password]);

            if ($loginResult) {
                Auth::guard('pegawai')->logout(); // Logout pegawai
                return redirect()->route('dashboard.index')->with('success', 'Login berhasil');
            }

        } catch (\Exception $e) {
            // Exception occurred during login
            return redirect()->back()->with('error', 'Terjadi kesalahan saat proses login.');
        }

        // Login failed
        return redirect()->back()->with('error', 'Login gagal, periksa kembali username dan password Anda.');
    }

    private function loginAsPegawai($username, $password)
    {
        // Check if pegawai exists in the pegawai table
        $pegawai = Pegawai::where('kode_pegawai', $username)->first();
        if ($pegawai && Hash::check($password, $pegawai->password)) {
            Auth::guard('users')->logout(); // Logout users
            Auth::guard('pegawai')->attempt(['kode_pegawai' => $pegawai->username, 'password' => $password]);
            Auth::guard('pegawai')->login($pegawai); // Login pegawai
            return redirect()->route('dashboard.index')->with('success', 'Login Sebagai Pegawai berhasil');
        }

        // Login failed
        return redirect()->back()->with('error', 'Login gagal, periksa kembali username dan password Anda.');
    }




    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        Auth::guard('pegawai')->logout();
        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }
}
