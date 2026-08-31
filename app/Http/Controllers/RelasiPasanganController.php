<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKeluarga;
use App\Models\RelasiPasangan;
use Illuminate\Http\Request;

class RelasiPasanganController extends Controller
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
            'pasangan.create',
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

        $keluargaId = session('keluarga_id');

        $anggotaUtama = AnggotaKeluarga::where(
            'keluarga_id',
            $keluargaId
        )
            ->where('id', $data['anggota_utama_id'])
            ->firstOrFail();

        $pasangan = AnggotaKeluarga::where(
            'keluarga_id',
            $keluargaId
        )
            ->where('id', $data['anggota_pasangan_id'])
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Cek apakah hubungan sudah ada
        |--------------------------------------------------------------------------
        */

        $sudahAda = RelasiPasangan::where(function ($query) use ($data) {

            $query->where(
                'anggota_pertama_id',
                $data['anggota_utama_id']
            )
                ->where(
                    'anggota_kedua_id',
                    $data['anggota_pasangan_id']
                );
        })
            ->orWhere(function ($query) use ($data) {

                $query->where(
                    'anggota_pertama_id',
                    $data['anggota_pasangan_id']
                )
                    ->where(
                        'anggota_kedua_id',
                        $data['anggota_utama_id']
                    );
            })
            ->exists();


        if ($sudahAda) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Hubungan pasangan tersebut sudah terdaftar.'
                );
        }


        RelasiPasangan::create([
            'anggota_pertama_id' => $anggotaUtama->id,
            'anggota_kedua_id' => $pasangan->id,
            'status_hubungan' => 'suami_istri',
            'tanggal_mulai' => $data['tanggal_mulai'] ?? null,
            'tanggal_berakhir' => $data['tanggal_berakhir'] ?? null,
            'catatan' => $data['catatan'] ?? null,
            'dibuat_oleh' => auth()->id(),
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


    public function destroy($id)
    {
        $keluargaId = session('keluarga_id');

        $relasi = RelasiPasangan::where('id', $id)
            ->where(function ($query) use ($keluargaId) {

                $query->whereHas(
                    'anggotaPertama',
                    fn($q) => $q->where(
                        'keluarga_id',
                        $keluargaId
                    )
                );

                $query->whereHas(
                    'anggotaKedua',
                    fn($q) => $q->where(
                        'keluarga_id',
                        $keluargaId
                    )
                );
            })
            ->firstOrFail();


        $anggotaId = $relasi->anggota_pertama_id;

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
