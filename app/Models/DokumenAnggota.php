<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenAnggota extends Model
{
    use HasFactory;

    protected $table = 'dokumen_anggota';

    protected $fillable = [
        'anggota_id',
        'nama_dokumen',
        'jenis_dokumen',
        'file',
        'keterangan',
        'diunggah_oleh',
    ];


    public function anggota()
    {
        return $this->belongsTo(
            AnggotaKeluarga::class,
            'anggota_id'
        );
    }


    public function pengunggah()
    {
        return $this->belongsTo(
            User::class,
            'diunggah_oleh'
        );
    }
}
