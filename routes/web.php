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
use App\Http\Controllers\RuteController;
use App\Http\Controllers\BiayaTransportController;
use App\Http\Controllers\BiayaMuatController;
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
    Route::resource('/rute', RuteController::class)->name('*','rute');
    Route::resource('/darat', DaratController::class)->name('*','darat');
    Route::resource('/laut', LautController::class)->name('*','laut');
    Route::resource('/dephub', DephubController::class)->name('*','dephub');
    Route::resource('/provinsi', ProvinsiController::class)->name('*','provinsi');
    Route::resource('/kota', KotaController::class)->name('*','kota');
    Route::resource('/paraf', ParafController::class)->name('*','paraf');
    Route::resource('/sbum', SbumController::class)->name('*','sbum');
    Route::resource('/transport', TransportController::class)->name('*','transport');
    Route::resource('/uangh', UanghController::class)->name('*','uangh');
    Route::resource('/user', UsersController::class)->name('*','user');
    Route::resource('/biaya-transport', BiayaTransportController::class)->name('*','biaya_transport');
    Route::resource('/biaya-muat', BiayaMuatController::class)->name('*','biaya_muat');

    Route::get('/rute_print_pdf', [RuteController::class,'printPdf']);
    Route::get('/darat_print_pdf', [DaratController::class,'printPdf']);
    Route::get('/laut_print_pdf', [LautController::class,'printPdf']);
    Route::get('/dephub_print_pdf', [DephubController::class,'printPdf']);
    Route::get('/provinsi_print_pdf', [ProvinsiController::class,'printPdf']);
    Route::get('/kota_print_pdf', [KotaController::class,'printPdf']);
    Route::get('/paraf_print_pdf', [ParafController::class,'printPdf']);
    Route::get('/sbum_print_pdf', [SbumController::class,'printPdf']);
    Route::get('/transport_print_pdf', [TransportController::class,'printPdf']);
    Route::get('/uangh_print_pdf', [UanghController::class,'printPdf']);
    Route::get('/users_print_pdf', [UsersController::class,'printPdf']);
    Route::get('/biaya_transport_print_pdf', [BiayaTransportController::class,'printPdf']);
    Route::get('/biaya_muat_print_pdf', [BiayaMuatController::class,'printPdf']);

    Route::get('/rute_print_excel', [RuteController::class,'printExcel']);
    Route::get('/darat_print_excel', [DaratController::class,'printExcel']);
    Route::get('/laut_print_excel', [LautController::class,'printExcel']);
    Route::get('/dephub_print_excel', [DephubController::class,'printExcel']);
    Route::get('/provinsi_print_excel', [ProvinsiController::class,'printExcel']);
    Route::get('/kota_print_excel', [KotaController::class,'printExcel']);
    Route::get('/paraf_print_excel', [ParafController::class,'printExcel']);
    Route::get('/sbum_print_excel', [SbumController::class,'printExcel']);
    Route::get('/transport_print_excel', [TransportController::class,'printExcel']);
    Route::get('/uangh_print_excel', [UanghController::class,'printExcel']);
    Route::get('/users_print_excel', [UsersController::class,'printExcel']);
    Route::get('/biaya_transport_print_excel', [BiayaTransportController::class,'printExcel']);
    Route::get('/biaya_muat_print_excel', [BiayaMuatController::class,'printExcel']);

    Route::get('/logout', [AuthController::class,'logout'])->name('logout');
});