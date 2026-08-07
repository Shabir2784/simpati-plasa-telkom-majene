<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TargetProduktivitas extends Model
{
    use HasFactory;

    protected $table = 'target_produktivitas';

    protected $fillable = [
        'divisi_id',
        'target'
    ];

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }
    
}
