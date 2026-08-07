<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensis';

    protected $fillable = [
        'user_id',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'latitude_masuk',
        'longitude_masuk',
        'latitude_keluar',
        'longitude_keluar',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lokasiTeknisi()
    {
        return $this->hasMany(LokasiTeknisi::class);
    }
    // public function lokasiTerakhir()
    // {
    //     return $this->hasOne(LokasiTeknisi::class)->latestOfMany();
    // }
}

