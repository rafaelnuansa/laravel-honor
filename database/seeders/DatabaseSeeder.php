<?php

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('admin'),
        ]);

        Setting::create([
            'nama_aplikasi' => 'Sihonor',
            'logo_aplikasi' => 'logo.png',
            'nama_sekolah' => 'SMK Laravel',
            'logo_sekolah' => 'logo_sekolah.png',
            'alamat_sekolah' => 'Alamat Sekolah',
            'nomor_kontak' => '123456789',
            'nama_ttd_invoice' => 'Nama Penandatangan Invoice',
            'jabatan_ttd_invoice' => 'Jabatan Penandatangan Invoice',
            'catatan_invoice' => 'Catatan Invoice',
            'img_login' => 'login.png',
        ]);
    }
}
