<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKeluarga;
use App\Models\RelasiPasangan;
use Illuminate\Http\Request;

class RelasiPasanganController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Form Tambah Pasangan
    |--------------------------------------------------------------------------
    */

    public function create($id)
    {
        $keluargaId = session('keluarga_id');


        $anggota = AnggotaKeluarga::query()
            ->where(
                'keluarga_id',
                $keluargaId
            )
            ->where(
                'status_data',
                'aktif'
            )
            ->where(
                'id',
                $id
            )
            ->firstOrFail();


        $daftarAnggota = AnggotaKeluarga::query()
            ->where(
                'keluarga_id',
                $keluargaId
            )
            ->where(
                'status_data',
                'aktif'
            )
            ->where(
                'id',
                '!=',
                $anggota->id
            )
            ->orderBy(
                'nama_lengkap'
            )
            ->get();


        return view(
            'pasangan.create',
            compact(
                'anggota',
                'daftarAnggota'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Simpan Pasangan
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $keluargaId = session('keluarga_id');


        $data = $request->validate([

            'anggota_utama_id' => [
                'required',
                'integer',
                'different:anggota_pasangan_id',
            ],

            'anggota_pasangan_id' => [
                'required',
                'integer',
                'different:anggota_utama_id',
            ],

            'tanggal_mulai' => [
                'nullable',
                'date',
            ],

            'tanggal_berakhir' => [
                'nullable',
                'date',
                'after_or_equal:tanggal_mulai',
            ],

            'catatan' => [
                'nullable',
                'string',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Ambil anggota utama
        |--------------------------------------------------------------------------
        */

        $anggotaUtama = AnggotaKeluarga::query()
            ->where(
                'keluarga_id',
                $keluargaId
            )
            ->where(
                'status_data',
                'aktif'
            )
            ->where(
                'id',
                $data['anggota_utama_id']
            )
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Ambil pasangan
        |--------------------------------------------------------------------------
        */

        $anggotaPasangan = AnggotaKeluarga::query()
            ->where(
                'keluarga_id',
                $keluargaId
            )
            ->where(
                'status_data',
                'aktif'
            )
            ->where(
                'id',
                $data['anggota_pasangan_id']
            )
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Cegah pasangan yang sama
        |--------------------------------------------------------------------------
        |
        | Kita cek dua arah:
        |
        | A -> B
        | B -> A
        |
        | karena database unique biasa hanya mencegah kombinasi
        | yang benar-benar sama.
        |--------------------------------------------------------------------------
        */

        $relasiSudahAda = RelasiPasangan::query()
            ->where(function ($query) use (
                $anggotaUtama,
                $anggotaPasangan
            ) {

                $query
                    ->where(
                        'anggota_pertama_id',
                        $anggotaUtama->id
                    )
                    ->where(
                        'anggota_kedua_id',
                        $anggotaPasangan->id
                    );

            })
            ->orWhere(function ($query) use (
                $anggotaUtama,
                $anggotaPasangan
            ) {

                $query
                    ->where(
                        'anggota_pertama_id',
                        $anggotaPasangan->id
                    )
                    ->where(
                        'anggota_kedua_id',
                        $anggotaUtama->id
                    );

            })
            ->exists();


        if ($relasiSudahAda) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Hubungan pasangan antara kedua anggota tersebut sudah pernah dicatat.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Cek pasangan aktif anggota utama
        |--------------------------------------------------------------------------
        */

        $utamaMemilikiPasanganAktif =
            RelasiPasangan::query()
                ->where(
                    'status_hubungan',
                    'suami_istri'
                )
                ->where(function ($query) use (
                    $anggotaUtama
                ) {

                    $query
                        ->where(
                            'anggota_pertama_id',
                            $anggotaUtama->id
                        )
                        ->orWhere(
                            'anggota_kedua_id',
                            $anggotaUtama->id
                        );

                })
                ->exists();


        if ($utamaMemilikiPasanganAktif) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Anggota tersebut masih memiliki pasangan aktif.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Cek pasangan aktif anggota kedua
        |--------------------------------------------------------------------------
        */

        $pasanganMemilikiPasanganAktif =
            RelasiPasangan::query()
                ->where(
                    'status_hubungan',
                    'suami_istri'
                )
                ->where(function ($query) use (
                    $anggotaPasangan
                ) {

                    $query
                        ->where(
                            'anggota_pertama_id',
                            $anggotaPasangan->id
                        )
                        ->orWhere(
                            'anggota_kedua_id',
                            $anggotaPasangan->id
                        );

                })
                ->exists();


        if ($pasanganMemilikiPasanganAktif) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Anggota yang dipilih masih memiliki pasangan aktif.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Simpan relasi
        |--------------------------------------------------------------------------
        */

        RelasiPasangan::create([

            'anggota_pertama_id' =>
                $anggotaUtama->id,

            'anggota_kedua_id' =>
                $anggotaPasangan->id,

            'status_hubungan' =>
                'suami_istri',

            'tanggal_mulai' =>
                $data['tanggal_mulai'] ?? null,

            'tanggal_berakhir' =>
                $data['tanggal_berakhir'] ?? null,

            'catatan' =>
                $data['catatan'] ?? null,

            'dibuat_oleh' =>
                auth()->id(),

        ]);


        return redirect()
            ->route(
                'anggota.show',
                $anggotaUtama->id
            )
            ->with(
                'success',
                'Hubungan pasangan berhasil ditambahkan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Hapus Pasangan
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $keluargaId = session('keluarga_id');


        /*
        |--------------------------------------------------------------------------
        | Pastikan kedua anggota berasal dari keluarga aktif
        |--------------------------------------------------------------------------
        */

        $relasi = RelasiPasangan::query()
            ->where(
                'id',
                $id
            )
            ->whereHas(
                'anggotaPertama',
                function ($query) use (
                    $keluargaId
                ) {

                    $query
                        ->where(
                            'keluarga_id',
                            $keluargaId
                        )
                        ->where(
                            'status_data',
                            'aktif'
                        );
                }
            )
            ->whereHas(
                'anggotaKedua',
                function ($query) use (
                    $keluargaId
                ) {

                    $query
                        ->where(
                            'keluarga_id',
                            $keluargaId
                        )
                        ->where(
                            'status_data',
                            'aktif'
                        );
                }
            )
            ->firstOrFail();


        $anggotaId =
            $relasi->anggota_pertama_id;


        $relasi->delete();


        return redirect()
            ->route(
                'anggota.show',
                $anggotaId
            )
            ->with(
                'success',
                'Hubungan pasangan berhasil dihapus.'
            );
    }
}