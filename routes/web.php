<?php
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\SuratTugasController;
use Illuminate\Support\Facades\Route;

// ====================
// 🔐 LOGIN PAGE
// ====================
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.process');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/cetak-surat/{id}', [SuratTugasController::class, 'surat'])->name('surat');

// ====================
// 🧾 BAU
// ====================
Route::prefix('bau')->middleware(['auth', 'role:bau'])->group(function () {
    Route::get('/', fn() => view('bau.index'))->name('bau.dashboard');
    Route::view('/surat-tugas', 'bau.surat_tugas')->name('bau.surat_tugas');
    Route::view('/arsip', 'bau.arsip')->name('bau.arsip');
    Route::view('/transportasi', 'bau.transport')->name('bau.transport');
});

// ====================
// 🧑‍🏫 REKTOR
// ====================
Route::prefix('rektor')->middleware(['auth', 'role:rektor'])->group(function () {
    Route::get('/', [DosenController::class, 'dosen_dashboard'])->name('rektor.dashboard');
    Route::get('/surat/{id}', fn($id) => view('rektor.show'))->name('rektor.show');
});

// ====================
// 🧑‍💼 KAPRODI
// ====================
Route::prefix('kaprodi')->middleware(['auth', 'role:kaprodi'])->group(function () {
    Route::get('/', [DosenController::class, 'dosen_dashboard'])->name('kaprodi.dashboard');
    // Route::view('/createSurat', 'dosen_kaprodi.create_surat')->name('kaprodi.createSurat');
    Route::view('/create-surat', 'dosen_kaprodi.create_surat')->name('kaprodi.createSurat');
    Route::get('/riwayat', [SuratTugasController::class, 'riwayat_surat'])->name('kaprodi.riwayatSurat');
    Route::prefix('CRUD_Surat')->group(function () {
        Route::get('/form_surat', [SuratTugasController::class, 'create'])->name('kaprodi.CRUD_Surat.form_surat');
        Route::get('/edit_surat', [SuratTugasController::class, 'edit'])->name('kaprodi.CRUD_Surat.edit_surat');
        Route::post('/submit_surat', [SuratTugasController::class, 'store'])->name('kaprodi.CRUD_Surat.submit_surat');
        // Route::get('/surat-tugas', [SuratTugasController::class, 'index'])->name('surat-tugas.index');
        Route::get('/surat-tugas/create', [SuratTugasController::class, 'create'])->name('surat-tugas.create');
        Route::post('/surat-tugas', [SuratTugasController::class, 'store'])->name('surat-tugas.store');
        Route::get('/surat-tugas/preview/{id}', [SuratTugasController::class, 'preview'])->name('dashboard.preview');
        Route::get('/surat-tugas/detail/{id}', [SuratTugasController::class, 'detail'])->name('dashboard.detail');
        Route::post('/surat-tugas/{id}/acc', [SuratTugasController::class, 'acc'])->name('surat.acc');
        Route::post('/surat-tugas/{id}/tolak', [SuratTugasController::class, 'tolak'])->name('surat.tolak');
        Route::get('/surat-tugas/edit/{id}', [SuratTugasController::class, 'edit'])->name('CRUD_Surat.edit');
        Route::post('/surat-tugas/update/{id}', [SuratTugasController::class, 'update'])->name('CRUD_Surat.update');
    });
});

// ====================
// 🧾 SEKRETARIS
// ====================
Route::prefix('sekretaris')->middleware(['auth', 'role:sekretaris'])->group(function () {
    Route::get('/', fn() => view('sekretaris.index'))->name('sekretaris.dashboard');
    Route::view('/daftar-surat', 'sekretaris.daftar_surat')->name('sekretaris.daftar_surat');
    Route::view('/buat-surat', 'sekretaris.create_surat')->name('sekretaris.create_surat');
    Route::view('/surat-keluar', 'sekretaris.surat_keluar')->name('sekretaris.surat_keluar');
    Route::view('/arsip', 'sekretaris.arsip')->name('sekretaris.arsip');
    Route::view('/laporan', 'sekretaris.laporan')->name('sekretaris.laporan');
});

// ====================
// 🧑‍💼 DOSEN
// ====================
Route::prefix('dosen')->middleware(['auth', 'role:dosen'])->group(function () {
    Route::get('/', [DosenController::class, 'dosen_dashboard'])->name('dosen.dashboard');
    Route::view('/create-surat', 'dosen_kaprodi.create_surat')->name('dosen.createSurat');
    Route::get('/riwayat', [SuratTugasController::class, 'riwayat_surat'])->name('dosen.riwayatSurat');
    Route::prefix('CRUD_Surat')->group(function () {
    Route::get('/form_surat', [SuratTugasController::class, 'create'])->name('CRUD_Surat.form_surat');
    Route::get('/edit_surat', [SuratTugasController::class, 'edit'])->name('CRUD_Surat.edit_surat');
    Route::post('/submit_surat', [SuratTugasController::class, 'store'])->name('CRUD_Surat.submit_surat');
    Route::get('/surat-tugas', [SuratTugasController::class, 'index'])->name('surat-tugas.index');
    Route::get('/surat-tugas/create', [SuratTugasController::class, 'create'])->name('surat-tugas.create');
    Route::post('/surat-tugas', [SuratTugasController::class, 'store'])->name('surat-tugas.store');

    Route::get('/surat-tugas/preview/{id}', [SuratTugasController::class, 'preview'])->name('dashboard.preview');
    Route::get('/surat-tugas/detail/{id}', [SuratTugasController::class, 'detail'])->name('dashboard.detail');
    Route::post('/surat-tugas/{id}/acc', [SuratTugasController::class, 'acc'])->name('surat.acc');
    Route::post('/surat-tugas/{id}/tolak', [SuratTugasController::class, 'tolak'])->name('surat.tolak');
    Route::get('/surat-tugas/edit/{id}', [SuratTugasController::class, 'edit'])->name('CRUD_Surat.edit');
    Route::post('/surat-tugas/update/{id}', [SuratTugasController::class, 'update'])->name('CRUD_Surat.update');
});

});

// ====================
// 🧑‍💼 DEKAN
// ====================
Route::prefix('dekan')->middleware(['auth', 'role:dekan'])->group(function () {
    Route::get('/', [DosenController::class, 'dosen_dashboard'])->name('dekan.dashboard');
});


// ====================
// 🧠 ADMIN
// ====================
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::post('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::get('/users/{id}/delete', [AdminController::class, 'deleteUser'])->name('admin.users.delete');

    Route::get('/surat', [SuratTugasController::class, 'riwayat_surat'])->name('admin.surat');

    Route::view('/roles', 'admin.roles')->name('admin.roles');
    Route::view('/templates', 'admin.templates')->name('admin.templates');
    // Route::view('/logs', 'admin.logs')->name('admin.logs');
    Route::view('/backup', 'admin.backup')->name('admin.backup');


    // log aktivitas 
    Route::get('/logs', [AdminController::class, 'logAktivitas'])
            ->name('admin.logs');
});

// Route::get('/dashboard', function () {
//     return view('dashboard.dashboard');
// })->name('dashboard');

// Route::prefix('CRUD_Surat')->group(function () {
//     Route::get('/form_surat', [SuratTugasController::class, 'create'])->name('CRUD_Surat.form_surat');
//     Route::get('/edit_surat', [SuratTugasController::class, 'edit'])->name('CRUD_Surat.edit_surat');
//     Route::post('/submit_surat', [SuratTugasController::class, 'store'])->name('CRUD_Surat.submit_surat');
//     Route::get('/surat-tugas', [SuratTugasController::class, 'index'])->name('surat-tugas.index');
// Route::get('/surat-tugas/create', [SuratTugasController::class, 'create'])->name('surat-tugas.create');
// Route::post('/surat-tugas', [SuratTugasController::class, 'store'])->name('surat-tugas.store');

// Route::get('/surat-tugas/preview/{id}', [SuratTugasController::class, 'preview'])->name('dashboard.preview');
// Route::get('/surat-tugas/detail/{id}', [SuratTugasController::class, 'detail'])->name('dashboard.detail');
// Route::post('/surat-tugas/{id}/acc', [SuratTugasController::class, 'acc'])->name('surat.acc');
// Route::post('/surat-tugas/{id}/tolak', [SuratTugasController::class, 'tolak'])->name('surat.tolak');
// Route::get('/surat-tugas/edit/{id}', [SuratTugasController::class, 'edit'])->name('CRUD_Surat.edit');
// Route::post('/surat-tugas/update/{id}', [SuratTugasController::class, 'update'])->name('CRUD_Surat.update');
// });



