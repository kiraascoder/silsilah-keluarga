<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('anggota_keluarga', function (Blueprint $table) {
            $table->id();

            $table->foreignId('keluarga_id')
                ->constrained('keluarga')
                ->cascadeOnDelete();

            $table->foreignId('pengguna_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('nama_lengkap', 150);
            $table->string('nama_panggilan', 100)->nullable();

            $table->enum('jenis_kelamin', [
                'laki-laki',
                'perempuan'
            ]);

            $table->string('tempat_lahir', 150)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->date('tanggal_meninggal')->nullable();

            $table->string('golongan_darah', 5)->nullable();
            $table->string('agama', 50)->nullable();
            $table->string('pekerjaan', 100)->nullable();

            $table->string('telepon', 30)->nullable();
            $table->string('email', 150)->nullable();

            $table->text('alamat')->nullable();
            $table->string('foto')->nullable();
            $table->text('catatan')->nullable();

            $table->unsignedInteger('generasi')->nullable();

            $table->enum('status_hidup', [
                'hidup',
                'meninggal'
            ])->default('hidup');

            $table->enum('status_data', [
                'aktif',
                'nonaktif'
            ])->default('aktif');

            $table->foreignId('dibuat_oleh')
                ->constrained('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota_keluargas');
    }
};
