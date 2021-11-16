<?php

use GuzzleHttp\Middleware;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function() {
    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('/jabatan', \App\Http\Controllers\JabatanController::class)->except('create', 'show', 'update');
    Route::get('/golongan/list', [\App\Http\Controllers\GolonganController::class, 'golonganList'])->name('golongan.list');
    Route::post('/golongan/update', [\App\Http\Controllers\GolonganController::class, 'golonganUpdate'])->name('golongan.update');
    Route::resource('/golongan', \App\Http\Controllers\GolonganController::class)->except('create', 'update');
    Route::resource('/users', \App\Http\Controllers\UserController::class);
    Route::resource('/absens', \App\Http\Controllers\AbsenController::class);
    Route::resource('/pengaturan', \App\Http\Controllers\PengaturanController::class)->except('create', 'edit', 'show', 'destroy');
});