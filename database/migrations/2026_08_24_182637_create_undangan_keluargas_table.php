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
        Schema::create('undangan_keluarga', function (Blueprint $table) {
            $table->id();

            $table->foreignId('keluarga_id')
                ->constrained('keluarga')
                ->cascadeOnDelete();

            $table->foreignId('diundang_oleh')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('email', 150)->nullable();

            $table->string('kode_undangan', 50)->unique();

            $table->enum('status', [
                'menunggu',
                'diterima',
                'kedaluwarsa',
                'dibatalkan'
            ])->default('menunggu');

            $table->timestamp('kedaluwarsa_pada')->nullable();

            $table->foreignId('diterima_oleh')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('diterima_pada')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('undangan_keluarga');
    }
};
