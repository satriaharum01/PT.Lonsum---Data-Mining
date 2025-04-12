<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::POST('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::POST('/logout', [App\Http\Controllers\AuthController::class, 'logout']);
Route::get('/user', [App\Http\Controllers\AuthController::class, 'getUser']);


Route::prefix('data')->name('data.')->group(function () {
    Route::POST('/prediksi/store', [App\Http\Controllers\HomeController::class, 'prediksiStore']);
    Route::DELETE('/prediksi/delete/{id}', [App\Http\Controllers\HomeController::class, 'prediksiDestroy']);
});

Route::get('/animes', [App\Http\Controllers\AnimeController::class, 'index']);
Route::get('/animes/show/{id}', [App\Http\Controllers\AnimeController::class, 'show']);
Route::get('/animes/trending', [App\Http\Controllers\AnimeController::class, 'index']);
Route::get('/animes/recent', [App\Http\Controllers\AnimeController::class, 'index']);
Route::get('/animes/popular', [App\Http\Controllers\AnimeController::class, 'index']);
Route::get('/animes/live', [App\Http\Controllers\AnimeController::class, 'index']);
