<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelasiPasangan extends Model
{
    use HasFactory;


    protected $table =
        'relasi_pasangan';


    protected $fillable = [
        'anggota_pertama_id',
        'anggota_kedua_id',
        'status_hubungan',
        'tanggal_mulai',
        'tanggal_berakhir',
        'catatan',
        'dibuat_oleh',
    ];


    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_berakhir' => 'date',
    ];


    public function anggotaPertama()
    {
        return $this->belongsTo(
            AnggotaKeluarga::class,
            'anggota_pertama_id'
        );
    }


    public function anggotaKedua()
    {
        return $this->belongsTo(
            AnggotaKeluarga::class,
            'anggota_kedua_id'
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
