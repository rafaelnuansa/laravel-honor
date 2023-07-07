<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Pegawai extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'pegawai';
    protected $guarded = ['id'];
    protected $guard = 'pegawai';
    protected $username = 'kode_pegawai';
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'password' => 'hashed',
    ];
    public function payment()
    {
        return $this->hasMany(Payment::class, 'pegawai_id');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }

    public function pegawaiTugas()
    {
        return $this->hasMany(PegawaiTugas::class, 'pegawai_id');
    }
    public function mapel()
    {
        return $this->belongsToMany(Mapel::class, 'pegawai_mapel', 'pegawai_id', 'mapel_id');
    }

    public function tugas()
    {
        return $this->belongsToMany(Tugas::class, 'pegawai_tugas', 'pegawai_id', 'tugas_id');
    }

    // Nama kolom untuk username
    public function getAuthIdentifierName()
    {
        return 'kode_pegawai';
    }

    // Nilai untuk username
    public function getAuthIdentifier()
    {
        return $this->kode_pegawai;
    }

    // Nilai untuk password
    public function getAuthPassword()
    {
        return $this->password;
    }

}
