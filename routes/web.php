<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\KembaliController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\PetugasDashboardController;
use App\Http\Controllers\AlatController;

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
| ADMIN AREA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');

    // ================= KATEGORI =================
    Route::get('/kategori', [KategoriController::class, 'index'])
        ->name('kategori.index');

    Route::post('/kategori', [KategoriController::class, 'store'])
        ->name('kategori.store');

    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])
        ->name('kategori.edit');

    Route::put('/kategori/{id}', [KategoriController::class, 'update'])
        ->name('kategori.update');

    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])
        ->name('kategori.destroy');

    // ================= ALAT =================
    Route::get('/alat', [AlatController::class, 'index'])
        ->name('alat.index');

    Route::get('/alat/create', [AlatController::class, 'create'])
        ->name('alat.create');

    Route::post('/alat', [AlatController::class, 'store'])
        ->name('alat.store');

    Route::get('/alat/{id}/edit', [AlatController::class, 'edit'])
        ->name('alat.edit');

    Route::post('/alat/{id}/update', [AlatController::class, 'update'])
        ->name('alat.update');

    Route::post('/alat/{id}/delete', [AlatController::class, 'destroy'])
        ->name('alat.destroy');

    // ================= USER MANAGEMENT =================
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

    // ================= LOG =================
    Route::get('/log', [LogAktivitasController::class, 'index'])
        ->name('log.index');
});


/*
|--------------------------------------------------------------------------
| PETUGAS AREA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:petugas'])
    ->prefix('petugas')
    ->as('petugas.')
    ->group(function () {

    Route::get('/dashboard', [PetugasDashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/peminjaman', [PetugasDashboardController::class, 'peminjaman'])
        ->name('peminjaman');

    Route::get('/pengembalian', [PetugasDashboardController::class, 'pengembalian'])
        ->name('pengembalian');

    Route::get('/laporan', [PetugasDashboardController::class, 'laporan'])
        ->name('laporan');

    Route::post('/peminjaman/{id}/acc', [PetugasDashboardController::class, 'acc'])
        ->name('acc');

    Route::post('/peminjaman/{id}/kembali', [PetugasDashboardController::class, 'kembalikan'])
        ->name('kembali');
});


/*
|--------------------------------------------------------------------------
| PEMINJAM AREA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:peminjam'])
    ->prefix('user')
    ->as('user.')
    ->group(function () {

    Route::get('/dashboard', [UserDashboardController::class, 'index'])
        ->name('dashboard');

    Route::post('/pinjam', [UserDashboardController::class, 'pinjam'])
        ->name('pinjam');

    Route::post('/kembali/{id}', [UserDashboardController::class, 'kembali'])
        ->name('kembali');

    Route::post('/batal/{id}', [UserDashboardController::class, 'batal'])
        ->name('batal');
});


/*
|--------------------------------------------------------------------------
| PEMINJAMAN UMUM (ADMIN & PETUGAS)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:admin,petugas'])
    ->as('peminjaman.')
    ->group(function () {

    Route::get('/peminjaman', [PeminjamanController::class, 'index'])
        ->name('index');

    Route::get('/peminjaman/{id}/edit', [PeminjamanController::class, 'edit'])
        ->name('edit');

    Route::post('/peminjaman/{id}/update', [PeminjamanController::class, 'update'])
        ->name('update');

    Route::post('/peminjaman/{id}/acc', [PeminjamanController::class, 'acc'])
        ->name('acc');

    Route::post('/peminjaman/{id}/kembali', [PeminjamanController::class, 'kembali'])
        ->name('kembali');
});


/*
|--------------------------------------------------------------------------
| KEMBALI (ADMIN & PETUGAS)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:admin,petugas'])
    ->as('kembali.')
    ->group(function () {

    Route::get('/kembali', [KembaliController::class, 'index'])
        ->name('index');
});
