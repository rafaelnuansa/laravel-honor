<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';
    protected $guarded = ['id'];

    protected $casts = [
        'tugas_ids' => 'array',
    ];
    public function tugas()
    {
        return $this->belongsToMany(Tugas::class, 'tugas',  'tugas_id');
    }
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }


    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

}
