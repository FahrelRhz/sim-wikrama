<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminAuthController;
use App\Http\Controllers\admin\DaftarUserController;
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


Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::get('/dashboard', function () {
        return view('pages.admin.dashboard.dashboard');
    })->middleware('admin');

    Route::get('/daftar-user', [DaftarUserController::class, 'index'])->name('admin.daftar-user.index');
    Route::get('/daftar-user/create', [DaftarUserController::class, 'create'])->name('admin.daftar-user.create');
    Route::post('/daftar-user', [DaftarUserController::class, 'store'])->name('admin.daftar-user.store');
    Route::get('/daftar-user/{id}/edit', [DaftarUserController::class, 'edit'])->name('admin.daftar-user.edit');
    Route::put('/daftar-user/{id}', [DaftarUserController::class, 'update'])->name('admin.daftar-user.update');
    Route::delete('/daftar-user/{id}', [DaftarUserController::class, 'destroy'])->name('admin.daftar-user.destroy');
});