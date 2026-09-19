<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {

        Schema::create(
            'relasi_orang_tua_anak',
            function(Blueprint $table){

                $table->id();


                $table->foreignId(
                    'orang_tua_id'
                )
                ->constrained(
                    'anggota_keluarga'
                )
                ->cascadeOnDelete();


                $table->foreignId(
                    'anak_id'
                )
                ->constrained(
                    'anggota_keluarga'
                )
                ->cascadeOnDelete();



                $table->enum(
                    'jenis_hubungan',
                    [
                        'ayah',
                        'ibu'
                    ]
                );


                $table->foreignId(
                    'dibuat_oleh'
                )
                ->nullable()
                ->constrained(
                    'users'
                )
                ->nullOnDelete();


                $table->timestamps();



                $table->unique([
                    'orang_tua_id',
                    'anak_id',
                    'jenis_hubungan'
                ]);

            }
        );

    }



    public function down(): void
    {

        Schema::dropIfExists(
            'relasi_orang_tua_anak'
        );

    }

};
