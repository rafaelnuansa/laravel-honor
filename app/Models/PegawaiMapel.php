<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiMapel extends Model
{
    use HasFactory;
    protected $table = 'pegawai_mapel';
    protected $guarded = ['id'];

        public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
