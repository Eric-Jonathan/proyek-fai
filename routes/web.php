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
// 🧑‍🏫 rektor/dekan
// ====================
Route::prefix('dekan')->group(function () {
    Route::get('/', function () {
        return view('dosen.index');
    })->name('dosen.dashboard');
});


// ====================
// 🧑‍💼 dosen/kaprodi
// ====================
Route::prefix('kaprodi')->group(function () {
    Route::get('/', function () {
        return view('kaprodi.index');
    })->name('kaprodi.dashboard');
});


// ====================
// 🧾 SEKRETARIS
// ====================
// Dashboard Sekretaris
Route::prefix('seketaris')->group(function () {
    Route::get('/', function () {
        return view('seketaris.index'); // pastikan file ini ada di resources/views/seketaris/index.blade.php
    })->name('seketaris.dashboard');
});


route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.index');
    })->name('admin.dashboard');
});