<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenggunaKeluarga extends Model
{
    use HasFactory;

    protected $table = 'pengguna_keluarga';

    protected $fillable = [
        'keluarga_id',
        'pengguna_id',
        'anggota_keluarga_id',
        'level_akses',
        'status',
        'bergabung_pada',
    ];

    protected $casts = [
        'bergabung_pada' => 'datetime',
    ];

    public function keluarga()
    {
        return $this->belongsTo(
            Keluarga::class,
            'keluarga_id'
        );
    }

    public function pengguna()
    {
        return $this->belongsTo(
            User::class,
            'pengguna_id'
        );
    }

    public function anggota()
    {
        return $this->belongsTo(
            AnggotaKeluarga::class,
            'anggota_keluarga_id'
        );
    }
}
