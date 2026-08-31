<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('relasi_pasangan', function (Blueprint $table) {

            $table->id();

            $table->foreignId('anggota_pertama_id')
                ->constrained('anggota_keluarga')
                ->cascadeOnDelete();

            $table->foreignId('anggota_kedua_id')
                ->constrained('anggota_keluarga')
                ->cascadeOnDelete();

            $table->enum('status_hubungan', [
                'suami_istri',
            ])->default('suami_istri');

            $table->date('tanggal_mulai')
                ->nullable();

            $table->date('tanggal_berakhir')
                ->nullable();

            $table->text('catatan')
                ->nullable();

            $table->foreignId('dibuat_oleh')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->unique([
                'anggota_pertama_id',
                'anggota_kedua_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('relasi_pasangan');
    }
};
