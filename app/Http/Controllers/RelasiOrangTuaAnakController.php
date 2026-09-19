<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKeluarga;
use App\Models\RelasiOrangTuaAnak;
use Illuminate\Http\Request;

class RelasiOrangTuaAnakController extends Controller
{
    public function create($id)
    {
        $keluargaId = session('keluarga_id');

        $anggota = AnggotaKeluarga::where(
            'keluarga_id',
            $keluargaId
        )
            ->where('id', $id)
            ->firstOrFail();


        $daftarAnggota = AnggotaKeluarga::where(
            'keluarga_id',
            $keluargaId
        )
            ->where('id', '!=', $id)
            ->where('status_data', 'aktif')
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


    public function store(Request $request)
    {
        $keluargaId = session('keluarga_id');


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
        | Pastikan kedua anggota berada pada keluarga yang sama
        |--------------------------------------------------------------------------
        */

        $orangTua = AnggotaKeluarga::where(
            'keluarga_id',
            $keluargaId
        )
            ->where(
                'id',
                $data['orang_tua_id']
            )
            ->firstOrFail();


        $anak = AnggotaKeluarga::where(
            'keluarga_id',
            $keluargaId
        )
            ->where(
                'id',
                $data['anak_id']
            )
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Cegah relasi duplikat
        |--------------------------------------------------------------------------
        */

        $exists = RelasiOrangTuaAnak::where(
            'orang_tua_id',
            $orangTua->id
        )
            ->where(
                'anak_id',
                $anak->id
            )
            ->exists();


        if ($exists) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Hubungan orang tua dan anak sudah terdaftar.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Simpan
        |--------------------------------------------------------------------------
        */

        RelasiOrangTuaAnak::create([

            'orang_tua_id' => $orangTua->id,

            'anak_id' => $anak->id,

            'jenis_hubungan' =>
                $data['jenis_hubungan'],

            'dibuat_oleh' => auth()->id(),

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


    public function destroy($id)
    {
        $keluargaId = session('keluarga_id');


        $relasi = RelasiOrangTuaAnak::where(
            'id',
            $id
        )
            ->whereHas(
                'orangTua',
                function ($query) use ($keluargaId) {

                    $query->where(
                        'keluarga_id',
                        $keluargaId
                    );

                }
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
