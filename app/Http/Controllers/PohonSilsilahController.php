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

        $anggotaMap = $anggota->keyBy('id');

        $dataPohon = $anggota->map(function ($item) use ($anggotaMap) {

            /*
             * ============================================================
             * RELASI PASANGAN
             * ============================================================
             *
             * Gunakan collect() agar hasil map() berupa array dapat
             * digabungkan tanpa diproses sebagai Eloquent Model.
             *
             * Sebelumnya menggunakan:
             *
             * $item->relasiPasanganPertama->map(...)->merge(...)
             *
             * Eloquent Collection menganggap item hasil map() sebagai
             * model dan mencoba memanggil getKey(), sehingga muncul:
             *
             * Call to a member function getKey() on array
             *
             * Dengan collect()->concat(), data pasangan diperlakukan
             * sebagai Support Collection biasa.
             */

            $relasiPasangan = collect()
                ->concat(
                    $item->relasiPasanganPertama->map(function ($relasi) {
                        return [
                            'relasi_id' => $relasi->id,
                            'id' => $relasi->anggotaKedua?->id,
                            'status_hubungan' => $relasi->status_hubungan,
                            'tanggal_mulai' => $relasi->tanggal_mulai?->format('Y-m-d'),
                            'tanggal_berakhir' => $relasi->tanggal_berakhir?->format('Y-m-d'),
                            'catatan' => $relasi->catatan,
                        ];
                    })
                )
                ->concat(
                    $item->relasiPasanganKedua->map(function ($relasi) {
                        return [
                            'relasi_id' => $relasi->id,
                            'id' => $relasi->anggotaPertama?->id,
                            'status_hubungan' => $relasi->status_hubungan,
                            'tanggal_mulai' => $relasi->tanggal_mulai?->format('Y-m-d'),
                            'tanggal_berakhir' => $relasi->tanggal_berakhir?->format('Y-m-d'),
                            'catatan' => $relasi->catatan,
                        ];
                    })
                )
                ->filter(function ($relasi) {
                    return !empty($relasi['id']);
                })
                ->unique('id')
                ->sortBy(function ($relasi) use ($anggotaMap) {
                    $pasangan = $anggotaMap->get($relasi['id']);

                    return [
                        $pasangan?->generasi ?? 999,
                        $pasangan?->nama_lengkap ?? '',
                    ];
                })
                ->values();

            /*
             * ============================================================
             * ANAK
             * ============================================================
             *
             * Anak dari anggota utama dan anak dari seluruh pasangan
             * digabung agar anak dari pasangan kedua/ketiga tetap muncul.
             */

            $pasanganIds = $relasiPasangan
                ->pluck('id')
                ->values();

            $anakIds = $item->anak
                ->pluck('id');

            foreach ($pasanganIds as $pasanganId) {
                $pasangan = $anggotaMap->get($pasanganId);

                if ($pasangan) {
                    $anakIds = $anakIds->merge(
                        $pasangan->anak->pluck('id')
                    );
                }
            }

            $anakIds = $anakIds
                ->unique()
                ->filter(function ($id) use ($anggotaMap) {
                    return $anggotaMap->has($id);
                })
                ->sortBy(function ($id) use ($anggotaMap) {
                    $anak = $anggotaMap->get($id);

                    return [
                        $anak?->generasi ?? 999,
                        $anak?->nama_lengkap ?? '',
                    ];
                })
                ->values();

            /*
             * ============================================================
             * ORANG TUA
             * ============================================================
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
             * ============================================================
             * DATA PASANGAN
             * ============================================================
             *
             * Semua pasangan dikirim ke frontend.
             */

            $pasanganData = $relasiPasangan
                ->map(function ($relasi) use ($anggotaMap) {
                    $pasangan = $anggotaMap->get($relasi['id']);

                    return [
                        'id' => $pasangan?->id,
                        'nama' => $pasangan?->nama_lengkap,
                        'panggilan' => $pasangan?->nama_panggilan,
                        'deskripsi' => $pasangan?->deskripsi,
                        'jenis_kelamin' => $pasangan?->jenis_kelamin,
                        'generasi' => $pasangan?->generasi,
                        'foto' => $pasangan?->foto
                            ? asset('storage/' . $pasangan->foto)
                            : null,
                        'status_hubungan' => $relasi['status_hubungan'],
                        'tanggal_mulai' => $relasi['tanggal_mulai'],
                        'tanggal_berakhir' => $relasi['tanggal_berakhir'],
                        'catatan' => $relasi['catatan'],
                    ];
                })
                ->values();

            /*
             * ============================================================
             * DATA ANGGOTA
             * ============================================================
             */

            return [
                'id' => $item->id,

                'nama' => $item->nama_lengkap,

                'panggilan' => $item->nama_panggilan,

                'deskripsi' => $item->deskripsi,

                'jenis_kelamin' => $item->jenis_kelamin,

                'generasi' => $item->generasi,

                'status' => $item->status,

                'foto' => $item->foto
                    ? asset('storage/' . $item->foto)
                    : null,

                'orang_tua' => $orangTua,

                'orang_tua_ids' => $orangTua
                    ->pluck('id')
                    ->values(),

                'anak_ids' => $anakIds,

                'pasangan_ids' => $pasanganIds,

                'pasangan' => $pasanganData,
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
