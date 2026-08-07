<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;


    protected $fillable = [
        'nama',
        'nik',
        'email',
        'password',
        'role',
        'divisi_id',
        'no_hp',
        'foto',
        'is_active'
    ];

    // public function getAuthIdentifierName()
    // {
    //     return 'nik';
    // }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }
    
    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
    

    public function absensiTerakhir()
    {
        return $this->hasOne(Absensi::class)->latestOfMany();
    }

    public function pekerjaan()
    {
        return $this->hasMany(Pekerjaan::class);
    }
    public function teknisi()
    {
        return $this->hasOne(Teknisi::class);
    }

    public function lokasiTeknisi()
    {
        return $this->hasMany(LokasiTeknisi::class);
    }
    public function lokasiTerakhir()
    {
        return $this->hasOne(LokasiTeknisi::class)->latestOfMany();
    }

    public function logAktivitas()
    {
        return $this->hasMany(LogAktivitas::class);
    }
}

