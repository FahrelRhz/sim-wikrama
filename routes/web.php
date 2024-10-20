<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminAuthController;
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


// Route::get('/_admin/login', function () {
//     return view('pages.admin.login.index');
// });

// Route::get('/_admin/dashboard', function () {  
//     return view('pages.admin.dashboard.dashboard');
// });

Route::prefix('_admin')->group(function () {
    // Route untuk login
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Route untuk dashboard dengan middleware admin
    Route::get('/dashboard', function () {
        return view('pages.admin.dashboard.dashboard');
    })->middleware('admin');
});
