<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PastikanKeluargaDipilih
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        if (!session()->has('keluarga_id')) {
            return redirect()
                ->route('keluarga.pilih');
        }

        return $next($request);
    }
}
