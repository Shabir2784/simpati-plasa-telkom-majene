<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Pekerjaan extends Model
{
    use HasFactory;

    protected $table = 'pekerjaans';

    protected $fillable = [
        'user_id',
        'nomor_tiket',
        'nomor_wo',
        'nomor_referensi',
        'jenis_referensi',
        'nama_pelanggan',
        'alamat_pelanggan',
        'jenis_pekerjaan',
        'deskripsi',
        'foto',
        'tanggal',
        'jam_selesai',
        'durasi',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
