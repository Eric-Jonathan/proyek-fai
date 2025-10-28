@extends('layouts.app')

@section('title', 'Log Aktivitas Sistem')

@section('content')
<div class="container-fluid px-4 py-4">
    <h2 class="fw-bold mb-4"><i class="fa fa-history me-2"></i>Log Aktivitas Sistem</h2>

    {{-- 🔍 Filter Pencarian --}}
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body">
            <form action="#" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Pengguna</label>
                    <input type="text" name="user" class="form-control" placeholder="Nama pengguna...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jenis Aktivitas</label>
                    <select class="form-select" name="jenis">
                        <option value="">Semua</option>
                        <option value="login">Login</option>
                        <option value="create">Membuat Data</option>
                        <option value="update">Mengubah Data</option>
                        <option value="delete">Menghapus Data</option>
                        <option value="backup">Backup Sistem</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-search me-1"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- 📋 Tabel Log Aktivitas --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white fw-bold">
            <i class="fa fa-list-alt me-2 text-secondary"></i>Daftar Aktivitas Terbaru
        </div>
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-center">
                    <tr>
                        <th width="5%">#</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Pengguna</th>
                        <th>Aktivitas</th>
                        <th>Keterangan</th>
                        <th width="10%">Status</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Contoh data statis --}}
                    <tr>
                        <td class="text-center">1</td>
                        <td>28 Okt 2025</td>
                        <td>10:15</td>
                        <td><i class="fa fa-user text-primary me-1"></i> Sekretaris</td>
                        <td>Membuat surat tugas baru</td>
                        <td>Surat tugas untuk “Visiting Professor KMUTT” berhasil dibuat.</td>
                        <td class="text-center">
                            <span class="badge bg-success">Berhasil</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">2</td>
                        <td>28 Okt 2025</td>
                        <td>09:42</td>
                        <td><i class="fa fa-user text-info me-1"></i> Admin Sistem</td>
                        <td>Backup database sistem</td>
                        <td>Backup otomatis harian selesai tanpa error.</td>
                        <td class="text-center">
                            <span class="badge bg-success">Berhasil</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">3</td>
                        <td>27 Okt 2025</td>
                        <td>17:03</td>
                        <td><i class="fa fa-user text-danger me-1"></i> Dosen FTI</td>
                        <td>Login gagal</td>
                        <td>3 kali percobaan login dengan email yang tidak terdaftar.</td>
                        <td class="text-center">
                            <span class="badge bg-danger">Gagal</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">4</td>
                        <td>27 Okt 2025</td>
                        <td>14:25</td>
                        <td><i class="fa fa-user text-warning me-1"></i> Kaprodi FST</td>
                        <td>Menghapus data surat tugas</td>
                        <td>Surat tugas nomor 594/ISTTS/A6/VII/2025 dihapus dari sistem.</td>
                        <td class="text-center">
                            <span class="badge bg-warning text-dark">Perhatian</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- 📈 Statistik Singkat --}}
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-center border-primary shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Total Aktivitas Hari Ini</h6>
                    <h4 class="fw-bold text-primary">18</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center border-success shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Aktivitas Berhasil</h6>
                    <h4 class="fw-bold text-success">15</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center border-danger shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Aktivitas Gagal</h6>
                    <h4 class="fw-bold text-danger">3</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
