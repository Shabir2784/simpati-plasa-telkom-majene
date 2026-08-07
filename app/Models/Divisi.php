<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Divisi extends Model

{
     use HasFactory;

    protected $table = 'divisis';

    protected $fillable = [
        'nama_divisi',
        'target_default',
        'keterangan'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function targetProduktivitas()
    {
        return $this->hasMany(TargetProduktivitas::class);
    }
   
    public function teknisis()
    {
        return $this->hasMany(Teknisi::class);
    }
    
}
