<?php

use App\Http\Controllers\AnggotaKeluargaController;
use App\Http\Controllers\KeluargaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RelasiKeluargaController;

/*
|--------------------------------------------------------------------------
| Halaman Publik
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('beranda');


/*
|--------------------------------------------------------------------------
| Halaman Setelah Login
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Pemilihan Rumpun Keluarga
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/pilih-keluarga',
        [KeluargaController::class, 'pilih']
    )->name('keluarga.pilih');


    Route::get(
        '/keluarga/buat',
        [KeluargaController::class, 'create']
    )->name('keluarga.create');


    Route::post(
        '/keluarga',
        [KeluargaController::class, 'store']
    )->name('keluarga.store');


    Route::post(
        '/keluarga/{keluarga}/pilih',
        [KeluargaController::class, 'pilihAktif']
    )->name('keluarga.aktif');


    /*
    |--------------------------------------------------------------------------
    | Halaman yang membutuhkan keluarga aktif
    |--------------------------------------------------------------------------
    */

    Route::middleware('keluarga.aktif')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::view(
            '/dashboard',
            'dashboard'
        )->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Pohon Silsilah
        |--------------------------------------------------------------------------
        */

        Route::view(
            '/pohon-silsilah',
            'pohon.index'
        )->name('pohon.index');


        /*
        |--------------------------------------------------------------------------
        | Anggota Keluarga
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/anggota-keluarga',
            [AnggotaKeluargaController::class, 'index']
        )->name('anggota.index');


        Route::get(
            '/anggota-keluarga/tambah',
            [AnggotaKeluargaController::class, 'create']
        )->name('anggota.create');


        Route::post(
            '/anggota-keluarga',
            [AnggotaKeluargaController::class, 'store']
        )->name('anggota.store');


        Route::get(
            '/anggota-keluarga/{id}/edit',
            [AnggotaKeluargaController::class, 'edit']
        )->name('anggota.edit');


        Route::put(
            '/anggota-keluarga/{id}',
            [AnggotaKeluargaController::class, 'update']
        )->name('anggota.update');


        Route::patch(
            '/anggota-keluarga/{id}/nonaktifkan',
            [AnggotaKeluargaController::class, 'nonaktifkan']
        )->name('anggota.nonaktifkan');


        Route::get(
            '/anggota-keluarga/{id}',
            [AnggotaKeluargaController::class, 'show']
        )->name('anggota.show');


        Route::get(
            '/anggota-keluarga/{id}',
            [AnggotaKeluargaController::class, 'show']
        )->name('anggota.show');

        Route::put(
            '/anggota-keluarga/{id}',
            [AnggotaKeluargaController::class, 'update']
        )
            ->name('anggota.update');
        Route::get(
            '/anggota-keluarga/{id}/tambah-relasi',
            [
                RelasiKeluargaController::class,
                'create'
            ]
        )
            ->name('relasi.create');


        Route::post(
            '/relasi-keluarga',
            [
                RelasiKeluargaController::class,
                'store'
            ]
        )
            ->name('relasi.store');
        Route::delete(
            '/relasi-keluarga/{id}',
            [RelasiKeluargaController::class, 'destroy']
        )->name('relasi.destroy');


        /*
        |--------------------------------------------------------------------------
        | Profil
        |--------------------------------------------------------------------------
        */

        Route::view(
            '/profil',
            'profil.index'
        )->name('profil.index');


        /*
        |--------------------------------------------------------------------------
        | Pengaturan
        |--------------------------------------------------------------------------
        */

        Route::view(
            '/pengaturan',
            'pengaturan.index'
        )->name('pengaturan.index');
    });
});


/*
|--------------------------------------------------------------------------
| Authentication Breeze
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
