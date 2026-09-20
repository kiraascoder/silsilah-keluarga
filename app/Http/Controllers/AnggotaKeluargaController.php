<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKeluarga;
use App\Models\Keluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnggotaKeluargaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Daftar Anggota
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $keluargaId = session('keluarga_id');

        if (!$keluargaId) {
            return redirect()
                ->route('keluarga.pilih')
                ->with(
                    'error',
                    'Silakan pilih keluarga terlebih dahulu.'
                );
        }

        $query = AnggotaKeluarga::query()
            ->where('keluarga_id', $keluargaId)
            ->where('status_data', 'aktif');

        /*
    |--------------------------------------------------------------------------
    | Pencarian
    |--------------------------------------------------------------------------
    */

        if ($request->filled('search')) {

            $search = $request->input('search');

            $query->where(function ($q) use ($search) {

                $q->where(
                    'nama_lengkap',
                    'like',
                    "%{$search}%"
                );

                $q->orWhere(
                    'nama_panggilan',
                    'like',
                    "%{$search}%"
                );
            });
        }


        /*
    |--------------------------------------------------------------------------
    | Filter Jenis Kelamin
    |--------------------------------------------------------------------------
    */

        if ($request->filled('jenis_kelamin')) {

            $query->where(
                'jenis_kelamin',
                $request->input('jenis_kelamin')
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Filter Generasi
    |--------------------------------------------------------------------------
    */

        if ($request->filled('generasi')) {

            $query->where(
                'generasi',
                $request->input('generasi')
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Data Anggota
    |--------------------------------------------------------------------------
    */

        $anggota = $query
            ->orderBy('generasi')
            ->orderBy('nama_lengkap')
            ->paginate(10)
            ->withQueryString();


        /*
    |--------------------------------------------------------------------------
    | Daftar Generasi
    |--------------------------------------------------------------------------
    */

        $daftarGenerasi = AnggotaKeluarga::query()
            ->where('keluarga_id', $keluargaId)
            ->where('status_data', 'aktif')
            ->whereNotNull('generasi')
            ->distinct()
            ->orderBy('generasi')
            ->pluck('generasi');


        /*
    |--------------------------------------------------------------------------
    | Return View
    |--------------------------------------------------------------------------
    */

        return view('anggota.index', [
            'anggota' => $anggota,
            'daftarGenerasi' => $daftarGenerasi,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Tambah
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view(
            'anggota.create'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Simpan
    |--------------------------------------------------------------------------
    */

    public function store(
        Request $request
    ) {

        $keluargaId =
            session('keluarga_id');


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
                'before_or_equal:today',
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
                'in:hidup,meninggal',
            ],

            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Data Sistem
        |--------------------------------------------------------------------------
        */

        $data['keluarga_id'] =
            $keluargaId;

        $data['status_data'] =
            'aktif';

        $data['status'] =
            $data['status'] ?? 'hidup';


        /*
        |--------------------------------------------------------------------------
        | Foto
        |--------------------------------------------------------------------------
        */

        if (
            $request->hasFile('foto')
        ) {

            $data['foto'] =
                $request
                ->file('foto')
                ->store(
                    'anggota',
                    'public'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Simpan
        |--------------------------------------------------------------------------
        */

        $anggota =
            AnggotaKeluarga::create(
                $data
            );


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
    | Detail
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $keluargaId =
            session('keluarga_id');


        $anggota =
            AnggotaKeluarga::query()
            ->where(
                'keluarga_id',
                $keluargaId
            )
            ->where(
                'id',
                $id
            )
            ->where(
                'status_data',
                'aktif'
            )
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
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $keluargaId =
            session('keluarga_id');


        $anggota =
            AnggotaKeluarga::query()
            ->where(
                'keluarga_id',
                $keluargaId
            )
            ->where(
                'id',
                $id
            )
            ->where(
                'status_data',
                'aktif'
            )
            ->firstOrFail();


        return view(
            'anggota.edit',
            compact('anggota')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        $id
    ) {

        $keluargaId =
            session('keluarga_id');


        $anggota =
            AnggotaKeluarga::query()
            ->where(
                'keluarga_id',
                $keluargaId
            )
            ->where(
                'id',
                $id
            )
            ->where(
                'status_data',
                'aktif'
            )
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
                'before_or_equal:today',
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
                'in:hidup,meninggal',
            ],

            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],

        ]);


        $data['status'] =
            $data['status'] ?? 'hidup';


        /*
        |--------------------------------------------------------------------------
        | Foto Baru
        |--------------------------------------------------------------------------
        */

        if (
            $request->hasFile('foto')
        ) {

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


            $data['foto'] =
                $request
                ->file('foto')
                ->store(
                    'anggota',
                    'public'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Update
        |--------------------------------------------------------------------------
        */

        $anggota->update(
            $data
        );


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
    | Nonaktifkan
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $keluargaId =
            session('keluarga_id');


        $anggota =
            AnggotaKeluarga::query()
            ->where(
                'keluarga_id',
                $keluargaId
            )
            ->where(
                'id',
                $id
            )
            ->where(
                'status_data',
                'aktif'
            )
            ->firstOrFail();


        $keluarga =
            Keluarga::findOrFail(
                $keluargaId
            );


        /*
        |--------------------------------------------------------------------------
        | Kepala Keluarga
        |--------------------------------------------------------------------------
        */

        if (
            (int) $keluarga->kepala_keluarga_id ===
            (int) $anggota->id
        ) {

            return back()
                ->with(
                    'error',
                    'Kepala keluarga tidak dapat dinonaktifkan sebelum kepala keluarga baru ditentukan.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Nonaktifkan Data
        |--------------------------------------------------------------------------
        */

        $anggota->update([
            'status_data' =>
            'tidak_aktif',
        ]);


        return redirect()
            ->route(
                'anggota.index'
            )
            ->with(
                'success',
                'Anggota berhasil dinonaktifkan.'
            );
    }
}
