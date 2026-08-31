<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaKeluarga extends Model
{
    use HasFactory;

    protected $table = 'anggota_keluarga';

    protected $fillable = [
        'keluarga_id',
        'pengguna_id',
        'nama_lengkap',
        'nama_panggilan',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'tanggal_meninggal',
        'golongan_darah',
        'agama',
        'pekerjaan',
        'telepon',
        'email',
        'alamat',
        'foto',
        'catatan',
        'generasi',
        'status_hidup',
        'status_data',
        'dibuat_oleh',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_meninggal' => 'date',
    ];


    /*
    |--------------------------------------------------------------------------
    | Keluarga
    |--------------------------------------------------------------------------
    */

    public function keluarga()
    {
        return $this->belongsTo(
            Keluarga::class,
            'keluarga_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Orang Tua
    |--------------------------------------------------------------------------
    */

    public function orangTua()
    {
        return $this->belongsToMany(
            AnggotaKeluarga::class,
            'relasi_orang_tua_anak',
            'anak_id',
            'orang_tua_id'
        )
            ->withPivot([
                'id',
                'jenis_hubungan',
            ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Anak
    |--------------------------------------------------------------------------
    */

    public function anak()
    {
        return $this->belongsToMany(
            AnggotaKeluarga::class,
            'relasi_orang_tua_anak',
            'orang_tua_id',
            'anak_id'
        )
            ->withPivot([
                'id',
                'jenis_hubungan',
            ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Pembuat Data
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
