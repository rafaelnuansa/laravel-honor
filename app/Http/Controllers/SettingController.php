<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display the application settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Response
    {
        $settings = Setting::first();
        return response()->view('settings.index', compact('settings'));
    }

    /**
     * Update the application settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $settings = Setting::first();
        $settings->nama_aplikasi = $request->input('nama_aplikasi');

        // Logo Aplikasi
        if ($request->hasFile('logo_aplikasi')) {
            $this->deleteFile($settings->logo_aplikasi); // Hapus gambar lama jika ada

            $logoAplikasi = $request->file('logo_aplikasi');
            $logoAplikasiPath = $logoAplikasi->storeAs('images', $logoAplikasi->hashName(), 'public');
            $settings->logo_aplikasi = $logoAplikasiPath;
        }

        $settings->nama_sekolah = $request->input('nama_sekolah');

        // Logo Sekolah
        if ($request->hasFile('logo_sekolah')) {
            $this->deleteFile($settings->logo_sekolah); // Hapus gambar lama jika ada

            $logoSekolah = $request->file('logo_sekolah');
            $logoSekolahPath = $logoSekolah->storeAs('images', $logoSekolah->hashName(), 'public');
            $settings->logo_sekolah = $logoSekolahPath;
        }

        $settings->alamat_sekolah = $request->input('alamat_sekolah');
        $settings->nomor_kontak = $request->input('nomor_kontak');
        $settings->nama_ttd_invoice = $request->input('nama_ttd_invoice');
        $settings->jabatan_ttd_invoice = $request->input('jabatan_ttd_invoice');
        $settings->catatan_invoice = $request->input('catatan_invoice');

        // Img Login
        if ($request->hasFile('img_login')) {
            $this->deleteFile($settings->img_login); // Hapus gambar lama jika ada

            $imgLogin = $request->file('img_login');
            $imgLoginPath = $imgLogin->storeAs('images', $imgLogin->hashName(), 'public');
            $settings->img_login = $imgLoginPath;
        }

        $settings->save();

        return Redirect::route('settings.index')->with('success', 'Settings updated successfully.');
    }

    /**
     * Delete a file from storage.
     *
     * @param  string|null  $path
     * @return void
     */
    private function deleteFile(?string $path)
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
