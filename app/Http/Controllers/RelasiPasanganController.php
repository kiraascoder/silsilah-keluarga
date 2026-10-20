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

        $anggota = AnggotaKeluarga::query()
            ->where('keluarga_id', $keluargaId)
            ->where('status_data', 'aktif')
            ->where('id', $id)
            ->firstOrFail();

        $daftarAnggota = AnggotaKeluarga::query()
            ->where('keluarga_id', $keluargaId)
            ->where('status_data', 'aktif')
            ->where('id', '!=', $anggota->id)
            ->orderBy('nama_lengkap')
            ->get();

        return view('pasangan.create', compact('anggota', 'daftarAnggota'));
    }

    public function store(Request $request)
    {
        $keluargaId = session('keluarga_id');

        $data = $request->validate([
            'anggota_utama_id' => [
                'required',
                'integer',
                'different:anggota_pasangan_id',
            ],
            'anggota_pasangan_id' => [
                'required',
                'integer',
                'different:anggota_utama_id',
            ],
            'status_hubungan' => [
                'required',
                'in:suami_istri,mantan',
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

        $anggotaUtama = AnggotaKeluarga::query()
            ->where('keluarga_id', $keluargaId)
            ->where('status_data', 'aktif')
            ->where('id', $data['anggota_utama_id'])
            ->firstOrFail();

        $anggotaPasangan = AnggotaKeluarga::query()
            ->where('keluarga_id', $keluargaId)
            ->where('status_data', 'aktif')
            ->where('id', $data['anggota_pasangan_id'])
            ->firstOrFail();

        $relasiSudahAda = RelasiPasangan::query()
            ->where(function ($query) use ($anggotaUtama, $anggotaPasangan) {
                $query
                    ->where('anggota_pertama_id', $anggotaUtama->id)
                    ->where('anggota_kedua_id', $anggotaPasangan->id);
            })
            ->orWhere(function ($query) use ($anggotaUtama, $anggotaPasangan) {
                $query
                    ->where('anggota_pertama_id', $anggotaPasangan->id)
                    ->where('anggota_kedua_id', $anggotaUtama->id);
            })
            ->exists();

        if ($relasiSudahAda) {
            return back()
                ->withInput()
                ->with('error', 'Hubungan pasangan antara kedua anggota tersebut sudah pernah dicatat.');
        }

        RelasiPasangan::create([
            'anggota_pertama_id' => $anggotaUtama->id,
            'anggota_kedua_id' => $anggotaPasangan->id,
            'status_hubungan' => $data['status_hubungan'],
            'tanggal_mulai' => $data['tanggal_mulai'] ?? null,
            'tanggal_berakhir' => $data['tanggal_berakhir'] ?? null,
            'catatan' => $data['catatan'] ?? null,
            'dibuat_oleh' => auth()->id(),
        ]);

        return redirect()
            ->route('anggota.show', $anggotaUtama->id)
            ->with('success', 'Hubungan pasangan berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $keluargaId = session('keluarga_id');

        $relasi = RelasiPasangan::query()
            ->where('id', $id)
            ->whereHas('anggotaPertama', function ($query) use ($keluargaId) {
                $query
                    ->where('keluarga_id', $keluargaId)
                    ->where('status_data', 'aktif');
            })
            ->whereHas('anggotaKedua', function ($query) use ($keluargaId) {
                $query
                    ->where('keluarga_id', $keluargaId)
                    ->where('status_data', 'aktif');
            })
            ->firstOrFail();

        $anggotaId = $relasi->anggota_pertama_id;

        $relasi->delete();

        return redirect()
            ->route('anggota.show', $anggotaId)
            ->with('success', 'Hubungan pasangan berhasil dihapus.');
    }
}
