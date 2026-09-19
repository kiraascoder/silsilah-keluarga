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
        Schema::create('pengguna_keluarga', function (Blueprint $table) {
            $table->id();

            $table->foreignId('keluarga_id')
                ->constrained('keluarga')
                ->cascadeOnDelete();

            $table->foreignId('pengguna_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('anggota_keluarga_id')
                ->nullable()
                ->constrained('anggota_keluarga')
                ->nullOnDelete();

            $table->enum('level_akses', [
                'pemilik',
                'editor',
                'anggota'
            ])->default('anggota');

            $table->enum('status', [
                'pending',
                'aktif',
                'ditolak'
            ])->default('pending');

            $table->timestamp('bergabung_pada')->nullable();

            $table->timestamps();

            $table->unique([
                'keluarga_id',
                'pengguna_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengguna_keluarga');
    }
};
