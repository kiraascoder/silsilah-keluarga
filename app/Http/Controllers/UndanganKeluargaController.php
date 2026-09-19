<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKeluarga;
use App\Models\Keluarga;
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
    | Form Undangan
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('undangan.create');
    }


    /*
    |--------------------------------------------------------------------------
    | Buat Undangan
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $keluargaId = session('keluarga_id');

        $data = $request->validate([
            'email' => [
                'required',
                'email',
                'max:255',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Cek apakah email sudah menjadi anggota keluarga
        |--------------------------------------------------------------------------
        */

        $sudahMenjadiAnggota = Keluarga::where(
            'id',
            $keluargaId
        )
            ->whereHas(
                'pengguna',
                function ($query) use ($data) {
                    $query->where(
                        'email',
                        $data['email']
                    );
                }
            )
            ->exists();


        if ($sudahMenjadiAnggota) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Pengguna tersebut sudah menjadi anggota keluarga.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Cek undangan yang masih aktif
        |--------------------------------------------------------------------------
        */

        $undanganAktif = UndanganKeluarga::where(
            'keluarga_id',
            $keluargaId
        )
            ->where(
                'email',
                $data['email']
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
        | Buat undangan
        |--------------------------------------------------------------------------
        */

        $undangan = UndanganKeluarga::create([

            'keluarga_id' =>
            $keluargaId,

            'diundang_oleh' =>
            auth()->id(),

            'email' =>
            $data['email'],

            'kode_undangan' =>
            Str::random(64),

            'status' =>
            'menunggu',

            'kedaluwarsa_pada' =>
            now()->addDays(7),

        ]);


        /*
        |--------------------------------------------------------------------------
        | Untuk tahap awal
        |--------------------------------------------------------------------------
        |
        | Belum mengirim email.
        | Kita tampilkan kode terlebih dahulu
        | untuk testing.
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
        $undangan = UndanganKeluarga::where(
            'kode_undangan',
            $kode
        )
            ->where(
                'status',
                'menunggu'
            )
            ->first();


        if (!$undangan) {

            return redirect()
                ->route('dashboard')
                ->with(
                    'error',
                    'Undangan tidak ditemukan atau sudah tidak berlaku.'
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
                ->route('dashboard')
                ->with(
                    'error',
                    'Undangan sudah kedaluwarsa.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | User harus login
        |--------------------------------------------------------------------------
        */

        if (!auth()->check()) {

            session([
                'kode_undangan' => $kode,
            ]);

            return redirect()
                ->route('login');
        }


        /*
        |--------------------------------------------------------------------------
        | Pastikan email sesuai
        |--------------------------------------------------------------------------
        */

        if (
            strtolower(auth()->user()->email)
            !== strtolower($undangan->email)
        ) {

            return redirect()
                ->route('dashboard')
                ->with(
                    'error',
                    'Undangan ini ditujukan untuk email yang berbeda.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Cegah keanggotaan duplikat
        |--------------------------------------------------------------------------
        */

        $sudahAda = $undangan
            ->keluarga
            ->pengguna()
            ->where(
                'users.id',
                auth()->id()
            )
            ->exists();


        if (!$sudahAda) {

            $undangan
                ->keluarga
                ->pengguna()
                ->attach(
                    auth()->id(),
                    [
                        'level_akses' => 'anggota',
                        'status' => 'aktif',
                    ]
                );
        }


        $undangan->update([

            'status' =>
            'diterima',

            'diterima_oleh' =>
            auth()->id(),

            'diterima_pada' =>
            now(),

        ]);


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
