<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keluarga extends Model
{
    use HasFactory;

    protected $table = 'keluarga';

    protected $fillable = [
        'nama_keluarga',
        'deskripsi',
        'kepala_keluarga_id',
        'dibuat_oleh',
    ];


    public function anggota()
    {
        return $this->hasMany(
            AnggotaKeluarga::class,
            'keluarga_id'
        );
    }


    public function pengguna()
    {
        return $this->belongsToMany(
            User::class,
            'pengguna_keluarga',
            'keluarga_id',
            'user_id'
        )->withPivot([
            'level_akses',
            'status',
        ])->withTimestamps();
    }


    public function undangan()
    {
        return $this->hasMany(
            UndanganKeluarga::class,
            'keluarga_id'
        );
    }


    public function kepalaKeluarga()
    {
        return $this->belongsTo(
            AnggotaKeluarga::class,
            'kepala_keluarga_id'
        );
    }


    public function pembuat()
    {
        return $this->belongsTo(
            User::class,
            'dibuat_oleh'
        );
    }
}
