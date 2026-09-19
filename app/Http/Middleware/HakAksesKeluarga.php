<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HakAksesKeluarga
{
    public function handle(
        Request $request,
        Closure $next,
        ...$levelYangDiizinkan
    ): Response {

        $levelAkses = session(
            'keluarga_level_akses'
        );


        /*
        |--------------------------------------------------------------------------
        | Tidak memiliki level akses
        |--------------------------------------------------------------------------
        */

        if (!$levelAkses) {

            return redirect()
                ->route('keluarga.pilih')
                ->with(
                    'error',
                    'Hak akses keluarga tidak ditemukan.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Periksa level akses
        |--------------------------------------------------------------------------
        */

        if (!in_array(
            $levelAkses,
            $levelYangDiizinkan,
            true
        )) {

            abort(
                403,
                'Anda tidak memiliki izin untuk melakukan tindakan ini.'
            );
        }


        return $next($request);
    }
}
