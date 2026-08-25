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
        Schema::create('relasi_pasangan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('keluarga_id')
                ->constrained('keluarga')
                ->cascadeOnDelete();

            $table->foreignId('anggota_1_id')
                ->constrained('anggota_keluarga')
                ->cascadeOnDelete();

            $table->foreignId('anggota_2_id')
                ->constrained('anggota_keluarga')
                ->cascadeOnDelete();

            $table->date('tanggal_pernikahan')->nullable();
            $table->date('tanggal_berakhir')->nullable();

            $table->enum('status_pernikahan', [
                'menikah',
                'bercerai',
                'janda_duda'
            ])->default('menikah');

            $table->text('catatan')->nullable();

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
        Schema::dropIfExists('relasi_pasangans');
    }
};
