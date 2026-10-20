<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sejarah_keluarga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('keluarga_id')
                ->constrained('keluarga')
                ->cascadeOnDelete();
            $table->string('judul', 200);
            $table->date('tanggal')->nullable();
            $table->text('deskripsi');
            $table->foreignId('dibuat_oleh')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sejarah_keluarga');
    }
};
