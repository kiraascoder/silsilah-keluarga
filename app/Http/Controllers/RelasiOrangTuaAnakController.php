<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKeluarga;
use App\Models\RelasiOrangTuaAnak;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RelasiOrangTuaAnakController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Form Tambah Relasi
    |--------------------------------------------------------------------------
    */

    public function create($id)
    {
        $keluargaId = session('keluarga_id');

        /*
        |--------------------------------------------------------------------------
        | Pastikan keluarga aktif tersedia
        |--------------------------------------------------------------------------
        */

        if (!$keluargaId) {
            abort(403, 'Keluarga aktif belum dipilih.');
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil anggota utama
        |--------------------------------------------------------------------------
        */

        $anggota = AnggotaKeluarga::query()
            ->where('keluarga_id', $keluargaId)
            ->where('status_data', 'aktif')
            ->where('id', $id)
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Ambil daftar anggota keluarga
        |--------------------------------------------------------------------------
        |
        | Hanya anggota aktif dari keluarga yang sedang aktif.
        |
        */

        $daftarAnggota = AnggotaKeluarga::query()
            ->where('keluarga_id', $keluargaId)
            ->where('status_data', 'aktif')
            ->where('id', '!=', $anggota->id)
            ->orderBy('generasi')
            ->orderBy('nama_lengkap')
            ->get();

        return view(
            'relasi.create',
            compact(
                'anggota',
                'daftarAnggota'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Simpan Relasi
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil keluarga aktif
        |--------------------------------------------------------------------------
        */

        $keluargaId = session('keluarga_id');

        if (!$keluargaId) {
            abort(403, 'Keluarga aktif belum dipilih.');
        }


        /*
        |--------------------------------------------------------------------------
        | Validasi input dasar
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'anggota_utama_id' => [
                'required',
                'integer',
                Rule::exists('anggota_keluarga', 'id')
                    ->where(function ($query) use ($keluargaId) {
                        $query->where('keluarga_id', $keluargaId)
                            ->where('status_data', 'aktif');
                    }),
            ],

            'anggota_id' => [
                'required',
                'integer',
                Rule::exists('anggota_keluarga', 'id')
                    ->where(function ($query) use ($keluargaId) {
                        $query->where('keluarga_id', $keluargaId)
                            ->where('status_data', 'aktif');
                    }),
            ],

            'arah_relasi' => [
                'required',
                'in:orang_tua,anak',
            ],

            'jenis_hubungan' => [
                'required',
                'in:ayah,ibu,anak',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Tidak boleh menghubungkan diri sendiri
        |--------------------------------------------------------------------------
        */

        if (
            (int) $validated['anggota_utama_id']
            ===
            (int) $validated['anggota_id']
        ) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Anggota tidak dapat dihubungkan dengan dirinya sendiri.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Validasi arah hubungan
        |--------------------------------------------------------------------------
        |
        | Jika:
        |
        | anggota utama = Test
        |
        | pilih "Orang Tua"
        |
        | maka anggota yang dipilih adalah Ayah/Ibu dari Test.
        |
        |
        | Jika:
        |
        | anggota utama = Test
        |
        | pilih "Anak"
        |
        | maka anggota yang dipilih adalah Anak dari Test.
        |
        */

        if (
            $validated['arah_relasi'] === 'orang_tua'
            &&
            !in_array(
                $validated['jenis_hubungan'],
                ['ayah', 'ibu'],
                true
            )
        ) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Jika hubungan yang dipilih adalah Orang Tua, jenis hubungan harus Ayah atau Ibu.'
                );
        }


        if (
            $validated['arah_relasi'] === 'anak'
            &&
            $validated['jenis_hubungan'] !== 'anak'
        ) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Jika hubungan yang dipilih adalah Anak, jenis hubungan harus Anak.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Tentukan struktur relasi
        |--------------------------------------------------------------------------
        |
        | Database selalu menyimpan:
        |
        | orang_tua_id
        | anak_id
        |
        */

        if ($validated['arah_relasi'] === 'orang_tua') {

            /*
            | Anggota utama adalah anak.
            | Anggota yang dipilih adalah orang tua.
            */

            $orangTuaId = (int) $validated['anggota_id'];

            $anakId = (int) $validated['anggota_utama_id'];
        } else {

            /*
            | Anggota utama adalah orang tua.
            | Anggota yang dipilih adalah anak.
            */

            $orangTuaId = (int) $validated['anggota_utama_id'];

            $anakId = (int) $validated['anggota_id'];
        }


        /*
        |--------------------------------------------------------------------------
        | Pastikan kedua anggota benar-benar berada di keluarga aktif
        |--------------------------------------------------------------------------
        */

        $orangTua = AnggotaKeluarga::query()
            ->where('id', $orangTuaId)
            ->where('keluarga_id', $keluargaId)
            ->where('status_data', 'aktif')
            ->firstOrFail();


        $anak = AnggotaKeluarga::query()
            ->where('id', $anakId)
            ->where('keluarga_id', $keluargaId)
            ->where('status_data', 'aktif')
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Cek relasi duplikat
        |--------------------------------------------------------------------------
        */

        $relasiSudahAda = RelasiOrangTuaAnak::query()
            ->where('orang_tua_id', $orangTuaId)
            ->where('anak_id', $anakId)
            ->exists();

        if ($relasiSudahAda) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Hubungan antara kedua anggota tersebut sudah terdaftar.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Cek batas hubungan orang tua
        |--------------------------------------------------------------------------
        |
        | Satu anak maksimal:
        |
        | 1 ayah
        | 1 ibu
        |
        */

        if (
            in_array(
                $validated['jenis_hubungan'],
                ['ayah', 'ibu'],
                true
            )
        ) {

            $orangTuaDenganJenisSudahAda =
                RelasiOrangTuaAnak::query()
                ->where('anak_id', $anakId)
                ->where(
                    'jenis_hubungan',
                    $validated['jenis_hubungan']
                )
                ->exists();

            if ($orangTuaDenganJenisSudahAda) {

                $label = $validated['jenis_hubungan'] === 'ayah'
                    ? 'Ayah'
                    : 'Ibu';

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        "Anggota ini sudah memiliki {$label}. Hapus hubungan lama terlebih dahulu jika ingin menggantinya."
                    );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Cek siklus silsilah
        |--------------------------------------------------------------------------
        |
        | Contoh yang dilarang:
        |
        | A -> B -> C
        |
        | lalu mencoba:
        |
        | C -> A
        |
        */

        if (
            $this->menyebabkanSiklus(
                $orangTuaId,
                $anakId,
                $keluargaId
            )
        ) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Hubungan tersebut akan membentuk siklus dalam silsilah keluarga.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Simpan relasi
        |--------------------------------------------------------------------------
        */

        RelasiOrangTuaAnak::create([
            'orang_tua_id' => $orangTuaId,
            'anak_id' => $anakId,
            'jenis_hubungan' => $validated['jenis_hubungan'],
            'dibuat_oleh' => auth()->id(),
        ]);


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'anggota.show',
                $validated['anggota_utama_id']
            )
            ->with(
                'success',
                'Hubungan keluarga berhasil ditambahkan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Cek Siklus
    |--------------------------------------------------------------------------
    */

    private function menyebabkanSiklus(
        int $orangTuaId,
        int $anakId,
        int $keluargaId
    ): bool {

        /*
        |--------------------------------------------------------------------------
        | Mulai dari anak
        |--------------------------------------------------------------------------
        |
        | Kita mencari seluruh keturunan dari anak tersebut.
        |
        | Jika orang tua baru ternyata merupakan keturunan
        | dari anak tersebut, berarti akan terbentuk siklus.
        |
        */

        $antrian = [$anakId];

        $sudahDiperiksa = [];


        while (!empty($antrian)) {

            $anggotaId = array_shift($antrian);


            /*
            |--------------------------------------------------------------------------
            | Hindari pemeriksaan berulang
            |--------------------------------------------------------------------------
            */

            if (
                in_array(
                    $anggotaId,
                    $sudahDiperiksa,
                    true
                )
            ) {
                continue;
            }


            $sudahDiperiksa[] = $anggotaId;


            /*
            |--------------------------------------------------------------------------
            | Ambil semua anak dari anggota saat ini
            |--------------------------------------------------------------------------
            */

            $anakAnak = RelasiOrangTuaAnak::query()
                ->where(
                    'orang_tua_id',
                    $anggotaId
                )
                ->whereHas(
                    'anak',
                    function ($query) use ($keluargaId) {

                        $query
                            ->where(
                                'keluarga_id',
                                $keluargaId
                            )
                            ->where(
                                'status_data',
                                'aktif'
                            );
                    }
                )
                ->pluck('anak_id');


            /*
            |--------------------------------------------------------------------------
            | Periksa keturunan
            |--------------------------------------------------------------------------
            */

            foreach ($anakAnak as $id) {

                /*
                | Jika orang tua yang akan ditambahkan
                | ditemukan sebagai keturunan dari anak,
                | maka hubungan tersebut membentuk siklus.
                */

                if ((int) $id === $orangTuaId) {
                    return true;
                }


                /*
                | Masukkan ke antrian untuk diperiksa
                */

                if (
                    !in_array(
                        (int) $id,
                        $sudahDiperiksa,
                        true
                    )
                ) {

                    $antrian[] = (int) $id;
                }
            }
        }


        return false;
    }


    /*
    |--------------------------------------------------------------------------
    | Hapus Relasi
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $keluargaId = session('keluarga_id');


        if (!$keluargaId) {
            abort(403, 'Keluarga aktif belum dipilih.');
        }


        /*
        |--------------------------------------------------------------------------
        | Pastikan relasi berasal dari keluarga aktif
        |--------------------------------------------------------------------------
        */

        $relasi = RelasiOrangTuaAnak::query()
            ->where('id', $id)

            ->whereHas(
                'orangTua',
                function ($query) use ($keluargaId) {

                    $query
                        ->where(
                            'keluarga_id',
                            $keluargaId
                        );
                }
            )

            ->whereHas(
                'anak',
                function ($query) use ($keluargaId) {

                    $query
                        ->where(
                            'keluarga_id',
                            $keluargaId
                        );
                }
            )

            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Simpan ID anak untuk redirect
        |--------------------------------------------------------------------------
        */

        $anakId = $relasi->anak_id;


        /*
        |--------------------------------------------------------------------------
        | Hapus relasi
        |--------------------------------------------------------------------------
        */

        $relasi->delete();


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'anggota.show',
                $anakId
            )
            ->with(
                'success',
                'Hubungan keluarga berhasil dihapus.'
            );
    }
}
