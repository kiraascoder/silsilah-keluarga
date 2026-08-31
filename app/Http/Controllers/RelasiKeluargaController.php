<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKeluarga;
use App\Models\RelasiOrangTuaAnak;
use Illuminate\Http\Request;

class RelasiKeluargaController extends Controller
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
        $data = $request->validate([
            'anggota_utama_id' => [
                'required',
                'integer',
            ],

            'anggota_id' => [
                'required',
                'integer',
            ],

            'jenis_hubungan' => [
                'required',
                'in:ayah,ibu,anak',
            ],

            'arah_relasi' => [
                'required',
                'in:orang_tua,anak',
            ],
        ]);


        $keluargaId = session('keluarga_id');


        /*
        |--------------------------------------------------------------------------
        | Pastikan kedua anggota berasal dari keluarga yang sama
        |--------------------------------------------------------------------------
        */

        $anggotaUtama = AnggotaKeluarga::where(
            'keluarga_id',
            $keluargaId
        )
            ->where('id', $data['anggota_utama_id'])
            ->firstOrFail();


        $anggotaTarget = AnggotaKeluarga::where(
            'keluarga_id',
            $keluargaId
        )
            ->where('id', $data['anggota_id'])
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Tentukan arah relasi
        |--------------------------------------------------------------------------
        */

        if ($data['arah_relasi'] === 'orang_tua') {

            $orangTuaId = $anggotaTarget->id;
            $anakId = $anggotaUtama->id;
        } else {

            $orangTuaId = $anggotaUtama->id;
            $anakId = $anggotaTarget->id;
        }


        /*
        |--------------------------------------------------------------------------
        | Cegah relasi duplikat
        |--------------------------------------------------------------------------
        */

        $sudahAda = RelasiOrangTuaAnak::where(
            'orang_tua_id',
            $orangTuaId
        )
            ->where(
                'anak_id',
                $anakId
            )
            ->exists();


        if ($sudahAda) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Hubungan keluarga tersebut sudah ada.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Simpan relasi
        |--------------------------------------------------------------------------
        */

        RelasiOrangTuaAnak::create([
            'orang_tua_id' => $orangTuaId,
            'anak_id' => $anakId,
            'jenis_hubungan' => $data['jenis_hubungan'],
            'dibuat_oleh' => auth()->id(),
        ]);


        return redirect()
            ->route(
                'anggota.show',
                $anggotaUtama->id
            )
            ->with(
                'success',
                'Hubungan keluarga berhasil ditambahkan.'
            );
    }
    public function destroy($id)
    {
        $relasi = RelasiOrangTuaAnak::where('id', $id)
            ->whereHas(
                'orangTua',
                function ($query) {
                    $query->where(
                        'keluarga_id',
                        session('keluarga_id')
                    );
                }
            )
            ->whereHas(
                'anak',
                function ($query) {
                    $query->where(
                        'keluarga_id',
                        session('keluarga_id')
                    );
                }
            )
            ->firstOrFail();


        $anggotaId = $relasi->anak_id;


        $relasi->delete();


        return redirect()
            ->route('anggota.show', $anggotaId)
            ->with(
                'success',
                'Hubungan keluarga berhasil dihapus.'
            );
    }
}
