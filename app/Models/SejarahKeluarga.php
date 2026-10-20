<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SejarahKeluarga extends Model
{
    use HasFactory;

    protected $table = 'sejarah_keluarga';

    protected $fillable = [
        'keluarga_id',
        'judul',
        'tanggal',
        'deskripsi',
        'dibuat_oleh',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class, 'keluarga_id');
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}
