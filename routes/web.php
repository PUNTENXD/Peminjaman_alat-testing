<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\KembaliController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->name('login.store');

Route::post('/logout', function () {
   Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');


/*
|--------------------------------------------------------------------------
| AUTH REQUIRED
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | PEMINJAMAN
    |--------------------------------------------------------------------------
    */

    Route::get('/peminjaman', [PeminjamanController::class, 'index'])
        ->name('peminjaman.index');

    Route::get('/peminjaman/{id}/edit', [PeminjamanController::class, 'edit'])
        ->middleware('role:admin,petugas')
        ->name('peminjaman.edit');

    Route::post('/peminjaman/{id}/update', [PeminjamanController::class, 'update'])
        ->middleware('role:admin,petugas')
        ->name('peminjaman.update');

    Route::post('/peminjaman/{id}/acc', [PeminjamanController::class, 'acc'])
        ->middleware('role:petugas')
        ->name('peminjaman.acc');

    Route::post('/peminjaman/{id}/kembali', [PeminjamanController::class, 'kembali'])
        ->middleware('role:petugas')
        ->name('peminjaman.kembali');


    /*
    |--------------------------------------------------------------------------
    | KEMBALI (ADMIN & PETUGAS)
    |--------------------------------------------------------------------------
    */

    Route::get('/kembali', [KembaliController::class, 'index'])
        ->middleware('role:admin,petugas')
        ->name('kembali.index');


    /*
    |--------------------------------------------------------------------------
    | ADMIN AREA
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')->group(function () {

        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');

        // Kategori
        Route::get('/kategori', [KategoriController::class, 'index'])
            ->name('kategori.index');

        Route::post('/kategori', [KategoriController::class, 'store'])
            ->name('kategori.store');


            // Edit form
        Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])
            ->name('kategori.edit');

        // Update
        Route::put('/kategori/{id}', [KategoriController::class, 'update'])
            ->name('kategori.update');

        // Delete
        Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])
            ->name('kategori.destroy');


        // Log Aktivitas
        Route::get('/log', [LogAktivitasController::class, 'index'])
            ->name('log.index');

        // User Management
        Route::get('/user', [UserController::class, 'index'])
            ->name('user.index');

        Route::get('/user/create', [UserController::class, 'create'])
            ->name('user.create');

        Route::post('/user', [UserController::class, 'store'])
            ->name('user.store');

        Route::get('/user/{id}/edit', [UserController::class, 'edit'])
            ->name('user.edit');

        Route::post('/user/{id}', [UserController::class, 'update'])
            ->name('user.update');

        Route::post('/user/{id}/delete', [UserController::class, 'destroy'])
            ->name('user.destroy');


        // ===============================
        // ALAT (ADMIN ONLY)
        // ===============================

        Route::get('/alat', [\App\Http\Controllers\AlatController::class, 'index'])
         ->name('alat.index');

        Route::get('/alat/create', [\App\Http\Controllers\AlatController::class, 'create'])
        ->name('alat.create');

        Route::post('/alat', [\App\Http\Controllers\AlatController::class, 'store'])
        ->name('alat.store');

        Route::get('/alat/{id}/edit', [\App\Http\Controllers\AlatController::class, 'edit'])
        ->name('alat.edit');

        Route::post('/alat/{id}/update', [\App\Http\Controllers\AlatController::class, 'update'])
        ->name('alat.update');

        Route::post('/alat/{id}/delete', [\App\Http\Controllers\AlatController::class, 'destroy'])
        ->name('alat.destroy');


    });


/*
|--------------------------------------------------------------------------
| PETUGAS AREA
|--------------------------------------------------------------------------
*/

Route::middleware('role:petugas')->group(function () {

    Route::get('/petugas/dashboard', [\App\Http\Controllers\PetugasDashboardController::class, 'index'])
        ->name('petugas.dashboard');

    Route::get('/petugas/peminjaman', [\App\Http\Controllers\PetugasDashboardController::class, 'peminjaman'])
        ->name('petugas.peminjaman');

    Route::get('/petugas/pengembalian', [\App\Http\Controllers\PetugasDashboardController::class, 'pengembalian'])
        ->name('petugas.pengembalian');

    Route::get('/petugas/laporan', [\App\Http\Controllers\PetugasDashboardController::class, 'laporan'])
    ->name('petugas.laporan');

    // return view('petugas.laporan', compact('data','alat'));


});



Route::middleware(['auth','role:peminjam'])->group(function () {

    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])
        ->name('user.dashboard');

    Route::post('/user/pinjam', [UserDashboardController::class, 'pinjam'])
        ->name('user.pinjam');

    Route::post('/user/kembali/{id}', [UserDashboardController::class, 'kembali'])
        ->name('user.kembali');
});




});
