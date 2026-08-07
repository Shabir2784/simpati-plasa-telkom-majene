<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teknisi extends Model
{
    use HasFactory;

    protected $table = 'teknisis';

    protected $fillable = [
        'user_id',
        'divisi_id',
        'nik',
        'no_hp',
        'alamat',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }
}
