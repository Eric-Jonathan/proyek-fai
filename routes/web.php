<?php



use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuratController;
use Illuminate\Support\Facades\Route;

// ====================
// 🔐 LOGIN PAGE
// ====================
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.process');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/surat', [SuratController::class, 'surat'])->name('surat');

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
    Route::get('/', fn() => view('rektor.index'))->name('rektor.dashboard');
    Route::get('/surat/{id}', fn($id) => view('rektor.show'))->name('rektor.show');
});

// ====================
// 🧑‍💼 KAPRODI
// ====================
Route::prefix('kaprodi')->middleware(['auth', 'role:kaprodi'])->group(function () {
    Route::get('/', fn() => view('dosen_kaprodi.index'))->name('kaprodi.dashboard');
    Route::view('/createSurat', 'dosen_kaprodi.create_surat')->name('kaprodi.createSurat');
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
// 🧠 ADMIN
// ====================
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::view('/', [AdminController::class, 'admin.index'])->name('admin.dashboard');
    Route::view('/users', 'admin.users')->name('admin.users');
    Route::view('/roles', 'admin.roles')->name('admin.roles');
    Route::view('/templates', 'admin.templates')->name('admin.templates');
    Route::view('/logs', 'admin.logs')->name('admin.logs');
    Route::view('/backup', 'admin.backup')->name('admin.backup');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::post('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::get('/users/{id}/delete', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
});

Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
});