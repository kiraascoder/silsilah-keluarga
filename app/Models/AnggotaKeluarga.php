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
        'nama_lengkap',
        'nama_panggilan',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'golongan_darah',
        'generasi',
        'status',
        'foto',
        'status_data',
    ];


    protected $casts = [
        'tanggal_lahir' => 'date',
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
                'dibuat_oleh',
            ])
            ->withTimestamps();
    }


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
                'dibuat_oleh',
            ])
            ->withTimestamps();
    }


    /*
    |--------------------------------------------------------------------------
    | Relasi Pasangan
    |--------------------------------------------------------------------------
    */

    public function relasiPasanganPertama()
    {
        return $this->hasMany(
            RelasiPasangan::class,
            'anggota_pertama_id'
        );
    }


    public function relasiPasanganKedua()
    {
        return $this->hasMany(
            RelasiPasangan::class,
            'anggota_kedua_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Pasangan
    |--------------------------------------------------------------------------
    */

    public function getPasanganAttribute()
    {
        $relasi = $this
            ->relasiPasanganPertama()
            ->with('anggotaKedua')
            ->first();


        if ($relasi) {
            return $relasi->anggotaKedua;
        }


        $relasi = $this
            ->relasiPasanganKedua()
            ->with('anggotaPertama')
            ->first();


        return $relasi?->anggotaPertama;
    }


    /*
    |--------------------------------------------------------------------------
    | Dokumen
    |--------------------------------------------------------------------------
    */

    public function dokumen()
    {
        return $this->hasMany(
            DokumenAnggota::class,
            'anggota_id'
        );
    }
}
