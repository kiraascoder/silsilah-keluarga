<?php

namespace App\Http\Middleware;

use App\Models\Keluarga;
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
        | Pastikan user sudah login
        |--------------------------------------------------------------------------
        */

        if (!auth()->check()) {
            return redirect()->route('login');
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil keluarga aktif dari session
        |--------------------------------------------------------------------------
        */

        $keluargaId = session('keluarga_id');


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
        | Pastikan keluarga masih tersedia
        |--------------------------------------------------------------------------
        */

        $keluarga = Keluarga::find($keluargaId);


        if (!$keluarga) {

            session()->forget([
                'keluarga_id',
                'keluarga_level_akses',
            ]);

            return redirect()
                ->route('keluarga.pilih')
                ->with(
                    'error',
                    'Keluarga yang dipilih tidak ditemukan.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Pastikan user memiliki akses ke keluarga
        |--------------------------------------------------------------------------
        */

        $keanggotaan = $keluarga
            ->pengguna()
            ->where('users.id', auth()->id())
            ->wherePivot('status', 'aktif')
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
        | Simpan data akses ke session
        |--------------------------------------------------------------------------
        */

        session([
            'keluarga_level_akses' =>
            $keanggotaan->pivot->level_akses,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Bagikan keluarga aktif ke seluruh view
        |--------------------------------------------------------------------------
        */

        view()->share(
            'keluargaAktif',
            $keluarga
        );


        view()->share(
            'levelAksesKeluarga',
            $keanggotaan->pivot->level_akses
        );


        return $next($request);
    }
}
