<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\BahanController;
use App\Http\Controllers\ResepController;
use App\Http\Controllers\StokMasukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ResetPasswordPelangganController;
use App\Http\Controllers\LaporanController;

// halaman utama
Route::get('/', function () {
    return view('login');
});

// login
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'prosesLogin'])->name('proses.login');

// logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// route manajer 

Route::middleware('role:manajer')->group(function () {

    // dashboard
    Route::get('/manajer/dashboard', function () {
        $totalMenu = \App\Models\Menu::count();
        $totalBahan = \App\Models\Bahan::count();

        $stokMasukHariIni = \App\Models\StokMasuk::whereDate(
            'tanggal',
            today()
        )->count();

        $stokMasuks = \App\Models\StokMasuk::with('bahan')
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        return view('manajer.dashboard', compact(
            'totalMenu',
            'totalBahan',
            'stokMasukHariIni',
            'stokMasuks'
        ));
    });

    // menu
    Route::get('/manajer/menu', [MenuController::class, 'index']);
    Route::get('/manajer/menu/tambah', [MenuController::class, 'create']);
    Route::post('/manajer/menu', [MenuController::class, 'store']);
    Route::get('/manajer/menu/{id}/edit', [MenuController::class, 'edit']);
    Route::put('/manajer/menu/{id}', [MenuController::class, 'update']);
    Route::put('/manajer/menu/{id}/status', [MenuController::class, 'ubahStatus']);
    Route::delete('/manajer/menu/{id}', [MenuController::class, 'destroy']);

    // bahan
    Route::get('/manajer/bahan', [BahanController::class, 'index']);
    Route::get('/manajer/bahan/tambah', [BahanController::class, 'create']);
    Route::post('/manajer/bahan', [BahanController::class, 'store']);
    Route::get('/manajer/bahan/{id}/edit', [BahanController::class, 'edit']);
    Route::put('/manajer/bahan/{id}', [BahanController::class, 'update']);
    Route::delete('/manajer/bahan/{id}', [BahanController::class, 'destroy']);

    Route::post('/manajer/bahan/sinkronisasi', [BahanController::class, 'sinkronisasi']);
    Route::post('/manajer/bahan/import', [BahanController::class, 'import']);

    // resep
    Route::get('/manajer/resep', [ResepController::class, 'index']);
    Route::get('/manajer/resep/{menu_id}/create', [ResepController::class, 'create']);
    Route::post('/manajer/resep', [ResepController::class, 'store']);
    Route::get('/manajer/resep/{id}/edit', [ResepController::class, 'edit']);
    Route::put('/manajer/resep/{id}', [ResepController::class, 'update']);
    Route::delete('/manajer/resep/{id}', [ResepController::class, 'destroy']);
    Route::post('/manajer/resep/import', [ResepController::class, 'import']);

    // stok masuk
    Route::get('/manajer/stok-masuk', [StokMasukController::class, 'index']);
    Route::post('/manajer/stok-masuk', [StokMasukController::class, 'simpan']);
    Route::get('/manajer/laporan/stok-masuk', [StokMasukController::class, 'laporan']);

    // route laporan
    Route::middleware('role:manajer')->group(function () {
        // laporan
        Route::get('/manajer/laporan', [LaporanController::class, 'index']);
    });
});

// route kasir

Route::middleware('role:kasir')->group(function () {

    // dashboard
    Route::get('/kasir/dashboard', function () {
        return view('kasir.dashboard');
    });

    // menu
    Route::get('/kasir/menu', function () {
        $menus = \App\Models\Menu::where('status', 'aktif')->get();

        return view('kasir.menu.index', compact('menus'));
    });

    // transaksi
    Route::get('/kasir/transaksi', [TransaksiController::class, 'index']);
    Route::get('/kasir/transaksi/create', [TransaksiController::class, 'create']);
    Route::post('/kasir/transaksi', [TransaksiController::class, 'store']);
    Route::get('/kasir/transaksi/{id}', [TransaksiController::class, 'show']);

    Route::get('/kasir/reset-password-pelanggan', [ResetPasswordPelangganController::class, 'index']);

    Route::put('/kasir/reset-password-pelanggan/{id}', [ResetPasswordPelangganController::class, 'update']);

    Route::put('/kasir/transaksi/{id}/status', [TransaksiController::class, 'updateStatus']);

    Route::put('/kasir/transaksi/{id}/batal', [TransaksiController::class, 'batal']);
});