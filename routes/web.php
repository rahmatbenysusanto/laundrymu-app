<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\ParfumController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\TransaksiController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'login')->name('login');
    Route::post('/login', 'loginPost')->name('loginPost');
});

Route::middleware([AuthMiddleware::class])->group(function () {
    Route::prefix('dashboard')->controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard');
    });

    Route::prefix('pelanggan')->controller(PelangganController::class)->group(function () {
        Route::get('/', 'index')->name('pelanggan');
        Route::post('/', 'tambah')->name('tambahPelanggan');
        Route::post('/create', 'create')->name('createPelanggan');
        Route::post('/update', 'update')->name('updatePelanggan');
        Route::get('/hapus', 'hapus')->name('hapusPelanggan');
    });

    Route::prefix('layanan')->controller(LayananController::class)->group(function () {
        Route::get('/', 'index')->name('layanan');
        Route::post('/', 'tambah')->name('tambahLayanan');
        Route::post('/update', 'update')->name('updateLayanan');
        Route::get('/hapus', 'hapus')->name('hapusLayanan');
    });

    Route::prefix('diskon')->controller(DiskonController::class)->group(function () {
        Route::get('/', 'index')->name('diskon');
        Route::post('/', 'tambah')->name('tambahDiskon');
        Route::post('/update', 'update')->name('updateDiskon');
        Route::get('/hapus', 'hapus')->name('hapusDiskon');
    });

    Route::prefix('parfum')->controller(ParfumController::class)->group(function () {
        Route::get('/', 'index')->name('parfum');
        Route::post('/', 'tambah')->name('tambahParfum');
        Route::post('/update', 'update')->name('updateParfum');
        Route::get('/hapus', 'hapus')->name('hapusParfum');
    });

    Route::prefix('pengiriman')->controller(PengirimanController::class)->group(function () {
        Route::get('/', 'index')->name('pengiriman');
        Route::post('/', 'tambah')->name('tambahPengiriman');
        Route::post('/update', 'update')->name('updatePengiriman');
        Route::get('/hapus', 'hapus')->name('hapusPengiriman');
    });

    Route::prefix('pembayaran')->controller(PembayaranController::class)->group(function () {
        Route::get('/', 'index')->name('pembayaran');
        Route::post('/', 'tambah')->name('tambahPembayaran');
        Route::post('/update', 'update')->name('updatePembayaran');
        Route::get('/hapus', 'hapus')->name('hapusPembayaran');
    });

    Route::prefix('outlet')->controller(OutletController::class)->group(function () {
        Route::get('/', 'index')->name('outlet');
        Route::get('/pembayaran-lisensi', 'historyPembayaran')->name('historyPembayaran');
    });

    Route::prefix('transaksi')->controller(TransaksiController::class)->group(function () {
        Route::get('/', 'listTransaksi')->name('listTransaksi');
        Route::get('/tambah', 'createTransaksi')->name('createTransaksi');
        Route::post('/create', 'createTransaksiPost')->name('createTransaksiPost');

        // JSON Response
        Route::get('/get-layanan', 'getLayanan')->name('transaksi.getLayanan');
        Route::get('/get-pelanggan', 'getPelanggan')->name('transaksi.getPelanggan');
    });
});


