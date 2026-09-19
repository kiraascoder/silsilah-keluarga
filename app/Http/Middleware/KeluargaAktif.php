<?php

namespace App\Http\Middleware;

use App\Models\Keluarga;
use App\Models\PenggunaKeluarga;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KeluargaAktif
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {

        /*
        |--------------------------------------------------------------------------
        | Pastikan login
        |--------------------------------------------------------------------------
        */

        if (!auth()->check()) {
            return redirect()
                ->route('login');
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil keluarga aktif
        |--------------------------------------------------------------------------
        */

        $keluargaId =
            session('keluarga_id');


        if (!$keluargaId) {

            return redirect()
                ->route('keluarga.pilih')
                ->with(
                    'error',
                    'Silakan pilih keluarga terlebih dahulu.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Cari keluarga
        |--------------------------------------------------------------------------
        */

        $keluarga =
            Keluarga::aktif()
                ->where(
                    'id',
                    $keluargaId
                )
                ->first();


        if (!$keluarga) {

            session()->forget([
                'keluarga_id',
                'keluarga_level_akses',
            ]);


            return redirect()
                ->route('keluarga.pilih')
                ->with(
                    'error',
                    'Keluarga aktif tidak ditemukan.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Pastikan user adalah anggota keluarga
        |--------------------------------------------------------------------------
        */

        $keanggotaan =
            PenggunaKeluarga::where(
                'keluarga_id',
                $keluarga->id
            )
            ->where(
                'pengguna_id',
                auth()->id()
            )
            ->where(
                'status',
                'aktif'
            )
            ->first();


        if (!$keanggotaan) {

            session()->forget([
                'keluarga_id',
                'keluarga_level_akses',
            ]);


            return redirect()
                ->route('keluarga.pilih')
                ->with(
                    'error',
                    'Anda tidak memiliki akses ke keluarga tersebut.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Sinkronkan level akses
        |--------------------------------------------------------------------------
        */

        session([
            'keluarga_level_akses' =>
                $keanggotaan->level_akses,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Share ke Blade
        |--------------------------------------------------------------------------
        */

        view()->share(
            'keluargaAktif',
            $keluarga
        );


        view()->share(
            'levelAksesKeluarga',
            $keanggotaan->level_akses
        );


        return $next($request);
    }
}
