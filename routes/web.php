<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\BahanController;
use App\Services\HargaBahanService;
use App\Http\Controllers\ResepController;
use App\Http\Controllers\StokMasukController;

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

Route::get('/manajer/bahan', [BahanController::class, 'index']);

Route::get('/manajer/bahan/tambah', [BahanController::class, 'create']);

Route::post('/manajer/bahan', [BahanController::class, 'store']);

Route::get('manajer/bahan/{id}/edit', [BahanController::class, 'edit']);

Route::put('/manajer/bahan/{id}', [BahanController::class, 'update']);

Route::delete('/manajer/bahan/{id}', [BahanController::class, 'destroy']);

Route::get('/manajer/resep', [ResepController::class, 'index']);

Route::get('/manajer/resep/{menu_id}/create', [ResepController::class, 'create']);

Route::post('/manajer/resep', [ResepController::class, 'store']);

Route::delete('manajer/resep/{id}', [ResepController::class, 'destroy']);

Route::post('/manajer/bahan/sinkronisasi', [BahanController::class, 'sinkronisasi']);

Route::post('/manajer/bahan/import', [BahanController::class, 'import']);

Route::get('/manajer/stok-masuk', [StokMasukController::class, 'index']);

Route::post('/manajer/stok-masuk', [StokMasukController::class, 'simpan']);

Route::get('/manajer/laporan/stok-masuk', [StokMasukController::class, 'laporan']);