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

    /*
    |--------------------------------------------------------------------------
    | Anggota Keluarga
    |--------------------------------------------------------------------------
    */

    public function anggota()
    {
        return $this->hasMany(
            AnggotaKeluarga::class,
            'keluarga_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Pengguna Keluarga
    |--------------------------------------------------------------------------
    */

    public function pengguna()
    {
        return $this->belongsToMany(
            User::class,
            'pengguna_keluarga',
            'keluarga_id',
            'pengguna_id'
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

    public function dataPengguna()
    {
        return $this->hasMany(
            PenggunaKeluarga::class,
            'keluarga_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Undangan
    |--------------------------------------------------------------------------
    */

    public function undangan()
    {
        return $this->hasMany(
            UndanganKeluarga::class,
            'keluarga_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Kepala Keluarga
    |--------------------------------------------------------------------------
    */

    public function kepalaKeluarga()
    {
        return $this->belongsTo(
            AnggotaKeluarga::class,
            'kepala_keluarga_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Pembuat
    |--------------------------------------------------------------------------
    */

    public function pembuat()
    {
        return $this->belongsTo(
            User::class,
            'dibuat_oleh'
        );
    }
}
