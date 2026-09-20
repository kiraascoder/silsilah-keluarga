<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKeluarga;
use App\Models\RelasiOrangTuaAnak;
use Illuminate\Http\Request;

class RelasiOrangTuaAnakController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Form Tambah Relasi
    |--------------------------------------------------------------------------
    */

    public function create($id)
    {
        $keluargaId = session('keluarga_id');


        /*
        |--------------------------------------------------------------------------
        | Pastikan anggota berasal dari keluarga aktif
        |--------------------------------------------------------------------------
        */

        $anggota = AnggotaKeluarga::query()
            ->where('keluarga_id', $keluargaId)
            ->where('status_data', 'aktif')
            ->where('id', $id)
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Daftar anggota yang dapat dipilih
        |--------------------------------------------------------------------------
        */

        $daftarAnggota = AnggotaKeluarga::query()
            ->where('keluarga_id', $keluargaId)
            ->where('status_data', 'aktif')
            ->where('id', '!=', $anggota->id)
            ->orderBy('nama_lengkap')
            ->get();


        return view(
            'relasi.create',
            compact(
                'anggota',
                'daftarAnggota'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Simpan Relasi
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'anggota_utama_id' => [
                'required',
                'exists:anggota_keluarga,id',
            ],

            'arah_relasi' => [
                'required',
                'in:orang_tua,anak',
            ],

            'jenis_hubungan' => [
                'required',
                'in:ayah,ibu,anak',
            ],

            'anggota_id' => [
                'required',
                'exists:anggota_keluarga,id',
                'different:anggota_utama_id',
            ],
        ]);

        /*
    |--------------------------------------------------------------------------
    | Tentukan posisi hubungan
    |--------------------------------------------------------------------------
    */

        if ($validated['arah_relasi'] === 'orang_tua') {
            // Anggota yang dipilih adalah orang tua
            $orangTuaId = $validated['anggota_id'];
            $anakId = $validated['anggota_utama_id'];
        } else {
            // Anggota yang dipilih adalah anak
            $orangTuaId = $validated['anggota_utama_id'];
            $anakId = $validated['anggota_id'];
        }

        /*
    |--------------------------------------------------------------------------
    | Simpan relasi
    |--------------------------------------------------------------------------
    */

        RelasiOrangTuaAnak::create([
            'orang_tua_id' => $orangTuaId,
            'anak_id' => $anakId,
            'jenis_hubungan' => $validated['jenis_hubungan'],
            'dibuat_oleh' => auth()->id(),
        ]);

        return redirect()
            ->route('anggota.show', $validated['anggota_utama_id'])
            ->with('success', 'Hubungan keluarga berhasil ditambahkan.');
    }


    /*
    |--------------------------------------------------------------------------
    | Cek Siklus
    |--------------------------------------------------------------------------
    */

    private function menyebabkanSiklus(
        int $orangTuaId,
        int $anakId,
        int $keluargaId
    ): bool {

        /*
        |--------------------------------------------------------------------------
        | Mulai dari anak.
        |
        | Jika orang tua yang akan ditambahkan ternyata berada
        | di bawah anak tersebut, maka akan terbentuk siklus.
        |--------------------------------------------------------------------------
        */

        $antrian = [$anakId];

        $sudahDiperiksa = [];


        while (!empty($antrian)) {

            $anggotaId = array_shift($antrian);


            if (
                in_array(
                    $anggotaId,
                    $sudahDiperiksa,
                    true
                )
            ) {
                continue;
            }


            $sudahDiperiksa[] = $anggotaId;


            /*
            |--------------------------------------------------------------------------
            | Ambil anak-anak anggota saat ini
            |--------------------------------------------------------------------------
            */

            $anakAnak = RelasiOrangTuaAnak::query()
                ->where(
                    'orang_tua_id',
                    $anggotaId
                )
                ->whereHas(
                    'anak',
                    function ($query) use ($keluargaId) {

                        $query->where(
                            'keluarga_id',
                            $keluargaId
                        );
                    }
                )
                ->pluck('anak_id');


            foreach ($anakAnak as $id) {

                /*
                |--------------------------------------------------------------------------
                | Orang tua baru ditemukan sebagai keturunan
                |--------------------------------------------------------------------------
                */

                if (
                    (int) $id === $orangTuaId
                ) {

                    return true;
                }


                if (
                    !in_array(
                        (int) $id,
                        $sudahDiperiksa,
                        true
                    )
                ) {

                    $antrian[] =
                        (int) $id;
                }
            }
        }


        return false;
    }


    /*
    |--------------------------------------------------------------------------
    | Hapus Relasi
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $keluargaId = session('keluarga_id');


        /*
        |--------------------------------------------------------------------------
        | Pastikan kedua anggota berada di keluarga aktif
        |--------------------------------------------------------------------------
        */

        $relasi = RelasiOrangTuaAnak::query()
            ->where('id', $id)
            ->whereHas(
                'orangTua',
                function ($query) use ($keluargaId) {

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
                'anak',
                function ($query) use ($keluargaId) {

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


        $anakId = $relasi->anak_id;


        $relasi->delete();


        return redirect()
            ->route(
                'anggota.show',
                $anakId
            )
            ->with(
                'success',
                'Hubungan keluarga berhasil dihapus.'
            );
    }
}
