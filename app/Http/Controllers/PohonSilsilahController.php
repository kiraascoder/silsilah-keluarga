<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKeluarga;
use App\Models\Keluarga;

class PohonSilsilahController extends Controller
{
    public function index()
    {
        $keluargaId = session('keluarga_id');


        /*
        |--------------------------------------------------------------------------
        | Keluarga aktif
        |--------------------------------------------------------------------------
        */

        $keluargaAktif = Keluarga::find(
            $keluargaId
        );


        if (!$keluargaAktif) {

            abort(
                404,
                'Keluarga tidak ditemukan.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Anggota keluarga
        |--------------------------------------------------------------------------
        */

        $anggota = AnggotaKeluarga::query()
            ->where(
                'keluarga_id',
                $keluargaId
            )
            ->where(
                'status_data',
                'aktif'
            )
            ->with([
                'orangTua',
                'anak',
                'relasiPasanganPertama.anggotaKedua',
                'relasiPasanganKedua.anggotaPertama',
            ])
            ->orderBy('generasi')
            ->orderBy('nama_lengkap')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Tentukan anggota utama
        |--------------------------------------------------------------------------
        */

        $anggotaUtama = null;


        if (
            $keluargaAktif->kepala_keluarga_id
        ) {

            $anggotaUtama = $anggota
                ->firstWhere(
                    'id',
                    $keluargaAktif
                        ->kepala_keluarga_id
                );
        }


        if (!$anggotaUtama) {

            $anggotaUtama = $anggota
                ->sortBy('generasi')
                ->first();
        }


        /*
        |--------------------------------------------------------------------------
        | Data pohon
        |--------------------------------------------------------------------------
        */

        $dataPohon = $anggota
            ->map(function (
                AnggotaKeluarga $item
            ) {

                /*
                |--------------------------------------------------------------------------
                | Orang tua
                |--------------------------------------------------------------------------
                */

                $orangTua =
                    $item->orangTua
                        ->map(function ($orang) {

                            return [
                                'id' =>
                                    $orang->id,

                                'nama' =>
                                    $orang->nama_lengkap,

                                'hubungan' =>
                                    $orang
                                        ->pivot
                                        ->jenis_hubungan,
                            ];

                        })
                        ->values();


                /*
                |--------------------------------------------------------------------------
                | Anak
                |--------------------------------------------------------------------------
                */

                $anak =
                    $item->anak
                        ->map(function ($anak) {

                            return [
                                'id' =>
                                    $anak->id,

                                'nama' =>
                                    $anak->nama_lengkap,

                                'hubungan' =>
                                    $anak
                                        ->pivot
                                        ->jenis_hubungan,
                            ];

                        })
                        ->values();


                /*
                |--------------------------------------------------------------------------
                | Pasangan
                |--------------------------------------------------------------------------
                */

                $pasangan = null;


                $relasiPertama =
                    $item
                        ->relasiPasanganPertama
                        ->first();


                if ($relasiPertama) {

                    $pasangan =
                        $relasiPertama
                            ->anggotaKedua;
                }


                if (!$pasangan) {

                    $relasiKedua =
                        $item
                            ->relasiPasanganKedua
                            ->first();


                    if ($relasiKedua) {

                        $pasangan =
                            $relasiKedua
                                ->anggotaPertama;
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | Return
                |--------------------------------------------------------------------------
                */

                return [

                    'id' =>
                        $item->id,

                    'nama' =>
                        $item->nama_lengkap,

                    'panggilan' =>
                        $item->nama_panggilan,

                    'jenis_kelamin' =>
                        $item->jenis_kelamin,

                    'generasi' =>
                        $item->generasi,

                    'status' =>
                        $item->status,

                    'foto' =>
                        $item->foto
                            ? asset(
                                'storage/' .
                                $item->foto
                            )
                            : null,

                    'orang_tua' =>
                        $orangTua,

                    'anak' =>
                        $anak,

                    'pasangan' =>
                        $pasangan
                            ? [
                                'id' =>
                                    $pasangan->id,

                                'nama' =>
                                    $pasangan
                                        ->nama_lengkap,

                                'foto' =>
                                    $pasangan->foto
                                        ? asset(
                                            'storage/' .
                                            $pasangan->foto
                                        )
                                        : null,
                            ]
                            : null,

                ];
            })
            ->values();


        return view(
            'pohon.index',
            compact(
                'keluargaAktif',
                'anggota',
                'anggotaUtama',
                'dataPohon'
            )
        );
    }
}
