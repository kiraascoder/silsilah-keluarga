<?php

namespace App\Http\Controllers;

use App\Models\PenggunaKeluarga;
use App\Models\UndanganKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UndanganKeluargaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Daftar Undangan
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $keluargaId = session('keluarga_id');

        $undangan = UndanganKeluarga::where(
            'keluarga_id',
            $keluargaId
        )
            ->with('pengundang')
            ->latest()
            ->get();

        return view(
            'undangan.index',
            compact('undangan')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Form Tambah
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('undangan.create');
    }

    /*
    |--------------------------------------------------------------------------
    | Simpan Undangan
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $keluargaId = session('keluarga_id');

        $data = $request->validate([
            'email' => [
                'required',
                'email',
                'max:150',
            ],
        ]);

        $email = strtolower(
            trim($data['email'])
        );

        /*
        |--------------------------------------------------------------------------
        | Cek apakah sudah menjadi anggota
        |--------------------------------------------------------------------------
        */

        $sudahMenjadiAnggota =
            PenggunaKeluarga::where(
                'keluarga_id',
                $keluargaId
            )
            ->whereHas(
                'pengguna',
                function ($query) use ($email) {

                    $query->where(
                        'email',
                        $email
                    );
                }
            )
            ->where(
                'status',
                'aktif'
            )
            ->exists();

        if ($sudahMenjadiAnggota) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Email tersebut sudah menjadi anggota keluarga.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Cek undangan aktif
        |--------------------------------------------------------------------------
        */

        $undanganAktif =
            UndanganKeluarga::where(
                'keluarga_id',
                $keluargaId
            )
            ->whereRaw(
                'LOWER(email) = ?',
                [$email]
            )
            ->where(
                'status',
                'menunggu'
            )
            ->where(
                'kedaluwarsa_pada',
                '>',
                now()
            )
            ->exists();

        if ($undanganAktif) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Undangan untuk email tersebut masih aktif.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Buat kode unik
        |--------------------------------------------------------------------------
        */

        do {

            $kode = Str::random(48);
        } while (
            UndanganKeluarga::where(
                'kode_undangan',
                $kode
            )->exists()
        );

        /*
        |--------------------------------------------------------------------------
        | Simpan undangan
        |--------------------------------------------------------------------------
        */

        $undangan = UndanganKeluarga::create([
            'keluarga_id' =>
            $keluargaId,

            'diundang_oleh' =>
            auth()->id(),

            'email' =>
            $email,

            'kode_undangan' =>
            $kode,

            'status' =>
            'menunggu',

            'kedaluwarsa_pada' =>
            now()->addDays(7),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Tahap testing
        |--------------------------------------------------------------------------
        |
        | Belum mengirim email.
        | Link ditampilkan pada halaman daftar.
        |
        */

        return redirect()
            ->route('undangan.index')
            ->with(
                'success',
                'Undangan berhasil dibuat.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Terima Undangan
    |--------------------------------------------------------------------------
    */

    public function terima($kode)
    {
        $undangan =
            UndanganKeluarga::where(
                'kode_undangan',
                $kode
            )->first();

        /*
        |--------------------------------------------------------------------------
        | Undangan tidak ditemukan
        |--------------------------------------------------------------------------
        */

        if (!$undangan) {

            return redirect()
                ->route(
                    auth()->check()
                        ? 'keluarga.pilih'
                        : 'login'
                )
                ->with(
                    'error',
                    'Undangan tidak ditemukan.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Cek status
        |--------------------------------------------------------------------------
        */

        if (
            $undangan->status !== 'menunggu'
        ) {

            return redirect()
                ->route(
                    auth()->check()
                        ? 'keluarga.pilih'
                        : 'login'
                )
                ->with(
                    'error',
                    'Undangan ini sudah tidak dapat digunakan.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Cek kedaluwarsa
        |--------------------------------------------------------------------------
        */

        if (
            $undangan->kedaluwarsa_pada &&
            $undangan->kedaluwarsa_pada->isPast()
        ) {

            $undangan->update([
                'status' => 'kedaluwarsa',
            ]);

            return redirect()
                ->route(
                    auth()->check()
                        ? 'keluarga.pilih'
                        : 'login'
                )
                ->with(
                    'error',
                    'Undangan sudah kedaluwarsa.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | User belum login
        |--------------------------------------------------------------------------
        */

        if (!auth()->check()) {

            session([
                'kode_undangan' =>
                $kode,
            ]);

            return redirect()
                ->route('login');
        }

        /*
        |--------------------------------------------------------------------------
        | Pastikan email sesuai
        |--------------------------------------------------------------------------
        */

        $emailUser = strtolower(
            trim(auth()->user()->email)
        );

        $emailUndangan = strtolower(
            trim($undangan->email)
        );

        if (
            $emailUser !==
            $emailUndangan
        ) {

            return redirect()
                ->route('keluarga.pilih')
                ->with(
                    'error',
                    'Undangan ini ditujukan untuk email yang berbeda.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Cek keanggotaan
        |--------------------------------------------------------------------------
        */

        $keanggotaan =
            PenggunaKeluarga::where(
                'keluarga_id',
                $undangan->keluarga_id
            )
            ->where(
                'pengguna_id',
                auth()->id()
            )
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Jika belum ada, buat keanggotaan
        |--------------------------------------------------------------------------
        */

        if (!$keanggotaan) {

            $keanggotaan =
                PenggunaKeluarga::create([

                    'keluarga_id' =>
                    $undangan->keluarga_id,

                    'pengguna_id' =>
                    auth()->id(),

                    'anggota_keluarga_id' =>
                    null,

                    'level_akses' =>
                    'anggota',

                    'status' =>
                    'aktif',

                    'bergabung_pada' =>
                    now(),

                ]);
        } else {

            /*
            |--------------------------------------------------------------------------
            | Jika sudah ada tetapi pending
            |--------------------------------------------------------------------------
            */

            $keanggotaan->update([

                'level_akses' =>
                'anggota',

                'status' =>
                'aktif',

                'bergabung_pada' =>
                $keanggotaan->bergabung_pada
                    ?? now(),

            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Tandai undangan diterima
        |--------------------------------------------------------------------------
        */

        $undangan->update([

            'status' =>
            'diterima',

            'diterima_oleh' =>
            auth()->id(),

            'diterima_pada' =>
            now(),

        ]);

        /*
        |--------------------------------------------------------------------------
        | Set keluarga aktif
        |--------------------------------------------------------------------------
        */

        session([

            'keluarga_id' =>
            $undangan->keluarga_id,

            'keluarga_level_akses' =>
            'anggota',

        ]);

        session()->forget(
            'kode_undangan'
        );

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Anda berhasil bergabung ke keluarga.'
            );
    }
}
