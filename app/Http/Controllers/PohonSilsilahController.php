<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKeluarga;

class PohonSilsilahController extends Controller
{
    public function index()
    {
        $keluargaId = session('keluarga_id');

        /*
        |--------------------------------------------------------------------------
        | Ambil anggota keluarga
        |--------------------------------------------------------------------------
        */

        $anggota = AnggotaKeluarga::where(
            'keluarga_id',
            $keluargaId
        )
            ->where('status_data', 'aktif')
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
        | Buat struktur pohon
        |--------------------------------------------------------------------------
        */

        $pohon = $this->bangunStrukturPohon($anggota);


        /*
        |--------------------------------------------------------------------------
        | Kelompok berdasarkan generasi
        |--------------------------------------------------------------------------
        */

        $generasi = $anggota->groupBy(
            function ($item) {
                return $item->generasi ?? 0;
            }
        );


        return view(
            'pohon.index',
            compact(
                'anggota',
                'generasi',
                'pohon'
            )
        );
    }


    /**
     * Membentuk struktur parent → children
     */
    private function bangunStrukturPohon($anggota)
    {
        $struktur = [];


        foreach ($anggota as $item) {

            $struktur[$item->id] = [

                'id' => $item->id,

                'nama' => $item->nama_lengkap,

                'generasi' => $item->generasi,

                'jenis_kelamin' => $item->jenis_kelamin,

                'foto' => $item->foto,

                'orang_tua' => [],

                'anak' => [],

                'pasangan' => null,

            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Hubungan orang tua dan anak
        |--------------------------------------------------------------------------
        */

        foreach ($anggota as $item) {

            foreach ($item->orangTua as $orangTua) {

                if (isset($struktur[$item->id])) {

                    $struktur[$item->id]['orang_tua'][] = [

                        'id' => $orangTua->id,

                        'nama' => $orangTua->nama_lengkap,

                    ];
                }
            }


            foreach ($item->anak as $anak) {

                if (isset($struktur[$item->id])) {

                    $struktur[$item->id]['anak'][] = [

                        'id' => $anak->id,

                        'nama' => $anak->nama_lengkap,

                    ];
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Hubungan pasangan
        |--------------------------------------------------------------------------
        */

        foreach ($anggota as $item) {

            $pasangan = $item
                ->relasiPasanganPertama
                ->first();

            if ($pasangan) {

                $struktur[$item->id]['pasangan'] = [

                    'id' => $pasangan
                        ->anggotaKedua
                        ->id,

                    'nama' => $pasangan
                        ->anggotaKedua
                        ->nama_lengkap,

                ];

                continue;
            }


            $pasangan = $item
                ->relasiPasanganKedua
                ->first();

            if ($pasangan) {

                $struktur[$item->id]['pasangan'] = [

                    'id' => $pasangan
                        ->anggotaPertama
                        ->id,

                    'nama' => $pasangan
                        ->anggotaPertama
                        ->nama_lengkap,

                ];
            }
        }


        return $struktur;
    }
}
