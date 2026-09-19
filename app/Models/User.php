<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
    ];
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function keluarga()
    {
        return $this->belongsToMany(
            Keluarga::class,
            'pengguna_keluarga',
            'user_id',
            'keluarga_id'
        )->withPivot([
            'level_akses',
            'status',
        ])->withTimestamps();
    }
    public function undanganDibuat()
    {
        return $this->hasMany(
            UndanganKeluarga::class,
            'diundang_oleh'
        );
    }


    public function undanganDiterima()
    {
        return $this->hasMany(
            UndanganKeluarga::class,
            'diterima_oleh'
        );
    }
}
