<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnggotaKeluargaController extends Controller
{
    public function index(Request $request)
    {
        $keluargaId = session('keluarga_id');

        $query = AnggotaKeluarga::where('keluarga_id', $keluargaId);

        // Pencarian
        if ($request->filled('cari')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->cari . '%')
                    ->orWhere('nama_panggilan', 'like', '%' . $request->cari . '%');
            });
        }

        // Filter generasi
        if ($request->filled('generasi')) {
            $query->where('generasi', $request->generasi);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status_data', $request->status);
        }

        $anggota = $query
            ->orderBy('generasi')
            ->orderBy('nama_lengkap')
            ->paginate(10)
            ->withQueryString();

        $daftarGenerasi = AnggotaKeluarga::where(
            'keluarga_id',
            $keluargaId
        )
            ->whereNotNull('generasi')
            ->distinct()
            ->orderBy('generasi')
            ->pluck('generasi');

        return view(
            'anggota.index',
            compact('anggota', 'daftarGenerasi')
        );
    }


    public function create()
    {
        return view('anggota.create');
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_lengkap' => [
                'required',
                'string',
                'max:150',
            ],

            'nama_panggilan' => [
                'nullable',
                'string',
                'max:100',
            ],

            'jenis_kelamin' => [
                'required',
                'in:laki-laki,perempuan',
            ],

            'tempat_lahir' => [
                'nullable',
                'string',
                'max:150',
            ],

            'tanggal_lahir' => [
                'nullable',
                'date',
            ],

            'tanggal_meninggal' => [
                'nullable',
                'date',
            ],

            'golongan_darah' => [
                'nullable',
                'string',
                'max:5',
            ],

            'agama' => [
                'nullable',
                'string',
                'max:50',
            ],

            'pekerjaan' => [
                'nullable',
                'string',
                'max:100',
            ],

            'telepon' => [
                'nullable',
                'string',
                'max:30',
            ],

            'email' => [
                'nullable',
                'email',
                'max:150',
            ],

            'alamat' => [
                'nullable',
                'string',
            ],

            'catatan' => [
                'nullable',
                'string',
            ],

            'generasi' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'status_hidup' => [
                'required',
                'in:hidup,meninggal',
            ],

            'foto' => [
                'nullable',
                'image',
                'max:2048',
            ],
        ]);


        if ($request->hasFile('foto')) {
            $data['foto'] = $request
                ->file('foto')
                ->store('anggota', 'public');
        }


        $data['keluarga_id'] = session('keluarga_id');

        $data['dibuat_oleh'] = Auth::id();

        $data['status_data'] = 'aktif';


        $anggota = AnggotaKeluarga::create($data);


        return redirect()
            ->route('anggota.show', $anggota->id)
            ->with(
                'success',
                'Anggota keluarga berhasil ditambahkan.'
            );
    }


    public function show($id)
    {
        $anggota = $this->findAnggota($id);

        return view(
            'anggota.show',
            compact('anggota')
        );
    }


    public function edit($id)
    {
        $anggota = $this->findAnggota($id);

        return view(
            'anggota.edit',
            compact('anggota')
        );
    }


    public function update(Request $request, $id)
    {
        $anggota = $this->findAnggota($id);

        $data = $request->validate([
            'nama_lengkap' => [
                'required',
                'string',
                'max:150',
            ],

            'nama_panggilan' => [
                'nullable',
                'string',
                'max:100',
            ],

            'jenis_kelamin' => [
                'required',
                'in:laki-laki,perempuan',
            ],

            'tempat_lahir' => [
                'nullable',
                'string',
                'max:150',
            ],

            'tanggal_lahir' => [
                'nullable',
                'date',
            ],

            'tanggal_meninggal' => [
                'nullable',
                'date',
            ],

            'golongan_darah' => [
                'nullable',
                'string',
                'max:5',
            ],

            'agama' => [
                'nullable',
                'string',
                'max:50',
            ],

            'pekerjaan' => [
                'nullable',
                'string',
                'max:100',
            ],

            'telepon' => [
                'nullable',
                'string',
                'max:30',
            ],

            'email' => [
                'nullable',
                'email',
                'max:150',
            ],

            'alamat' => [
                'nullable',
                'string',
            ],

            'catatan' => [
                'nullable',
                'string',
            ],

            'generasi' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'status_hidup' => [
                'required',
                'in:hidup,meninggal',
            ],

            'foto' => [
                'nullable',
                'image',
                'max:2048',
            ],
        ]);


        if ($request->hasFile('foto')) {
            $data['foto'] = $request
                ->file('foto')
                ->store('anggota', 'public');
        }


        $anggota->update($data);


        return redirect()
            ->route('anggota.show', $anggota->id)
            ->with(
                'success',
                'Data anggota berhasil diperbarui.'
            );
    }


    public function nonaktifkan($id)
    {
        $anggota = $this->findAnggota($id);

        $anggota->update([
            'status_data' => 'nonaktif',
        ]);

        return redirect()
            ->route('anggota.index')
            ->with(
                'success',
                'Anggota berhasil dinonaktifkan.'
            );
    }


    private function findAnggota($id)
    {
        return AnggotaKeluarga::where(
            'keluarga_id',
            session('keluarga_id')
        )
            ->where('id', $id)
            ->firstOrFail();
    }
}
