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
    Route::GET('/prediksi/get/{id}', [App\Http\Controllers\HomeController::class, 'prediksiCetak']);
    Route::DELETE('/prediksi/delete/{id}', [App\Http\Controllers\HomeController::class, 'prediksiDestroy']);
});
