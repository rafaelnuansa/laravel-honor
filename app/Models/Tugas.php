<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    protected $table = 'tugas';
    protected $guarded = ['id'];

    public function pegawaiTugas()
    {
        return $this->hasMany(PegawaiTugas::class, 'tugas_id');
    }
}
