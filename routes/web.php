<?php

use Illuminate\Support\Facades\Route;

// ====================
// 🔐 LOGIN PAGE
// ====================
Route::get('/', function () {
    return view('auth.login');
})->name('login');


// ====================
// 🧾 BAU
// ====================
Route::prefix('bau')->group(function () {
    Route::get('/', function () {
        return view('bau.index');
    })->name('bau.dashboard');
});


// ====================
// 🧑‍🏫 rektor
// ====================
Route::prefix('rektor')->group(function () {
    Route::get('/', function () {
        return view('rektor.index');
    })->name('rektor.dashboard');

});


// ====================
// 🧑‍💼 dosen/kaprodi
// ====================
Route::prefix('kaprodi')->group(function () {
    Route::get('/', function () {
        return view('dosen_kaprodi.index');
    })->name('kaprodi.dashboard');

    Route::get('/createSurat', function () {
        return view('dosen_kaprodi.create_surat');
    })->name('kaprodi.createSurat');
});


// ====================
// 🧾 SEKRETARIS
// ====================
// Dashboard Sekretaris
Route::prefix('sekretaris')->group(function () {
    Route::get('/', function () {
        return view('sekretaris.index'); // pastikan file ini ada di resources/views/seketaris/index.blade.php
    })->name('sekretaris.dashboard');
});


route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.index');
    })->name('admin.dashboard');
});