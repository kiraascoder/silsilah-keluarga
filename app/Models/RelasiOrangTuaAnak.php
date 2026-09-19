<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelasiOrangTuaAnak extends Model
{
    use HasFactory;


    protected $table =
        'relasi_orang_tua_anak';


    protected $fillable = [
        'orang_tua_id',
        'anak_id',
        'jenis_hubungan',
        'dibuat_oleh',
    ];


    public function orangTua()
    {
        return $this->belongsTo(
            AnggotaKeluarga::class,
            'orang_tua_id'
        );
    }


    public function anak()
    {
        return $this->belongsTo(
            AnggotaKeluarga::class,
            'anak_id'
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
