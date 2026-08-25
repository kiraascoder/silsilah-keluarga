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
        Schema::create('dokumen_anggota', function (Blueprint $table) {
            $table->id();

            $table->foreignId('anggota_keluarga_id')
                ->constrained('anggota_keluarga')
                ->cascadeOnDelete();

            $table->string('nama_dokumen', 150);
            $table->string('file_path');
            $table->string('tipe_file', 50)->nullable();

            $table->foreignId('diunggah_oleh')
                ->constrained('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_anggotas');
    }
};
