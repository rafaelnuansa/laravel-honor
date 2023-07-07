<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;
    protected $table = 'jabatan';
    protected $guarded = ['id'];


    public function pegawai()
    {
        return $this->hasMany(Pegawai::class, 'jabatan_id');
    }

    public function settingHonors()
    {
        return $this->hasMany(SettingHonor::class, 'jabatan_id');
    }


}
