<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public function other_payments()
    {
        return $this->hashMany(OtherPayment::class);
    }

    public function payments()
    {
        return $this->hashMany(Payment::class);
    }
}
