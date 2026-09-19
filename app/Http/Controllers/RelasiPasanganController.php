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
        $keluargaId = session('keluarga_id');

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


        $anggotaUtama = AnggotaKeluarga::where(
            'keluarga_id',
            $keluargaId
        )
            ->where(
                'id',
                $data['anggota_utama_id']
            )
            ->firstOrFail();


        $anggotaPasangan = AnggotaKeluarga::where(
            'keluarga_id',
            $keluargaId
        )
            ->where(
                'id',
                $data['anggota_pasangan_id']
            )
            ->firstOrFail();


        /*
    |--------------------------------------------------------------------------
    | Cegah seseorang memiliki dua pasangan aktif
    |--------------------------------------------------------------------------
    */

        $sudahMemilikiPasangan =
            $anggotaUtama->relasiPasanganPertama()
            ->exists()
            ||
            $anggotaUtama->relasiPasanganKedua()
            ->exists();


        if ($sudahMemilikiPasangan) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Anggota tersebut sudah memiliki pasangan.'
                );
        }


        /*
    |--------------------------------------------------------------------------
    | Cek pasangan juga belum memiliki pasangan
    |--------------------------------------------------------------------------
    */

        $pasanganSudahMenikah =
            $anggotaPasangan->relasiPasanganPertama()
            ->exists()
            ||
            $anggotaPasangan->relasiPasanganKedua()
            ->exists();


        if ($pasanganSudahMenikah) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Anggota yang dipilih sudah memiliki pasangan.'
                );
        }


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


    public function destroy($id)
    {
        $keluargaId = session('keluarga_id');


        $relasi = RelasiPasangan::where(
            'id',
            $id
        )
            ->whereHas(
                'anggotaPertama',
                function ($query) use ($keluargaId) {

                    $query->where(
                        'keluarga_id',
                        $keluargaId
                    );
                }
            )
            ->whereHas(
                'anggotaKedua',
                function ($query) use ($keluargaId) {

                    $query->where(
                        'keluarga_id',
                        $keluargaId
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
