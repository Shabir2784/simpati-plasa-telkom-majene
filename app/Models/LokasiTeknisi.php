<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiTeknisi extends Model
{
    use HasFactory;

    protected $table = 'lokasi_teknisis';

    protected $fillable = [
        'user_id',
        'absensi_id',
        'latitude',
        'longitude',
        'alamat',
        'waktu_update'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function absensi()
    {
        return $this->belongsTo(Absensi::class);
    }
}
