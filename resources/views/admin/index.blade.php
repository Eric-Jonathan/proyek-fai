@extends('layouts.app')

@section('title', 'Dashboard Admin Sistem')

@section('content')
<div class="container-fluid px-4 py-4">
    <h2 class="fw-bold mb-4">Dashboard Admin Sistem</h2>

    {{-- Statistik Singkat --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <i class="fa fa-users fa-2x text-primary mb-2"></i>
                    <h5 class="fw-bold mb-0">124</h5>
                    <small class="text-muted">Total Akun Pengguna</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <i class="fa fa-key fa-2x text-success mb-2"></i>
                    <h5 class="fw-bold mb-0">5</h5>
                    <small class="text-muted">Total Role & Permission</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <i class="fa fa-file-alt fa-2x text-warning mb-2"></i>
                    <h5 class="fw-bold mb-0">8</h5>
                    <small class="text-muted">Template Surat Aktif</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <i class="fa fa-database fa-2x text-danger mb-2"></i>
                    <h5 class="fw-bold mb-0">Terakhir: 20 Okt 2025</h5>
                    <small class="text-muted">Backup Terbaru</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Log Aktivitas Terbaru --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white fw-bold">
            <i class="fa fa-history me-2 text-secondary"></i>Log Aktivitas Terbaru
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Pengguna</th>
                        <th>Aksi</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>21 Okt 2025</td>
                        <td><i class="fa fa-user text-primary me-1"></i> Sekretaris Rektor</td>
                        <td>Mengedit Template Surat</td>
                        <td>Pembaruan template “Surat Tugas Narasumber”.</td>
                    </tr>
                    <tr>
                        <td>20 Okt 2025</td>
                        <td><i class="fa fa-user text-success me-1"></i> Admin Sistem</td>
                        <td>Backup Sistem</td>
                        <td>Backup otomatis berhasil disimpan.</td>
                    </tr>
                    <tr>
                        <td>19 Okt 2025</td>
                        <td><i class="fa fa-user text-danger me-1"></i> Kaprodi FST</td>
                        <td>Login Gagal</td>
                        <td>3 kali percobaan login dengan email salah.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Status Sistem --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white fw-bold">
            <i class="fa fa-cogs me-2 text-secondary"></i>Status Sistem & Reset Nomor Surat
        </div>
        <div class="card-body">
            <p class="mb-2">
                <i class="fa fa-info-circle text-primary me-1"></i>
                Nomor surat akan otomatis direset setiap <strong>Januari</strong> (contoh: <code>001/ST/FST/01/2025</code>).
            </p>
            <div class="d-flex align-items-center">
                <button class="btn btn-primary me-2">
                    <i class="fa fa-database me-1"></i> Backup Sekarang
                </button>
                <button class="btn btn-warning text-white">
                    <i class="fa fa-sync-alt me-1"></i> Reset Nomor Surat
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
