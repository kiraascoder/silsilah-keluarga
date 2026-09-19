<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use App\Models\PenggunaKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class KeluargaController extends Controller
{
    public function pilih()
    {
        $keluarga = Keluarga::whereHas('pengguna', function ($query) {
            $query->where('users.id', Auth::id())
                ->where('pengguna_keluarga.status', 'aktif');
        })->get();

        return view('keluarga.pilih', compact('keluarga'));
    }

    public function create()
    {
        return view('keluarga.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_keluarga' => ['required', 'string', 'max:150'],
            'asal_daerah' => ['nullable', 'string', 'max:150'],
            'deskripsi' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);

        $foto = null;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')
                ->store('keluarga', 'public');
        }

        $keluarga = Keluarga::create([
            'nama_keluarga' => $request->nama_keluarga,
            'slug' => Str::slug($request->nama_keluarga)
                . '-' . Str::lower(Str::random(5)),
            'asal_daerah' => $request->asal_daerah,
            'deskripsi' => $request->deskripsi,
            'foto' => $foto,
            'kode_undangan' => Str::upper(Str::random(8)),
            'dibuat_oleh' => Auth::id(),
            'status' => 'aktif',
        ]);

        PenggunaKeluarga::create([
            'keluarga_id' => $keluarga->id,
            'pengguna_id' => Auth::id(),
            'anggota_keluarga_id' => null,
            'level_akses' => 'pemilik',
            'status' => 'aktif',
            'bergabung_pada' => now(),
        ]);

        session([
            'keluarga_id' => $keluarga->id
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Rumpun keluarga berhasil dibuat.');
    }

    public function pilihAktif(Keluarga $keluarga)
    {
        $user = auth()->user();


        $keanggotaan = $keluarga
            ->pengguna()
            ->where('users.id', $user->id)
            ->wherePivot('status', 'aktif')
            ->first();


        if (!$keanggotaan) {

            abort(
                403,
                'Anda tidak memiliki akses ke keluarga tersebut.'
            );
        }


        session([
            'keluarga_id' =>
            $keluarga->id,

            'keluarga_level_akses' =>
            $keanggotaan->pivot->level_akses,
        ]);


        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Keluarga aktif berhasil dipilih.'
            );
    }
}
