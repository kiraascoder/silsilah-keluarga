<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggota_keluarga', function (Blueprint $table) {

            $table->id();


            $table->foreignId('keluarga_id')
                ->constrained('keluarga')
                ->cascadeOnDelete();


            $table->string('nama_lengkap');

            $table->string('nama_panggilan')
                ->nullable();


            $table->string('tempat_lahir')
                ->nullable();


            $table->date('tanggal_lahir')
                ->nullable();


            $table->enum(
                'jenis_kelamin',
                [
                    'laki-laki',
                    'perempuan'
                ]
            );


            $table->enum(
                'golongan_darah',
                [
                    'A',
                    'B',
                    'AB',
                    'O'
                ]
            )
            ->nullable();


            $table->integer('generasi')
                ->default(1);


            $table->string('status')
                ->default('hidup');


            $table->string('foto')
                ->nullable();


            /*
            aktif:
            masih tampil

            tidak_aktif:
            anggota keluar
            */

            $table->enum(
                'status_data',
                [
                    'aktif',
                    'tidak_aktif'
                ]
            )
            ->default('aktif');


            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('anggota_keluarga');
    }
};