<?php

use Illuminate\Support\Facades\Route;

// ====================
// 🔐 LOGIN PAGE
// ====================
Route::get('/', function () {
    return view('auth.login');
})->name('login');


// ====================
// 🧾 BAA
// ====================
Route::prefix('baa')->group(function () {
    Route::get('/', function () {
        return view('baa.index');
    })->name('baa.dashboard');
});


// ====================
// 🧑‍🏫 DOSEN
// ====================
Route::prefix('dosen')->group(function () {
    Route::get('/', function () {
        return view('dosen.index');
    })->name('dosen.dashboard');
});


// ====================
// 🧑‍💼 KAPRODI
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