<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//GET ROUTER PUBLIC
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('landing');

Route::prefix('get')->name('get.')->group(function () {
    Route::get('/barang', [App\Http\Controllers\HomeController::class, 'getBarang']);
});

//FIND ROUTER PUBLIC

Route::prefix('find')->name('find.')->group(function () {

});

//Login

Route::prefix('account')->group(function () {
    Route::get('/login', [App\Http\Controllers\HomeController::class, 'login'])->name('login');
    Route::POST('/logout', [App\Http\Controllers\CustomAuth::class, 'customlogout'])->name('logout');
    Route::POST('/set_password', [App\Http\Controllers\CustomAuth::class, 'set_password'])->name('set.password');
    Route::POST('/login/cek_login', [App\Http\Controllers\CustomAuth::class, 'customLogin'])->name('custom.login');
});

//ADMIN ROUTES
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/pengguna', [App\Http\Controllers\AdminPenggunaController::class, 'index'])->name('pengguna');
    Route::get('/resources', [App\Http\Controllers\AdminSumberDayaController::class, 'index'])->name('resources');
    Route::get('/stoking', [App\Http\Controllers\AdminStokingController::class, 'index'])->name('stoking');
    Route::get('/prediksi', [App\Http\Controllers\AdminPrediksiController::class, 'index'])->name('prediksi');
    Route::get('/laporan', [App\Http\Controllers\AdminLaporanController::class, 'index'])->name('laporan');
    Route::get('/profile', [App\Http\Controllers\AdminProfileController::class, 'index'])->name('profile');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::POST('/update/{id}', [App\Http\Controllers\AdminProfileController::class, 'update']);
    });

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/json', [App\Http\Controllers\AdminDashboardController::class, 'json']);
        Route::get('/barChart', [App\Http\Controllers\AdminDashboardController::class, 'barChart']);
        Route::get('/testpage', [App\Http\Controllers\AdminDashboardController::class, 'getCalculate']);
    });

    Route::prefix('pengguna')->name('pengguna.')->group(function () {
        Route::get('/tambah', [App\Http\Controllers\AdminPenggunaController::class, 'new'])->name('new');
        Route::get('/edit/{id}', [App\Http\Controllers\AdminPenggunaController::class, 'edit'])->name('edit');
        Route::POST('/save', [App\Http\Controllers\AdminPenggunaController::class, 'store']);
        Route::POST('/update/{id}', [App\Http\Controllers\AdminPenggunaController::class, 'update']);
        Route::GET('/delete/{id}', [App\Http\Controllers\AdminPenggunaController::class, 'destroy']);
        Route::get('/json', [App\Http\Controllers\AdminPenggunaController::class, 'json']);
        Route::get('/find/{id}', [App\Http\Controllers\AdminPenggunaController::class, 'find']);
    });

    Route::prefix('resources')->name('resources.')->group(function () {
        Route::get('/tambah', [App\Http\Controllers\AdminSumberDayaController::class, 'new'])->name('new');
        Route::get('/edit/{id}', [App\Http\Controllers\AdminSumberDayaController::class, 'edit'])->name('edit');
        Route::POST('/save', [App\Http\Controllers\AdminSumberDayaController::class, 'store']);
        Route::POST('/update/{id}', [App\Http\Controllers\AdminSumberDayaController::class, 'update']);
        Route::GET('/delete/{id}', [App\Http\Controllers\AdminSumberDayaController::class, 'destroy']);
        Route::get('/json', [App\Http\Controllers\AdminSumberDayaController::class, 'json']);
        Route::get('/find/{id}', [App\Http\Controllers\AdminSumberDayaController::class, 'find']);
    });

    Route::prefix('stoking')->name('stoking.')->group(function () {
        Route::get('/tambah', [App\Http\Controllers\AdminStokingController::class, 'new'])->name('new');
        Route::get('/edit/{id}', [App\Http\Controllers\AdminStokingController::class, 'edit'])->name('edit');
        Route::POST('/save', [App\Http\Controllers\AdminStokingController::class, 'store']);
        Route::POST('/update/{id}', [App\Http\Controllers\AdminStokingController::class, 'update']);
        Route::GET('/delete/{id}', [App\Http\Controllers\AdminStokingController::class, 'destroy']);
        Route::get('/json', [App\Http\Controllers\AdminStokingController::class, 'json']);
        Route::get('/find/{id}', [App\Http\Controllers\AdminStokingController::class, 'find']);
    });

    Route::prefix('prediksi')->name('prediksi.')->group(function () {
        Route::GET('/analys', [App\Http\Controllers\AdminPrediksiController::class, 'analys']);
        Route::get('/find/{id}', [App\Http\Controllers\AdminLaporanController::class, 'find']);
    });

    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::POST('/update/{id}', [App\Http\Controllers\AdminLaporanController::class, 'update']);
        Route::GET('/delete/{id}', [App\Http\Controllers\AdminLaporanController::class, 'destroy']);
        Route::get('/json', [App\Http\Controllers\AdminLaporanController::class, 'json']);
        Route::get('/find/{id}', [App\Http\Controllers\AdminLaporanController::class, 'find']);
    });
});
