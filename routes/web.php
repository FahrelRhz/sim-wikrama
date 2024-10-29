<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminAuthController;
use App\Http\Controllers\admin\DaftarUserController;
use App\Http\Controllers\user\UserAuthController;
use App\Http\Controllers\user\DaftarBarangController;
use App\Http\Controllers\user\DaftarSiswaController;
use App\Http\Controllers\user\PeminjamanBarangController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/ 

//admin
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('pages.admin.dashboard.index'); 
        });

        //daftar user
        Route::get('/daftar-user', [DaftarUserController::class, 'index'])->name('admin.daftar-user.index');
        Route::get('/daftar-user/create', [DaftarUserController::class, 'create'])->name('admin.daftar-user.create');
        Route::post('/daftar-user', [DaftarUserController::class, 'store'])->name('admin.daftar-user.store');
        Route::get('/daftar-user/{id}/edit', [DaftarUserController::class, 'edit'])->name('admin.daftar-user.edit');
        Route::put('/daftar-user/{id}', [DaftarUserController::class, 'update'])->name('admin.daftar-user.update');
        Route::delete('/daftar-user/{id}', [DaftarUserController::class, 'destroy'])->name('admin.daftar-user.destroy');

    });
});


//user
Route::prefix('user')->group(function () {
    Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('user.login');
    Route::post('/login', [UserAuthController::class, 'login']);
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('user.logout');

    Route::middleware('user')->group(function () {
        Route::get('/dashboard', function () {
            return view('pages.user.dashboard.dashboard');
        });

        //daftar barang
        Route::get('/daftar-barang', [DaftarBarangController::class, 'index'])->name('user.daftar-barang.index');
        Route::get('/daftar-barang/create', [DaftarBarangController::class, 'create'])->name('user.daftar-barang.create');
        Route::post('/daftar-barang', [DaftarBarangController::class, 'store'])->name('user.daftar-barang.store');
        Route::get('/daftar-barang/{id}/edit', [DaftarBarangController::class, 'edit'])->name('user.daftar-barang.edit');
        Route::put('/daftar-barang/{id}', [DaftarBarangController::class, 'update'])->name('user.daftar-barang.update');
        Route::delete('/daftar-barang/{id}', [DaftarBarangController::class, 'destroy'])->name('user.daftar-barang.destroy');

        //daftar siswa
        Route::get('/daftar-siswa', [DaftarSiswaController::class, 'index'])->name('user.daftar-siswa.index');
        Route::get('/daftar-siswa/create', [DaftarSiswaController::class, 'create'])->name('user.daftar-siswa.create');
        Route::post('/daftar-siswa', [DaftarSiswaController::class, 'store'])->name('user.daftar-siswa.store');
        Route::get('/daftar-siswa/{id}/edit', [DaftarSiswaController::class, 'edit'])->name('user.daftar-siswa.edit');
        Route::put('/daftar-siswa/{id}', [DaftarSiswaController::class, 'update'])->name('user.daftar-siswa.update');
        Route::delete('/daftar-siswa/{id}', [DaftarSiswaController::class, 'destroy'])->name('user.daftar-siswa.destroy');

        //peminjaman barang
        Route::get('/peminjaman-barang', [PeminjamanBarangController::class, 'index'])->name('user.peminjaman-barang.index');
        Route::get('/peminjaman-barang/create', [PeminjamanBarangController::class, 'create'])->name('user.peminjaman-barang.create');
        Route::post('/peminjaman-barang', [PeminjamanBarangController::class, 'store'])->name('user.peminjaman-barang.store');
        Route::get('/peminjaman-barang/{id}/edit', [PeminjamanBarangController::class, 'edit'])->name('user.peminjaman-barang.edit');
        Route::put('/peminjaman-barang/{id}', [PeminjamanBarangController::class, 'update'])->name('user.peminjaman-barang.update');
        Route::delete('/peminjaman-barang/{id}', [PeminjamanBarangController::class, 'destroy'])->name('user.peminjaman-barang.destroy');
        
        
    });
});