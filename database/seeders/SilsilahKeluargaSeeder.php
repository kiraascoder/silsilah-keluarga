<?php

namespace Database\Seeders;

use App\Models\AnggotaKeluarga;
use App\Models\Keluarga;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SilsilahKeluargaSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | USER
        |--------------------------------------------------------------------------
        */

        $user = User::firstOrCreate(
            [
                'email' => 'irmansyah@example.com',
            ],
            [
                'name' => 'Irmansyah Muslimin',
                'password' => Hash::make('password'),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | KELUARGA
        |--------------------------------------------------------------------------
        */

        $keluarga = Keluarga::create([
            'nama_keluarga' => 'Rumpun Akung Letta',
            'slug' => 'rumpun-akung-letta',
            'asal_daerah' => 'Parepare',
            'deskripsi' => 'Data contoh rumpun keluarga Akung Letta.',
            'kode_undangan' => 'AKUNGLETTA01',
            'dibuat_oleh' => $user->id,
            'status' => 'aktif',
        ]);

        /*
        |--------------------------------------------------------------------------
        | GENERASI 1
        |--------------------------------------------------------------------------
        */

        $akungLetta = AnggotaKeluarga::create([
            'keluarga_id' => $keluarga->id,
            'nama_lengkap' => 'Akung Letta',
            'nama_panggilan' => 'Akung',
            'jenis_kelamin' => 'laki-laki',
            'generasi' => 1,
            'status' => 'hidup',
            'status_data' => 'aktif',
        ]);

        $maraiuntang = AnggotaKeluarga::create([
            'keluarga_id' => $keluarga->id,
            'nama_lengkap' => 'Maraiuntang',
            'nama_panggilan' => 'Marai',
            'jenis_kelamin' => 'perempuan',
            'generasi' => 1,
            'status' => 'hidup',
            'status_data' => 'aktif',
        ]);

        /*
        |--------------------------------------------------------------------------
        | PASANGAN GENERASI 1
        |--------------------------------------------------------------------------
        */

        $akungLetta->relasiPasanganPertama()->create([
            'anggota_kedua_id' => $maraiuntang->id,
            'status_hubungan' => 'suami_istri',
            'dibuat_oleh' => $user->id,
        ]);

        /*
        |--------------------------------------------------------------------------
        | GENERASI 2
        |--------------------------------------------------------------------------
        */

        $puangTollo = $this->anggota(
            $keluarga,
            'Puang Tollo',
            'Tollo',
            'laki-laki',
            2
        );

        $puangBukkung = $this->anggota(
            $keluarga,
            'Puang Bukkung',
            'Bukkung',
            'laki-laki',
            2
        );

        $puangTaru = $this->anggota(
            $keluarga,
            'Puang Taru',
            'Taru',
            'perempuan',
            2
        );

        /*
        |--------------------------------------------------------------------------
        | ORANG TUA GENERASI 1 -> GENERASI 2
        |--------------------------------------------------------------------------
        */

        $this->orangTuaAnak(
            $akungLetta,
            $puangTollo,
            'ayah',
            $user
        );

        $this->orangTuaAnak(
            $maraiuntang,
            $puangTollo,
            'ibu',
            $user
        );

        $this->orangTuaAnak(
            $akungLetta,
            $puangBukkung,
            'ayah',
            $user
        );

        $this->orangTuaAnak(
            $maraiuntang,
            $puangBukkung,
            'ibu',
            $user
        );

        $this->orangTuaAnak(
            $akungLetta,
            $puangTaru,
            'ayah',
            $user
        );

        $this->orangTuaAnak(
            $maraiuntang,
            $puangTaru,
            'ibu',
            $user
        );

        /*
        |--------------------------------------------------------------------------
        | PASANGAN PUANG BUKKUNG
        |--------------------------------------------------------------------------
        */

        $diKariang = $this->anggota(
            $keluarga,
            'Di Kariang',
            'Kariang',
            'perempuan',
            2
        );

        $puangBukkung->relasiPasanganPertama()->create([
            'anggota_kedua_id' => $diKariang->id,
            'status_hubungan' => 'suami_istri',
            'dibuat_oleh' => $user->id,
        ]);

        /*
        |--------------------------------------------------------------------------
        | GENERASI 3
        |--------------------------------------------------------------------------
        */

        $nenekBinggo = $this->anggota(
            $keluarga,
            'Nenek Binggo',
            'Binggo',
            'perempuan',
            3
        );

        /*
        |--------------------------------------------------------------------------
        | PUANG BUKKUNG + DI KARIANG -> NENEK BINGGO
        |--------------------------------------------------------------------------
        */

        $this->orangTuaAnak(
            $puangBukkung,
            $nenekBinggo,
            'ayah',
            $user
        );

        $this->orangTuaAnak(
            $diKariang,
            $nenekBinggo,
            'ibu',
            $user
        );

        /*
        |--------------------------------------------------------------------------
        | PASANGAN NENEK BINGGO
        |--------------------------------------------------------------------------
        */

        $kpptMadika = $this->anggota(
            $keluarga,
            'P. Kppt Madika Garontong',
            'Madika',
            'laki-laki',
            3
        );

        $nenekBinggo->relasiPasanganPertama()->create([
            'anggota_kedua_id' => $kpptMadika->id,
            'status_hubungan' => 'suami_istri',
            'dibuat_oleh' => $user->id,
        ]);

        /*
        |--------------------------------------------------------------------------
        | GENERASI 4
        |--------------------------------------------------------------------------
        */

        $puangPunju = $this->anggota(
            $keluarga,
            'Puang Punju',
            'Punju',
            'laki-laki',
            4
        );

        $pungA = $this->anggota(
            $keluarga,
            'Pung A',
            'Pung A',
            'perempuan',
            4
        );

        $diTondoBunga = $this->anggota(
            $keluarga,
            'Di Tondo Bunga',
            'Tondo',
            'laki-laki',
            4
        );

        $diPenkeng = $this->anggota(
            $keluarga,
            'Di Penkeng',
            'Penkeng',
            'laki-laki',
            4
        );

        $dunga = $this->anggota(
            $keluarga,
            'Dunga',
            'Dunga',
            'perempuan',
            4
        );

        /*
        |--------------------------------------------------------------------------
        | NENEK BINGGO + KPPT MADIKA -> GENERASI 4
        |--------------------------------------------------------------------------
        */

        $anakGenerasi4 = [
            $puangPunju,
            $pungA,
            $diTondoBunga,
            $diPenkeng,
            $dunga,
        ];

        foreach ($anakGenerasi4 as $anak) {
            $this->orangTuaAnak(
                $nenekBinggo,
                $anak,
                'ibu',
                $user
            );

            $this->orangTuaAnak(
                $kpptMadika,
                $anak,
                'ayah',
                $user
            );
        }

        /*
        |--------------------------------------------------------------------------
        | GENERASI 4 - CABANG BERIKUTNYA
        |--------------------------------------------------------------------------
        */

        $puangLahe = $this->anggota(
            $keluarga,
            'Puang Lahe',
            'Lahe',
            'laki-laki',
            4
        );

        $puangTarburu = $this->anggota(
            $keluarga,
            'Puang Tarburu',
            'Tarburu',
            'laki-laki',
            4
        );

        $puangMarlunu = $this->anggota(
            $keluarga,
            'Puang Marlunu',
            'Marlunu',
            'laki-laki',
            4
        );

        $puangToanang = $this->anggota(
            $keluarga,
            'Puang Toanang',
            'Toanang',
            'laki-laki',
            4
        );

        $puangKambece = $this->anggota(
            $keluarga,
            'Puang Kambece',
            'Kambece',
            'laki-laki',
            4
        );

        $indoLaware = $this->anggota(
            $keluarga,
            'Indo Laware',
            'Laware',
            'perempuan',
            4
        );

        $indoPacala = $this->anggota(
            $keluarga,
            'Indo Pacala',
            'Pacala',
            'perempuan',
            4
        );

        /*
        |--------------------------------------------------------------------------
        | GENERASI 4 -> ANAK DARI NENEK BINGGO
        |--------------------------------------------------------------------------
        */

        $anakCabangGenerasi4 = [
            $puangLahe,
            $puangTarburu,
            $puangMarlunu,
            $puangToanang,
            $puangKambece,
            $indoLaware,
            $indoPacala,
        ];

        foreach ($anakCabangGenerasi4 as $anak) {
            $this->orangTuaAnak(
                $nenekBinggo,
                $anak,
                'ibu',
                $user
            );

            $this->orangTuaAnak(
                $kpptMadika,
                $anak,
                'ayah',
                $user
            );
        }

        /*
        |--------------------------------------------------------------------------
        | GENERASI 5
        |--------------------------------------------------------------------------
        */

        $talburu = $this->anggota(
            $keluarga,
            'Talburu',
            'Talburu',
            'laki-laki',
            5
        );

        $pilu = $this->anggota(
            $keluarga,
            'Pilu',
            'Pilu',
            'laki-laki',
            5
        );

        $daca = $this->anggota(
            $keluarga,
            'Daca',
            'Daca',
            'perempuan',
            5
        );

        $tannang = $this->anggota(
            $keluarga,
            'Tannang',
            'Tannang',
            'laki-laki',
            5
        );

        $tawwa = $this->anggota(
            $keluarga,
            'Tawwa',
            'Tawwa',
            'laki-laki',
            5
        );

        $sabbe = $this->anggota(
            $keluarga,
            'Sabbe',
            'Sabbe',
            'laki-laki',
            5
        );

        $pitta = $this->anggota(
            $keluarga,
            'Pitta',
            'Pitta',
            'perempuan',
            5
        );

        $rala = $this->anggota(
            $keluarga,
            'Rala',
            'Rala',
            'perempuan',
            5
        );

        $becce = $this->anggota(
            $keluarga,
            'Becce',
            'Becce',
            'perempuan',
            5
        );

        /*
        |--------------------------------------------------------------------------
        | HUBUNGKAN GENERASI 5
        |--------------------------------------------------------------------------
        |
        | Generasi 5 merupakan anak dari Puang Lahe.
        |
        */

        $anakPuangLahe = [
            $talburu,
            $pilu,
            $daca,
            $tannang,
            $tawwa,
            $sabbe,
            $pitta,
            $rala,
            $becce,
        ];

        foreach ($anakPuangLahe as $anak) {
            $this->orangTuaAnak(
                $puangLahe,
                $anak,
                'ayah',
                $user
            );
        }

        /*
        |--------------------------------------------------------------------------
        | KEPALA KELUARGA
        |--------------------------------------------------------------------------
        */

        $keluarga->update([
            'kepala_keluarga_id' => $akungLetta->id,
        ]);

        /*
        |--------------------------------------------------------------------------
        | PENGGUNA KELUARGA
        |--------------------------------------------------------------------------
        |
        | Relasi Keluarga -> User menggunakan belongsToMany.
        | Data disimpan pada tabel pengguna_keluarga,
        | bukan tabel users.
        |
        */

        $keluarga->pengguna()->attach($user->id, [
            'anggota_keluarga_id' => $akungLetta->id,
            'level_akses' => 'pemilik',
            'status' => 'aktif',
            'bergabung_pada' => now(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER ANGGOTA
    |--------------------------------------------------------------------------
    */

    private function anggota(
        Keluarga $keluarga,
        string $nama,
        string $panggilan,
        string $jenisKelamin,
        int $generasi
    ): AnggotaKeluarga {
        return AnggotaKeluarga::create([
            'keluarga_id' => $keluarga->id,
            'nama_lengkap' => $nama,
            'nama_panggilan' => $panggilan,
            'jenis_kelamin' => $jenisKelamin,
            'generasi' => $generasi,
            'status' => 'hidup',
            'status_data' => 'aktif',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER RELASI ORANG TUA
    |--------------------------------------------------------------------------
    */

    private function orangTuaAnak(
        AnggotaKeluarga $orangTua,
        AnggotaKeluarga $anak,
        string $jenisHubungan,
        User $user
    ): void {
        $anak->orangTua()->attach(
            $orangTua->id,
            [
                'jenis_hubungan' => $jenisHubungan,
                'dibuat_oleh' => $user->id,
            ]
        );
    }
}
