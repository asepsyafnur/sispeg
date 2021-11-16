<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\GolonganController;
use \App\Http\Controllers\jabatanController;

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
    // jabatan
    Route::get('/jabatan', [JabatanController::class, 'index'])->name('jabatan.index');
    Route::get('/jabatan/read', [JabatanController::class, 'read'])->name('jabatan.read');
    Route::post('/jabatan/store', [JabatanController::class, 'store'])->name('jabatan.store');
    Route::post('/jabatan/edit', [JabatanController::class, 'edit'])->name('jabatan.edit');
    Route::post('/jabatan/update', [JabatanController::class, 'update'])->name('jabatan.update');
    Route::post('/jabatan/destroy', [JabatanController::class, 'destroy'])->name('jabatan.destroy');
    // golongan
    Route::get('/golongan', [GolonganController::class, 'index'])->name('golongan.index');
    Route::get('/golongan/read', [GolonganController::class, 'read'])->name('golongan.read');
    Route::post('/golongan/store', [GolonganController::class, 'store'])->name('golongan.store');
    Route::post('/golongan/edit', [GolonganController::class, 'edit'])->name('golongan.edit');
    Route::post('/golongan/update', [GolonganController::class, 'update'])->name('golongan.update');
    Route::post('/golongan/destroy', [GolonganController::class, 'destroy'])->name('golongan.destroy');
    // users
    Route::resource('/users', \App\Http\Controllers\UserController::class);
    // absen
    Route::get('/absens/read', [\App\Http\Controllers\AbsenController::class, 'read'])->name('absens.read');
    Route::post('/absens/update',[\App\Http\Controllers\AbsenController::class, 'update'])->name('absens.update');
    Route::resource('/absens', \App\Http\Controllers\AbsenController::class)->except('update');
    Route::resource('/pengaturan', \App\Http\Controllers\PengaturanController::class)->except('create', 'edit', 'show', 'destroy');
});