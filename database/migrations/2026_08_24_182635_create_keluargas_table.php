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
        Schema::create('keluarga', function (Blueprint $table) {
            $table->id();

            $table->string('nama_keluarga', 150);
            $table->string('slug', 180)->unique();

            $table->string('asal_daerah', 150)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable();

            $table->string('kode_undangan', 30)->unique();

            $table->foreignId('dibuat_oleh')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->enum('status', [
                'aktif',
                'nonaktif'
            ])->default('aktif');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keluarga');
    }
};
