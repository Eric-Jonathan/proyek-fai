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

    // Dashboard
    Route::get('/', function () {
        return view('bau.index');
    })->name('bau.dashboard');

    // Daftar surat tugas
    Route::get('/surat-tugas', function () {
        return view('bau.surat_tugas');
    })->name('bau.surat_tugas');

    // Detail surat tugas
    Route::get('/surat-tugas/{id}', function ($id) {
        return view('bau.surat_detail');
    })->name('bau.surat_detail');

    // Arsip surat tugas
    Route::get('/arsip', function () {
        return view('bau.arsip');
    })->name('bau.arsip');

    // Transportasi / logistik
    Route::get('/transportasi', function () {
        return view('bau.transport');
    })->name('bau.transport');

    Route::get('/transport/{id}', function ($id) {
        return view('bau.transport_detail'); // detail kendaraan
    })->name('bau.transport_detail');
});


// ====================
// 🧑‍🏫 rektor
// ====================
Route::prefix('rektor')->group(function () {
    // Halaman dashboard / daftar surat tugas
    Route::get('/', function () {
        return view('rektor.index');
    })->name('rektor.dashboard');

    // Halaman detail surat tugas
    Route::get('/surat/{id}', function ($id) {
        return view('rektor.show');
    })->name('rektor.show');
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

    // 🏠 Dashboard
    Route::get('/', function () {
        return view('sekretaris.index');
    })->name('sekretaris.dashboard');

    // 📄 Daftar Surat Tugas
    Route::view('/daftar-surat', 'sekretaris.daftar_surat')->name('sekretaris.daftar_surat');

    // 📝 Buat Surat Tugas
    Route::view('/buat-surat', 'sekretaris.create_surat')->name('sekretaris.create_surat');

    // ✉️ Surat Keluar / Balasan
    Route::view('/surat-keluar', 'sekretaris.surat_keluar')->name('sekretaris.surat_keluar');

    // 📦 Arsip Surat
    Route::view('/arsip', 'sekretaris.arsip')->name('sekretaris.arsip');

    // 📊 Laporan
    Route::view('/laporan', 'sekretaris.laporan')->name('sekretaris.laporan');

});

Route::prefix('admin')->group(function () {
    // 🏠 Dashboard
    Route::view('/', 'admin.index')->name('admin.dashboard');

    // 👥 Manajemen Akun
    Route::view('/users', 'admin.users')->name('admin.users');

    // 🔐 Role & Permission (Spatie Laravel Permission)
    Route::view('/roles', 'admin.roles')->name('admin.roles');

    // 📄 Template Surat (surat tugas / surat keluar)
    Route::view('/templates', 'admin.templates')->name('admin.templates');

    // 📜 Log Aktivitas
    Route::view('/logs', 'admin.logs')->name('admin.logs');

    // 💾 Backup & Reset Nomor Surat
    Route::view('/backup', 'admin.backup')->name('admin.backup');
});
