<?php

use App\Http\Controllers\ClaimController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PoskoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Kampus Lost & Found
|--------------------------------------------------------------------------
| Penamaan route mengikuti sitemap Pertemuan 3:
|   H-01 Beranda              -> /
|   H-02 Cari Barang          -> /barang
|   H-03 Detail Barang        -> /barang/{item}
|   H-04 Form Klaim           -> /klaim/buat?item={id}
|   H-05 Klaim Saya           -> /klaim
|   H-06 Daftar Klaim Posko   -> /posko
|   H-07 Detail Klaim         -> /posko/{claim}
|   H-08 Not Found            -> fallback
*/

Route::view('/', 'home')->name('home');

// --- Barang temuan ---
Route::get('/barang', [ItemController::class, 'index'])->name('items.index');
Route::get('/barang/kelola', [ItemController::class, 'manage'])->name('items.manage');
Route::get('/barang/tambah', [ItemController::class, 'create'])->name('items.create');
Route::post('/barang', [ItemController::class, 'store'])->name('items.store');
Route::get('/barang/{item}', [ItemController::class, 'show'])->name('items.show');
Route::get('/barang/{item}/ubah', [ItemController::class, 'edit'])->name('items.edit');
Route::put('/barang/{item}', [ItemController::class, 'update'])->name('items.update');
Route::delete('/barang/{item}', [ItemController::class, 'destroy'])->name('items.destroy');

// --- Klaim ---
Route::get('/klaim', [ClaimController::class, 'index'])->name('claims.index');
Route::get('/klaim/buat', [ClaimController::class, 'create'])->name('claims.create');
Route::post('/klaim', [ClaimController::class, 'store'])->name('claims.store');
Route::get('/klaim/{claim}/ubah', [ClaimController::class, 'edit'])->name('claims.edit');
Route::put('/klaim/{claim}', [ClaimController::class, 'update'])->name('claims.update');
Route::delete('/klaim/{claim}', [ClaimController::class, 'destroy'])->name('claims.destroy');

// --- Posko (petugas) ---
Route::get('/posko', [PoskoController::class, 'index'])->name('posko.index');
Route::get('/posko/{claim}', [PoskoController::class, 'show'])->name('posko.show');
Route::post('/posko/{claim}/setujui', [PoskoController::class, 'approve'])->name('posko.approve');
Route::post('/posko/{claim}/tolak', [PoskoController::class, 'reject'])->name('posko.reject');
Route::post('/posko/{claim}/serahkan', [PoskoController::class, 'handover'])->name('posko.handover');

// --- H-08 Not Found ---
Route::fallback(fn () => response()->view('errors.404', [], 404));
