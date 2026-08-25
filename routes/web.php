<?php

use App\Http\Controllers\KeluargaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

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


    Route::middleware('keluarga.aktif')->group(function () {

        Route::view(
            '/dashboard',
            'dashboard'
        )->name('dashboard');

        Route::view(
            '/pohon-silsilah',
            'pohon.index'
        )->name('pohon.index');

        Route::view(
            '/anggota-keluarga',
            'anggota.index'
        )->name('anggota.index');

        Route::view(
            '/anggota-keluarga/tambah',
            'anggota.create'
        )->name('anggota.create');

        Route::view(
            '/anggota-keluarga/{id}',
            'anggota.show'
        )->name('anggota.show');
    });
});

require __DIR__ . '/auth.php';
