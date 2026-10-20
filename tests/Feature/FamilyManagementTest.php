<?php

namespace Tests\Feature;

use App\Models\AnggotaKeluarga;
use App\Models\Keluarga;
use App\Models\RelasiPasangan;
use App\Models\RelasiOrangTuaAnak;
use App\Models\SejarahKeluarga;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FamilyManagementTest extends TestCase
{
    use RefreshDatabase;

    private function keluarga(User $user): Keluarga
    {
        $keluarga = Keluarga::create([
            'nama_keluarga' => 'Keluarga Test',
            'slug' => 'keluarga-test-' . uniqid(),
            'kode_undangan' => 'TEST' . uniqid(),
            'dibuat_oleh' => $user->id,
            'status' => 'aktif',
        ]);

        $keluarga->pengguna()->attach($user->id, [
            'level_akses' => 'pemilik',
            'status' => 'aktif',
            'bergabung_pada' => now(),
        ]);

        return $keluarga;
    }

    private function anggota(Keluarga $keluarga, string $nama, string $jenisKelamin = 'laki-laki'): AnggotaKeluarga
    {
        return AnggotaKeluarga::create([
            'keluarga_id' => $keluarga->id,
            'nama_lengkap' => $nama,
            'jenis_kelamin' => $jenisKelamin,
            'generasi' => 1,
            'status' => 'hidup',
            'status_data' => 'aktif',
        ]);
    }

    public function test_an_member_can_have_multiple_spouse_relationships(): void
    {
        $user = User::factory()->create();
        $keluarga = $this->keluarga($user);
        $utama = $this->anggota($keluarga, 'Suami');
        $istriPertama = $this->anggota($keluarga, 'Istri Pertama', 'perempuan');
        $istriKedua = $this->anggota($keluarga, 'Istri Kedua', 'perempuan');
        $istriKetiga = $this->anggota($keluarga, 'Istri Ketiga', 'perempuan');

        $this->actingAs($user)->withSession([
            'keluarga_id' => $keluarga->id,
            'keluarga_level_akses' => 'pemilik',
        ]);

        foreach ([$istriPertama, $istriKedua, $istriKetiga] as $pasangan) {
            $this->post(route('pasangan.store'), [
                'anggota_utama_id' => $utama->id,
                'anggota_pasangan_id' => $pasangan->id,
                'status_hubungan' => 'suami_istri',
            ])->assertRedirect(route('anggota.show', $utama->id));
        }

        $this->assertSame(3, RelasiPasangan::where('anggota_pertama_id', $utama->id)->count());
    }

    public function test_member_permanent_delete_removes_relationships(): void
    {
        $user = User::factory()->create();
        $keluarga = $this->keluarga($user);
        $parent = $this->anggota($keluarga, 'Parent');
        $child = $this->anggota($keluarga, 'Child');
        $spouse = $this->anggota($keluarga, 'Spouse', 'perempuan');

        $child->orangTua()->attach($parent->id, [
            'jenis_hubungan' => 'ayah',
            'dibuat_oleh' => $user->id,
        ]);

        RelasiPasangan::create([
            'anggota_pertama_id' => $child->id,
            'anggota_kedua_id' => $spouse->id,
            'status_hubungan' => 'suami_istri',
            'dibuat_oleh' => $user->id,
        ]);

        $this->actingAs($user)->withSession([
            'keluarga_id' => $keluarga->id,
            'keluarga_level_akses' => 'pemilik',
        ]);

        $this->delete(route('anggota.hapus-permanen', $child->id))
            ->assertRedirect(route('anggota.index'));

        $this->assertDatabaseMissing('anggota_keluarga', ['id' => $child->id]);
        $this->assertDatabaseMissing('relasi_orang_tua_anak', ['anak_id' => $child->id]);
        $this->assertDatabaseMissing('relasi_pasangan', ['anggota_pertama_id' => $child->id]);
    }

    public function test_family_history_is_scoped_to_active_family(): void
    {
        $user = User::factory()->create();
        $keluarga = $this->keluarga($user);

        $this->actingAs($user)->withSession([
            'keluarga_id' => $keluarga->id,
            'keluarga_level_akses' => 'pemilik',
        ]);

        $this->post(route('sejarah.store'), [
            'judul' => 'Peristiwa Keluarga',
            'tanggal' => '2026-01-01',
            'deskripsi' => 'Catatan sejarah keluarga.',
        ])->assertRedirect(route('sejarah.index'));

        $this->assertDatabaseHas('sejarah_keluarga', [
            'keluarga_id' => $keluarga->id,
            'judul' => 'Peristiwa Keluarga',
        ]);

        $this->get(route('sejarah.index'))->assertOk();
    }

    public function test_family_owner_can_delete_family(): void
    {
        $user = User::factory()->create();
        $keluarga = $this->keluarga($user);
        $member = $this->anggota($keluarga, 'Member');
        SejarahKeluarga::create([
            'keluarga_id' => $keluarga->id,
            'judul' => 'Sejarah',
            'deskripsi' => 'Catatan',
            'dibuat_oleh' => $user->id,
        ]);

        $this->actingAs($user)->withSession([
            'keluarga_id' => $keluarga->id,
            'keluarga_level_akses' => 'pemilik',
        ]);

        $this->delete(route('keluarga.destroy', $keluarga->id))
            ->assertRedirect(route('keluarga.pilih'));

        $this->assertDatabaseMissing('keluarga', ['id' => $keluarga->id]);
        $this->assertDatabaseMissing('anggota_keluarga', ['id' => $member->id]);
        $this->assertDatabaseMissing('sejarah_keluarga', ['keluarga_id' => $keluarga->id]);
    }
}
