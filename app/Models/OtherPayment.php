<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherPayment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function items()
    {
        return $this->hasMany(OtherPaymentItem::class, 'kode_payment', 'kode_payment');
    }


}
