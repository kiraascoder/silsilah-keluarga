<?php

namespace App\Http\Controllers;

use App\Models\SejarahKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SejarahKeluargaController extends Controller
{
    /**
     * Daftar sejarah keluarga
     */
    public function index()
    {
        $sejarah = SejarahKeluarga::query()
            ->where('keluarga_id', session('keluarga_id'))
            ->latest('tanggal')
            ->latest('id')
            ->paginate(10);

        return view('sejarah.index', compact('sejarah'));
    }

    /**
     * Form tambah sejarah
     */
    public function create()
    {
        return view('sejarah.create');
    }

    /**
     * Simpan sejarah baru
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => [
                'required',
                'string',
                'max:200',
            ],

            'tanggal' => [
                'nullable',
                'date',
            ],

            'deskripsi' => [
                'required',
                'string',
            ],

            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $foto = null;

        /*
        |--------------------------------------------------------------------------
        | Upload foto
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('foto')) {
            $foto = $request
                ->file('foto')
                ->store('sejarah-keluarga', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Simpan data
        |--------------------------------------------------------------------------
        */

        SejarahKeluarga::create([
            'keluarga_id' => session('keluarga_id'),

            'judul' => $data['judul'],

            'tanggal' => $data['tanggal'] ?? null,

            'deskripsi' => $data['deskripsi'],

            'foto' => $foto,

            'dibuat_oleh' => auth()->id(),
        ]);

        return redirect()
            ->route('sejarah.index')
            ->with(
                'success',
                'Sejarah keluarga berhasil ditambahkan.'
            );
    }

    /**
     * Form edit sejarah
     */
    public function edit($id)
    {
        $sejarah = SejarahKeluarga::query()
            ->where('keluarga_id', session('keluarga_id'))
            ->where('id', $id)
            ->firstOrFail();

        return view(
            'sejarah.edit',
            compact('sejarah')
        );
    }

    /**
     * Update sejarah
     */
    public function update(Request $request, $id)
    {
        $sejarah = SejarahKeluarga::query()
            ->where('keluarga_id', session('keluarga_id'))
            ->where('id', $id)
            ->firstOrFail();

        $data = $request->validate([
            'judul' => [
                'required',
                'string',
                'max:200',
            ],

            'tanggal' => [
                'nullable',
                'date',
            ],

            'deskripsi' => [
                'required',
                'string',
            ],

            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Data utama
        |--------------------------------------------------------------------------
        */

        $sejarah->judul = $data['judul'];

        $sejarah->tanggal = $data['tanggal'] ?? null;

        $sejarah->deskripsi = $data['deskripsi'];

        /*
        |--------------------------------------------------------------------------
        | Jika ada foto baru
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('foto')) {

            // Hapus foto lama
            if (
                $sejarah->foto &&
                Storage::disk('public')->exists($sejarah->foto)
            ) {
                Storage::disk('public')->delete(
                    $sejarah->foto
                );
            }

            // Simpan foto baru
            $sejarah->foto = $request
                ->file('foto')
                ->store('sejarah-keluarga', 'public');
        }

        $sejarah->save();

        return redirect()
            ->route('sejarah.index')
            ->with(
                'success',
                'Sejarah keluarga berhasil diperbarui.'
            );
    }

    /**
     * Hapus sejarah
     */
    public function destroy($id)
    {
        $sejarah = SejarahKeluarga::query()
            ->where('keluarga_id', session('keluarga_id'))
            ->where('id', $id)
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Hapus file foto
        |--------------------------------------------------------------------------
        */

        if (
            $sejarah->foto &&
            Storage::disk('public')->exists($sejarah->foto)
        ) {
            Storage::disk('public')->delete(
                $sejarah->foto
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Hapus data
        |--------------------------------------------------------------------------
        */

        $sejarah->delete();

        return redirect()
            ->route('sejarah.index')
            ->with(
                'success',
                'Sejarah keluarga berhasil dihapus.'
            );
    }
}
