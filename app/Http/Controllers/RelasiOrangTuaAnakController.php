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
        $keluargaId = session('keluarga_id');


        /*
        |--------------------------------------------------------------------------
        | Validasi input
        |--------------------------------------------------------------------------
        */

        $data = $request->validate([

            'orang_tua_id' => [
                'required',
                'integer',
            ],

            'anak_id' => [
                'required',
                'integer',
                'different:orang_tua_id',
            ],

            'jenis_hubungan' => [
                'required',
                'in:ayah,ibu',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Ambil orang tua
        |--------------------------------------------------------------------------
        */

        $orangTua = AnggotaKeluarga::query()
            ->where('keluarga_id', $keluargaId)
            ->where('status_data', 'aktif')
            ->where('id', $data['orang_tua_id'])
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Ambil anak
        |--------------------------------------------------------------------------
        */

        $anak = AnggotaKeluarga::query()
            ->where('keluarga_id', $keluargaId)
            ->where('status_data', 'aktif')
            ->where('id', $data['anak_id'])
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Validasi jenis hubungan berdasarkan jenis kelamin
        |--------------------------------------------------------------------------
        */

        if (
            $data['jenis_hubungan'] === 'ayah'
            &&
            $orangTua->jenis_kelamin !== 'laki-laki'
        ) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Hubungan ayah hanya dapat diberikan kepada anggota laki-laki.'
                );
        }


        if (
            $data['jenis_hubungan'] === 'ibu'
            &&
            $orangTua->jenis_kelamin !== 'perempuan'
        ) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Hubungan ibu hanya dapat diberikan kepada anggota perempuan.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Cegah relasi yang sama
        |--------------------------------------------------------------------------
        */

        $relasiSama = RelasiOrangTuaAnak::query()
            ->where(
                'orang_tua_id',
                $orangTua->id
            )
            ->where(
                'anak_id',
                $anak->id
            )
            ->exists();


        if ($relasiSama) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Hubungan orang tua dan anak tersebut sudah terdaftar.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Cegah anak memiliki dua ayah
        |--------------------------------------------------------------------------
        */

        if (
            $data['jenis_hubungan'] === 'ayah'
        ) {

            $sudahAdaAyah =
                RelasiOrangTuaAnak::query()
                    ->where(
                        'anak_id',
                        $anak->id
                    )
                    ->where(
                        'jenis_hubungan',
                        'ayah'
                    )
                    ->exists();


            if ($sudahAdaAyah) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Anak tersebut sudah memiliki data ayah.'
                    );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Cegah anak memiliki dua ibu
        |--------------------------------------------------------------------------
        */

        if (
            $data['jenis_hubungan'] === 'ibu'
        ) {

            $sudahAdaIbu =
                RelasiOrangTuaAnak::query()
                    ->where(
                        'anak_id',
                        $anak->id
                    )
                    ->where(
                        'jenis_hubungan',
                        'ibu'
                    )
                    ->exists();


            if ($sudahAdaIbu) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Anak tersebut sudah memiliki data ibu.'
                    );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Cegah siklus silsilah
        |--------------------------------------------------------------------------
        |
        | Contoh yang tidak boleh:
        |
        | A -> B
        | B -> C
        | C -> A
        |
        */

        if (
            $this->menyebabkanSiklus(
                $orangTua->id,
                $anak->id,
                $keluargaId
            )
        ) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Hubungan tersebut akan membentuk siklus pada silsilah keluarga.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Simpan
        |--------------------------------------------------------------------------
        */

        RelasiOrangTuaAnak::create([

            'orang_tua_id' =>
                $orangTua->id,

            'anak_id' =>
                $anak->id,

            'jenis_hubungan' =>
                $data['jenis_hubungan'],

            'dibuat_oleh' =>
                auth()->id(),

        ]);


        return redirect()
            ->route(
                'anggota.show',
                $anak->id
            )
            ->with(
                'success',
                'Hubungan keluarga berhasil ditambahkan.'
            );
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
