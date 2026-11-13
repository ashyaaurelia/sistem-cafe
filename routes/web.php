<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;

// halaman utama
Route::get('/', function () {
    return view('/login');
});

// halaman login
Route::get('/login', [AuthController::class, 'login'])->name('login');

// proses login
Route::post('/login', [AuthController::class, 'prosesLogin'])->name('proses.login');

//logout

Route::post ('/logout', [AuthController::class, 'logout'])->name('logout');

//dashboard manajer
Route::get('/manajer/dashboard', function () {
    return view('manajer.dashboard');
});

//dashboard kasir
Route::get('/kasir/dashboard', function () {
    return view ('kasir.dashboard');
});

Route::get('/manajer/menu', [MenuController::class, 'index']);

Route::get('/manajer/menu/tambah', [MenuCOntroller::class, 'create']);

Route::post('/manajer/menu', [MenuController::class, 'store']);

Route::get('/manajer/menu/{id}/edit', [MenuController::class, 'edit']);

Route::put('/manajer/menu/{id}', [MenuController::class, 'update']);

Route::delete('/manajer/menu/{id}', [MenuController::class, 'destroy']);