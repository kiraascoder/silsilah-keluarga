<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class AnggotaKeluarga extends Model
{

    use HasFactory;


    protected $table =
    'anggota_keluarga';



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

        'tanggal_lahir'
        => 'date',

    ];




    public function keluarga()
    {

        return $this->belongsTo(
            Keluarga::class,
            'keluarga_id'
        );
    }





    public function orangTua()
    {

        return $this->belongsToMany(

            AnggotaKeluarga::class,

            'relasi_orang_tua_anak',

            'anak_id',

            'orang_tua_id'

        )
            ->withPivot(
                [
                    'id',
                    'jenis_hubungan'
                ]
            )
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
            ->withPivot(
                [
                    'id',
                    'jenis_hubungan'
                ]
            )
            ->withTimestamps();
    }





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





    public function getPasanganAttribute()
    {

        $pasangan = $this
            ->relasiPasanganPertama()
            ->with('anggotaKedua')
            ->first();



        if ($pasangan) {

            return $pasangan->anggotaKedua;
        }



        return $this
            ->relasiPasanganKedua()
            ->with('anggotaPertama')
            ->first()
            ?->anggotaPertama;
    }





    public function dokumen()
    {

        return $this->hasMany(
            DokumenAnggota::class,
            'anggota_id'
        );
    }
}
