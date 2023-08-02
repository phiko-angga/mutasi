<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DaratController;
use App\Http\Controllers\LautController;
use App\Http\Controllers\DephubController;
use App\Http\Controllers\ProvinsiController;
use App\Http\Controllers\ParafController;
use App\Http\Controllers\KotaController;
use App\Http\Controllers\SbumController;
use App\Http\Controllers\TransportController;
use App\Http\Controllers\UanghController;
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

Route::get('/login', [AuthController::class,'login'])->name('login');
Route::post('/login', [AuthController::class,'authenticate']);
Route::get('/logout', [AuthController::class,'logout'])->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [DashboardController::class,'index'])->name('dashboard');

    Route::resource('/users', UsersController::class)->name('*','users');
    Route::resource('/darat', DaratController::class)->name('*','darat');
    Route::resource('/laut', LautController::class)->name('*','laut');
    Route::resource('/dephub', DephubController::class)->name('*','dephub');
    Route::resource('/provinsi', ProvinsiController::class)->name('*','provinsi');
    Route::resource('/kota', KotaController::class)->name('*','kota');
    Route::resource('/paraf', ParafController::class)->name('*','paraf');
    Route::resource('/sbum', SbumController::class)->name('*','sbum');
    Route::resource('/transport', TransportController::class)->name('*','transport');
    Route::resource('/uangh', UanghController::class)->name('*','uangh');

    Route::get('/logout', [AuthController::class,'logout'])->name('logout');
});