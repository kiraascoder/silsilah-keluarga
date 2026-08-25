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
        Schema::table('keluarga', function (Blueprint $table) {
            $table->foreignId('kepala_keluarga_id')
                ->nullable()
                ->after('dibuat_oleh')
                ->constrained('anggota_keluarga')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('keluarga', function (Blueprint $table) {
            //
        });
    }
};
