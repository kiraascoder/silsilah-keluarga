<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use App\Models\PenggunaKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $keluarga = Keluarga::whereHas('pengguna', function ($query) {
            $query->where('pengguna_id', auth()->id());
        })
            ->where('status', 'aktif')
            ->orderBy('nama_keluarga')
            ->get();

        return view('keluarga.pilih', compact('keluarga'));
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
        ]);

        $slug = Str::slug($data['nama_keluarga']);

        $baseSlug = $slug;
        $counter = 1;

        while (
            Keluarga::where('slug', $slug)->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        do {
            $kodeUndangan = strtoupper(
                Str::random(10)
            );
        } while (
            Keluarga::where(
                'kode_undangan',
                $kodeUndangan
            )->exists()
        );

        DB::transaction(function () use (
            $data,
            $slug,
            $kodeUndangan,
            &$keluarga
        ) {

            $keluarga = Keluarga::create([
                'nama_keluarga' =>
                $data['nama_keluarga'],

                'slug' =>
                $slug,

                'asal_daerah' =>
                $data['asal_daerah'] ?? null,

                'deskripsi' =>
                $data['deskripsi'] ?? null,

                'kode_undangan' =>
                $kodeUndangan,

                'dibuat_oleh' =>
                auth()->id(),

                'status' =>
                'aktif',
            ]);

            $keluarga->pengguna()->attach(
                auth()->id(),
                [
                    'level_akses' =>
                    'pemilik',

                    'status' =>
                    'aktif',

                    'bergabung_pada' =>
                    now(),
                ]
            );
        });

        return redirect()
            ->route('keluarga.pilih')
            ->with(
                'success',
                'Keluarga berhasil dibuat.'
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
