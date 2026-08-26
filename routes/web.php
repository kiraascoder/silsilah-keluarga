<?php

use App\Http\Controllers\KeluargaController;
use Illuminate\Support\Facades\Route;

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

        Route::view(
            '/anggota-keluarga',
            'anggota.index'
        )->name('anggota.index');


        Route::view(
            '/anggota-keluarga/tambah',
            'anggota.create'
        )->name('anggota.create');


        Route::view(
            '/anggota-keluarga/{id}/edit',
            'anggota.edit'
        )->name('anggota.edit');


        Route::view(
            '/anggota-keluarga/{id}',
            'anggota.show'
        )->name('anggota.show');


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
