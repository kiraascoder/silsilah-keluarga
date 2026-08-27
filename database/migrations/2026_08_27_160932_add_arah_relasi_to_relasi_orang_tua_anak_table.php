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
        Schema::create('relasi_orang_tua_anak', function (Blueprint $table) {


            $table->id();


            /*
            |--------------------------------------------------------------------------
            | Relasi Orang Tua Anak
            |--------------------------------------------------------------------------
            */


            $table->foreignId('orang_tua_id')
                ->constrained('anggota_keluarga')
                ->cascadeOnDelete();



            $table->foreignId('anak_id')
                ->constrained('anggota_keluarga')
                ->cascadeOnDelete();



            /*
            |--------------------------------------------------------------------------
            | Jenis hubungan
            |--------------------------------------------------------------------------
            |
            | Contoh:
            | ayah
            | ibu
            |
            */


            $table->enum(
                'jenis_hubungan',
                [
                    'ayah',
                    'ibu'
                ]
            );



            /*
            |--------------------------------------------------------------------------
            | User pembuat relasi
            |--------------------------------------------------------------------------
            */


            $table->foreignId('dibuat_oleh')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();



            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('relasi_orang_tua_anak');
    }
};
