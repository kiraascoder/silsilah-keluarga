<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UndanganKeluarga extends Model
{
    use HasFactory;

    protected $table = 'undangan_keluarga';

    protected $fillable = [
        'keluarga_id',
        'diundang_oleh',
        'email',
        'kode_undangan',
        'status',
        'kedaluwarsa_pada',
        'diterima_oleh',
        'diterima_pada',
    ];

    protected $casts = [
        'kedaluwarsa_pada' => 'datetime',
        'diterima_pada' => 'datetime',
    ];


    public function keluarga()
    {
        return $this->belongsTo(
            Keluarga::class,
            'keluarga_id'
        );
    }


    public function pengundang()
    {
        return $this->belongsTo(
            User::class,
            'diundang_oleh'
        );
    }


    public function penerima()
    {
        return $this->belongsTo(
            User::class,
            'diterima_oleh'
        );
    }
}
