<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'password'
])]
#[Hidden([
    'password',
    'remember_token'
])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Keluarga
    |--------------------------------------------------------------------------
    */

    public function keluarga()
    {
        return $this->belongsToMany(
            Keluarga::class,
            'pengguna_keluarga',
            'pengguna_id',
            'keluarga_id'
        )->withPivot([
            'id',
            'anggota_keluarga_id',
            'level_akses',
            'status',
            'bergabung_pada',
        ])->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | Data Keanggotaan
    |--------------------------------------------------------------------------
    */

    public function dataKeluarga()
    {
        return $this->hasMany(
            PenggunaKeluarga::class,
            'pengguna_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Undangan Dibuat
    |--------------------------------------------------------------------------
    */

    public function undanganDibuat()
    {
        return $this->hasMany(
            UndanganKeluarga::class,
            'diundang_oleh'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Undangan Diterima
    |--------------------------------------------------------------------------
    */

    public function undanganDiterima()
    {
        return $this->hasMany(
            UndanganKeluarga::class,
            'diterima_oleh'
        );
    }
}
