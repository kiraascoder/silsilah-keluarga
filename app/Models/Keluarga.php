<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Keluarga extends Model
{
    use HasFactory;

    protected $table = 'keluarga';

    protected $fillable = [
        'nama_keluarga',
        'slug',
        'asal_daerah',
        'deskripsi',
        'foto',
        'kode_undangan',
        'dibuat_oleh',
        'kepala_keluarga_id',
        'status',
    ];

    public function pembuat()
    {
        return $this->belongsTo(
            User::class,
            'dibuat_oleh'
        );
    }

    public function pengguna()
    {
        return $this->belongsToMany(
            User::class,
            'pengguna_keluarga',
            'keluarga_id',
            'pengguna_id'
        )
        ->withPivot([
            'anggota_keluarga_id',
            'level_akses',
            'status',
            'bergabung_pada',
        ]);
    }

    public function anggota()
    {
        return $this->hasMany(
            AnggotaKeluarga::class,
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
}
