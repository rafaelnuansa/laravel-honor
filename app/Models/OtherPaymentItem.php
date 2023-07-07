<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherPaymentItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    public function payment()
    {
        return $this->belongsTo(OtherPayment::class, 'kode_payment', 'kode_payment');
    }
}
