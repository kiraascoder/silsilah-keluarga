<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKeluarga;
use App\Models\RelasiOrangTuaAnak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RelasiKeluargaController extends Controller
{

    public function create($id)
    {

        $anggota = AnggotaKeluarga::findOrFail($id);


        $daftarAnggota = AnggotaKeluarga::where(
            'keluarga_id',
            session('keluarga_id')
        )
            ->where(
                'id',
                '!=',
                $id
            )
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

            'anggota_id' => [
                'required'
            ],


            'jenis_hubungan' => [
                'required'
            ]

        ]);



        $anggotaSekarang = $request->anggota_id;



        $anggotaTarget = $request->route();
    }
}
