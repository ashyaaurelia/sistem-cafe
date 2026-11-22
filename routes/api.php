<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelangganAuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// route login
Route::post('/pelanggan/register', [PelangganAuthController::class, 'register']);
Route::post('/pelanggan/login', [PelangganAuthController::class, 'login']);

// route logout
Route::post('/pelanggan/logout', [PelangganAuthController::class, 'logout'])
->middleware('auth:sanctum');

//route ganti pw
Route::post('/pelanggan/ganti-password', [PelangganAuthController::class, 'gantiPassword'])
->middleware('auth:sanctum');