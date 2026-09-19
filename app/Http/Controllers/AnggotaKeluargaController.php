<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnggotaKeluargaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Daftar Anggota
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $keluargaId = session('keluarga_id');

        $anggota = AnggotaKeluarga::where(
            'keluarga_id',
            $keluargaId
        )
            ->where('status_data', 'aktif')
            ->orderBy('generasi')
            ->orderBy('nama_lengkap')
            ->get();

        return view(
            'anggota.index',
            compact('anggota')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Form Tambah
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('anggota.create');
    }


    /*
    |--------------------------------------------------------------------------
    | Simpan Anggota
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $keluargaId = session('keluarga_id');

        $data = $request->validate([

            'nama_lengkap' => [
                'required',
                'string',
                'max:255',
            ],

            'nama_panggilan' => [
                'nullable',
                'string',
                'max:100',
            ],

            'tempat_lahir' => [
                'nullable',
                'string',
                'max:100',
            ],

            'tanggal_lahir' => [
                'nullable',
                'date',
            ],

            'jenis_kelamin' => [
                'required',
                'in:laki-laki,perempuan',
            ],

            'golongan_darah' => [
                'nullable',
                'in:A,B,AB,O',
            ],

            'generasi' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'status' => [
                'nullable',
                'string',
                'max:50',
            ],

            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],

        ]);


        $data['keluarga_id'] = $keluargaId;
        $data['status_data'] = 'aktif';


        /*
        |--------------------------------------------------------------------------
        | Upload Foto
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('foto')) {

            $data['foto'] = $request
                ->file('foto')
                ->store(
                    'anggota',
                    'public'
                );
        }


        $anggota = AnggotaKeluarga::create($data);


        return redirect()
            ->route(
                'anggota.show',
                $anggota->id
            )
            ->with(
                'success',
                'Anggota keluarga berhasil ditambahkan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Detail Anggota
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $keluargaId = session('keluarga_id');

        $anggota = AnggotaKeluarga::where(
            'keluarga_id',
            $keluargaId
        )
            ->where('id', $id)
            ->with([
                'orangTua',
                'anak',
                'relasiPasanganPertama.anggotaKedua',
                'relasiPasanganKedua.anggotaPertama',
            ])
            ->firstOrFail();


        return view(
            'anggota.show',
            compact('anggota')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Form Edit
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $keluargaId = session('keluarga_id');

        $anggota = AnggotaKeluarga::where(
            'keluarga_id',
            $keluargaId
        )
            ->where('id', $id)
            ->firstOrFail();


        return view(
            'anggota.edit',
            compact('anggota')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Anggota
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        $id
    ) {

        $keluargaId = session('keluarga_id');

        $anggota = AnggotaKeluarga::where(
            'keluarga_id',
            $keluargaId
        )
            ->where('id', $id)
            ->firstOrFail();


        $data = $request->validate([

            'nama_lengkap' => [
                'required',
                'string',
                'max:255',
            ],

            'nama_panggilan' => [
                'nullable',
                'string',
                'max:100',
            ],

            'tempat_lahir' => [
                'nullable',
                'string',
                'max:100',
            ],

            'tanggal_lahir' => [
                'nullable',
                'date',
            ],

            'jenis_kelamin' => [
                'required',
                'in:laki-laki,perempuan',
            ],

            'golongan_darah' => [
                'nullable',
                'in:A,B,AB,O',
            ],

            'generasi' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'status' => [
                'nullable',
                'string',
                'max:50',
            ],

            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],

        ]);


        if ($request->hasFile('foto')) {

            if (
                $anggota->foto &&
                Storage::disk('public')->exists(
                    $anggota->foto
                )
            ) {
                Storage::disk('public')->delete(
                    $anggota->foto
                );
            }


            $data['foto'] = $request
                ->file('foto')
                ->store(
                    'anggota',
                    'public'
                );
        }


        $anggota->update($data);


        return redirect()
            ->route(
                'anggota.show',
                $anggota->id
            )
            ->with(
                'success',
                'Data anggota berhasil diperbarui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Anggota Keluar
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $keluargaId = session('keluarga_id');

        $anggota = AnggotaKeluarga::where(
            'keluarga_id',
            $keluargaId
        )
            ->where('id', $id)
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Soft Delete Logis
        |--------------------------------------------------------------------------
        |
        | Data tidak dihapus dari database.
        | Hanya dibuat tidak aktif.
        |
        */

        $anggota->update([
            'status_data' => 'tidak_aktif',
        ]);


        return redirect()
            ->route('anggota.index')
            ->with(
                'success',
                'Anggota berhasil dikeluarkan dari daftar aktif.'
            );
    }
}
