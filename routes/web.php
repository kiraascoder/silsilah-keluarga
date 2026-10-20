<?php

use App\Http\Controllers\AnggotaKeluargaController;
use App\Http\Controllers\KeluargaController;
use App\Http\Controllers\PohonSilsilahController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RelasiOrangTuaAnakController;
use App\Http\Controllers\RelasiPasanganController;
use App\Http\Controllers\SejarahKeluargaController;
use App\Http\Controllers\UndanganKeluargaController;
use App\Models\AnggotaKeluarga;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    return view('welcome');
})->name('welcome');



/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {


    /*
    |--------------------------------------------------------------------------
    | Keluarga
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/undangan/{kode}/terima',
        [UndanganKeluargaController::class, 'terima']
    )->name('undangan.terima');

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


    Route::delete(
        '/keluarga/{keluarga}',
        [KeluargaController::class, 'destroy']
    )->name('keluarga.destroy');


    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');


    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');


    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');


    /*
    |--------------------------------------------------------------------------
    | Terima Undangan
    |--------------------------------------------------------------------------
    |
    | Tidak menggunakan keluarga.aktif karena penerima
    | bisa jadi belum menjadi anggota keluarga.
    |
    */

    Route::get(
        '/undangan/{kode}/terima',
        [UndanganKeluargaController::class, 'terima']
    )->name('undangan.terima');


    /*
    |--------------------------------------------------------------------------
    | Keluarga Aktif
    |--------------------------------------------------------------------------
    */

    Route::middleware('keluarga.aktif')->group(function () {


        Route::middleware('hak.akses:pemilik,editor')
            ->group(function () {

                Route::get(
                    '/undangan-keluarga',
                    [UndanganKeluargaController::class, 'index']
                )->name('undangan.index');


                Route::get(
                    '/undangan-keluarga/tambah',
                    [UndanganKeluargaController::class, 'create']
                )->name('undangan.create');


                Route::post(
                    '/undangan-keluarga',
                    [UndanganKeluargaController::class, 'store']
                )->name('undangan.store');
            });
        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */
        Route::get('/dashboard', function () {

            $keluargaId = session('keluarga_id');

            $total_anggota = AnggotaKeluarga::query()
                ->where('keluarga_id', $keluargaId)
                ->where('status_data', 'aktif')
                ->count();

            return view('dashboard', compact('total_anggota'));
        })->name('dashboard');
        /*
        |--------------------------------------------------------------------------
        | Pohon Silsilah
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/pohon-silsilah',
            [PohonSilsilahController::class, 'index']
        )->name('pohon.index');


        Route::get(
            '/sejarah-keluarga',
            [SejarahKeluargaController::class, 'index']
        )->name('sejarah.index');


        /*
        |--------------------------------------------------------------------------
        | Anggota - Read
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/anggota-keluarga',
            [AnggotaKeluargaController::class, 'index']
        )->name('anggota.index');


        /*
        |--------------------------------------------------------------------------
        | Anggota - Write
        |--------------------------------------------------------------------------
        */

        Route::middleware(
            'hak.akses:pemilik,editor'
        )->group(function () {

        
            Route::patch(
                '/anggota-keluarga/{id}/aktifkan',
                [AnggotaKeluargaController::class, 'aktifkan']
            )->name('anggota.aktifkan');

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


            Route::delete(
                '/anggota-keluarga/{id}',
                [AnggotaKeluargaController::class, 'destroy']
            )->name('anggota.destroy');


            Route::delete(
                '/anggota-keluarga/{id}/hapus-permanen',
                [AnggotaKeluargaController::class, 'hapusPermanen']
            )->name('anggota.hapus-permanen');


            /*
            |--------------------------------------------------------------------------
            | Relasi Orang Tua Anak
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/anggota-keluarga/{id}/tambah-relasi',
                [RelasiOrangTuaAnakController::class, 'create']
            )->name('relasi.create');


            Route::post(
                '/relasi-orang-tua-anak',
                [RelasiOrangTuaAnakController::class, 'store']
            )->name('relasi.store');


            Route::delete(
                '/relasi-orang-tua-anak/{id}',
                [RelasiOrangTuaAnakController::class, 'destroy']
            )->name('relasi.destroy');


            /*
            |--------------------------------------------------------------------------
            | Relasi Pasangan
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/anggota-keluarga/{id}/tambah-pasangan',
                [RelasiPasanganController::class, 'create']
            )->name('pasangan.create');


            Route::post(
                '/relasi-pasangan',
                [RelasiPasanganController::class, 'store']
            )->name('pasangan.store');


            Route::delete(
                '/relasi-pasangan/{id}',
                [RelasiPasanganController::class, 'destroy']
            )->name('pasangan.destroy');


            Route::get(
                '/sejarah-keluarga/tambah',
                [SejarahKeluargaController::class, 'create']
            )->name('sejarah.create');


            Route::post(
                '/sejarah-keluarga',
                [SejarahKeluargaController::class, 'store']
            )->name('sejarah.store');


            Route::get(
                '/sejarah-keluarga/{id}/edit',
                [SejarahKeluargaController::class, 'edit']
            )->name('sejarah.edit');


            Route::put(
                '/sejarah-keluarga/{id}',
                [SejarahKeluargaController::class, 'update']
            )->name('sejarah.update');


            Route::delete(
                '/sejarah-keluarga/{id}',
                [SejarahKeluargaController::class, 'destroy']
            )->name('sejarah.destroy');


            /*
            |--------------------------------------------------------------------------
            | Undangan Keluarga
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/undangan-keluarga',
                [UndanganKeluargaController::class, 'index']
            )->name('undangan.index');


            Route::get(
                '/undangan-keluarga/tambah',
                [UndanganKeluargaController::class, 'create']
            )->name('undangan.create');


            Route::post(
                '/undangan-keluarga',
                [UndanganKeluargaController::class, 'store']
            )->name('undangan.store');

            Route::delete(
                '/undangan-keluarga/{id}/delete',
                [UndanganKeluargaController::class, 'destroy']
            )->name('undangan.destroy');
        });


        /*
        |--------------------------------------------------------------------------
        | Detail Anggota
        |--------------------------------------------------------------------------
        |
        | Harus berada setelah route /tambah dan /{id}/edit.
        |
        */

        Route::get(
            '/anggota-keluarga/{id}',
            [AnggotaKeluargaController::class, 'show']
        )->name('anggota.show');
    });
});


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';