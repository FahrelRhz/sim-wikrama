<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminAuthController;
use App\Http\Controllers\admin\DaftarUserController;
use App\Http\Controllers\admin\PermintaanBarangsController;
use App\Http\Controllers\admin\RequestPerbaikanBarangsController;
use App\Http\Controllers\user\UserAuthController;
use App\Http\Controllers\user\DaftarBarangController;
use App\Http\Controllers\user\DaftarSiswaController;
use App\Http\Controllers\user\PeminjamanBarangController;
use App\Http\Controllers\user\PermintaanBarangController;
use App\Http\Controllers\user\RequestPerbaikanBarangController;

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

        //permintaan barang 
        Route::get('/permintaan-barang', [PermintaanBarangsController::class, 'index'])->name('admin.permintaan-barang.index');
        Route::get('/permintaan-barang/{id}/edit', [PermintaanBarangsController::class, 'edit'])->name('admin.permintaan-barang.edit');
        Route::put('/permintaan-barang/{id}', [PermintaanBarangsController::class, 'update'])->name('admin.permintaan-barang.update');
        Route::delete('/permintaan-barang/{id}', [PermintaanBarangsController::class, 'destroy'])->name('admin.permintaan-barang.destroy');

        //perbaikan barang
        Route::get('/request-perbaikan-barang', [RequestPerbaikanBarangsController::class, 'index'])->name('admin.request-perbaikan-barang.index');
        Route::get('/request-perbaikan-barang/{id}/edit', [RequestPerbaikanBarangsController::class, 'edit'])->name('admin.request-perbaikan-barang.edit');
        Route::put('/request-perbaikan-barang/{id}', [RequestPerbaikanBarangsController::class, 'update'])->name('admin.request-perbaikan-barang.update');
        Route::delete('/request-perbaikan-barang/{id}', [RequestPerbaikanBarangsController::class, 'destroy'])->name('admin.request-perbaikan-barang.destroy');

    });
});


//user
Route::prefix('user')->group(function () {
    Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('user.login');
    Route::post('/login', [UserAuthController::class, 'login']);
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('user.logout');

    Route::middleware('user')->group(function () {
        // Mengubah route untuk dashboard agar menggunakan method dari controller
        Route::middleware('user')->group(function () {
            Route::get('/dashboard', [UserAuthController::class, 'dashboard'])->name('user.dashboard'); // Pastikan nama route sesuai
        });


        // Daftar Barang
        Route::get('/daftar-barang', [DaftarBarangController::class, 'index'])->name('user.daftar-barang.index');
        Route::get('/daftar-barang/create', [DaftarBarangController::class, 'create'])->name('user.daftar-barang.create');
        Route::post('/daftar-barang', [DaftarBarangController::class, 'store'])->name('user.daftar-barang.store');
        Route::get('/daftar-barang/{id}/edit', [DaftarBarangController::class, 'edit'])->name('user.daftar-barang.edit');
        Route::put('/daftar-barang/{id}', [DaftarBarangController::class, 'update'])->name('user.daftar-barang.update');
        Route::get('/daftar-barang/{id}', [DaftarBarangController::class, 'show'])->name('user.daftar-barang.show');
        Route::delete('/daftar-barang/{id}', [DaftarBarangController::class, 'destroy'])->name('user.daftar-barang.destroy');

        // Daftar Siswa
        Route::get('/daftar-siswa', [DaftarSiswaController::class, 'index'])->name('user.daftar-siswa.index');
        Route::get('/fetch', [DaftarSiswaController::class, 'fetchDataSiswa'])->name('user.fetch');

        //peminjaman barang
        Route::get('/peminjaman-barang', [PeminjamanBarangController::class, 'index'])->name('user.peminjaman-barang.index');
        Route::get('/peminjaman-barang/create', [PeminjamanBarangController::class, 'create'])->name('user.peminjaman-barang.create');
        Route::get('/peminjaman/fetch', [PeminjamanBarangController::class, 'fetchDataSiswa'])->name('peminjaman.fetch');
        Route::post('/peminjaman-barang', [PeminjamanBarangController::class, 'store'])->name('user.peminjaman-barang.store');
        Route::get('/peminjaman-barang/{id}/edit', [PeminjamanBarangController::class, 'edit'])->name('user.peminjaman-barang.edit');
        Route::put('/peminjaman-barang/{id}', [PeminjamanBarangController::class, 'update'])->name('user.peminjaman-barang.update');
        Route::delete('/peminjaman-barang/{id}', [PeminjamanBarangController::class, 'destroy'])->name('user.peminjaman-barang.destroy');

        // Permintaan Barang
        Route::get('/permintaan-barang', [PermintaanBarangController::class, 'index'])->name('user.permintaan-barang.index');
        Route::get('/permintaan-barang/create', [PermintaanBarangController::class, 'create'])->name('user.permintaan-barang.create');
        Route::post('/permintaan-barang', [PermintaanBarangController::class, 'store'])->name('user.permintaan-barang.store');
        Route::get('/permintaan-barang/{id}/edit', [PermintaanBarangController::class, 'edit'])->name('user.permintaan-barang.edit');
        Route::put('/permintaan-barang/{id}', [PermintaanBarangController::class, 'update'])->name('user.permintaan-barang.update');
        Route::delete('/user/permintaan-barang/{id}', [PermintaanBarangController::class, 'destroy'])->name('user.permintaan-barang.delete');

        // Request Perbaikan Barang
        Route::get('/request-perbaikan-barang', [RequestPerbaikanBarangController::class, 'index'])->name('user.request-perbaikan-barang.index');
        Route::get('/request-perbaikan-barang/create', [RequestPerbaikanBarangController::class, 'create'])->name('user.request-perbaikan-barang.create');
        Route::post('/request-perbaikan-barang', [RequestPerbaikanBarangController::class, 'store'])->name('user.request-perbaikan-barang.store');
        Route::get('/request-perbaikan-barang/{id}/edit', [RequestPerbaikanBarangController::class, 'edit'])->name('user.request-perbaikan-barang.edit');
        Route::put('/request-perbaikan-barang/{id}', [RequestPerbaikanBarangController::class, 'update'])->name('user.request-perbaikan-barang.update');
        Route::delete('/user/request-perbaikan-barang/{id}', [RequestPerbaikanBarangController::class, 'destroy'])->name('user.request-perbaikan-barang.delete');
    });
});