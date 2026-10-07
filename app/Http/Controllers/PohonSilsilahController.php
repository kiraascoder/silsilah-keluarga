<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKeluarga;
use App\Models\Keluarga;

class PohonSilsilahController extends Controller
{
    public function index()
    {
        $keluargaId = session('keluarga_id');

        $keluargaAktif = Keluarga::find($keluargaId);

        if (!$keluargaAktif) {
            abort(404, 'Keluarga tidak ditemukan.');
        }

        $anggota = AnggotaKeluarga::query()
            ->where('keluarga_id', $keluargaId)
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

        $anggotaUtama = null;

        if ($keluargaAktif->kepala_keluarga_id) {
            $anggotaUtama = $anggota->firstWhere(
                'id',
                $keluargaAktif->kepala_keluarga_id
            );
        }

        if (!$anggotaUtama) {
            $anggotaUtama = $anggota
                ->sortBy('generasi')
                ->first();
        }

        /*
        |--------------------------------------------------------------------------
        | Map semua anggota
        |--------------------------------------------------------------------------
        */

        $anggotaMap = $anggota->keyBy('id');

        /*
        |--------------------------------------------------------------------------
        | Bentuk data pasangan
        |--------------------------------------------------------------------------
        */

        $pasanganMap = [];

        foreach ($anggota as $item) {
            $pasangan = null;

            $relasiPertama = $item
                ->relasiPasanganPertama
                ->first();

            if ($relasiPertama) {
                $pasangan = $relasiPertama->anggotaKedua;
            }

            if (!$pasangan) {
                $relasiKedua = $item
                    ->relasiPasanganKedua
                    ->first();

                if ($relasiKedua) {
                    $pasangan = $relasiKedua->anggotaPertama;
                }
            }

            if ($pasangan) {
                $pasanganMap[$item->id] = $pasangan->id;
                $pasanganMap[$pasangan->id] = $item->id;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Bentuk data pohon
        |--------------------------------------------------------------------------
        */

        $dataPohon = $anggota->map(function ($item) use (
            $pasanganMap,
            $anggotaMap
        ) {
            /*
            |--------------------------------------------------------------------------
            | Pasangan
            |--------------------------------------------------------------------------
            */

            $pasangan = null;

            if (isset($pasanganMap[$item->id])) {
                $pasangan = $anggotaMap->get(
                    $pasanganMap[$item->id]
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Anak
            |--------------------------------------------------------------------------
            */

            $anakIds = collect();

            foreach ($item->anak as $anak) {
                $anakIds->push($anak->id);
            }

            /*
            |--------------------------------------------------------------------------
            | Jika memiliki pasangan,
            | gabungkan anak pasangan juga.
            |--------------------------------------------------------------------------
            */

            if ($pasangan) {
                foreach ($pasangan->anak as $anak) {
                    $anakIds->push($anak->id);
                }
            }

            $anakIds = $anakIds
                ->unique()
                ->sortBy(function ($id) use ($anggotaMap) {
                    $anak = $anggotaMap->get($id);

                    return [
                        $anak?->generasi ?? 999,
                        $anak?->nama_lengkap ?? '',
                    ];
                })
                ->values();

            /*
            |--------------------------------------------------------------------------
            | Orang tua
            |--------------------------------------------------------------------------
            */

            $orangTua = $item->orangTua
                ->map(function ($orang) {
                    return [
                        'id' => $orang->id,
                        'nama' => $orang->nama_lengkap,
                        'hubungan' => $orang->pivot->jenis_hubungan ?? null,
                    ];
                })
                ->values();

            /*
            |--------------------------------------------------------------------------
            | Data pasangan
            |--------------------------------------------------------------------------
            */

            $dataPasangan = null;

            if ($pasangan) {
                $dataPasangan = [
                    'id' => $pasangan->id,
                    'nama' => $pasangan->nama_lengkap,
                    'panggilan' => $pasangan->nama_panggilan,
                    'jenis_kelamin' => $pasangan->jenis_kelamin,
                    'generasi' => $pasangan->generasi,
                    'foto' => $pasangan->foto
                        ? asset('storage/' . $pasangan->foto)
                        : null,
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | Return
            |--------------------------------------------------------------------------
            */

            return [
                'id' => $item->id,

                'nama' => $item->nama_lengkap,

                'panggilan' => $item->nama_panggilan,

                'jenis_kelamin' => $item->jenis_kelamin,

                'generasi' => $item->generasi,

                'status' => $item->status,

                'foto' => $item->foto
                    ? asset('storage/' . $item->foto)
                    : null,

                'orang_tua' => $orangTua,

                'anak_ids' => $anakIds,

                'pasangan_id' => $pasangan?->id,

                'pasangan' => $dataPasangan,
            ];
        })->values();

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
