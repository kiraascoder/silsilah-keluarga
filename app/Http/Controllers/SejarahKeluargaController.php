<?php

namespace App\Http\Controllers;

use App\Models\SejarahKeluarga;
use Illuminate\Http\Request;

class SejarahKeluargaController extends Controller
{
    public function index()
    {
        $sejarah = SejarahKeluarga::query()
            ->where('keluarga_id', session('keluarga_id'))
            ->latest('tanggal')
            ->latest('id')
            ->paginate(10);

        return view('sejarah.index', compact('sejarah'));
    }

    public function create()
    {
        return view('sejarah.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => ['required', 'string', 'max:200'],
            'tanggal' => ['nullable', 'date'],
            'deskripsi' => ['required', 'string'],
        ]);

        SejarahKeluarga::create([
            'keluarga_id' => session('keluarga_id'),
            'judul' => $data['judul'],
            'tanggal' => $data['tanggal'] ?? null,
            'deskripsi' => $data['deskripsi'],
            'dibuat_oleh' => auth()->id(),
        ]);

        return redirect()
            ->route('sejarah.index')
            ->with('success', 'Sejarah keluarga berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $sejarah = SejarahKeluarga::query()
            ->where('keluarga_id', session('keluarga_id'))
            ->where('id', $id)
            ->firstOrFail();

        return view('sejarah.edit', compact('sejarah'));
    }

    public function update(Request $request, $id)
    {
        $sejarah = SejarahKeluarga::query()
            ->where('keluarga_id', session('keluarga_id'))
            ->where('id', $id)
            ->firstOrFail();

        $data = $request->validate([
            'judul' => ['required', 'string', 'max:200'],
            'tanggal' => ['nullable', 'date'],
            'deskripsi' => ['required', 'string'],
        ]);

        $sejarah->update($data);

        return redirect()
            ->route('sejarah.index')
            ->with('success', 'Sejarah keluarga berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $sejarah = SejarahKeluarga::query()
            ->where('keluarga_id', session('keluarga_id'))
            ->where('id', $id)
            ->firstOrFail();

        $sejarah->delete();

        return redirect()
            ->route('sejarah.index')
            ->with('success', 'Sejarah keluarga berhasil dihapus.');
    }
}
