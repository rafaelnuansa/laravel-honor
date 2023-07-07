<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public static function setAktifSemester($semesterId)
    {
        self::query()->update(['aktif' => false]);
        self::where('id', $semesterId)->update(['aktif' => true]);
    }

    public function honors()
    {
        return $this->hasMany(Honor::class);
    }
}
