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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/', function () {
    return response()->json([
        'status' => 200,
        'message' => 'Selamat datang di aplikasi sistem penjualan kendaraan berbasis REST API'
    ]);
});

Route::prefix('auth')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('logout', 'AuthController@logout');
    Route::get('refresh', 'AuthController@refresh');
});


// use auth:api to protect unauthenticated user with jwt
Route::middleware('auth:api')->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('/me', 'UserController@me');
    });

    Route::resource('kendaraan/motor', 'Kendaraan\MotorController');
    Route::prefix('kendaraan/motor')->namespace('Kendaraan')->group(function () {
        Route::put('/{motor}/stok', 'MotorController@updateStok');
        Route::get('/{motor}/stok', 'MotorController@getStok');
    });

    Route::resource('kendaraan/mobil', 'Kendaraan\MobilController');
    Route::prefix('kendaraan/mobil')->namespace('Kendaraan')->group(function () {
        Route::put('/{mobil}/stok', 'MobilController@updateStok');
        Route::get('/{mobil}/stok', 'MobilController@getStok');
    });

    Route::resource('sale', 'SaleController')->except(['update', 'edit', 'create']);
    Route::post('laporan', 'LaporanController');
});
