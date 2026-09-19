<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use App\Models\PenggunaKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KeluargaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Pilih Keluarga
    |--------------------------------------------------------------------------
    */

    public function pilih()
    {
        $keluarga = Keluarga::whereHas(
            'pengguna',
            function ($query) {

                $query
                    ->where(
                        'users.id',
                        Auth::id()
                    )
                    ->where(
                        'pengguna_keluarga.status',
                        'aktif'
                    );

            }
        )
        ->aktif()
        ->orderBy('nama_keluarga')
        ->get();


        return view(
            'keluarga.pilih',
            compact('keluarga')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Form Buat Keluarga
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('keluarga.create');
    }


    /*
    |--------------------------------------------------------------------------
    | Simpan Keluarga
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $data = $request->validate([

            'nama_keluarga' => [
                'required',
                'string',
                'max:150',
            ],

            'asal_daerah' => [
                'nullable',
                'string',
                'max:150',
            ],

            'deskripsi' => [
                'nullable',
                'string',
            ],

            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],

        ]);


        $foto = null;


        if ($request->hasFile('foto')) {

            $foto = $request
                ->file('foto')
                ->store(
                    'keluarga',
                    'public'
                );
        }


        $keluarga = Keluarga::create([

            'nama_keluarga' =>
                $data['nama_keluarga'],

            'slug' =>
                Str::slug(
                    $data['nama_keluarga']
                )
                . '-'
                . Str::lower(
                    Str::random(5)
                ),

            'asal_daerah' =>
                $data['asal_daerah'] ?? null,

            'deskripsi' =>
                $data['deskripsi'] ?? null,

            'foto' =>
                $foto,

            'kode_undangan' =>
                Str::upper(
                    Str::random(8)
                ),

            'dibuat_oleh' =>
                Auth::id(),

            'status' =>
                'aktif',

        ]);


        /*
        |--------------------------------------------------------------------------
        | Masukkan pembuat sebagai pemilik
        |--------------------------------------------------------------------------
        */

        PenggunaKeluarga::create([

            'keluarga_id' =>
                $keluarga->id,

            'pengguna_id' =>
                Auth::id(),

            'anggota_keluarga_id' =>
                null,

            'level_akses' =>
                'pemilik',

            'status' =>
                'aktif',

            'bergabung_pada' =>
                now(),

        ]);


        /*
        |--------------------------------------------------------------------------
        | Set keluarga aktif
        |--------------------------------------------------------------------------
        */

        session([
            'keluarga_id' =>
                $keluarga->id,

            'keluarga_level_akses' =>
                'pemilik',
        ]);


        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Rumpun keluarga berhasil dibuat.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Pilih Keluarga Aktif
    |--------------------------------------------------------------------------
    */

    public function pilihAktif(
        Keluarga $keluarga
    ) {

        $keanggotaan =
            PenggunaKeluarga::where(
                'keluarga_id',
                $keluarga->id
            )
            ->where(
                'pengguna_id',
                Auth::id()
            )
            ->where(
                'status',
                'aktif'
            )
            ->first();


        if (!$keanggotaan) {

            abort(
                403,
                'Anda tidak memiliki akses ke keluarga tersebut.'
            );
        }


        session([

            'keluarga_id' =>
                $keluarga->id,

            'keluarga_level_akses' =>
                $keanggotaan->level_akses,

        ]);


        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Keluarga aktif berhasil dipilih.'
            );
    }
}
