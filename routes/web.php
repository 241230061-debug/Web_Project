<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('beranda');
// Tambahkan ini:
Route::get('/harga', [HomeController::class, 'harga'])->name('harga');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');